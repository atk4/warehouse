<?php
class Contact extends Model {
    public $table = 'contact';

    function init()
    {
        parent::init();
        $this->hasCompany();

        $this->addField('type', ['enum'=>['client','supplier']]);

        $this->addField('name');
        $this->addField('phone');

    }
}
