<?php

$servername = "localhost";
$dbname = "mswiss";
$username = "root";
$password = "";
$db_conn;

try {
    $db_conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db_conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e)
{   
    echo "Connection failed " . $e -> getMessage();
}

?>