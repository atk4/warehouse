<?php
namespace ui;

/**
 * Implements a form, with our custom JS stuff
 */
class LineForm extends \atk4\ui\Form 
{
    public $which_price = 'sale';

    function setModel($m, $fields = null) {
        parent::setModel($m, $fields);

        $this->layout->getElement('article_id')->on('change', 'select', function($e, $data) {  
            $art = $this->model->refModel('article_id')->load($data);
            $actions = [];
            $actions[] = $this->layout->getElement('price')->jsInput()->val($art[$this->which_price.'_price']);

            // TODO - wrap value setting into jsSet()
            $actions[] = $this->layout->getElement('vat_rate')->jsInput()->val($art['vat_rate']);
            return $actions;
        }, [(new \atk4\ui\jQuery())->val()]);
    }
}
