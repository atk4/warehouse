<?php
class Producer extends Partner {

    function init()
    {
        parent::init();
        $this->addCondition('is_producer', true);
    }
}
