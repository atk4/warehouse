<?php
class Invoice extends Document {

    public $contact_type = 'Contact';

    public $type;

    function init()
    {
        parent::init();
        $this->j_invoice = $this->join('invoice.document_id');
        $this->j_invoice->hasOne('partner_id', new $this->contact_type());

        $l =$this->hasMany('Lines', new Line());
        $l->addField('total', ['aggregate'=>'sum']);
        $l->addField('net', ['aggregate'=>'sum']);

        if ($this->type) {
            $this->addCondition('type', $this->type);
        }
    }
}
