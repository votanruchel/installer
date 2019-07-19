require 'environment.php';

$config = array();
//Definindo dados padrões das paginas
define('ADMIN_USER','{admuser}');
define('ADMIN_EMAIL','{admmail}');
define('ADMIN_PASSOWRD','{admpass}');
define('DEFAULT_EMAIL','{dfmail}');


if(ENVIRONMENT == "development"){
    define("BASE_URL", "{baseurl}");
    $config['dbname'] = '{dbname}';
    $config['host'] = '{host}';
    $config['dbuser'] = '{dbuser}';
    $config['dbpass'] = '{dbpass}';
}else{
  define("BASE_URL", "{baseurl}");
  $config['dbname'] = '{dbname}';
  $config['host'] = '{host}';
  $config['dbuser'] = '{dbuser}';
  $config['dbpass'] = '{dbpass}';

global $db;
try{
    $db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],$config['dbuser'],$config['dbpass']);
}catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}
