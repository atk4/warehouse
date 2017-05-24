<?php
class Document extends Model {
    public $table = 'document';

    public $title_field = 'ref';

    function init()
    {
        parent::init();
        $this->hasCompany();

        $this->addField('type', ['enum'=>['purchase','sale','production','loss']]);

        $this->addField('ref', ['required'=>true]);
        $this->addField('date', ['type'=>'date']);
        $this->addField('currency', ['enum'=>$this->app->currencies]);
        $this->addField('status', ['enum'=>['draft','official'], 'default'=>'draft']);
    }
}
