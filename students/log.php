<?php
session_start();
include '../connection/connection.php';

// Check if the user is not logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

$user_data = $_SESSION['user_data'];
$id = $user_data['id'];
$student_email = $user_data['email'];

// Fetch 3 latest internships posted by employers
$announcementsQuery = "
    SELECT CONCAT('New Internship Posted by ', e.name) AS announcement
    FROM internship i
    JOIN activated_employer e ON i.Company_ID = e.Company_ID
    ORDER BY i.posted_date DESC
    LIMIT 3";
$announcementsResult = $conn->query($announcementsQuery);
if (!$announcementsResult) {
    die("Error fetching announcements: " . $conn->error);
}
$announcements = [];
while ($row = $announcementsResult->fetch_assoc()) {
    $announcements[] = $row['announcement'];
}

// Fetch 3 latest notifications for the logged-in student
$notificationsQuery = "
    SELECT CONCAT('Your application for ', ai.title, ' at ', ai.company_name, ' is ', ai.status) AS notification
    FROM application_internship ai
    WHERE ai.student_email = ? AND ai.status = 'approved'
    ORDER BY ai.application_date DESC
    LIMIT 3";
$notificationsStmt = $conn->prepare($notificationsQuery);
if (!$notificationsStmt) {
    die("Error preparing notifications statement: " . $conn->error);
}
$notificationsStmt->bind_param("s", $student_email);
$notificationsStmt->execute();
$notificationsResult = $notificationsStmt->get_result();
if (!$notificationsResult) {
    die("Error fetching notifications: " . $conn->error);
}
$notifications = [];
while ($row = $notificationsResult->fetch_assoc()) {
    $notifications[] = $row['notification'];
}
$notificationsStmt->close();

// Fetch 3 available internships
$internshipsQuery = "
    SELECT i.Title AS title, e.name AS company_name
    FROM internship i
    JOIN activated_employer e ON i.Company_ID = e.Company_ID
    LIMIT 3";
$internshipsResult = $conn->query($internshipsQuery);
if (!$internshipsResult) {
    die("Error fetching internships: " . $conn->error);
}
$internships = [];
while ($row = $internshipsResult->fetch_assoc()) {
    $internships[] = $row;
}

// Fetch 3 pending applications for the logged-in student
$pendingApplicationsQuery = "
    SELECT ai.title, ai.company_name, ai.status
    FROM application_internship ai
    WHERE ai.student_email = ? AND ai.status = 'Pending'
    LIMIT 3";
$pendingApplicationsStmt = $conn->prepare($pendingApplicationsQuery);
if (!$pendingApplicationsStmt) {
    die("Error preparing pending applications statement: " . $conn->error);
}
$pendingApplicationsStmt->bind_param("s", $student_email);
$pendingApplicationsStmt->execute();
$pendingApplicationsResult = $pendingApplicationsStmt->get_result();
if (!$pendingApplicationsResult) {
    die("Error fetching pending applications: " . $conn->error);
}
$pendingApplications = [];
while ($row = $pendingApplicationsResult->fetch_assoc()) {
    $pendingApplications[] = $row;
}
$pendingApplicationsStmt->close();

// Fetch user data from the activated_student table
$stmt = $conn->prepare("SELECT name, sex, address, course, studentID, birthday, contact_no, email FROM activated_student WHERE id = ?");
if (!$stmt) {
    die("Error preparing user data statement: " . $conn->error);
}
$stmt->bind_param("i", $user_data['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user_data = array_merge($user_data, $result->fetch_assoc());
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="shortcut icon" href="../assets/img/nvidia.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #7d8da1;
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .dashboard-card {
            background-color: white;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
            transition: transform 0.3s ease; /* Smooth transition for scaling effect */
        }

        .dashboard-card:hover {
            transform: scale(1.05); /* Scale transformation on hover */
        }

        .dashboard-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #75A47F;
        }

        .dashboard-card p {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .dashboard-table th, .dashboard-table td {
            padding: 8px;
            font-size: 12px;
            color: #7d8da1;
        }

        .dashboard-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .dashboard-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .dashboard-table tbody tr:hover {
            background-color: #e9ecef;
        }

        .section-divider-top {
            border-bottom: 2px solid #e9ecef;
            margin: 5px 0;
        }

        .sidebar a {
            font-size: 14px;
        }

        .sidebar .brand {
            font-size: 18px;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

            .modern-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease; /* Smooth transition for scaling effect */
        }

        .modern-table:hover {
            transform: scale(1.05); /* Scale transformation on hover */
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
            color: #75A47F;
        }

        .modern-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .modern-table tbody tr:hover {
            background-color: #e9ecef;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
        }

        .pending-status {
            color: #FF7F3E;
            font-weight: 400;
        }

        .text-top {
            color: #75A47F;
        }

        .float-right {
            float: right;
            margin: 20px;
            color: #75A47F;
            font-size: 12px;
        }
        .float-right:hover {
            text-decoration: none;
            color: #75A47F;
        }

        h1, h2, h3 {
            font-size: 12px;
            color: #75A47F;
        }
        .float-right-table {
            float: right;
            margin: 8px;
            color: #75A47F;
            font-size: 12px;
        }

        .float-right-table:hover {
            color: #75A47F;
            text-decoration: none;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center" style="margin-top: -30px;">Welcome to Student's Dashboard, <span style="color: #75A47F;"><?php echo $user_data['name']; ?></span></h5>
            </div>
        </div>
        <div class="section-divider-top"></div>
        <div class="section-divider-top" style="visibility: hidden;"></div>
        <div class="section-divider-top" style="visibility: hidden;"></div>
        <div class="section-divider-top" style="visibility: hidden;"></div>
        <div class="section-divider-top" style="visibility: hidden;"></div>
        <div class="section-divider-top" style="visibility: hidden;"></div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Announcements</h3>
                    <div class="section-divider-top"></div>
                    <?php foreach ($announcements as $announcement): ?>
                        <p><?php echo $announcement; ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="dashboard-card">
                    <h3>Notifications</h3>
                    <div class="section-divider-top"></div>
                    <?php foreach ($notifications as $notification): ?>
                        <p><?php echo $notification; ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card" style="width: 300px;">
                    <h3>My Information</h3>
                    <div class="section-divider-top"></div>
                    <p style="text-align:left;">Name: <span style="color: #75A47F;"><?php echo $user_data['name']; ?></span></p>
                    <p style="text-align:left;">Sex: <span style="color: #75A47F;"><?php echo $user_data['sex']; ?></span></p>
                    <p style="text-align:left;">Email: <span style="color: #75A47F;"><?php echo $user_data['email']; ?></span></p>
                    <p style="text-align:left;">Address: <span style="color: #75A47F;"><?php echo $user_data['address']; ?></span></p>
                    <p style="text-align:left;">Student ID: <span style="color: #75A47F;"><?php echo $user_data['studentID']; ?></span></p>
                    <p style="text-align:left;">Birthday: <span style="color: #75A47F;"><?php echo $user_data['birthday']; ?></span></p>
                    <p style="text-align:left;">Contact No: <span style="color: #75A47F;"><?php echo $user_data['contact_no']; ?></span></p>
                    <p style="text-align:left;">Course: <span style="color: #75A47F;"><?php echo $user_data['course']; ?></span></p>
                    <a href="profile.php" class="float-right">See All</a>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <h3>Available Internships</h3>
                <div class="section-divider-top"></div>
                <table class="modern-table dashboard-table">
                    <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($internships as $internship): ?>
                        <tr>
                            <td><?php echo $internship['title']; ?></td>
                            <td><?php echo $internship['company_name']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="application_v2.php" class="float-right-table">See All</a>
            </div>
            <div class="col-md-6">
                <h3>Pending Applications</h3>
                <div class="section-divider-top"></div>
                <table class="modern-table dashboard-table">
                    <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pendingApplications as $application): ?>
                        <tr>
                            <td><?php echo $application['title']; ?></td>
                            <td><?php echo $application['company_name']; ?></td>
                            <td><?php echo $application['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
