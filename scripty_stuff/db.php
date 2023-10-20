<?php

namespace aces;
use PDO;
use PDOException;

if(!defined("aces_config")) require_once($_SERVER['DOCUMENT_ROOT'] . "/src/app/plugins/aces/config.php");

class db{
    private $log;
    private $db;

    function connect($db_name = null){
        $this -> log = new log();
        if(empty($_SESSION)) session_start();
        $host = aces_db_host;
        $charset = aces_db_charset;
        $port = aces_db_port;
        $user = aces_db_user;
        $pass = aces_db_pass;
        if(empty($db_name)) $db_name = aces_db_name;

        try{
            $this -> db = new PDO("mysql:host=$host;charset=$charset;port=$port;dbname=$db_name", $user, $pass);
        }catch(PDOException $e){
            // $this -> log -> set_record("connection_error", ["error" => trim($e -> getMessage())]);
            echo $e -> getMessage();
            return;
        } // try

        $this -> db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // If we've made it this far, log the good connection
        $this -> log -> set_record("connection", ["database" => $db_name]);
        return $this -> db;
    } // connect()
} // class db

?>