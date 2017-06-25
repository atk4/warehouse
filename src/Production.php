<?php
class Production extends Document {

    public $contact_type = false;

    public $type = 'production';

    function init()
    {
        parent::init();

        $this->getElement('currency')->destroy();

        $l =$this->hasMany('Lines', new Line());

        if ($this->type) {
            $this->addCondition('type', $this->type);
        }
    }

    function makePosted()
    {
        $this->atomic(function() {
            $effect = $this->type == 'sale' ? -1 : 1;

            foreach($this->ref('Lines') as $line) {

                // Create stack/effect model
                $stock = $line->ref('article_id')->ref('Stock')->addCondition('type', 'effect');

                $stock['qty_increase'] = $line['qty'] * $effect;
                $stock['date'] = new \DateTime();
                $stock['description'] = 'Invoice '.$this['ref'].' now live';
                $stock->reload_after_save = false;
                $stock->save();

                // make relation
                $stock->ref('Related')->save(['document_id'=>$this->id]);
            }

            $this['status'] = 'posted';
            $this->save();
        });
    }
}
