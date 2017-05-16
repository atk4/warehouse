<?php
include'vendor/autoload.php';

$app = new Warehouse(false);
$app->layout->add(new ui\loginForm());
