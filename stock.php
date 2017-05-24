<?php
include'vendor/autoload.php';

$app = new Warehouse();

$cr = $app->layout->add('CRUD');

//$cr->addColumn(new \atk4\ui\TableColumn\Template('<a href="article.php?article_id={$id}"><i class="stack overflow icon"></i> {$name}: {$stock} in stock</a>'));

$cr->fieldsGrid = ['id', 'name', 'vendor', 'category', 'purchase_price', 'sale_price'];
$cr->setModel(new Article($app->db));

$cr->addColumn('name', ['TableColumn/Link', 'article', 'args'=>['article_id'=>'id']]);

$cr->addQuickSearch(['name','category','vendor']);


$cr->menu->addItem(new ui\Manager(['Brands', 'icon'=>'tag']))
    ->setModel(new Brand($app->db));

$cr->menu->addItem(new ui\Manager(['Categories', 'icon'=>'folder']))
    ->setModel(new Category($app->db));
