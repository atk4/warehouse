<?php
class Warehouse extends \atk4\ui\App
{

    /**
     * Currently logged in user
     * @var User
     */
    public $user;
    public $company;
    public $vat_rates = ['21.0', '10.0', '0'];
    public $currencies = ['USD','GBP','EUR'];


    function __construct($auth = true) {
        if (is_dir('public')) {
            $this->cdn['atk'] = 'public';
        }
        parent::__construct('Warehouse App v0.6');


        // Connect to database (Heroku or Local)
        if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            $this->db = \atk4\data\Persistence::connect($_ENV['CLEARDB_DATABASE_URL']);
        } else {
            $this->db = \atk4\data\Persistence::connect('mysql:host=127.0.0.1;dbname=warehouse', 'root', 'root');
        }
        $this->db->app = $this;


        $this->user = new User($this->db);
        $this->company = new Company($this->db);
        session_start();

        if (!$auth) {
            $this->initLayout('Centered');
            return;
        }

        if (isset($_SESSION['user_id'])) {
            $this->user->tryLoad($_SESSION['user_id']);
        }

        if(!$this->user->loaded()) {
            $this->initLayout('Centered');
            $this->layout->add(['Message', 'Login Required', 'error']);
            $this->layout->add(['Button', 'Login', 'primary'])->link('index.php');
            exit;
        }

        $this->company = $this->user->ref('company_id');

        $this->initLayout('Admin');

        $this->layout->leftMenu->addItem(['Dashboard', 'icon'=>'home'], ['dashboard']);

        $m = $this->layout->leftMenu->addGroup(['Documents', 'icon'=>'file']);

        // Invoices
        $m->addItem('Purchase', ['docs',    'type'=>'purchase']);
        $m->addItem('Sale', ['docs',    'type'=>'sale']);
        $m->addItem('Internal', ['production']);

        $this->layout->leftMenu->addItem(['Payables', 'icon'=>'visa'], ['docs', 'type'=>'sale', 'due'=>true]);
        $this->layout->leftMenu->addItem(['Receivables', 'icon'=>'euro'], ['docs', 'type'=>'purchase', 'due'=>true]);
        $this->layout->leftMenu->addItem(['Partners', 'icon'=>'users'], ['partners']);


        $m = $this->layout->leftMenu->addGroup(['Catalogue', 'icon'=>'shipping']);
        $m->addItem('Categories', ['manage', 'model'=>'Supplier']);
        $m->addItem('Articles', ['stock',    'type'=>'purchase']);

        $this->layout->leftMenu->addItem(['Reports', 'icon'=>'line chart'], ['chart']);

        // Invoice can be converted into credit note
        //$m->addItem(['Credit Notes', 'label'=>'coming soon'], ['docs','type'=>'credit-note', 'dir'=>'supply']);

        //$m->addItem(['Reports', 'label'=>'coming soon'], ['supplier-reports']);

        //$m->addItem(['At a glance', 'label'=>'coming soon'], ['sales']);

        //$m->addItem(['Credit Notes', 'label'=>'coming soon'], ['docs','type'=>'credit-note', 'dir'=>'sale']);

        $mr = $this->layout->menu->addMenuRight();
        $mr ->addItem([$this->user['email'], 'icon'=>'user']);
        $mr ->addItem(['Logout', 'icon'=>'sign out'], ['logout']);

        $a = new Article($this->db);
        $a->addCondition('stock', '<', 0);
        $c = $a->action('count')->getOne();
        if ($c>0) {
            $this->layout->menuRight->addItem(null, ['stock', 'negative'=>true])->add(['Label', 'There are '.$c.' articles with negative stock', 'red']);
        }

    }
}
