<?php
include'vendor/autoload.php';

$app = new Warehouse();

$app->add('CRUD')->setModel(new Company($app->db));
$app->add('CRUD')->setModel(new User($app->db));
