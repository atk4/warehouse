<?php
/**
 * For articles we may only select 3rd level categories
 */
class SelectableCategory extends Category {
    // Level 2 category
    public $l2;

    // Level 1 category
    public $l1;

    public $title_field = 'title';

    function init()
    {
        parent::init();

        $this->addExpression('title', 'concat([l2]," > ",[name])');

        $this->l2 = $this->join('category','parent_id');
        $this->l2->addField('l2', ['actual'=>'name']);
        $this->l2->addField('l2_parent_id', ['actual'=>'parent_id']);

        $this->addCondition('l2_parent_id', null);
        $this->setOrder('title');
    }
}
