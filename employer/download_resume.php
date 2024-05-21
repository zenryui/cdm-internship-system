<?php
require_once("../connection/connection.php");

// Start session and check employer login
session_start();
if (!isset($_SESSION['employer_data'])) {
    header("Location: index.php");
    exit;
}

// Check if application_id is passed
if (!isset($_GET['application_id'])) {
    echo "Application ID is required.";
    exit;
}

$application_id = intval($_GET['application_id']);

// Fetch application data from database
$stmt = $conn->prepare("SELECT ai.*, s.*, r.* FROM application_internship ai
                        JOIN activated_student s ON ai.student_email = s.email
                        JOIN table_resume r ON s.id = r.user_id
                        WHERE ai.id = ?");
$stmt->bind_param("i", $application_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "Application not found.";
    exit;
}

// Prepare resume content
$resume_content = "Name: " . $user_data['name'] . "\n";
$resume_content .= "Address: " . $user_data['address'] . "\n";
$resume_content .= "Contact No.: " . $user_data['contact_no'] . "\n";
$resume_content .= "Email: " . $user_data['email'] . "\n\n";
$resume_content .= "OBJECTIVE:\n" . $user_data['objective'] . "\n\n";
$resume_content .= "PERSONAL INFORMATION:\n";
$resume_content .= "Birthdate: " . $user_data['birthday'] . "\n";
$resume_content .= "Birthplace: " . $user_data['birthplace'] . "\n";
$resume_content .= "Citizenship: " . $user_data['citizenship'] . "\n";
$resume_content .= "Religion: " . $user_data['religion'] . "\n";
$resume_content .= "Languages Spoken: " . $user_data['languages_spoken'] . "\n";
$resume_content .= "Civil Status: " . $user_data['civil_status'] . "\n\n";
$resume_content .= "EDUCATIONAL BACKGROUND:\n";
$resume_content .= "Course: " . $user_data['course'] . "\n";
$resume_content .= "Tertiary Education: " . $user_data['tertiary_education'] . " (" . $user_data['tertiary_year'] . ")\n";
$resume_content .= "Secondary Education: " . $user_data['secondary_education'] . " (" . $user_data['secondary_year'] . ")\n";
$resume_content .= "Primary Education: " . $user_data['primary_education'] . " (" . $user_data['primary_year'] . ")\n";

// Set headers for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="resume_' . $user_data['name'] . '.txt"');
header('Content-Length: ' . strlen($resume_content));
echo $resume_content;
exit;
?>
