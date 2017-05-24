<?php
include'vendor/autoload.php';

$app = new Warehouse();

$m = new Partner($app->db);
if ($id  = $app->stickyGET('id')) {
    $m->load($id);
}


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

$v = $app->layout->add(['ui'=>'segment']);
$c = $v->add('Columns');

$gr = $c->addColumn()->add('Grid');

$gr->menu->addItem('Add New Supplier')->link(['action'=>'add', 'id'=>false, 'type'=>'supplier']);
$gr->menu->addItem('Add New Client')->link(  ['action'=>'add', 'id'=>false, 'type'=>'client']);
$gr->menu->addItem('Add New Producer')->link(['action'=>'add', 'id'=>false, 'type'=>'producer']);


$card = $c->addColumn()->add(new ui\Card());

$gr->table->addClass('selectable');
$gr->table->on('click', 'tr', new \atk4\ui\jsReload($card, ['id'=>$gr->table->jsRow()->data('id')]))
    ->addClass('active')
    ->siblings()->removeClass('active');
$gr->setModel(clone $m, ['name', 'type', 'phone']);

$card->setModel($m);
if ($m->loaded()) {
    $card->add(['Button', 'Edit', 'icon'=>'edit'], 'Buttons')->link(['action'=>'edit']);
    $card->add(['Button', 'Delete', 'icon'=>'red delete'], 'Buttons')->link(['action'=>'delete']);
} else {
    $card->template->del('has_buttons');
}
