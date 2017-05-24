<?php
class Stock extends Model {
    public $table = 'stock';

    function init()
    {
        parent::init();

        $this->hasOne('article_id', new Article())
            ->addField('name');
        $this->addField('type', ['enum'=>['inventory', 'write-off', 'effect']]);
        $this->addField('qty_increase', ['type'=>'integer', 'caption'=>'Qty', 'required'=>true]);
        $this->addField('date', ['type'=>'date', 'default'=>new \DateTime()]);
        $this->addField('description');
        //, 'case when [type]="inventory" then "Inventory adjusted" when [type]="write-off" then "Perished" end');
    }
}
