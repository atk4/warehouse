<?php
include'vendor/autoload.php';

$app = new Warehouse();

/*
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

 */

$m = new Production($app->db);


if ($id = $app->stickyGET('id')) {
    $m->load($id);

    $bc = $app->layout->add(['ui'=>'segment'])->add(new ui\Breadcrumb($m['ref']));
    $bc->addCrumb(get_class($m).'s', ['id'=>false]);

    $cc = $app->layout->add('Columns');
    $c = $cc->addColumn(4);

    $card = $c->add(new ui\Card());
    $card->setModel($m);
    $card->withEdit();

    if ($m['status'] == 'draft') {
        $reload_url  = $app->url();
        $card->add(['Button', 'Make Posted', 'blue fluid'])->on('click', function() use ($m, $reload_url) {
            $m->makePosted();
            return new \atk4\ui\jsExpression('document.location = []', [$reload_url]);
        });
    }

    $c = $cc->addColumn(6);

    if ($m['status'] == 'draft') {
        $lines = $c->add(['CRUD', 'paginator'=>false]);
    } else {
        $lines = $c->add(['Grid', 'paginator'=>false]);
    }
    $lines->add(['Header', 'Stock Produced']);
    $mm = $m->ref('Lines', ['used_up'=>false]);

    $lines->setModel($mm);

    $c = $cc->addColumn(6);

    if ($m['status'] == 'draft') {
        $lines = $c->add(['CRUD', 'paginator'=>false]);
    } else {
        $lines = $c->add(['Grid', 'paginator'=>false]);
    }
    $lines->add(['Header', 'Stock Used Up']);

    $mm = $m->ref('Lines', ['used_up'=>true]);
   // ->addCondition('qty', '<', 0);
   // $mm->getElement('qty')->system = false;

    $lines->setModel($mm);

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
$gr->fieldsGrid = ['ref','date','status'];
$gr->setModel($m);
$gr->addColumn('status', new \atk4\ui\TableColumn\Status(['positive'=>['posted', 'paid'], 'disabled'=>['draft']]));

$gr->table->addClass('selectable');
$gr->table->addStyle('cursor', 'pointer');
$gr->table->on('click', 'tr', new \atk4\ui\jsExpression('document.location=[]+"?id="+[]', [$app->url(), $gr->table->jsRow()->data('id')]))
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
