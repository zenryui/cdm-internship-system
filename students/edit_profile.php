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

$stmt_resume = $conn->prepare("SELECT objective, birthplace, citizenship, religion, languages_spoken, civil_status, primary_education, secondary_education, tertiary_education, primary_year, secondary_year, tertiary_year FROM table_resume WHERE user_id = ?");
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
    'objective' => '',
    'birthplace' => '',
    'citizenship' => '',
    'religion' => '',
    'languages_spoken' => '',
    'civil_status' => '',
    'primary_education' => '',
    'secondary_education' => '',
    'tertiary_education' => '',
    'primary_year' => '',
    'secondary_year' => '',
    'tertiary_year' => ''
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
    $objective = sanitize($_POST['objective']);
    $birthplace = sanitize($_POST['birthplace']);
    $citizenship = sanitize($_POST['citizenship']);
    $religion = sanitize($_POST['religion']);
    $languages_spoken = sanitize($_POST['languages_spoken']);
    $civil_status = sanitize($_POST['civil_status']);
    $primary_education = sanitize($_POST['primary_education']);
    $secondary_education = sanitize($_POST['secondary_education']);
    $tertiary_education = sanitize($_POST['tertiary_education']);
    $primary_year = sanitize($_POST['primary_year']);
    $secondary_year = sanitize($_POST['secondary_year']);
    $tertiary_year = sanitize($_POST['tertiary_year']);
    
    // // Validate input data
    // if (empty($name) || empty($sex) || empty($address) || empty($course) || empty($studentID) || empty($birthday) || empty($contact_no)) {
    //     $errors[] = "All fields are required.";
    // }
    
    if (empty($errors)) {
        // Prepare SQL query to update user data
        $stmt = $conn->prepare("UPDATE activated_student SET name=?, sex=?, address=?, course=?, studentID=?, birthday=?, contact_no=? WHERE id=?");
        $stmt->bind_param("sssssssi", $name, $sex, $address, $course, $studentID, $birthday, $contact_no, $user_data['id']);
        
        if ($stmt->execute()) {
            // Insert resume details into table_resume
            $stmt_resume = $conn->prepare("REPLACE INTO table_resume (user_id, objective, birthplace, citizenship, religion, languages_spoken, civil_status, primary_education, secondary_education, tertiary_education, primary_year, secondary_year, tertiary_year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_resume->bind_param("issssssssssss", $user_data['id'], $objective, $birthplace, $citizenship, $religion, $languages_spoken, $civil_status, $primary_education, $secondary_education, $tertiary_education, $primary_year, $secondary_year, $tertiary_year);
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
            $user_data['objective'] = $objective;
            $user_data['birthplace'] = $birthplace;
            $user_data['citizenship'] = $citizenship;
            $user_data['religion'] = $religion;
            $user_data['languages_spoken'] = $languages_spoken;
            $user_data['civil_status'] = $civil_status;
            $user_data['primary_education'] = $primary_education;
            $user_data['secondary_education'] = $secondary_education;
            $user_data['tertiary_education'] = $tertiary_education;
            $user_data['primary_year'] = $primary_year;
            $user_data['secondary_year'] = $secondary_year;
            $user_data['tertiary_year'] = $tertiary_year;
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
                <label for="name">Full Name<span style="font-size: .7rem; padding-left: 10px;"> ( First Name, M.I., Last Name )</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data['name']; ?>">
                </div>
                <div class="form-group-inline">
                <label for="studentID">Student ID<span style="font-size: .7rem; padding-left: 10px;"> ( 22-XXXXX )</span></label>
                    <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $user_data['studentID']; ?>">
                </div>
                <div class="form-group-inline">
                    <label class="text-center" for="sex">Sex</label>
                    <select class="form-control portfolio-textarea" id="sex" name="sex" style="margin-top: 0px;">
                        <option value="">--Select--</option>
                        <option value="Male" <?php if($user_data['sex'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if($user_data['sex'] == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <!-- Religion -->
                <div class="form-group-inline">
                    <label for="religion">Religion<span style="font-size: .6rem; padding-left: 10px; font-weight: bold;"> Ex: ( Roman Catholic, Iglesia ni Cristo )</span></label>
                    <input type="text" class="form-control" id="religion" name="religion" value="<?php echo $user_data['religion']; ?>">
                </div>
                <div class="form-group-inline">
                    <label for="birthday">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $user_data['birthday']; ?>">
                </div>
                <!-- Birthplace -->
                <div class="form-group-inline">
                    <label for="birthplace">Birthplace</label>
                    <input type="text" class="form-control" id="birthplace" name="birthplace" value="<?php echo $user_data['birthplace']; ?>">
                </div>
            </div>
            <!-- Citizenship -->
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="citizenship">Citizenship<span style="font-size: .7rem; padding-left: 10px; font-weight: bold;"> Ex: ( Filipino )</span></label>
                    <input type="text" class="form-control" id="citizenship" name="citizenship" value="<?php echo $user_data['citizenship']; ?>">
                </div>
                <!-- Civil Status -->
                <div class="form-group-inline">
                    <label for="civil_status">Civil Status<span style="font-size: .6rem; padding-left: 10px; font-weight: bold;"> Ex: ( Single, Married, Widowed)</span></label>
                    <select class="form-control portfolio-textarea" id="civil_status" name="civil_status" style="margin-top: 0px;">
                        <option value="Single" <?php if($user_data['civil_status'] == 'Single') echo 'selected'; ?>>Single</option>
                        <option value="Married" <?php if($user_data['civil_status'] == 'Married') echo 'selected'; ?>>Married</option>
                        <option value="Divorced" <?php if($user_data['civil_status'] == 'Divorced') echo 'selected'; ?>>Divorced</option>
                        <option value="Separated" <?php if($user_data['civil_status'] == 'Separated') echo 'selected'; ?>>Separated</option>
                        <option value="Widowed" <?php if($user_data['civil_status'] == 'Widowed') echo 'selected'; ?>>Widowed</option>
                        <option value="Annulled" <?php if($user_data['civil_status'] == 'Annulled') echo 'selected'; ?>>Annulled</option>
                    </select>
                    <!-- We are no longer going to use this
                    <input type="text" class="form-control" id="civil_status" name="civil_status" value="<?php echo $user_data['civil_status']; ?>" readonly> -->
                </div>
            </div>
            <div class="section-divider"></div>
                    <!-- Address label and input box -->
                <div class="form-group-inline centered">
            <label class="text-center" for="address">Address</label>
        <textarea class="form-control portfolio-textarea" id="address" name="address" rows="3"><?php echo htmlspecialchars($user_data['address']); ?></textarea>
    </div>
    <div class="section-divider"></div>
        <h3>Contact Information</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="contact_no">Phone Number</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo $user_data['contact_no']; ?>">
                </div>
                <div class="form-group-inline">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>
                </div>
            </div>
        <div class="section-divider"></div>
    <h3>Education</h3>
        <div class="section-divider"></div>
        <div class="form-group-inline centered">
                    <label class="text-center" for="course">Course</label>
                    <select class="form-control portfolio-textarea" id="course" name="course">
                        <option value="BS Computer Engineering" <?php if($user_data['course'] == 'BS Computer Engineering') echo 'selected'; ?>>BS Computer Engineering</option>
                        <option value="BS Information Technology" <?php if($user_data['course'] == 'BS Information Technology') echo 'selected'; ?>>BS Information Technology</option>
                    </select>
                </div>
            <div class="section-divider"></div>
            <div class="form-row">
                <!-- START -->
            <div class="form-group-inline">
                    <label for="primary_education">Primary Education<span style="font-size: .7rem; padding-left: 10px; font-weight: bold;"> ( Elementary )</span></label>
                    <input type="text" class="form-control" id="primary_education" name="primary_education" value="<?php echo $user_data['primary_education']; ?>">
                </div>
                <div class="form-group-inline">
                    <label for="primary_year">Year<span style="font-size: .7rem; padding-left: 10px; font-weight: bold;"> ( Year Started - Year Graduated )</span></label>
                    <input type="text" class="form-control" id="primary_year" name="primary_year" value="<?php echo $user_data['primary_year']; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="secondary_education">Secondary Education<span style="font-size: .7rem; padding-left: 10px; font-weight: bold;"> ( Highschool )</span></label>
                    <input type="text" class="form-control" id="secondary_education" name="secondary_education" value="<?php echo $user_data['secondary_education']; ?>">
                </div>
                <div class="form-group-inline">
                    <label for="secondary_year">Year</label>
                    <input type="text" class="form-control" id="secondary_year" name="secondary_year" value="<?php echo $user_data['secondary_year']; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="tertiary_education">Tertiary Education<span style="font-size: .7rem; padding-left: 10px; font-weight: bold;"> ( College or University )</span></label>
                    <input type="text" class="form-control" id="tertiary_education" name="tertiary_education" value="<?php echo $user_data['tertiary_education']; ?>">
                </div>
                <div class="form-group-inline">
                    <label for="tertiary_year">Year</label>
                    <input type="text" class="form-control" id="tertiary_year" name="tertiary_year" value="<?php echo $user_data['tertiary_year']; ?>">
                </div>
            </div>    
             <!-- END    -->
             <div class="section-divider"></div>
            <h3>Resume Details</h3>
            <div class="section-divider"></div>
            <div class="form-row">
            <div class="form-group-inline centered">
            <label for="objective">Objective</label>
            <textarea class="form-control portfolio-textarea" id="objective" name="objective" rows="3" placeholder="Example: To develop my career in a reputable company with integrity and with an opportunity for personal and professional development." style="font-size: 12px;"><?php echo $user_data['objective']; ?></textarea>
        </div>
        <div class="form-group-inline">
            <label for="languages_spoken">Languages Spoken</label>
            <textarea class="form-control portfolio-textarea" id="languages_spoken" name="languages_spoken" rows="3" style="font-size: 12px; height: 70px;" placeholder="Example: English and Filipino." style="font-size: 12px;"><?php echo $user_data['languages_spoken']; ?></textarea>
        </div>
            </div>
            <div class="section-divider"></div>
<!-- END -->
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