<?php
require_once("../connection/connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_course = $_POST['student_course'];
    $internship_ID = $_POST['internship_ID'];
    $title = $_POST['title'];
    $company_ID = $_POST['company_ID'];

    // Fetch the company name using a JOIN query
    $company_name_query = $conn->prepare("SELECT e.name FROM internship i JOIN activated_employer e ON i.Company_ID = e.Company_ID WHERE i.Internship_ID = ?");
    $company_name_query->bind_param("i", $internship_ID);
    $company_name_query->execute();
    $company_name_query->bind_result($company_name);
    $company_name_query->fetch();
    $company_name_query->close();

    // Ensure the uploads directory exists
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Handle file upload
    $resume_path = $upload_dir . basename($_FILES['resume']['name']);
    if (move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path)) {
        // Insert application data into the database
        $stmt = $conn->prepare("INSERT INTO application_internship (student_name, student_email, student_course, internship_ID, title, company_ID, company_name, resume_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissss", $student_name, $student_email, $student_course, $internship_ID, $title, $company_ID, $company_name, $resume_path);

        if ($stmt->execute()) {
            echo "Application submitted successfully.";
        } else {
            echo "Error submitting application.";
        }
        $stmt->close();
    } else {
        echo "Error uploading resume.";
    }
}
?>
