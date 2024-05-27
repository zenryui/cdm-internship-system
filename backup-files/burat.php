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
$sql = "SELECT ai.*, e.name as company_name 
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
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

        .section-divider-top {
            border-bottom: 2px solid #e9ecef;
            margin: 5px 0;
        }

        .dashboard-card-info {
            background-color: white;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: left;
            font-size: 12px;
            max-width: 20rem;
            transition: transform 0.3s ease; /* Smooth transition for scaling effect */
        }

        .dashboard-card-info:hover {
            transform: scale(1.05); /* Scale transformation on hover */
        }

        .dashboard-table {
            font-size: 12px;
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
        }
        .float-right:hover {
            text-decoration: none;
            color: #75A47F;
        }

        h1, h2, h3 {
            font-size: 12px;
        }

        .float-right-table {
            float: right;
            margin: 8px;
            color: #75A47F;
            font-size: 12px;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center">Welcome to Dashboard, <span style="color: #75A47F;"><?php echo htmlspecialchars($employer_data['name']); ?></span></h5>
            </div>
        </div>
        <div class="section-divider-top"></div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3 class="text-top">Total Students</h3>
                    <div class="section-divider-top"></div>
                    <p><?php echo $total_students; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3 class="text-top">Notifications</h3>
                    <div class="section-divider-top"></div>
                    <?php foreach ($notifications as $notification): ?>
                        <p>Your post <strong><?php echo htmlspecialchars($notification['Title']); ?></strong> has been <?php echo htmlspecialchars($notification['status']); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="dashboard-card-info">
                    <h3 class="text-top">Company Information</h3>
                    <div class="section-divider-top"></div>
                    <div class="section-divider-top" style="visibility: hidden;"></div>
                    <div class="section-divider-top" style="visibility: hidden;"></div>
                    <p style="color: #7d8da1; font-weight: 500;">Company Name: <span style="font-weight: 600;"><?php echo htmlspecialchars($employer_data['name']); ?></span></p>
                    <?php if (isset($employer_data['Location'])): ?>
                        <p style="color: #7d8da1; font-weight: 500;">Location: <span style="font-weight: 600;"><?php echo htmlspecialchars($employer_data['Location']); ?></span></p>
                    <?php endif; ?>
                    <?php if (isset($employer_data['Contact_No'])): ?>
                        <p style="color: #7d8da1; font-weight: 500;">Phone No.: <span style="font-weight: 600;"><?php echo htmlspecialchars($employer_data['Contact_No']); ?></span></p>
                    <?php endif; ?>
                    <p style="color: #7d8da1; font-weight: 500;">Email: <span style="font-weight: 600;"><?php echo htmlspecialchars($employer_data['email']); ?></span></p>
                    <a href="profile.php" class="float-right">See All</a>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-top">Internship Programs</h2>
                <div class="section-divider-top"></div>
                <table class="modern-table dashboard-table">
                    <thead>
                    <tr>   
                        <th class="text-top">ID</th>
                        <th class="text-top">Title</th>
                        <th class="text-top">Duration</th>
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
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-top">Application List</h2>
                <div class="section-divider-top"></div>
                <table class="modern-table dashboard-table">
                    <thead>
                    <tr>
                        <th class="text-top">ID</th>
                        <th class="text-top">Student Name</th>
                        <th class="text-top">Student Email</th>
                        <th class="text-top">Student Course</th>
                        <th class="text-top">Internship ID</th>
                        <th class="text-top">Title</th>
                        <th class="text-top">Company Name</th>
                        <th class="text-top">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $application_result->fetch_assoc()): ?>
                        <tr class="<?php echo $row['status'] == 'pending' ? 'pending-status' : ''; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_course']); ?></td>
                            <td><?php echo $row['internship_ID']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
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
