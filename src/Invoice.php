<?php
class Invoice extends Document {

    public $contact_type = 'Contact';

    public $type;

    function init()
    {
        parent::init();
        $this->j_invoice = $this->join('invoice.document_id');
        $this->j_invoice->hasOne('contact_id', new $this->contact_type());

        if ($this->type) {
            $this->addCondition('type', $this->type);
        }
    }
}
