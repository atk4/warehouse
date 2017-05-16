<?php
/**
 * We define common anchentor for all our models, to have
 * more control over them
 */
class Model extends \atk4\data\Model {
    use \atk4\core\AppScopeTrait;

    function hasCompany() {

        $this->hasOne('company_id', new Company());

        /**
         * Global ACL for making sure all models that define 'company_id' will
         * automatically restricted to the current company.
         */
        if ($this->hasElement('company_id') && $this->app->company && $this->app->company->loaded()) {
            $this->addCondition('company_id', $this->app->company->id);
        }
    }
}
