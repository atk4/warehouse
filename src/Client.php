<?php
class Client extends Contact {

    function init()
    {
        parent::init();
        $this->addCondition('type', 'client');
    }
}
