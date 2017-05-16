<?php
include'vendor/autoload.php';

$app = new Warehouse();

$article = new Article($app->db);
$article->load($app->stickyGET('article_id'));

$c = $app->layout->add('Columns');

$c->addColumn()->add(['Header', 'Article info '.$article['name'], 'icon'=>'stack overflow', 'subHeader'=>$article['category']. ' / '.$article['brand']]);

$button_bar = $c->addColumn(['', 'right aligned'])->add(['ui'=>'buttons', 'right aligned'=>true]);

$c = $app->layout->add(['ui'=>'segment'])->add(new \atk4\ui\Columns('divided'));

$c1 = $c->addColumn();
$c2 = $c->addColumn();

$c1->add(['Header', 'Recent Additions']);
$c2->add(['Header', 'Recent Subtractions']);

$button_bar->add(new ui\EditButton(['Adjust Stock', 'action'=>new \atk4\ui\jsReload($c)]))
    ->setModel($article->ref('Stock'));

$c1->add(['Table', 'very compact very basic small'])
    ->setModel($article->ref('Stock')->addCondition('qty_increase','>=',0), ['date', 'description', 'qty_increase'])
    ->setLimit(5)
    ->setOrder('date desc');
$c2->add(['Table', 'very compact very basic small'])
    ->setModel($article->ref('Stock')->addCondition('qty_increase','<',0), ['date', 'description', 'qty_increase'])
    ->setLimit(5)
    ->setOrder('date desc');

