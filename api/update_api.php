<?php
ob_start();
session_start();
header('Content-Type: application/json');

include("../config/db.php");
include("age_finder.php");

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {

    $name    = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email   = $_SESSION['email'];
    $password= $_SESSION['password'];
    $dob     = $_POST['dob'];
    $gender  = $_POST['gender'];

    if (empty($name) || empty($dob) || empty($gender) || empty($email)) {
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
    
            if (substr($upload_dir, -1) !== '/') {
                $upload_dir .= '/';
            }
    
            if (!chmod($upload_dir, 0777)) {
                error_log("Failed to change permissions for $upload_dir");
            }
    
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
    
            $upload_dir = '/tmp/uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
    
            $new_filename = uniqid() . "." . $ext;
            if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $upload_dir . $new_filename)) {
                $profile_pic = $new_filename;
            } else {
                $response["error"] = "There was a problem uploading your file. Please try again.";
                echo json_encode($response);
                exit();
            }
        }
    }

    if ($profile_pic) {
        $sql = "UPDATE students SET name=?, dob=?, age=?, gender=?, profile_pic=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $dob, $age, $gender, $profile_pic, $_SESSION['email']);
    } else {
        $sql = "UPDATE students SET name=?, dob=?, age=?, gender=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $dob, $age, $gender, $_SESSION['email']);
    }

    if ($stmt->execute()) {
        $response["success"] = "Registered successfully";
    } else {
        $response["error"] = "Database error: " . $stmt->error;
    }

    ob_clean();
    echo json_encode($response);
    $stmt->close();

} else {
    $response["error"] = "Invalid request or session expired.";
    ob_clean();
    echo json_encode($response);
}
ob_end_flush();
?>