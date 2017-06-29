<?php
include'vendor/autoload.php';

$app = new Warehouse();

switch ($app->stickyGET('type')) {
case 'sale':
    $m = new Sale($app->db);
    break;
case 'purchase':
    $m = new Purchase($app->db);
    break;
default:
    $app->layout->add(['Message','Cannot recognize type', 'error']);
    exit;
    // not sure
}

if ($app->stickyGET('due')) {
    // must only show documents that are due
    $m->addCondition('status', 'posted');
}



$type = $app->stickyGET('type');
$dir = $app->stickyGET('dir');

if ($id = $app->stickyGET('id')) {
    $m->load($id);

    $bc = $app->layout->add(['ui'=>'segment'])->add(new ui\Breadcrumb($m['ref']));
    $bc->addCrumb(get_class($m).'s', ['id'=>false]);

    $cc = $app->layout->add('Columns');
    $c = $cc->addColumn(4);

    $print = $app->layout->add('VirtualPage');
    $print->set(function($page) use($m) {
        $page->app->initLayout('Centered', ['template'=>new \atk4\ui\Template('{$Content}')]);
        $page->app->layout->template->tryDel('Header');
        $page->add(new ui\DocView())->setModel($m);
    });



    $card = $c->add(new ui\Card());
    $card->setModel($m);
    $card->withEdit();
    $card->add(['Button', 'Print', 'icon'=>'print'], 'Buttons')->on('click', new \atk4\ui\jsExpression(
        'window.open([], [], [])',
        [$print->getURL(), 'print', 'width=1000, height=1100, location=no, menubar=no, scrollbars=yes,toolbar=no,titlebar=no']
    ));

    if ($m['status'] == 'draft') {
        $reload_url  = $app->url();
        $card->add(['Button', 'Make Posted', 'blue fluid'])->on('click', function() use ($m, $reload_url) {
            $m->makePosted();
            return new \atk4\ui\jsExpression('document.location = []', [$reload_url]);
        });
    }

    if ($m['status'] == 'posted') {
        $reload_url  = $app->url();
        $card->add(['Button', 'Make Paid', 'green fluid'])->on('click', function() use ($m, $reload_url) {
            $m->saveAndUnload(['status'=>'paid']);
            return new \atk4\ui\jsExpression('document.location = []', [$reload_url]);
        });
    }

    if($m->hasElement('partner_id')) {
        $card = $c->add(new ui\Card());
        $card->setModel($m->ref('partner_id'));
        $card->withEdit();
    }

    $c = $cc->addColumn(12);

    if ($m['status'] == 'draft' || $m['status'] == 'validated') {
        $lines = $c->add([
            'CRUD', 
            'paginator'=>false,
            'formEdit'=>new ui\LineForm(),
            'formAdd'=>new ui\LineForm()
        ]);
    } else {
        $lines = $c->add(['Grid', 'paginator'=>false]);
    }
    $lines->add(['Header', 'Invoice Lines']);
    $lines->setModel($m->ref('Lines'));
    $lines->menu->addItem('Back')->link($app->url(['id'=>false]));

    if ($m['status'] != 'draft') {
        $c->add(['Header', 'Related stock effect']);
        $related = $c->add(['Grid', 'menu'=>false, 'paginator'=>false]);
        $stock = new Stock($app->db);
        $stock->join('related.stock_id')->addField('document_id');
        $stock->addCondition('document_id', $m->id);
        $related->setModel($stock);
    }

    exit;
}

$gr = $app->layout->add(['CRUD', 'ops'=>['u'=>false]]);
$gr->fieldsGrid = ['ref','date','partner','status','net','total'];
$gr->setModel($m);
$gr->addColumn('status', new \atk4\ui\TableColumn\Status(['positive'=>['posted', 'paid'], 'disabled'=>['draft']]));

$gr->table->addClass('selectable');
$gr->table->addStyle('cursor', 'pointer');
$gr->table->on('click', 'tr', new \atk4\ui\jsExpression('document.location=[]+"&id="+[]', [$app->url(), $gr->table->jsRow()->data('id')]))
    ->addClass('active')
    ->siblings()->removeClass('active');
//$gr->setModel(clone $m, ['name', 'type', 'phone']);

/*
$card = $c->addColumn()->add(new ui\Card());

$card->setModel($m);
if ($m->loaded()) {
    $card->add(['Button', 'Edit', 'icon'=>'edit'], 'Buttons')->link(['action'=>'edit']);
    $card->add(['Button', 'Delete', 'icon'=>'red delete'], 'Buttons')->link(['action'=>'delete']);
} else {
    $card->template->del('has_buttons');
}
 */
