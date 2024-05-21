<?php
session_start();
require '../connection/connection.php'; // Include your database connection

// Check if the employer is logged in
if (!isset($_SESSION['employer_data'])) {
    header('Location: index.php');
    exit;
}

$employer_data = $_SESSION['employer_data'];

// Ensure company_id exists in session data
if (!isset($employer_data['Company_ID'])) {
    echo "Error: company_id not found in session data.";
    exit;
}

$company_id = $employer_data['Company_ID']; // Get the company_id from the session data

// Fetch the applications for the internships posted by the currently logged-in employer
$sql = "SELECT ai.*, e.name as company_name 
        FROM application_internship ai
        JOIN internship i ON ai.internship_ID = i.Internship_ID
        JOIN activated_employer e ON i.Company_ID = e.Company_ID
        WHERE e.Company_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <style>
    .btn-group {
        display: flex;
        gap: 10px;
    }
    </style>

</head>
<body>
<div class="container mt-5">
    <h2>Application List</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Student Email</th>
            <th>Student Course</th>
            <th>Internship ID</th>
            <th>Title</th>
            <th>Company Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['student_email']; ?></td>
                <td><?php echo $row['student_course']; ?></td>
                <td><?php echo $row['internship_ID']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td id="status-<?php echo $row['id']; ?>"><?php echo $row['status']; ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-success" onclick="changeStatus(<?php echo $row['id']; ?>, 'Approved')">Approve</button>
                        <button class="btn btn-danger" onclick="changeStatus(<?php echo $row['id']; ?>, 'Rejected')">Reject</button>
                        <a href="../students/<?php echo $row['resume_path']; ?>" class="btn btn-info" target="_blank">View Resume</a>
                        <a href="../students/<?php echo $row['resume_path']; ?>" class="btn btn-secondary" download>Download Resume</a>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
function changeStatus(id, status) {
    $.ajax({
        url: 'update_status.php',
        method: 'POST',
        data: { id: id, status: status },
        success: function(response) {
            if (response === 'success') {
                $('#status-' + id).text(status);
            } else {
                alert('Failed to update status');
            }
        }
    });
}
</script>
</body>
</html>
