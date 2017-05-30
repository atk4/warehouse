<?php
namespace ui;

class Breadcrumb extends \atk4\ui\View 
{
    public $crumbs = [];

    public $ui = 'breadcrumb';

    public $defaultTemplate = './template/breadcrumb.html';

    public $divider = '/';

    function addCrumb($label, $link = null) 
    {
        $this->crumbs[] = [$label, $link];
    }

    function addCrumbLeft($label, $link = null)
    {
        array_unshift($this->crumbs, [$label, $link]);
    }

    function renderView()
    {
        $t_crumb = $this->template->cloneRegion('crumbs');
        $t_crumb->set('divider', $this->divider);
        $this->template->del('crumbs');

        foreach ($this->crumbs as list($label, $link)) {

            $t_crumb->set('label', $label);
            $t_crumb->set('link', $this->app->url($link));
            $this->template->appendHTML('crumbs', $t_crumb->render());
        }

        return parent::renderView();

    }

}
