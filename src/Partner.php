<?php
class Partner extends Model {
    public $table = 'partner';

    function init()
    {
        parent::init();
        $this->hasCompany();

        $this->addField('name', ['caption'=>'Legal Name']);

        $this->addField('is_supplier', ['type'=>'boolean', 'system'=>true]);
        $this->addField('is_producer', ['type'=>'boolean', 'system'=>true]);
        $this->addField('is_client',   ['type'=>'boolean', 'system'=>true]);
        $this->addField('type', ['never_persist'=>true]);
        $this->addHook('afterLoad', function($m) {
            $t = [];
            if($m['is_supplier']){ 
                $t[] = 'Supplier';
            }
            if($m['is_producer']){ 
                $t[] = 'Producer';
            }
            if($m['is_client']){ 
                $t[] = 'Client';
            }
            $m['type'] = join(', ', $t);
        });

        $this->addField('phone');
        $this->addField('reg_nr');
        $this->addField('vat_nr');
        $this->addField('address', ['type'=>'text']);

        $this->addField('bank_name');
        $this->addField('bank_swift');
        $this->addField('bank_iban');
        $this->addField('bank_extra', ['type'=>'text']);

        $this->addField('contact_info', ['type'=>'text']);

        $this->hasMany('Delivery', [new Partner(), 'their_field'=>'subsidiary_of_id']);


    }
}
