<?php

ob_start();
session_start();
header('Content-Type: application/json');

include("../config/db.php");

require '../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dtfkwnn8w',
        'api_key'    => '236292654365697',
        'api_secret' => 'Dmntux07BhmEvgM1EoaeU8V-x_Q'
    ],
    'url' => ['secure' => true]
]);

function age($bday) {
    $dob = new DateTime($bday);
    $today = new DateTime();
    return (string) $dob->diff($today)->y;
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email']) && isset($_SESSION['password'])) {

    $name     = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email    = $_SESSION['email'];
    $password = $_SESSION['password'];
    $dob      = $_POST['dob'];
    $gender   = $_POST['gender'];

    if (empty($name) || empty($dob) || empty($gender)) {
        $response['error'] = 'Fill in all the details';
        ob_clean();
        echo json_encode($response);
        exit();
    }

    $age = age($dob);
    $profile_pic = "";

    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] == 0) {

        $accepted = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];
        $filename = $_FILES['myfile']['name'];
        $filetype = $_FILES['myfile']['type'];
        $filesize = $_FILES['myfile']['size'];
        $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!array_key_exists($ext, $accepted) || !in_array(strtolower($filetype), $accepted)) {
            $response['error'] = 'Unaccepted file format or type!';
            ob_clean();
            echo json_encode($response);
            exit();
        }

        if ($filesize > (5 * 1024 * 1024)) {
            $response['error'] = 'File too big!';
            ob_clean();
            echo json_encode($response);
            exit();
        }

        try {
            $uploadResult = (new UploadApi())->upload($_FILES['myfile']['tmp_name'], [
                'folder' => 'students_profiles'
            ]);
            $profile_pic = $uploadResult['secure_url'];
        } catch (Exception $e) {
            $response["error"] = "Cloudinary upload failed: " . $e->getMessage();
            ob_clean();
            echo json_encode($response);
            exit();
        }

    } else {
        $response["error"] = "You have to set your profile pic";
        ob_clean();
        echo json_encode($response);
        exit();
    }

    $sql = "INSERT INTO students (name, email, password, dob, age, gender, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssss", $name, $email, $password, $dob, $age, $gender, $profile_pic);
        if ($stmt->execute()) {
            $response["success"] = "Registered successfully";
            session_unset();
        } else {
            $response["error"] = "Database error: " . $stmt->error;
        }
        ob_clean();
        echo json_encode($response);
        $stmt->close();
    } else {
        $response["error"] = "Database error: " . $conn->error;
        ob_clean();
        echo json_encode($response);
    }
} else {
    $response["error"] = "Invalid request or session expired.";
    ob_clean();
    echo json_encode($response);
}

ob_end_flush();
?>