<?php
class Brand extends Model {
    public $table = 'brand';

    function init()
    {
        parent::init();
        $this->hasCompany();

        $this->addField('name');
    }
}
