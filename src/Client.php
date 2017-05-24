<?php
class Client extends Partner {

    function init()
    {
        parent::init();
        $this->addCondition('is_client', true);
    }
}
