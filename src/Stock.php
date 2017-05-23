<?php
class Stock extends Model {
    public $table = 'stock';

    function init()
    {
        parent::init();

        $this->hasOne('article_id', new Article());
        $this->addField('qty_increase', ['type'=>'integer', 'caption'=>'Qty', 'required'=>true]);
        $this->addField('date', ['type'=>'date', 'default'=>new \DateTime()]);
        $this->addField('description');
    }
}
