<?php 

$aces_doc_root = $_SERVER["DOCUMENT_ROOT"];
// Use if log directory is the same for all
$aces_log_directory = "logs/";

// Master config file for aces
define("aces_config", 1); // DO NOT CHANGE

// Database conneection info
define("aces_db_host", $_SESSION['fnd']['db']['host']);
define("aces_db_charset", $_SESSION['fnd']['db']['charset']);
define("aces_db_port", $_SESSION['fnd']['db']['port']);
define("aces_db_name", $_SESSION['fnd']['db']['database']);
define("aces_db_user", $_SESSION['fnd']['db']['username']);
define("aces_db_pass", $_SESSION['fnd']['db']['password']);

// Turn file logs on or off
define("aces_log_status_query", true); // Query log on or off (true | false)
define("aces_log_status_connection", true); // Connection log on or off (true | false)
define("aces_log_status_error", true); // Error log on or off (true |)

// Log file paths (directories)
define("aces_log_file_dir_query", $aces_doc_root . $aces_log_directory); // Query log file location
define("aces_log_file_dir_connection", $aces_doc_root . $aces_log_directory); // Connection log file location
define("aces_log_file_dir_query_error", $aces_doc_root . $aces_log_directory); // Query error log file location
define("aces_log_file_dir_connection_error", $aces_doc_root . $aces_log_directory); // Connection error log file location

// Log options
define("aces_log_time_limit_query", "M"); // Default to monthly - "W" (Weekly) | "M" (Monthly) | "Q" (Quarterly) | "Y" (Yearly)
define("aces_log_time_limit_connection", "M"); // Default to monthly - "W" (Weekly) | "M" (Monthly) | "Q" (Quarterly) | "Y" (Yearly)

// Database record logging options
define("aces_db_record_logging_life", true); // Set to false if you don't want to log record create and delete records in the database
define("aces_db_record_logging_edits", true); // Set to false if you don't want to log record edits and values in the database

?>