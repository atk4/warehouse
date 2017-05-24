<?php
class User extends Model {

    public $table = 'user';
    public $title_field = 'email';

    function init()
    {
        parent::init();

        $this->addField('email', ['required'=>true]);
        $this->addField('password', ['type'=>'password', 'required'=>true]);

        $this->hasOne('company_id', new Company());
    }
}
