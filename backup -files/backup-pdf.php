<?php
require_once("../connection/connection.php");
require_once '../vendor/autoload.php'; // Include Dompdf library

use Dompdf\Dompdf;

// Start session and check user login
session_start();
if (!isset($_SESSION['user_data'])) {
    header("Location: index.php");
    exit;
}

$user_data = $_SESSION['user_data'];

// Fetch user data from database
$stmt = $conn->prepare("SELECT name, sex, address, course, studentID, birthday, contact_no, email FROM activated_student WHERE id = ?");
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

// Function to get user data safely
function getUserData($key, $user_data) {
    return isset($user_data[$key]) ? htmlspecialchars($user_data[$key]) : '';
}

// HTML content for PDF
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    <style>
    body {
        font-family: "Arial", sans-serif;
        background-color: #f6f6f9;
        color: #6c757d;
        padding-left: 50px;
    }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Resume</h2>
    <h2>--------------------------------------------------------------------------</h2>
    <h3 style="text-align: center;">Personal Details</h3>
    <p><strong>Full Name:</strong> ' . getUserData('name', $user_data) . '</p>
    <p><strong>Sex:</strong> ' . getUserData('sex', $user_data) . '</p>
    <p><strong>Birthday:</strong> ' . getUserData('birthday', $user_data) . '</p>
    <p><strong>Student ID:</strong> ' . getUserData('studentID', $user_data) . '</p>
    <p><strong>Address:</strong> ' . getUserData('address', $user_data) . '</p>
    <h5>-------------------------------------------------------------------------------------------------------------------------------------</h5>
    <h3 style="text-align: center;">Contact Information</h3>
    <p><strong>Contact No:</strong> ' . getUserData('contact_no', $user_data) . '</p>
    <p><strong>Email:</strong> ' . getUserData('email', $user_data) . '</p>
    <h5>-------------------------------------------------------------------------------------------------------------------------------------</h5>
    <h3 style="text-align: center;">Education</h3>
    <p><strong>School Name:</strong> ' . getUserData('school_name', $user_data) . '</p>
    <p><strong>Course:</strong> ' . getUserData('course', $user_data) . '</p>
    <h5>-------------------------------------------------------------------------------------------------------------------------------------</h5>
    <h3>Professional Summary or Objective</h3>
    <p>' . getUserData('professional_summary', $user_data) . '</p>
    <h3>Skills</h3>
    <p>' . getUserData('skills', $user_data) . '</p>
    <h3>Experience</h3>
    <p>' . getUserData('experience', $user_data) . '</p>
    <h3>Projects</h3>
    <p>' . getUserData('projects', $user_data) . '</p>
    <h3>Certifications</h3>
    <p>' . getUserData('certifications', $user_data) . '</p>
    <h3>Honors and Awards</h3>
    <p>' . getUserData('honors_awards', $user_data) . '</p>
    <h3>Extracurricular Activities</h3>
    <p>' . getUserData('extracurricular_activities', $user_data) . '</p>
    <h3>Portfolio</h3>
    <p>' . getUserData('portfolio', $user_data) . '</p>
</body>
</html>';

// Create a Dompdf instance
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF (inline or attachment)
$dompdf->stream("resume.pdf", array("Attachment" => false));
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
            flex-direction: column

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
        <form action="edit_profile.php" method="GET">
            <h3>Personal Details</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo getUserData('name', $user_data); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="studentID">Student ID</label>
                    <input type="text" class="form-control" id="studentID" name="studentID" style="width: 50%" value="<?php echo getUserData('studentID', $user_data); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="sex">Sex</label>
                    <input type="text" class="form-control" id="sex" name="sex" style="width: 50%" value="<?php echo getUserData('sex', $user_data); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="birthday">Birthday</label>
                    <input type="text" class="form-control" id="birthday" name="birthday" style="width: 70%" value="<?php echo getUserData('birthday', $user_data); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>

                <h3>Contact Information</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="contact_no">Phone Number</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" style="width: 60%" value="<?php echo getUserData('contact_no', $user_data); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo getUserData('email', $user_data); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>

            <div class="form-group-inline centered">
                <label for="address">Address</label>
                <textarea class="form-control portfolio-textarea" id="address" name="address" rows="3" readonly><?php echo getUserData('address', $user_data); ?></textarea>
            </div>
            <div class="section-divider"></div>

            <h3>Education</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="school_name">School Name</label>
                    <input type="text" class="form-control" id="school_name" name="school_name" value="<?php echo getUserData('school_name', $user_data); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="course">Course</label>
                    <input type="text" class="form-control" id="course" name="course" value="<?php echo getUserData('course', $user_data); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>

            <div class="form-group-inline centered">
                <label for="professional_summary">Professional Summary or Objective</label>
                <textarea class="form-control portfolio-textarea" id="professional_summary" name="professional_summary" rows="3" readonly><?php echo getUserData('professional_summary', $user_data); ?></textarea>
            </div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="form-group-inline">
                    <label for="skills">Skills</label>
                    <textarea class="form-control" id="skills" name="skills" rows="3" readonly><?php echo getUserData('skills', $user_data); ?></textarea>
                </div>
                <div class="form-group-inline">
                    <label for="experience">Experience</label>
                    <textarea class="form-control" id="experience" name="experience" rows="3" readonly><?php echo getUserData('experience', $user_data); ?></textarea>
                </div>
            </div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="form-group-inline">
                    <label for="projects">Projects</label>
                    <textarea class="form-control" id="projects" name="projects" rows="3" readonly><?php echo getUserData('projects', $user_data); ?></textarea>
                </div>
                <div class="form-group-inline">
                    <label for="certifications">Certifications</label>
                    <textarea class="form-control" id="certifications" name="certifications" rows="3" readonly><?php echo getUserData('certifications', $user_data); ?></textarea>
                </div>
            </div>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="honors_awards">Honors and Awards</label>
                    <textarea class="form-control" id="honors_awards" name="honors_awards" rows="3" readonly><?php echo getUserData('honors_awards', $user_data); ?></textarea>
                </div>
                <div class="form-group-inline">
                    <label for="extracurricular_activities">Extracurricular Activities</label>
                    <textarea class="form-control" id="extracurricular_activities" name="extracurricular_activities" rows="3" readonly><?php echo getUserData('extracurricular_activities', $user_data); ?></textarea>
                </div>
                <div class="form-group-inline centered">
                    <label class="text-center" for="portfolio">Portfolio (Optional)</label>
                    <textarea class="form-control portfolio-textarea" id="portfolio" name="portfolio" rows="3" readonly><?php echo getUserData('portfolio', $user_data); ?></textarea>
                </div>
            </div>
            <div class="section-divider"></div>
            <button type="submit" class="btn btn-primary btn-block">Edit Profile</button>
    
        </form>

        <a href="log.php" class="btn btn-secondary btn-block mt-3">Back to Dashboard</a>
    </div>

</body>
</html>

