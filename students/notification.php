<?php
session_start();
require_once("../connection/connection.php");

// Check if the user is not logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Assuming user data is stored in the session
$user_data = $_SESSION['user_data']; 
$user_id = $user_data['id']; // Replace with actual session variable for user ID

// Fetch student data
$studentQuery = "SELECT name, email, course FROM activated_student WHERE id = ?";
$stmt = $conn->prepare($studentQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($student_name, $student_email, $student_course);
$stmt->fetch();
$stmt->close();

// Fetch student's application history with status 'Approved' or 'Rejected'
$applicationsQuery = "
SELECT ai.id, ai.internship_ID, ai.title, ai.company_ID, ai.company_name, ai.status, ai.resume_path
FROM application_internship ai
WHERE ai.student_email = ? AND (ai.status = 'Approved' OR ai.status = 'Rejected')";
$applicationsStmt = $conn->prepare($applicationsQuery);
$applicationsStmt->bind_param("s", $student_email);
$applicationsStmt->execute();
$applicationsResult = $applicationsStmt->get_result();
$applicationsStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Notifications</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Internship ID</th>
                <th>Title</th>
                <th>Company ID</th>
                <th>Company Name</th>
                <th>Status</th>
                <th>Resume Path</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($application = $applicationsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $application['id']; ?></td>
                    <td><?php echo $application['internship_ID']; ?></td>
                    <td><?php echo $application['title']; ?></td>
                    <td><?php echo $application['company_ID']; ?></td>
                    <td><?php echo $application['company_name']; ?></td>
                    <td><?php echo $application['status']; ?></td>
                    <td><a href="<?php echo $application['resume_path']; ?>" target="_blank">View Resume</a></td>
                    <td>
                        <?php if ($application['status'] == 'Rejected'): ?>
                            <button class="btn btn-danger" disabled>Rejected</button>
                        <?php else: ?>
                            <button class="btn btn-success" disabled>Approved</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
