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

        $this->hasOne('category_id', [new SelectableCategory(), 'mandatory'=>true])
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


        $this->addExpression('purchase_total', function() {
            $p = new Purchase($this->persistence);
            $p->addCondition('status', 'posted');
            $l = $p->ref('Lines');
            $l->addCondition('article_id', $this->getElement('id'));
            return $l->action('fx', ['sum', 'net']);
        });
        $this->addExpression('purchase_qty', function() {
            $p = new Purchase($this->persistence);
            $p->addCondition('status', 'posted');
            $l = $p->ref('Lines');
            $l->addCondition('article_id', $this->getElement('id'));
            return $l->action('fx', ['sum', 'qty']);
        });
        $this->addExpression('purchase_cost', ['[purchase_total] / [purchase_qty]', 'type'=>'money'] );
    }

    function validate($intent = null)
    {
        $errors = parent::validate();

        if (!preg_match('/^[0-9]*$/', $this['primary_ean'])) {
            $errors['primary_ean'] = 'Primary EAN contains invalid characters';
        }
        if (!preg_match('/^[0-9]*$/', $this['secondary_ean'])) {
            $errors['secondary_ean'] = 'Primary EAN contains invalid characters';
        }
        return $errors;
    }
}
