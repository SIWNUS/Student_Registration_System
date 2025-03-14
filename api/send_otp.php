<?php

ob_start();

session_start();

ini_set('display_errors', 0);
error_reporting(0);


header('Content-Type: application/json');

include '../config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

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
        ob_clean();
        echo json_encode($response);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = 'Invalid email format';
        ob_clean();
        echo json_encode( $response );
        exit;
    } else {

        $checkEmailQuery = "SELECT id FROM students WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result(); // Needed to get num_rows
            if ($stmt->num_rows > 0) {
                $response["exist_error"] = "This email is already registered.";
                ob_clean();
                echo json_encode($response);
                $stmt->close();
                exit();
            }
            $stmt->close();
        } else {
            $response["error"] = "Database error: " . $conn->error;
            ob_clean();
            echo json_encode($response);
            exit();
        }

        $otp = generate_otp();
        
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'suswinpalaniswamy@gmail.com';
            $mail->Password = 'bogr nach ysxa yhfv';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('suswinpalaniswamy@gmail.com','Suswin');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Verification - reg.';
            $mail->Body = '<p>Your OTP: <strong>' . $otp . '</strong></p>';
            $mail->AltBody = 'Your OTP: ' . $otp;;

            $mail->send();

            $_SESSION['email'] = $email;
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_valid_time'] = time() + 300;

            $response["success"] = "OTP sent successfully. \nCheck your mail.";
            ob_clean();
            echo json_encode( $response );
        } catch (Exception $e) {
            $response['error'] = "Message could not be sent. Error: ". $e->getMessage() ."Please try again!";
            ob_clean();
            echo json_encode( $response );
        }        
    }
}

ob_end_flush();
?>