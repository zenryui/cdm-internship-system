<?php
session_start(); // Add session_start() at the beginning to access session data

$servername = "localhost";
$username = "root";
$password = "2474";
$dbname = "cdm-internship-database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle different actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'create') {
        $title = $conn->real_escape_string($_POST['title']);
        $description = $conn->real_escape_string($_POST['description']);
        $requirements = $conn->real_escape_string($_POST['requirements']);
        $duration = $conn->real_escape_string($_POST['duration']);
        
        // Get the company_id from the session data
        if (isset($_SESSION['employer_data'])) {
            $company_id = $_SESSION['employer_data']['Company_ID'];
        } else {
            die("Error: Employer is not logged in.");
        }

        $sql = "INSERT INTO internship (Title, Description, Requirements, Duration, Company_ID) VALUES ('$title', '$description', '$requirements', '$duration', '$company_id')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New internship created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'read') {
        $result = $conn->query("SELECT * FROM internship");
        $internships = array();
        while ($row = $result->fetch_assoc()) {
            $internships[] = $row;
        }
        echo json_encode($internships);
    } elseif ($action == 'view' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $result = $conn->query("SELECT * FROM internship WHERE Internship_ID = $id");
        echo json_encode($result->fetch_assoc());
    } elseif ($action == 'update' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $title = $conn->real_escape_string($_POST['title']);
        $description = $conn->real_escape_string($_POST['description']);
        $requirements = $conn->real_escape_string($_POST['requirements']);
        $duration = $conn->real_escape_string($_POST['duration']);

        $sql = "UPDATE internship SET Title='$title', Description='$description', Requirements='$requirements', Duration='$duration' WHERE Internship_ID = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo "Internship updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM internship WHERE Internship_ID = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo "Internship deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
