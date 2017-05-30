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



$type = $app->stickyGET('type');
$dir = $app->stickyGET('dir');

if ($id = $app->stickyGET('id')) {
    $m->load($id);


    $cc = $app->layout->add('Columns');
    $c = $cc->addColumn(4);

    $card = $c->add(new ui\Card());
    $card->setModel($m);
    $card->withEdit();

    $reload_url  = $app->url();
    $card->add(['Button', 'Make Posted', 'blue fluid'])->on('click', function() use ($m, $reload_url) {
        $m->makePosted();
        return new \atk4\ui\jsExpression('document.location = []', [$reload_url]);
    });

    if($m->hasElement('partner_id')) {
        $card = $c->add(new ui\Card());
        $card->setModel($m->ref('partner_id'));
        $card->withEdit();
    }

    $c = $cc->addColumn(12);

    if ($m['status'] == 'draft') {
        $lines = $c->add(['CRUD', 'paginator'=>false]);
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


/*
switch ($app->stickyGET('action')) {
case 'edit':
case 'add':
    $form = $app->layout->add(['ui'=>'segment'])->add(['Form', 'layout'=>'FormLayout/Columns']);

    $type = $app->stickyGET('type');

    $form->setModel($m);
    $form->add(['Button','Cancel'])->link(['action'=>false]);
    $form->onSubmit(function($form) use($type) {
        $form->model['is_'.$type] = true;
        $form->model->save();
        return new \atk4\ui\jsExpression('document.location=[]', [$form->app->url([
            'id'=>$form->model->id,
            'action'=>false,
            'type'=>false
        ])]);
    });
    exit;
case 'delete':
    if (isset($_GET['confirm'])) {
        $m->delete();
        header('Location: '.$app->url(['action'=>false, 'id'=>false]));
        exit;
    }

    $m = $app->layout->add(['Message', 'Are you sure you want to delete '.$m['name'].'?', 'negative']);
    $m->text->addParagraph('The record will only be marked as deleted. It will remain in the database.');
    $m->add(['Button', 'Yes', 'red'])->link(['confirm'=>true]);
    $m->add(['Button', 'No'])->link(['action'=>false]);;
    exit;
}
 */

//$v = $app->layout->add(['ui'=>'segment']);
//$c = $v->add('Columns');

$gr = $app->layout->add('Grid');
$gr->setModel($m);

$gr->menu->addItem('Add '.get_class($m))->link(['action'=>'add', 'id'=>false]);

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
