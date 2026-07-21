<?php
$PS = DIRECTORY_SEPARATOR;
require_once dirname(dirname(__FILE__))."{$PS}config{$PS}config.php";

/* File per la connessione al database e l'inizializzazione delle globals */
class dbnew extends Config {
	
	 private static ?dbnew $instance = null;
    public ?PDO $connection = null;
	public $website;
	protected $local = false;
	protected $cws = false;
    protected $testenv = false;
	protected $prec_db;
	protected $http;
	protected $SMTP_host;
	protected $SMTP_user;
	protected $SMTP_psw;
	protected $user_login_paypal;
	
	 // Costruttore
    public function __construct() {
        $this->initConfig();
        $this->connect();

        // Chiude la connessione alla fine dello script
        register_shutdown_function([$this, 'disconnect']);
    }

    // Singleton
    public static function getInstance(): dbnew {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Connessione al DB
    public function connect(): void {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    "mysql:host=$this->host_db;dbname=$this->db_name;charset=utf8mb4",
                    $this->user_db,
                    $this->pass_db,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                    ]
                );
            } catch (PDOException $e) {
                die("DB Connection failed: " . $e->getMessage());
            }
        }
    }

    // Disconnessione al DB
    public function disconnect(): void {
        if ($this->connection !== null) {
            $this->connection = null;
        }
    }

    // Query diretta (usala solo per SELECT semplici)
    public function query(string $sql): ?PDOStatement {
        try {
            return $this->connection?->query($sql);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
		
	   // Configurazione ambiente
    private function initConfig(): void {
        $host = $_SERVER["HTTP_HOST"];
        if ($host === "servernew:8081" || $host === "192.168.0.17") {
            $this->local = true;
        } elseif ($host === "moruzzi.cwstudio.it") {
            $this->cws = true;
        }
		
		if ($this->local) {
			$this->dir_up = "admin/img_up";
			$this->host_db = "";
			$this->user_db = "";
			$this->pass_db = "";
			$this->db_name = "";
			$this->ind_sito = "";
			$this->prec_db = "";
			$this->mail_sito = "f.denegri@cwstudio.it";
			$this->http = "http";
			$this->SMTP_host = "";
			$this->SMTP_user = "";
			$this->SMTP_psw = "";
		} elseif ($this->cws) {
			$this->dir_up = "admin/img_up";
			/*$this->host_db = "89.46.111.178";
			$this->user_db = "Sql1775636";
			$this->pass_db = "7RP8Xp%fNH";
			$this->db_name = "Sql1775636_5";*/
			$this->host_db = "localhost";
			$this->user_db = "moruzzi_2026";
			$this->pass_db = 'rAbq$SWf34fy&qo7';
			$this->db_name = "moruzzi_2026";
			$this->prec_db = "mor_";
			$this->ind_sito = "moruzzi.cwstudio.it";
			$this->mail_sito = "f.denegri@cwstudio.it";
			$this->http = "https";
			$this->user_login_paypal = "sb-bq8fd4042191@business.example.com"; //password: 8g,44/Gt
			//user paypal sandbox s.depe_1320053064_per@cwstudio.it - 320053017
			$this->SMTP_host = "out.postassl.it";
			$this->SMTP_user = "es@creativewebstudio.it";
			$this->SMTP_psw = "Es2021cw%";
		} elseif ($host === "www.moruzzi.it" || $host === "moruzzi.it") {
			$this->dir_up = "admin/img_up";
			$this->host_db = "localhost";
			$this->user_db = "moruzzi_prod";
			$this->pass_db = "IaHsBbojMjcCyYqQkPp6mF7I";
			$this->db_name = "moruzzi_prod";
			$this->prec_db = "mor_";
			$this->ind_sito = "www.moruzzi.it";
			$this->mail_sito = "info@moruzzi.it";
			$this->http = "https";
			/*$this->SMTP_host = "smtps.interhost.it";
			$this->SMTP_user = "website@moruzzi.it";
			$this->SMTP_psw = '$YsVp4Gf7P';*/
			$this->SMTP_host = "out.postassl.it";
			$this->SMTP_user = "es@creativewebstudio.it";
			$this->SMTP_psw = "Es2021cw%";
		} else {
			$this->dir_up = "admin/img_up";
			$this->host_db = "localhost";
			$this->user_db = "moruzzi_staging";
			$this->pass_db = "LD9SgCe@kv";
			$this->db_name = "moruzzi_staging";
			$this->prec_db = "mor_";
			$this->ind_sito = "staging.moruzzi.it";
			$this->mail_sito = "info@moruzzi.it";
			$this->http = "https";
			/*$this->SMTP_host = "smtps.interhost.it";
			$this->SMTP_user = "website@moruzzi.it";
			$this->SMTP_psw = '$YsVp4Gf7P';*/
			$this->SMTP_host = "out.postassl.it";
			$this->SMTP_user = "es@creativewebstudio.it";
			$this->SMTP_psw = "Es2021cw%";
		}
	}
	
	public function get_Var($nome) {
		return $this->$nome;
	}
	
}

/* apertura connessione db + inizializzazione variabili globali */
$open_connection = dbnew::getInstance();
$mail_sito = $open_connection->get_Var('mail_sito');
$ind_sito = $open_connection->get_Var('ind_sito');
$dir_up = $open_connection->get_Var('dir_up');
$local = $open_connection->get_Var('local');
$cws = $open_connection->get_Var('cws');
$http = $open_connection->get_Var('http');
$prec_db = $prefix = $prefix_db = $open_connection->get_Var('prec_db');
$SMTP_host = $open_connection->get_Var('SMTP_host');
$SMTP_user = $open_connection->get_Var('SMTP_user');
$SMTP_psw = $open_connection->get_Var('SMTP_psw');

$google_api_key = "AIzaSyAMap-4lyIIPrOgmU4mQMKMOeX1XjJbubk";

$website = "fm"; // fm = Fashion Market; mm = Mag Moda
if(isset($_GET['website'])) $website=$_GET['website'];

$nome_del_sito = "Moruzzi Numismatica";
$mail_sito_def = "info@moruzzi.it";
$tel_sito_def = "+39 0671545937";
$ind_sito_def = "www.moruzzi.it";

$logo_sito = "Logo_Moruzzi_Orizz.png";
$logo_mail = $http."://".$ind_sito."/img/moruzzi_numismatica_logo.png";
$logo_preload = "logo_vert.png";
$logo_footer = "logo_vert.png";
$color1 = "#880002";
$color1rgb = "136,0,2"; // rosso
$color1hover = "#590001";
$color1hoverrgb = "359,100,35"; // rosso
$lingua="ita";
$callFamily = "raleway";
$color2 = "#e1e1e1"; // giallo
$color2rgb = "225,225,225";
$colorTxtTop = "#31313D";
$colorGrey = "#F9F9F9";


$google_site_key = "6LdwNhIqAAAAADFpmb8CzrDFX-2RsrdIMIDChtxy";
$google_secret_key = "6LdwNhIqAAAAAJe0JUID5NZhDMPq6_O8MHSydEGF";	
	
$cloudeflare_site_key = "0x4AAAAAAASfEaXQfg7m3yKC";
$cloudeflare_secret_key = "0x4AAAAAAASfEVntg1wcgZAYbDzWdaEF9PM";	

$conf_user_paypal = "";
$sandbox=0;
if($sandbox==1) $user_login_paypal="sb-bq8fd4042191@business.example.com"; // PASSWORD 8g,44/Gt
else $user_login_paypal="umberto@moruzzi.it";

$beneficiario_bonifico  = "MORUZZI NUMISMATICA FILATELIA DON BOSCO di Moruzzi Umberto SNC<br/>Monte dei Paschi di Siena Agenzia 133 di Roma<br/>IBAN: IT41U0103003315000000081225<br/>Codice BIC: PASCITM1Z76";
//$beneficiario_bonifico  = "";

$ecommerce = 0; // valori 0 e 1 per disattivare/Attivare le fuinzioni E-Commerce

$limite_spesa = "59.00";
$spesa_italia = "8.90";
$spesa_estero = "14.90";
$spese_contrassegno = "5.00"
?>