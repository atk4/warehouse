<?php
class Sale extends Invoice {
    public $contact_type = 'Client';
    public $type = 'sale';

    function init() {
        parent::init();

        $this->getElement('ref')->default=$this->app->company['next_invoice_ref'];

        $this->addHook('afterInsert', function($m) {
            $v = $m['ref'];
            $v++;
            $this->app->company['next_invoice_ref'] = $v;
            $this->app->company->save();
        });
    }

    function validate() {
        $e = parent::validate();

        $c = clone $this;
        $c->unload();
        if ($this->id) $c->addCondition($c->id_field, '!=', $this->id);
        $c->tryLoadBy('ref', $this['ref']);
        if($c->loaded()) {
            $e['ref'] = 'This ref is already used';
        }
        return $e;
    }
}
