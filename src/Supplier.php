<?php
class Supplier extends Partner {

    function init()
    {
        parent::init();
        $this->addCondition('is_supplier', true);

        $i = $this->hasMany('Invoices', [new Purchase()]);
        $i->addField('invoiced', ['caption'=>'Total Purchase', 'field'=>'total', 'aggregate'=>'sum']);
    }
}
