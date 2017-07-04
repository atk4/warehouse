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

$m->addCondition('is_paid', false);
$m->addCondition('status', 'posted');

$gr = $app->layout->add(['Grid', 'menu'=>false]);
$gr->setModel($m, ['ref','date','partner','is_paid','total']);

$vp = $gr->table->_add(new \atk4\ui\CallbackLater());
$vp->set(function () use ($m, $app, $gr) {
    $m->load($_POST['pay'])->pay();

    $app->terminate($gr->table->renderJSON());
});

$gr->table->addClass('selectable');
//$gr->table->addStyle('cursor', 'pointer');
//
$gr->table->js(true)->find('tr[data-id]')->css(['cursor'=>'pointer']);
$gr->table->on('click', 'tr[data-id]')->ajaxec([
    'uri'        => $vp->getURL(),
    'uri_options'=> ['pay' => $gr->table->jsRow()->data('id')],
    'confirm'    => "Mark this invoice as paid?",
]);

