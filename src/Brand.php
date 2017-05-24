<?php
class Brand extends Model {
    public $table = 'brand';

    function init()
    {
        parent::init();
        $this->hasCompany();

        $this->hasOne('partner_id', [new Producer(), 'caption'=>'Producer'])
            ->addTitle(['caption'=>'Producer']);

        $this->addField('name');
    }
}
