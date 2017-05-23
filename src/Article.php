<?php
class Article extends Model {
    public $table = 'article';

    function init()
    {
        parent::init();

        $this->hasCompany();

        $this->hasOne('category_id', new Category())
            ->addTitle();
        $this->hasOne('brand_id', new Brand())
            ->addTitle();

        $this->addField('name');
        $this->addField('purchase_price', ['type'=>'money']);
        $this->addField('sale_price', ['type'=>'money']);
        $this->addField('vat_rate', ['enum'=>$this->app->vat_rates]);

        $this->hasMany('Stock', new Stock())
            ->addField('stock', ['aggregate'=>'sum', 'field'=>'qty_increase']);
        //$this->addExpression('stock', '28');
    }
}
