<?php

$host = "localhost";
$user = "root";
$pass = "Su\$i0410";
$dbname = "students_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error connecting to databse: \n". $conn->connect_error);
}

?>