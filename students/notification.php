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
    <title>Apply for Internships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: #7d8da1;
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .section-divider-top {
            border-bottom: 2px solid #e9ecef;
            margin: 50px 0;
        }

        .section-divider-bot {
            border-bottom: 2px solid #e9ecef;
            margin: 25px 0;
        }

        .dashboard-table {
            font-size: 12px;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
        }

        .modern-table thead {
            background-color: white;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
        }

        .modern-table th, .modern-table td {
            padding: 12px 15px;
        }

        .modern-table th {
            text-align: left;
            font-weight: bold;
        }

        .modern-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .modern-table tbody tr:hover {
            background-color: #e9ecef;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
        }

        /* for modal */
        .form-group {
            margin: 20px;
        }

        .btn {
            margin-left: 20px;
        }

        /* Scrollable table */
        .table-responsive {
            overflow-y: auto;
        }

        .scrollable-table {
            max-height: 150px;
            overflow-y: auto;
            display: block;
        }
        

    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="container mt-4">
    <h2 style="text-align: left;">Notifications</h2>
    <table class="modern-table dashboard-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Internship ID</th>
                <th>Title</th>
                <th>Company ID</th>
                <th>Company Name</th>
                <th>Status</th>
                <th>Resume</th>
                <th></th>
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
                            <button class="btn btn-danger" disabled style="font-size: 12px;">Rejected</button>
                        <?php else: ?>
                            <button class="btn btn-success" disabled style="font-size: 12px;">Approved</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
           function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
