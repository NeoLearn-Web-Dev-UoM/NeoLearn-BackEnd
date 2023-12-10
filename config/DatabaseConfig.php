<?php
// DB Credentials
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "neolearn";

function configDatabase() {
    global $db_host, $db_user, $db_pass, $db_name;
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $message = array("message" => "Database Connection failed");
        die(json_encode($message));
    }

    return $conn;
}