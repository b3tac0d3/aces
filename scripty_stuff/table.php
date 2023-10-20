<?php

namespace aces;
use PDO;
use PDOException;
use error_handler\load_errors;

class table extends db{
    
    // Databse object
    private $db;

    // Table name
    private $table_name;

    // Executable query string
    private $query_string;

    // List of columns for query
    private $columns_list;


    

    function __construct(){
        $this -> db = $this -> connect();
    }

    function create($name, $columns = array()){
        /* 
            $tbl -> add_col("id", "int", 11, "not null primary key auto_increment")
            $tbl -> create($cols)

        */
        $this -> table_name = $name;
        // $this -> columns_list = $this -> format_columns($columns);
    }

    function truncate(){}

    function update(){}

    function add_col($name, $type, $length = null, $params = null){

    }

    function delete_col(){}

    private function sample_array(){
        // Just a sample array for reference
        $log_entry = array(
            "type" => "create",
            "date" => strtotime(time()),
            "command_count" => 4,
            "commands" => array(
                1 => array(
                    "short" => "create table users",
                    "full" => "create table users(id int not null primary key auto_increment, username varchar(255), active boolean)",
                ),
                2 => array(
                    "short" => "create table contacts",
                    "full" => "create table contacts(id int not null primary key auto_increment, username varchar(255), active boolean)",
                ),
                3 => array(
                    "short" => "create table emails",
                    "full" => "create table emails(id int not null primary key auto_increment, username varchar(255), active boolean)",
                )
            )
        );
    }

} // class table
?>