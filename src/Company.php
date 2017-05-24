<?php
class Company extends \atk4\data\Model {
    public $table = 'company';

    function init()
    {
        parent::init();

        $this->addField('name');
        //$this->addField('reg_no');
    }
}
