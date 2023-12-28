<?php
namespace config;

// This class is used to configure the database connection
// It holds the database credentials and a method to connect to the database
// We will use this class on index.php to connect to the database

use mysqli;

class DatabaseConfig
{
    public static $db_host = "localhost";
    public static $db_user = "root";
    public static $db_pass = "";
    public static $db_name = "neolearn";

    public static function configDatabase() {
        $conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);

        if ($conn->connect_error) {
            $message = array("message" => "Database Connection failed");
            die(json_encode($message));
        }

        return $conn;
    }
}
