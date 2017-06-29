<?php
namespace ui;

class DocView extends \atk4\ui\View {
    public $defaultTemplate = './template/invoice.html';

    function setModel($m) {
        $this->template->set($m);

        $this->add('Lister', 'Lines')->setModel($m->ref('Lines'));
        $this->add(['View', 'template'=>false], 'Company')->template->set($this->app->company);
    }
}
