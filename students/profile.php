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
    <div class="container">
        <h2 class="text-center">Profile & Resume</h2>
        <div class="section-divider"></div>
        <form action="edit_profile.php" method="GET">
        <h3>I. Personal Details</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Firstname &nbsp;&nbsp;M.I. &nbsp;&nbsp;Lastname" value="<?php echo htmlspecialchars($user_data['name']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="studentID">Student ID</label>
                    <input type="text" class="form-control" id="studentID" name="studentID" placeholder="22-00000" value="<?php echo htmlspecialchars($user_data['studentID']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="sex">Sex</label>
                    <input type="text" class="form-control" id="sex" name="sex" placeholder="Male or Female"value ="<?php echo htmlspecialchars($user_data['sex']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="religion">Religion</label>
                    <input type="text" class="form-control" id="religion" name="religion" placeholder="Roman Catholic"value="<?php echo htmlspecialchars($user_data['religion']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="birthday">Birthday</label>
                    <input type="text" class="form-control" id="birthday" name="birthday" placeholder="DD-MM-YY" value="<?php echo htmlspecialchars($user_data['birthday']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="birthplace">Birthplace</label>
                    <input type="text" class="form-control" id="birthplace" name="birthplace" placeholder="City or Province" value="<?php echo htmlspecialchars($user_data['birthplace']); ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="citizenship">Citizenship</label>
                    <input type="text" class="form-control" id="citizenship" name="citizenship" placeholder="Filipino" value="<?php echo htmlspecialchars($user_data['citizenship']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="civil_status">Civil Status</label>
                    <input type="text" class="form-control" id="civil_status" name="civil_status" placeholder="Single or Married" value="<?php echo htmlspecialchars($user_data['civil_status']); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>
            <div class="form-group-inline centered">
                <label for="address">Address</label>
                <textarea class="form-control portfolio-textarea" id="address" name="address"  rows="3" readonly><?php echo htmlspecialchars($user_data['address']); ?></textarea>
            </div>     
            <div class="section-divider"></div>

            <h3>II. Contact Information</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="contact_no">Phone Number</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Mobile Number" value="<?php echo htmlspecialchars($user_data['contact_no']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="youremail@gmail.com" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>
            <h3>III. Education</h3>
            <div class="section-divider"></div>
            <div class="form-group-inline centered">
                    <label for="course">Course</label>
                    <input type="text" class="form-control portfolio-textarea" id="course" name="course" placeholder="course" value="<?php echo htmlspecialchars($user_data['course']); ?>" readonly>
                </div>
                <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="primary_education">Primary Education</label>
                    <input type="text" class="form-control" id="primary_education" name="primary_education"placeholder="Elementaty School" value="<?php echo htmlspecialchars($user_data['primary_education']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="primary_year">Year</label>
                    <input type="text" class="form-control" id="primary_year" name="primary_year" placeholder="Year Started - Year Graduate" value="<?php echo htmlspecialchars($user_data['primary_year']); ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="secondary_education">Secondary Education</label>
                    <input type="text" class="form-control" id="secondary_education" name="secondary_education" placeholder="High School" value="<?php echo htmlspecialchars($user_data['secondary_education']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="secondary_year">Year</label>
                    <input type="text" class="form-control" id="secondary_year" name="secondary_year" placeholder="Year Started - Year Graduate"value="<?php echo htmlspecialchars($user_data['secondary_year']); ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="tertiary_education">Tertiary Education</label>
                    <input type="text" class="form-control" id="tertiary_education" name="tertiary_education"placeholder="College or University" value="<?php echo htmlspecialchars($user_data['tertiary_education']); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="tertiary_year">Year</label>
                    <input type="text" class="form-control" id="tertiary_year" name="tertiary_year" placeholder="Year Started - Year Graduate" value="<?php echo htmlspecialchars($user_data['tertiary_year']); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>
            <h3>Resume Details</h3>
            <div class="section-divider"></div>
            <div class="form-row">
            <div class="form-group-inline centered">
            <label for="objective">Objective</label>
            <textarea class="form-control portfolio-textarea" id="objective" name="objective" rows="3" placeholder="Example: To develop my career in a reputable company with integrity and with an opportunity for personal and professional development." readonly style="font-size: 12px;"><?php echo htmlspecialchars($user_data['objective']); ?></textarea>
        </div>
        <div class="form-group-inline">
            <label for="languages_spoken">Languages Spoken</label>
            <textarea class="form-control portfolio-textarea" id="languages_spoken" name="languages_spoken" rows="3" style="font-size: 12px; height: 70px;" placeholder="Example: English and Filipino." readonly style="font-size: 12px;"><?php echo htmlspecialchars($user_data['languages_spoken']); ?></textarea>
        </div>

            </div>
            <div class="section-divider"></div>

            
            <button type="submit" class="btn btn-primary btn-block">Edit Profile</button>
        </form>

        <a href="log.php" class="btn btn-secondary btn-block mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
