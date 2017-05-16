<?php
namespace ui;

/**
 * Component implementing our log-in form
 */
class LoginForm extends \atk4\ui\Form 
{
    function init() {
        parent::init();

        $this->setModel(clone $this->app->user, ['email', 'password']);

        $this->onSubmit(function($form) {

            $this->app->user->tryLoadBy('email', $form->model['email']);

            if ($this->app->user['password'] == $form->model['password']) {
                // Auth successful!
                $_SESSION['user_id'] = $this->app->user->id;
                
                return new \atk4\ui\jsExpression('document.location="dashboard.php"');
            } else {
                $this->app->user->unload();

                return $form->error('password', 'No such user');
            }
        });
    }
}
