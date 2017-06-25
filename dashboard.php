<?php
include'vendor/autoload.php';

$app = new Warehouse();


// Left side of dashboard
$columns = $app->layout->add(['Columns', 'celled']);
$left = $columns->addColumn();
$left->add(['Header', $app->user['email'], 'aligned'=>'center', 'icon'=>'circular user']);

$left->add(new ui\EditButton([
    'Edit Profile',
    'action'=>new \atk4\ui\jsReload($left)
]))->setModel($app->user, ['email','password']);


// Right side of dashboard
$right = $columns->addColumn();
$right->add(['Header', $app->company['name'], 'aligned'=>'center', 'icon'=>'circular suitcase']);
$right->add(new ui\EditButton([
    'Edit',
    'action'=>new \atk4\ui\jsReload($right)
]))->setModel($app->company);
