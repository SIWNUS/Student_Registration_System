<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("../pages/login.php");
    exit();
}

?>