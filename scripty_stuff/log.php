<?php

namespace aces;

/* 
    fopen modes
    "r" - Read only. Starts at the beginning of the file
    "r+" - Read/Write. Starts at the beginning of the file
    "w" - Write only. Opens and truncates the file; or creates a new file if it doesn't exist. Place file pointer at the beginning of the file
    "w+" - Read/Write. Opens and truncates the file; or creates a new file if it doesn't exist. Place file pointer at the beginning of the file
    "a" - Write only. Opens and writes to the end of the file or creates a new file if it doesn't exist
    "a+" - Read/Write. Preserves file content by writing to the end of the file
    "x" - Write only. Creates a new file. Returns FALSE and an error if file already exists
    "x+" - Read/Write. Creates a new file. Returns FALSE and an error if file already exists
    "c" - Write only. Opens the file; or creates a new file if it doesn't exist. Place file pointer at the beginning of the file
    "c+" - Read/Write. Opens the file; or creates a new file if it doesn't exist. Place file pointer at the beginning of the file
    "e" - Only available in PHP compiled on POSIX.1-2008 conform systems.

    function set_log(){ 
        $data = array("test"=>"jimmy", "userid"=>1);
        $size = filesize("src/logs/sql_schema.json");
        $file = fopen("src/logs/sql_schema.json", "w+");
        $readdata = array_merge(json_decode(fread($file, $size)), $data);
        fwrite($file, json_encode($readdata));
        fclose($file);
    }

    function get_log(){
        $size = filesize("src/logs/sql_schema.json");
        $file = fopen("src/logs/sql_schema.json", "r"); 
        $data = fread($file, $size);
        fclose($file);
        print_r(json_decode($data));
    }

    get query execution time
    $start = microtime(true)
    run query
    $end = microtime(true)
    $execute = $end - $start
*/

class log{

    // Log directory
    private $log_dir;

    // Log file name
    private $log_name;

    // Log file path (dir/name.txt)
    private $log_path;

    // Header to insert in to log file
    private $header;

    // Log type in case we need to reference it later or in future updates
    private $log_type;

    // Data to be inserted in to log record
    private $log_record;

    // ID of new record being added to file
    private $new_record_id;


    function __construct(){}

    function set_record($type = "query", $data = array()){
        // Setup main variables to run scripts
        $this -> set_variables($type);
        
        // Check for log directory and make new if necessary
        if(!is_dir($this -> log_dir)) mkdir($this -> log_dir);

        // Open file for read/append
        $write_file = fopen($this -> log_path, "a+");

        // Get file size for reading and applying header if needed
        $read_size = filesize($this -> log_path);

        // Check if file has data. If not, make header to start
        if($read_size < 1){
            fwrite($write_file, $this -> header);
            $this -> new_record_id = 1;
        }else{
            // Get file data to put in to array
            $file_data = fread($write_file, $read_size);
        }

        // Load file data to array
        if(!empty($file_data)) $file_data_array = explode("\n", $file_data);

        // Get last element of array for last ID
        if(empty($this -> new_record_id))  $this -> new_record_id = intval(explode(trim("|"), end($file_data_array))[0]) + 1;
        
        // Make new record
        $this -> create_record($data);

        // Add the record to the file
        fwrite($write_file, $this -> log_record);

        // Close file
        if(!empty($file)) fclose($file);
    } // set_record()

    function set_variables($type){
        switch($this -> log_type = $type){
            case "query":
                $this -> header = "id | date | time | ip | table | result count | run time | query";
                $this -> log_dir = aces_log_file_dir_query;
                break;
            case "connection":
                $this -> header = "id | date | time | ip | database";
                $this -> log_dir = aces_log_file_dir_connection;
                break;
            case "query_error":
                $this -> header = "id | date | time | ip | error | query";
                $this -> log_dir = aces_log_file_dir_query_error;
                break;
            case "connection_error":
                $this -> header = "id | date | time | ip | error";
                $this -> log_dir = aces_log_file_dir_connection_error;
                break;
        }
        
        // Generate log name
        $this -> log_name = date("Ym") . "_aces_{$type}_log.txt";
        $this -> log_path = $this -> log_dir . $this -> log_name;
        return $this;
    } // set_variables()

    function create_record($data){
        date_default_timezone_set('America/New_York');
        extract($data);
        
        $log_date = date("Y_m_d");
        $log_time = date("H:i:s");
        
        // Delimiter
        $d = "|";
        $record_id = $this -> new_record_id;
        $ip = $_SERVER["REMOTE_ADDR"];
        
        $initial_record_data =  "\n$record_id $d $log_date $d $log_time $d $ip $d";
        
        switch($this -> log_type){
            case "query":
                // id | date | time | ip | table | result count | run time | query
                $this -> log_record = "$initial_record_data $table $d $result_count $d $run_time $d $query_string";
                break;
            case "connection":
                // id | date | time | ip | database
                $this -> log_record = "$initial_record_data $database";
                break;
            case "query_error":
                // id | date | time | ip | error | query string
                $this -> log_record = "$initial_record_data $error $d $query_string";
                break;
            case "connection_error":
                // id | date | time | ip | error
                $this -> log_record = "$initial_record_data $error";
                break;
        }
        return $this;
    } // create_record()

} // class log
?>