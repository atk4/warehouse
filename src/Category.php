<?php
class Category extends Model {
    public $table = 'category';

    function init()
    {
        parent::init();
        $this->hasCompany();

        $this->hasOne('parent_id', new Category())
            ->addTitle();

        $this->hasMany('SubCategory', [new Category(), 'their_field'=>'parent_id'])
            ->addField('count', ['caption'=>'Sub-categories', 'aggregate' => 'count', 'field' => $this->expr('*')]);

        $this->hasMany('Article', [new Article(), 'their_field'=>'category_id'])
            ->addField('items', ['caption'=>'Items', 'aggregate' => 'count', 'field' => $this->expr('*')]);

        $this->addField('name');
        $this->setOrder('name');
    }
}
