<?php
include'vendor/autoload.php';

$app = new Warehouse();


$m = $app->stickyGET('type') == 'purchase' ? new Purchase($app->db): new Sale($app->db);

$cr = $app->layout->add('CRUD');
$cr->setModel($m);
$cr->addColumn('ref', new \atk4\ui\TableColumn\Link('invoice.php?type'.$m->type.'&document_id={$id}'));

$cr->menu->addItem(new ui\Manager([get_class($m->refModel('contact_id')).' '.'Manager', 'icon'=>'user']))
    ->setModel($m->refModel('contact_id'));

