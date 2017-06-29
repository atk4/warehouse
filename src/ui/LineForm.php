<?php
namespace ui;

/**
 * Implements a form, with our custom JS stuff
 */
class LineForm extends \atk4\ui\Form 
{
    function setModel($m, $fields = null) {
        parent::setModel($m, $fields);

        $this->layout->getElement('article_id')->on('change', 'select', function($e, $data) {  
            $art = $this->model->refModel('article_id')->load($data);
            $actions = [];
            $actions[] = $this->layout->getElement('price')->jsInput()->val($art['sale_price']);

            // TODO - wrap value setting into jsSet()
            $actions[] = $this->layout->getElement('vat_rate')->jsInput()->val($art['vat_rate']);
            return $actions;
        }, [(new \atk4\ui\jQuery())->val()]);
    }
}
