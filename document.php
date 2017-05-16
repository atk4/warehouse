<?php
include'vendor/autoload.php';

$app = new Warehouse();


$m = $app->stickyGET('type') == 'purchase' ? new Purchase($app->db): new Sale($app->db);

$cr = $app->layout->add('CRUD');
$cr->setModel($m);

$cr->menu->addItem(new ui\Manager(['Contacts', 'icon'=>'user']))
    ->setModel($m->refModel('contact_id'));

