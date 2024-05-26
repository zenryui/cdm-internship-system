<?php
session_start();
require '../connection/connection.php'; // Include your database connection
require 'mail_config.php'; // Include your mail configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Fetch the student email and name based on application ID
    $sql = "SELECT ai.student_name, ai.student_email, i.title
            FROM application_internship ai
            JOIN internship i ON ai.internship_ID = i.Internship_ID
            WHERE ai.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();

    if ($application) {
        $student_email = $application['student_email'];
        $student_name = $application['student_name'];
        $job_title = $application['title'];

        // Update the status of the application
        $update_sql = "UPDATE application_internship SET status = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $status, $id);
        if ($update_stmt->execute()) {
            // Send email notification to the student
            $subject = "Application Status Update";
            $body = "Dear $student_name,<br><br>Your application for the position of $job_title has been $status.<br><br>Best regards,<br>CDM Internship Team";
            
            if (sendMail($student_email, $subject, $body)) {
                echo 'success';
            } else {
                error_log("Email failed to send to $student_email.");
                echo 'email_error';
            }
        } else {
            error_log("Failed to update status in the database.");
            echo 'update_error';
        }
    } else {
        error_log("Application not found for id $id.");
        echo 'application_not_found';
    }
}
?>
