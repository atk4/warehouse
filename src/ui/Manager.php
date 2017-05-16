<?php
namespace ui;
/**
 * A special menu item, that has it's own page with a crud and ability to
 * go back to original page
 */

class Manager extends \atk4\ui\Item {

    function setModel(\atk4\data\Model $m, $fields = null) {
        $vp = $this->add('VirtualPage');
        $cr = $vp->add('CRUD');
        $cr->menu->addItem(['Back', 'icon'=>'left arrow'])->link($this->app->url([
            $vp->name=>false]));

        $cr->setModel($m, $fields);

        $this->link($vp->getURL());
        //$this->on('click', \atk4\ui\jsModal($vp));
    }
}
