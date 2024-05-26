<?php
session_start();
include '../connection/connection.php'; // Ensure this path is correct based on your file structure

// Check if the employer is logged in
if (!isset($_SESSION['employer_data'])) {
    header("Location: index.php");
    exit();
}

$employer_data = $_SESSION['employer_data'];
$company_id = $employer_data['Company_ID']; // Fetching the company ID from the session employer data

// Fetch internships posted by the employer (limited to 3)
$sql = "SELECT * FROM internship WHERE Company_ID = ? LIMIT 3";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $company_id);
$stmt->execute();
$internship_result = $stmt->get_result();
if ($internship_result === false) {
    die("Error executing statement: " . $stmt->error);
}

// Fetch applications with status "pending" for the internships posted by the currently logged-in employer (limited to 3)
$sql = "SELECT ai.*, e.name as company_name, i.title
        FROM application_internship ai
        JOIN internship i ON ai.internship_ID = i.Internship_ID
        JOIN activated_employer e ON i.Company_ID = e.Company_ID
        WHERE e.Company_ID = ? AND ai.status = 'pending' LIMIT 3";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $company_id);
$stmt->execute();
$application_result = $stmt->get_result();
if ($application_result === false) {
    die("Error executing statement: " . $stmt->error);
}

// Fetch total number of students
$sql = "SELECT COUNT(*) as total_students FROM activated_student";
$total_students_result = $conn->query($sql);
$total_students = $total_students_result->fetch_assoc()['total_students'];

// Fetch the latest internships with status "Posted" or "Declined"
$sql = "SELECT Title, status FROM internship WHERE Company_ID = ? AND (status = 'Posted' OR status = 'Declined') ORDER BY posted_date DESC LIMIT 3";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $company_id);
$stmt->execute();
$notification_result = $stmt->get_result();
$notifications = [];
if ($notification_result->num_rows > 0) {
    while ($notification_row = $notification_result->fetch_assoc()) {
        $notifications[] = $notification_row;
    }
} else {
    $notifications[] = ["Title" => "No new notifications.", "status" => ""];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
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
                <h5 class="text-center" style="margin-top: -30px;">Welcome to Dashboard, <span style="color: #75A47F;"><?php echo htmlspecialchars($employer_data['name']); ?></span></h5>
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
                    <h3>Total Students</h3>
                    <div class="section-divider-top"></div>
                    <p><?php echo $total_students; ?></p>
                </div>
                <div class="dashboard-card">
                    <h3>Notifications</h3>
                    <div class="section-divider-top"></div>
                    <?php foreach ($notifications as $notification): ?>
                        <p>Your post <strong><?php echo htmlspecialchars($notification['Title']); ?></strong> has been <?php echo htmlspecialchars($notification['status']); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card" style="width: 300px;">
                    <h3>Company Information</h3>
                    <div class="section-divider-top"></div>
                    <?php if (isset($employer_data['name'])): ?>
                    <p style="text-align:left;">Company Name: <span style="color: #75A47F;"><?php echo htmlspecialchars($employer_data['name']); ?></span></p>
                    <?php endif; ?>
                    <?php if (isset($employer_data['Location'])): ?>
                    <p style="text-align:left;">Location: <span style="color: #75A47F;"><?php echo htmlspecialchars($employer_data['Location']); ?></span></p>
                    <?php endif; ?>
                    <?php if (isset($employer_data['Contact_No'])): ?>
                    <p style="text-align:left;">Phone No.: <span style="color: #75A47F;"><?php echo htmlspecialchars($employer_data['Contact_No']); ?></span></p>
                    <?php endif; ?>
                    <p style="text-align:left;">Email: <span style="color: #75A47F;"><?php echo htmlspecialchars($employer_data['email']); ?></span></p>
                    <a href="profile.php" class="float-right">See All</a>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <h3>Internship Programs</h3>
                <div class="section-divider-top"></div>
                <table class="modern-table dashboard-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Duration</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $internship_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['Internship_ID']; ?></td>
                            <td><?php echo htmlspecialchars($row['Title']); ?></td>
                            <td><?php echo htmlspecialchars($row['Duration']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <a href="post_internship.php" class="float-right-table">See all</a>
            </div>
            <div class="col-md-6">
                <h3>Application List</h3>
                <div class="section-divider-top"></div>
                <table class="modern-table dashboard-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $application_result->fetch_assoc()): ?>
                        <tr class="<?php echo $row['status'] == 'pending' ? 'pending-status' : ''; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <a href="application_list.php" class="float-right-table">See all</a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
