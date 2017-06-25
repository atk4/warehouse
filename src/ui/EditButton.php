<?php
namespace ui;

/**
 * Component button that edits something
 */
class EditButton extends \atk4\ui\Button 
{
    public $icon = 'edit';

    // Action to perform after successful edit
    public $action = null;


    function init() {
        parent::init();

        $this->addClass('blue compact');
    }

    function setModel(\atk4\data\Model $m, $fields = null) {

        $vp = $this->add('VirtualPage');
        $vp->set(function($p) use($m, $fields) {
            $f = $p->add(['Form', 'layout'=>new \atk4\ui\FormLayout\Columns(['col'=>2])]);
            $f->setModel($m, $fields);
            $f->onSubmit(function($f) {
                $f->model->save();
                return [$this->action,
                        new \atk4\ui\jsExpression('$(".atk-dialog-content").trigger("close")')];
            });
        });


        $this->on('click', new \atk4\ui\jsModal($this->content.' '.get_class($m).' '.$m[$m->title_field], $vp));
    }
}

