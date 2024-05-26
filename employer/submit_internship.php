<?php
session_start();
include '../connection/connection.php'; // Ensure this path is correct based on your file structure

// Check if the employer is logged in
if (!isset($_SESSION['employer_data'])) {
    header("Location: index.php");
    exit();
}

// Handle the delete request
if (isset($_POST['delete_internship_id'])) {
    $internship_id = $_POST['delete_internship_id'];
    
    $sql = "DELETE FROM internship WHERE Internship_ID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $internship_id);
    $stmt->execute();
    if ($stmt === false) {
        die("Error executing statement: " . $stmt->error);
    }
    echo "Internship deleted successfully";
    exit();
}

// Handle the create and update requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete_internship_id'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $duration = $_POST['duration'];
    $company_id = $_SESSION['employer_data']['Company_ID'];

    if (isset($_POST['internship_id']) && !empty($_POST['internship_id'])) {
        $internship_id = $_POST['internship_id'];

        // Update internship
        $sql = "UPDATE internship SET Title = ?, Description = ?, Requirements = ?, Duration = ? WHERE Internship_ID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ssssi", $title, $description, $requirements, $duration, $internship_id);
    } else {
        // Create new internship
        $sql = "INSERT INTO internship (Title, Description, Requirements, Duration, Company_ID, Status) VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ssssi", $title, $description, $requirements, $duration, $company_id);
    }

    $stmt->execute();
    if ($stmt === false) {
        die("Error executing statement: " . $stmt->error);
    }

    header("Location: post_internship.php");
    exit();
}
?>
