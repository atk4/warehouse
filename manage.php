<?php
include'vendor/autoload.php';

$app = new Warehouse();

$m = $app->stickyGET('model');
$m = basename($m);  // for security
$m = new $m($app->db);

// for security
if (!$m instanceof \atk4\data\Model) {
    throw new Exception('Incorrect model definition');
}

$cr = $app->layout->add('CRUD');
$cr->setModel($m);

/*
$cr->addColumn(new \atk4\ui\TableColumn\Template('<a href="article.php?article_id={$id}"><i class="stack overflow icon"></i> {$name}: {$stock} in stock</a>'));

$cr->fieldsGrid = ['category', 'brand', 'name'];
$cr->setModel(new Article($app->db));


$cr->menu->addItem(new ui\Manager(['Brands', 'icon'=>'tag']))
    ->setModel(new Brand($app->db));

$cr->menu->addItem(new ui\Manager(['Categories', 'icon'=>'folder']))
    ->setModel(new Category($app->db));
 */
