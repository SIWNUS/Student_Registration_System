<?php

session_start();

header('Content-Type: application/json');

function generate_otp(){
    $otp = '';
    for ($i = 0; $i < 6; $i++) {
        $num = random_int(0,9);
        $otp .= (string)$num;
    }
    return $otp;
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (empty($email)){
        $response['error'] = 'Fill in all the details';
        echo json_encode($response);
        exit();
    }

    // check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = 'Invalid email format';
        echo json_encode( $response );
        exit;
    } else {
        $otp = generate_otp();
        
        $subject = "OTP for verification -reg.";

        $msg = "This is the OTP: " . $otp;

        $header = "From: suswinpalaniswamy@gmail.com";

        if (mail($email, $subject, $msg, $header) ) {
            $response["success"] = "OTP sent successfully. \nCheck your mail.";
            echo json_encode( $response );
            $_SESSION['email'] = $email;
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_valid_time'] = time() + 300;
            exit();
        } else {
            $response['error'] = "Mail not sent. Try again.";
            echo json_encode( $response );
            exit();
        }        
    }
}

?>