<?php
class Supplier extends Partner {

    function init()
    {
        parent::init();
        $this->addCondition('is_supplier', true);
    }
}
