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

// Fetch user data from database
$stmt = $conn->prepare("SELECT name, sex, address, course, studentID, birthday, contact_no FROM activated_student WHERE id = ?");
$stmt->bind_param("i", $user_data['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user_data = array_merge($user_data, $result->fetch_assoc());
}

$stmt_resume = $conn->prepare("SELECT professional_summary, school_name, skills, experience, projects, certifications, honors_awards, extracurricular_activities, portfolio FROM table_resume WHERE user_id = ?");
$stmt_resume->bind_param("i", $user_data['id']);
$stmt_resume->execute();
$result_resume = $stmt_resume->get_result();
if ($result_resume->num_rows > 0) {
    $user_data = array_merge($user_data, $result_resume->fetch_assoc());
}

// Set default values for missing keys
$user_data += [
    'name' => '',
    'email' => '',
    'sex' => '',
    'address' => '',
    'course' => '',
    'studentID' => '',
    'birthday' => '',
    'contact_no' => '',
    'professional_summary' => '',
    'school_name' => '',
    'skills' => '',
    'experience' => '',
    'projects' => '',
    'certifications' => '',
    'honors_awards' => '',
    'extracurricular_activities' => '',
    'portfolio' => ''
];

// Function to sanitize input data
function sanitize($data)
{
    return htmlspecialchars(trim($data));
}

// Initialize error array
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $name = sanitize($_POST['name']);
    $sex = sanitize($_POST['sex']);
    $address = sanitize($_POST['address']);
    $course = sanitize($_POST['course']);
    $studentID = sanitize($_POST['studentID']);
    $birthday = sanitize($_POST['birthday']);
    $contact_no = sanitize($_POST['contact_no']);
    $professional_summary = sanitize($_POST['professional_summary']);
    $school_name = sanitize($_POST['school_name']);
    $skills = sanitize($_POST['skills']);
    $experience = sanitize($_POST['experience']);
    $projects = sanitize($_POST['projects']);
    $certifications = sanitize($_POST['certifications']);
    $honors_awards = sanitize($_POST['honors_awards']);
    $extracurricular_activities = sanitize($_POST['extracurricular_activities']);
    $portfolio = sanitize($_POST['portfolio']);
    
    // Validate input data
    if (empty($name) || empty($sex) || empty($address) || empty($course) || empty($studentID) || empty($birthday) || empty($contact_no)) {
        $errors[] = "All fields are required.";
    }
    
    if (empty($errors)) {
        // Prepare SQL query to update user data
        $stmt = $conn->prepare("UPDATE activated_student SET name=?, sex=?, address=?, course=?, studentID=?, birthday=?, contact_no=? WHERE id=?");
        $stmt->bind_param("sssssssi", $name, $sex, $address, $course, $studentID, $birthday, $contact_no, $user_data['id']);
        
        if ($stmt->execute()) {
            // Insert resume details into table_resume
            $stmt_resume = $conn->prepare("REPLACE INTO table_resume (user_id, address, professional_summary, school_name, skills, experience, projects, certifications, honors_awards, extracurricular_activities, portfolio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_resume->bind_param("issssssssss", $user_data['id'], $address, $professional_summary, $school_name, $skills, $experience, $projects, $certifications, $honors_awards, $extracurricular_activities, $portfolio);
            $stmt_resume->execute();
            $stmt_resume->close();

            $_SESSION['success'] = "Profile updated successfully.";
            // Optionally update session data
            $user_data['name'] = $name;
            $user_data['sex'] = $sex;
            $user_data['address'] = $address;
            $user_data['course'] = $course;
            $user_data['studentID'] = $studentID;
            $user_data['birthday'] = $birthday;
            $user_data['contact_no'] = $contact_no;
            $user_data['professional_summary'] = $professional_summary;
            $user_data['school_name'] = $school_name;
            $user_data['skills'] = $skills;
            $user_data['experience'] = $experience;
            $user_data['projects'] = $projects;
            $user_data['certifications'] = $certifications;
            $user_data['honors_awards'] = $honors_awards;
            $user_data['extracurricular_activities'] = $extracurricular_activities;
            $user_data['portfolio'] = $portfolio;
            $_SESSION['user_data'] = $user_data;
            header("Location: profile.php");
            exit;
        } else {
            $errors[] = "Error updating profile.";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f6f9;
            color: #6c757d;
        }
        .container {
            max-width: 550px;
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
        .form-control {
            font-size: 0.9rem;
        }
        .alert {
            margin-top: 20px;
        }
        h2 {
            margin-bottom: 20px;

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
        }
        /* CSS for portfolio label */


        /* CSS for portfolio textarea */
        .portfolio-textarea {
            width: 100%; /* Make the textarea fill the width of its container */
            min-width: 100px; /* Set a minimum width to prevent it from becoming too narrow */
            max-width: 400px; /* Set a maximum width to prevent it from becoming too wide */
            margin-top: 5px; /* Add some top margin for separation */
        }'
        
        /* CSS for address and professional summary input boxes */
        .address-input, .professional-summary-input {
            width: 100%; /* Make the input fill the width of its container */
            max-width: 400px; /* Set a maximum width to prevent it from becoming too wide */
            margin-top: 5px; /* Add some top margin for separation */
        }


        /* CSS for address and professional summary labels */
        .form-group-inline label {
            font-weight: 500;
            margin-bottom: 5px;
            text-align: left;
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
        <h2 class="text-center">Resume</h2>
        <div class="section-divider"></div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form id="edit-profile-form" action="edit_profile.php" method="post">
            <h3>Personal Details</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data['name']; ?>" required>
                </div>
                <div class="form-group-inline">
                    <label for="studentID">Student ID</label>
                    <input type="text" class="form-control" id="studentID" name="studentID" style="width: 50%" value="<?php echo $user_data['studentID']; ?>" required>
                </div>
                <div class="form-group-inline" style="margin-top: -5px;">
                    <label class="text-center" for="sex">Sex</label>
                    <select class="form-control portfolio-textarea" id="sex" name="sex" style="width: 50%">
                        <option value="Male" <?php if($user_data['sex'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if($user_data['sex'] == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>

                <div class="form-group-inline">
                    <label for="birthday">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" style="width: 70%" value="<?php echo $user_data['birthday']; ?>" required>
                </div>
            </div>
            <div class="section-divider"></div>

            <h3>Contact Information</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="contact_no">Phone Number</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" style="width: 60%" value="<?php echo $user_data['contact_no']; ?>" required>
                </div>
                <div class="form-group-inline">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>

            <!-- Address label and input box -->
            <div class="form-group-inline centered">
                <label class="text-center" for="address">Address</label>
                <textarea class="form-control portfolio-textarea" id="address" name="address" rows="3"><?php echo htmlspecialchars($user_data['address']); ?></textarea>
            </div>

            <div class="section-divider"></div>

            <h3>Education</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="school_name">School Name</label>
                    <input type="text" class="form-control" id="school_name" name="school_name" value="<?php echo $user_data['school_name']; ?>" required>
                </div>
                <div class="form-group-inline" style="margin-top: -5px;">
                    <label class="text-center" for="course">Course</label>
                    <select class="form-control portfolio-textarea" id="course" name="course">
                        <option value="BS Computer Engineering" <?php if($user_data['course'] == 'BS Computer Engineering') echo 'selected'; ?>>BS Computer Engineering</option>
                        <option value="BS Information Technology" <?php if($user_data['course'] == 'BS Information Technology') echo 'selected'; ?>>BS Information Technology</option>
                    </select>
                </div>
            </div>
            <div class="section-divider"></div>

            <div class="form-group-inline centered">
                <label class="text-center" for="professional_summary">Professional Summary or Objective</label>
                <textarea class="form-control portfolio-textarea" id="professional_summary" name="professional_summary" rows="3"><?php echo htmlspecialchars($user_data['professional_summary']); ?></textarea>
            </div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="form-group-inline">
                    <label for="skills">Skills</label>
                    <textarea class="form-control" id="skills" name="skills" rows="3"><?php echo $user_data['skills']; ?></textarea>
                </div>
                <div class="form-group-inline">
                    <label for="experience">Experience</label>
                    <textarea class="form-control" id="experience" name="experience" rows="3"><?php echo $user_data['experience']; ?></textarea>
                </div>
            </div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="form-group-inline">
                    <label for="projects">Projects</label>
                    <textarea class="form-control" id="projects" name="projects" rows="3"><?php echo $user_data['projects']; ?></textarea>
                </div>
                <div class="form-group-inline">
                    <label for="certifications">Certifications</label>
                    <textarea class="form-control" id="certifications" name="certifications" rows="3"><?php echo $user_data['certifications']; ?></textarea>
                </div>
            </div>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="honors_awards">Honors and Awards</label>
                    <textarea class="form-control" id="honors_awards" name="honors_awards" rows="3"><?php echo $user_data['honors_awards']; ?></textarea>
                </div>
                <div class="form-group-inline">
                    <label for="extracurricular_activities">Extracurricular Activities</label>
                    <textarea class="form-control" id="extracurricular_activities" name="extracurricular_activities" rows="3"><?php echo $user_data['extracurricular_activities']; ?></textarea>
                </div>
                <div class="form-group-inline centered">
                    <label class="text-center" for="portfolio">Portfolio (Optional)</label>
                    <textarea class="form-control portfolio-textarea" id="portfolio" name="portfolio" rows="3"><?php echo htmlspecialchars($user_data['portfolio']); ?></textarea>
                </div>
            </div>
            <div class="section-divider"></div>
            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
        </form>

        <a href="profile.php" class="btn btn-secondary btn-block mt-3">Cancel</a>
    </div>

    <script>
        document.getElementById('edit-profile-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save the changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Submit the form if the user confirms
                }
            });
        });
    </script>
</body>
</html>