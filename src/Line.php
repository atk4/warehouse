<?php

/**
 * Describes one line on the invoice
 */
class Line extends Model {

    public $table='line';

    function init() {
        parent::init();

        // We do not need to restrict here, because we won't be using Line outside of Invoice context
        $this->hasOne('document_id', new Invoice());

        $this->hasOne('article_id', new Article());

        $this->addField('qty', ['type'=>'integer']);
        $this->addField('price', ['type'=>'money']);
        $this->addField('vat_rate', ['enum'=>$this->app->vat_rates]);

        $this->addExpression('net', ['[qty] * [price]', 'type'=>'money']);
        $this->addExpression('total', ['[qty] * [price] * (1+vat_rate)', 'type'=>'money']);
    }

}
