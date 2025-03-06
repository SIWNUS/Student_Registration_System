<?php

session_start();
if (!isset($_SESSION["logged_in"])|| !isset($_SESSION['email'])) {
    echo "<script>alert('You are not logged in! Redirecting to home page!');</script>";
    echo "<script>window.location.assign('../index.php');</script>";
}
include("../config/db.php");

header('Content-Type: application/json');   

$response = [];

$student_email = $_GET['email'];

if (!isset($_GET['email'])) {
    $response['error'] = 'No student specified to delete.';
    echo json_encode($response);
    exit();
}

$sql = "DELETE FROM students WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    $response["error"] = "Prepare failed: " . $conn->error;
    echo json_encode($response);
    exit();
}

$stmt->bind_param("s", $student_email);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $response["success"] = "Records deleted successfully!";
        echo json_encode($response);
        $stmt->close();
        exit();
    } else {
        $response["error"] = "No record found with that email.";
        echo json_encode($response);
        $stmt->close();
        exit();
    }
} else {
    $response['error'] = "Error executing deletion: " . $stmt->error;
    echo json_encode($response);
    $stmt->close();
    exit();
}



?>