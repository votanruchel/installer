<?php
  global $db;
  if (isset($_POST['db_host'])) {
    $baseconfig = file_get_contents('base.php');
    $baseconfig = str_replace('{baseurl}',$_POST['site_domain'],$baseconfig);
    $baseconfig = str_replace('{dbname}',$_POST['db_name'],$baseconfig);
    $baseconfig = str_replace('{host}',$_POST['db_host'],$baseconfig);
    $baseconfig = str_replace('{dbuser}',$_POST['db_user'],$baseconfig);
    $baseconfig = str_replace('{dbpass}',$_POST['db_pass'],$baseconfig);
    if (file_exists('config.php')) {
      echo "Arquvio de configuracao ja existe!";
      exit;
    }else{
      try {
        global $db;
        $db = new PDO("mysql:dbname=".$_POST['db_name'].";host=".$_POST['db_host'],$_POST['db_user'],$_POST['db_pass']);
        //$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
      //  echo " 1 - Banco de dados conectado com sucesso!";
      } catch (PDOException $e) {
      //  echo utf8_encode($e->getMessage());
        echo "Banco de dados indisponivel / ou nao existe";
        exit;
      }

      if (file_exists('config.sql')) {
        try {
          global $db;
          $sqlquery = file_get_contents('config.sql');
          //var_dump($sqlquery);
          try {
            $sql = $db->exec("".$sqlquery."");
          //  echo "<br>2 - Tableas criadas com sucesso!<br>";
          } catch (PDOException $e) {
            echo utf8_encode($e->getMessage());
          }

        } catch (PDOException $e) {
          echo utf8_encode($e->getMessage());
        }

      }
       $file = fopen('config.php','w');
       fwrite($file, "<?php \r\n ".$baseconfig);
       fclose($file);
       echo "Arquivo de configuracao criado com sucesso";

    }
  }

 ?>
