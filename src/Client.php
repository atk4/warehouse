<?php
class Client extends Partner {

    function init()
    {
        parent::init();
        $this->addCondition('is_client', true);

        $i = $this->hasMany('Invoices', [new Sale()]);
        $i->addField('invoiced', ['caption'=>'Total Sale', 'field'=>'total', 'aggregate'=>'sum','type'=>'money']);
    }
}
