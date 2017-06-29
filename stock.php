<?php
include'vendor/autoload.php';

$app = new Warehouse();

$cr = $app->layout->add('CRUD');

//$cr->addColumn(new \atk4\ui\TableColumn\Template('<a href="article.php?article_id={$id}"><i class="stack overflow icon"></i> {$name}: {$stock} in stock</a>'));

$cr->fieldsGrid = ['id', 'name', 'vendor', 'category', 'stock'];
$m = new Article($app->db);

if ($category_id = $app->stickyGET('category_id')) {
    $m->addCondition('category_id', $category_id);
    $msg = $cr->add(['Message','Filters Active:']);

    $msg->add(['Label', $m->refModel('category_id')->load($category_id)['name'], 'detail'=>'category', 'iconRight'=>'close'])
        ->link(['category_id'=>false]);
}

if ($app->stickyGET('negative')) {
    $m->addCondition('stock', '<', 0);
    $msg = $cr->add(['Message','Filters Active:']);

    $msg->add(['Label', 'Only negative stock', 'detail'=>'category', 'iconRight'=>'close'])
        ->link(['negative'=>false]);
}

$cr->setModel($m);


$cr->addColumn('name', ['TableColumn/Link', 'article', 'args'=>['article_id'=>'id']]);

$cr->addQuickSearch(['name','category','vendor']);


$cr->menu->addItem(new ui\Manager(['Brands', 'icon'=>'tag']))
    ->setModel(new Brand($app->db));

/*
$cr->menu->addItem(new ui\Manager(['Categories', 'icon'=>'folder']))
    ->setModel(new SelectableCategory($app->db));
 */
