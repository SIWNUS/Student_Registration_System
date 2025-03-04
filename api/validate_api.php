<?php

session_start();

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['otp']) && isset($_SESSION['otp_valid_time'])) {
    if (time() >= $_SESSION['otp_valid_time']) {
        $response['error'] = 'OTP expired!';
        unset( $_SESSION['otp'] );
        echo json_encode($response);
        exit();
    }

    if (empty($_POST['otp'])) {
        $response['error'] = 'No OTP provided';
        echo json_encode($response);
        exit();
    }
    
    $otp = $_POST['otp'];
    if ($otp === $_SESSION['otp']) {
        $response['success'] = "OTP verified!";
        unset( $_SESSION["otp"] );
        echo json_encode($response);
        exit();
    } else {
        $response["error"] = "Wrong OTP!";
        echo json_encode($response);
        exit();
    }
} else if (!isset($_SESSION['otp'])) {
    $response['error'] = 'No OTP generated!';
    echo json_encode($response);
    exit();
} else {
    $response['error'] = "Form not submitted properly! Please try again!";
    echo json_encode($response);
    exit();
}

?>