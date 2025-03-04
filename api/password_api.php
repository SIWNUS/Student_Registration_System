<?php

session_start();

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['re_password'];

    if (empty($password) || empty($confirm_password)) {
        $response['error'] = 'Fill in all the details';
        echo json_encode($response);
        exit();
    }

    $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/";
    if (preg_match($pattern, $password)) {
        
        if ($password !== $confirm_password) {
            $response['error'] = 'Passwords do not match';
            echo json_encode($response);
            exit();
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $_SESSION['password'] = $hashedPassword;
            $response['success'] = "Password confirmed! You can proceed!";
            echo json_encode($response);
            exit();
        }
    } else {
        $response["error"] = "Password must be 8 characters long. Must contain at least 1 uppercase, lowercase, number and symbol.";
        echo json_encode($response);
        exit(); 
    }
} else {
    $response["error"] = "Form not submitted properly! Please try again!";
    echo json_encode($response);
    exit();
}

?>