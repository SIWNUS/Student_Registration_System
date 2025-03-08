<?php

ob_start();

session_start();
header('Content-Type: application/json');

include("../config/db.php");

ini_set('upload_max_filesize', '5M');
ini_set('post_max_size', '6M');


function age($bday) {
    $dob = new DateTime($bday);
    $today = new DateTime();

    $age = $dob->diff($today)->y;
    return (string)$age;
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email']) && isset($_SESSION['password'])) {

    $name    = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email   = $_SESSION['email'];
    $password= $_SESSION['password'];
    $dob     = $_POST['dob'];
    $gender  = $_POST['gender'];

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

        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (!array_key_exists($ext, $accepted)) {
            $response['error'] = 'Unaccepted file format!';
            ob_clean();
            echo json_encode($response);
            exit();
        }

        if (!in_array(strtolower($filetype), $accepted)) {
            $response['error'] = 'Unaccepted file type!';
            ob_clean();
            echo json_encode($response);
            exit();
        }

        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            $response['error'] = 'File too big!';
            ob_clean();
            echo json_encode($response);
            exit();
        }

        $upload_dir = getenv('RAILWAY_VOLUME_MOUNT_PATH') ?: (__DIR__ . '/../uploads/');


        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_filename = uniqid() . "." . $ext;
        var_dump(getenv('RAILWAY_RUN_UID'));
        var_dump(getenv('RAILWAY_VOLUME_MOUNT_PATH'));

        var_dump($upload_dir);
        var_dump(is_writable($upload_dir));
        var_dump($_FILES['myfile']['tmp_name']);

        if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $upload_dir . $new_filename)) {
            $profile_pic = $new_filename;
        } else {
            $response["error"] = "There was a problem uploading your file. Please try again.";
            // ob_clean();
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