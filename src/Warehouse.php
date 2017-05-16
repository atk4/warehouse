<?php
class Warehouse extends \atk4\ui\App 
{

    public $user;
    public $company;

    public $vat_rates = ['21.1', '13.0', '0'];
    public $currencies = ['USD','GBP','EUR'];


    function __construct($auth = true) {
        parent::__construct('Warehouse App v0.1');


        // Connect to database (Heroku or Local)
        if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            preg_match('|([a-z]+)://([^:]*)(:(.*))?@([A-Za-z0-9\.-]*)(/([0-9a-zA-Z_/\.]*))|',
                $_ENV['CLEARDB_DATABASE_URL'],$matches);

            $dsn=array(
                $matches[1].':host='.$matches[5].';dbname='.$matches[7],
                $matches[2],
                $matches[4]
            );
            $this->db = new \atk4\data\Persistence_SQL($dsn[0], $dsn[1], $dsn[2]);
        } else {
            $this->db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=warehouse', 'root', 'root');
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

        $this->layout->leftMenu->addItem(['Stock', 'icon'=>'barcode'], 'stock.php');

        $this->layout->leftMenu->addItem(['Purchases', 'icon'=>'shipping'], 'document.php?type=purchase');

        $this->layout->leftMenu->addItem(['Sales', 'icon'=>'shop'], 'document.php?type=sale');
    }
}
