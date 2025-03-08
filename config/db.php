<?php

$host = "localhost";
$user = "root";
$pass = "Su\$i0410";
$dbname = "students_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error connecting to database: \n" . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(155) NOT NULL,
    age VARCHAR(5) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    department VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
);";

$conn->query($sql);

?>