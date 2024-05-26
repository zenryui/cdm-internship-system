<?php
session_start();
require_once("../connection/connection.php");

if (!isset($_SESSION['user_data'])) {
    header("Location: index.php");
    exit;
}

$user_data = $_SESSION['user_data'];
$student_email = $user_data['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $internshipID = $_POST['internshipID'];

    $cancelQuery = "UPDATE application_internship SET status = 'Cancelled' WHERE internship_ID = ? AND student_email = ?";
    $stmt = $conn->prepare($cancelQuery);
    $stmt->bind_param("is", $internshipID, $student_email);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
    $stmt->close();
}
?>
