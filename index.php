<?php
include'vendor/autoload.php';


$app = new Warehouse(false);
$app->layout->add(['Message','Use "test" / "test" to login']);
$app->layout->add(new ui\LoginForm());
