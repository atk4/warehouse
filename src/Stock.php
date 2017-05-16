<?php
class Stock extends Model {
    public $table = 'stock';

    function init()
    {
        parent::init();

        $this->hasOne('article_id', new Article());
        $this->addField('qty_increase', ['type'=>'integer', 'caption'=>'Qty']);
        $this->addField('date', ['type'=>'date']);
        $this->addField('description');
    }
}
