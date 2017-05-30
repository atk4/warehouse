<?php

/**
 * Describes one line on the invoice
 */
class Related extends Model {

    public $table='related';

    function init() {
        parent::init();

        // We do not need to restrict here, because we won't be using Line outside of Invoice context
        $this->hasOne('document_id', new Invoice());
        $this->hasOne('stock_id', new Stock());
    }

}
