<?php
class Company extends \atk4\data\Model {
    public $table = 'company';

    function init()
    {
        parent::init();

        $this->addField('name');

        $this->addField('phone');
        $this->addField('reg_nr');
        $this->addField('vat_nr');
        $this->addField('address', ['type'=>'text']);

        $this->addField('bank_name');
        $this->addField('bank_swift');
        $this->addField('bank_iban');
        $this->addField('bank_extra', ['type'=>'text']);

        $this->addField('next_invoice_ref', ['caption'=>'Next Sales Invoice Ref', 'default'=>'INV000001']);
    }
}
