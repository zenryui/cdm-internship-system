<?php
session_start(); // Start the session

require_once("../connection/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_SESSION['user_data'])) {
    $internshipID = $_GET['id'];
    $studentName = $_SESSION['user_data']['name'];
    $studentEmail = $_SESSION['user_data']['email'];
    $course = $_SESSION['user_data']['course'];

    // Check if the internship_applications table exists
    $checkTableQuery = "SHOW TABLES LIKE 'internship_applications'";
    $tableResult = $conn->query($checkTableQuery);

    if ($tableResult->num_rows == 0) {
        // The internship_applications table does not exist, create it
        $createTableQuery = "CREATE TABLE internship_applications (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            Internship_ID INT NOT NULL,
            Student_Name VARCHAR(255) NOT NULL,
            Student_Email VARCHAR(255) NOT NULL,
            Course VARCHAR(255) NOT NULL,
            Application_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (Internship_ID) REFERENCES internship(ID)
        )";
        $createTableResult = $conn->query($createTableQuery);

        if (!$createTableResult) {
            echo "Error creating internship_applications table: " . $conn->error;
            exit();
        }
    }

    // Insert application into database
    $sql = "INSERT INTO internship_applications (Internship_ID, Student_Name, Student_Email, Course) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $internshipID, $studentName, $studentEmail, $course);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Application successful
        header("Location: student-dashboard.php");
        exit();
    } else {
        // Error handling
        echo "Error applying for internship: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Redirect the user to login page or display an error message
    header("Location: login.php");
    exit();
}

$conn->close();
?>
