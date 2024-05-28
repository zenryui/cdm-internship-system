<?php
require_once("../connection/connection.php");
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Fetch user data from session
$user_data = $_SESSION['user_data'];

// Fetch user data from the activated_student table
$stmt = $conn->prepare("SELECT name, sex, address, course, studentID, birthday, contact_no, email FROM activated_student WHERE id = ?");
$stmt->bind_param("i", $user_data['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user_data = array_merge($user_data, $result->fetch_assoc());
}

// Fetch resume details from the table_resume table
$stmt_resume = $conn->prepare("SELECT objective, birthplace, citizenship, religion, languages_spoken, civil_status, primary_education, secondary_education, tertiary_education, primary_year, secondary_year, tertiary_year FROM table_resume WHERE user_id = ?");
$stmt_resume->bind_param("i", $user_data['id']);
$stmt_resume->execute();
$result_resume = $stmt_resume->get_result();
if ($result_resume->num_rows > 0) {
    $user_data = array_merge($user_data, $result_resume->fetch_assoc());
}

// Function to get user data safely
function getUserData($key, $user_data) {
    return isset($user_data[$key]) ? htmlspecialchars($user_data[$key]) : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root{
            --color-primary: #7380ec;
            --color-white: #fff;
            --color-info: #7d8da1;
            --color-light: rgba(132, 139, 200, 0.18);
            --color-background: #f6f6f9;
            --border-radius-2: 1.2rem;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f6f9;
            color: #7d8da1;
        }
        .container {
            max-width: 700px;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-height: 80vh;
            overflow-y: auto;
        }
        .form-group label {
            font-weight: 500;
            font-size: 0.9rem;
        }
        .form-group-inline label {
            font-weight: 500;
            text-align: left;
        }
        .form-control {
            font-size: 0.9rem;
            text-align: center;
            color: #7d8da1;
            font-weight: 600;
        }
        .alert {
            margin-top: 20px;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        h3 {
            margin-top: 20px;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .btn-block {
            margin-top: 20px;
            font-size: 0.9rem;
        }
        .section-divider {
            border-bottom: 1px solid #e9ecef;
            margin: 20px 0;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }
        .form-group-inline {
            flex: 1 1 45%;
            margin-right: 10px;
            margin-bottom: 1rem;
            color: #7d8da1;
        }
        .portfolio-textarea {
            width: 100%;
            min-width: 200px;
            max-width: 400px;
            margin-top: 5px;
        }
        .centered {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .centered label {
            text-align: left;
        }
        .centered textarea {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="brand"><span>CDM Internship</span></div>
    <div class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars" style="font-size: 12px;"></i>
    </div>
    <div class="section-divider"></div>
    <a href="log.php"><i class="fas fa-columns"></i><span>Dashboard</span></a>
    <a href="profile.php"><i class="fas fa-user"></i><span>Profile Management</span></a>
    <a href="application_v2.php"><i class="fas fa-briefcase"></i><span>Internship Application</span></a>
    <a href="notification.php"><i class="fas fa-bell"></i><span>Notifications</span></a>
    <a href="pdf.php"><i class="fas fa-file-pdf"></i><span>Generate PDF</span></a>
    <a href="change_pass.php"><i class="fas fa-lock"></i><span>Change Password</span></a>
    <a href="logout.php" id="logout-btn"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
</div>
<div class="container">
    <h2 class="text-center">Profile & Resume View Only</h2>
    <div class="section-divider"></div>
    <form action="edit_profile.php" method="GET">
        <h3>I. Personal Details</h3>
        <div class="section-divider"></div>
        <div class="form-row">
            <div class="form-group-inline">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder=" ex: Juan D. Cruz" value="<?php echo getUserData('name', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="studentID">Student ID</label>
                <input type="text" class="form-control" id="studentID" name="studentID" placeholder=" ex: 22-00000" value="<?php echo getUserData('studentID', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="sex">Sex</label>
                <input type="text" class="form-control" id="sex" name="sex" placeholder="Male or Female" value="<?php echo getUserData('sex', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="religion">Religion</label>
                <input type="text" class="form-control" id="religion" name="religion" placeholder=" ex: Roman Catholic" value="<?php echo getUserData('religion', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="birthday">Birthday</label>
                <input type="text" class="form-control" id="birthday" name="birthday" placeholder="DD-MM-YY" value="<?php echo getUserData('birthday', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="birthplace">Birthplace</label>
                <input type="text" class="form-control" id="birthplace" name="birthplace" placeholder=" ex: Quezon Memorial Hospital" value="<?php echo getUserData('birthplace', $user_data); ?>" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inline">
                <label for="citizenship">Citizenship</label>
                <input type="text" class="form-control" id="citizenship" name="citizenship" placeholder=" ex: Filipino" value="<?php echo getUserData('citizenship', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="contact_no">Contact No.</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder=" ex: 09xx-xxx-xxxx" value="<?php echo getUserData('contact_no', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder=" ex: 141 Lawin st. Quezon City" value="<?php echo getUserData('address', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder=" ex: juan@gmail.com" value="<?php echo getUserData('email', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="civil_status">Civil Status</label>
                <input type="text" class="form-control" id="civil_status" name="civil_status" placeholder=" ex: Single" value="<?php echo getUserData('civil_status', $user_data); ?>" readonly>
            </div>
            <div class="form-group-inline">
                <label for="languages_spoken">Languages Spoken</label>
                <input type="text" class="form-control" id="languages_spoken" name="languages_spoken" placeholder=" ex: Filipino, English" value="<?php echo getUserData('languages_spoken', $user_data); ?>" readonly>
            </div>
        </div>
        <h3>II. Educational Background</h3>
        <div class="section-divider"></div>
        <div class="form-group">
            <label for="primary_education">Primary Education</label>
            <input type="text" class="form-control" id="primary_education" name="primary_education" placeholder=" ex: Lawin Elementary School" value="<?php echo getUserData('primary_education', $user_data); ?>" readonly>
            <input type="text" class="form-control mt-2" id="primary_year" name="primary_year" placeholder=" ex: 2011-2017" value="<?php echo getUserData('primary_year', $user_data); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="secondary_education">Secondary Education</label>
            <input type="text" class="form-control" id="secondary_education" name="secondary_education" placeholder=" ex: New Era High School" value="<?php echo getUserData('secondary_education', $user_data); ?>" readonly>
            <input type="text" class="form-control mt-2" id="secondary_year" name="secondary_year" placeholder=" ex: 2017-2021" value="<?php echo getUserData('secondary_year', $user_data); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="tertiary_education">Tertiary Education</label>
            <input type="text" class="form-control" id="tertiary_education" name="tertiary_education" placeholder=" ex: City College of Manila" value="<?php echo getUserData('tertiary_education', $user_data); ?>" readonly>
            <input type="text" class="form-control mt-2" id="tertiary_year" name="tertiary_year" placeholder=" ex: 2021-Present" value="<?php echo getUserData('tertiary_year', $user_data); ?>" readonly>
        </div>
        <h3>III. Resume Details</h3>
        <div class="section-divider"></div>
        <div class="form-group">
            <label for="objective">Objectives</label>
            <textarea id="objective" class="form-control portfolio-textarea" rows="2" placeholder="Write your objectives here..."><?php echo getUserData('objective', $user_data); ?></textarea>
        </div>
        <div class="form-group">
            <a href="edit_profile.php" class="btn btn-primary btn-block">Edit</a>
        </div>
    </form>
</div>
<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('open');
    }
</script>
</body>
</html>
