<?php
namespace ui;

/**
 * Component button that edits something
 */
class Card extends \atk4\ui\View 
{

    public $defaultTemplate = './template/card.html';

    public $ui = 'card';

    public $actions = [];   // define things you can do with the card

    function renderView() {

        if (!$this->model->loaded()) {
            // No record is loaded
            $this->template->del('has_title');
            //$this->template['Content'] = 'No '.get_class($this->model).' selected';
            $this->add(['Message', false, 'basic warning'])->text->addParagraph('Select '.get_class($this->model).' to see details.');
            return parent::renderView();
        }

        $data = ['a'=>[]];
        $values = $this->app->ui_persistence->typecastSaveRow($this->model, $this->model->get());

        $this->template['title'] = get_class($this->model).': '.$values[$this->model->title_field];

        foreach($this->model->elements as $name=>$element) {
            if (!$element instanceof \atk4\data\Field) {
                continue;
            }
            if ($element->system || $name == $this->model->title_field) {
                continue;
            }

            $data['a'][] = [ 'name'=> $element->getCaption().':', 'value'=> $values[$name]]; 
        }

        $m = new \atk4\data\Model(new \atk4\data\Persistence_Array($data), 'a');
        $m->addField('name');
        $m->addField('value');


        $t = $this->add(['Table', 'very compact very basic small']);
        $t->header = false;
        $t->setModel($m);

        parent::renderView();
    }

    function withEdit()
    {
        $b = $this->add(new EditButton(['Edit', 'icon'=>'edit']), 'Buttons')
            ->setModel($this->model);

        return $this;
    }
}

