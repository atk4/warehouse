<?php
class Article extends Model {
    public $table = 'article';

    function init()
    {
        parent::init();

        $this->hasCompany();

        //$this->hasOne('brand_id', new Brand())
            //->addTitle();

        $this->addField('primary_ean');
        $this->addField('secondary_ean');
        $this->addField('name');
        $this->addField('description', ['type'=>'text']);
        $this->addField('measurement_unit', ['enum'=>['pc', 'kg', 'm', 'l' ]]);
        $this->hasOne('primary_supplier_id', new Supplier())
            ->addField('vendor', 'name');
        $this->addField('producer_product_code');
        $this->addField('brand');

        $this->hasOne('category_id', new Category())
            ->addTitle();

        $this->addField('purchase_price', ['type'=>'money', 'caption'=>'purchase price EXCL VAT']);
        $this->addField('vat_rate', ['enum'=>$this->app->vat_rates]);
        $this->addField('sale_price', ['type'=>'money', 'caption'=>'sale price EXCL VAT']);

        $this->addField('weight');
        $this->addField('height');
        $this->addField('width');
        $this->addField('length');

        $this->addField('factor', ['caption'=>'Factor (pcs/box)']);
//        $this->addField('is_active', ['type'=>'boolean']);

        $this->hasMany('Stock', new Stock())
            ->addField('stock', ['aggregate'=>'sum', 'field'=>'qty_increase']);
    }
}
