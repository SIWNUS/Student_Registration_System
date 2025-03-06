<?php
// Ensure no whitespace exists before this tag

ob_start(); // Start output buffering
session_start();

header('Content-Type: application/json');

include('../config/db.php');

function generate_otp(){
    $otp = '';
    for ($i = 0; $i < 6; $i++) {
        $otp .= random_int(0, 9);
    }
    return $otp;
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        $response['error'] = 'Fill in all the details';
        echo json_encode($response);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = 'Invalid email format';
        echo json_encode($response);
        exit();
    }

    $checkEmailQuery = "SELECT id FROM students WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $response['exist_error'] = "This email is already registered.";
            echo json_encode($response);
            $stmt->close();
            exit();
        }
        $stmt->close();
    } else {
        $response['error'] = "Database error: " . $conn->error;
        echo json_encode($response);
        exit();
    }

    $otp = generate_otp();
    $subject = "OTP for verification - reg.";
    $msg = "This is the OTP: " . $otp;
    $header = "From: suswinpalaniswamy@gmail.com";

    if (mail($email, $subject, $msg, $header)) {
        // Set session variables before sending the JSON response
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_valid_time'] = time() + 300;

        $response['success'] = "OTP sent successfully. Check your mail.";
        echo json_encode($response);
        exit();
    } else {
        $response['error'] = "Mail not sent. Try again.";
        echo json_encode($response);
        exit();
    }
}

ob_end_flush();
?>
