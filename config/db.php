<?php

$$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT');
$dbname = getenv('MYSQLDATABASE') ?: 'your_database_name';

$conn = new mysqli($host, $user, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Error connecting to database: \n" . $conn->connect_error);
}

?>