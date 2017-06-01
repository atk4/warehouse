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
        $this->addField('status', ['enum'=>['draft','validated','posted','paid'], 'default'=>'draft']);
    }
    public function ref($link, $defaults = [])
    {
        $defaults['document'] = $this;
        return parent::ref($link, $defaults);
    }
    public function refModel($link, $defaults = [])
    {
        $defaults['document'] = $this;
        return parent::refModel($link, $defaults);
    }
}
