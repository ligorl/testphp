<?php

$data['db'] = new ConectDB();
$data['db']->conect($config['db_host'], $config['db_login'], $config['db_pass'], $config['db_name']);
$config['link'] = $data['db']->getDBConnect();

class ConectDB {

     public $db;

    function conect($host, $login, $pass, $name_bd) {
        $this->db = mysqli_connect($host, $login, $pass) or die("Ошибка соедининия с MySQL.");
        
        mysqli_select_db($this->db,$name_bd) or die("Ошибка подключения к базе.");
        
    }
    
    public function getDBConnect(){
        return $this->db;
    }
    public function setDBConnect($link){
        $this->db = $link;
    }

}

?>
