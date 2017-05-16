<?php
class Category extends Model {
    public $table = 'category';

    function init()
    {
        parent::init();
        $this->hasCompany();

        $this->addField('name');
        $this->setOrder('name');
    }
}
