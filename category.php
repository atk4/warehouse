<?php
include'vendor/autoload.php';

$app = new Warehouse();

$m = new Category($app->db);

$category_id = $app->stickyGET('category_id');

$bc = $app->layout->add(['ui'=>'segment'])->add(new ui\Breadcrumb($category_id ? $m->load($category_id)['name'] : '[root]'));
$bc->addClass('huge');
$sanity = 10;
while (($m=$m->ref('parent_id'))->loaded()) {
    if (!$sanity--)break;
    $bc->addCrumbLeft($m['name'], ['category_id'=>$m->id]);
}

if ($category_id) {
    $bc->addCrumbLeft('[root]', ['category_id'=>false]);
}

$cr = $app->layout->add('CRUD');
$cr->fieldsGrid = ['name', 'count', 'items'];
$cr->setModel(new Category($app->db))->addCondition('parent_id', $category_id);
$cr->addColumn('name', ['TableColumn/Link', 'args'=>['category_id'=>'id']]);
$cr->addColumn('items', ['TableColumn/Link', 'page'=>'stock', 'args'=>['category_id'=>'id']]);


