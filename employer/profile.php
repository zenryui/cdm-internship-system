<?php
require_once("../connection/connection.php");
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['employer_data'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Fetch user data from session
$employer_data = $_SESSION['employer_data'];

// Fetch user data from the activated_employer table
$stmt = $conn->prepare("SELECT name, email, Contact_No, Location FROM activated_employer WHERE Company_ID = ?");
$stmt->bind_param("i", $employer_data['Company_ID']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $employer_data = array_merge($employer_data, $result->fetch_assoc());
    $_SESSION['employer_data'] = $employer_data; // Update session data
}

$stmt->close();

function getUserData($key, $employer_data) {
    return isset($employer_data[$key]) ? htmlspecialchars($employer_data[$key]) : '';
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
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo getUserData('name', $employer_data); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>
            <div class="form-group-inline centered">
                <label for="Location">Location</label>
                <textarea class="form-control portfolio-textarea" id="Location" name="Location" rows="3" readonly><?php echo getUserData('Location', $employer_data); ?></textarea>
            </div>     
            <div class="section-divider"></div>
            <h3>II. Contact Information</h3>
            <div class="section-divider"></div>
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="Contact_No">Phone Number</label>
                    <input type="text" class="form-control" id="Contact_No" name="Contact_No" value="<?php echo getUserData('Contact_No', $employer_data); ?>" readonly>
                </div>
                <div class="form-group-inline">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo getUserData('email', $employer_data); ?>" readonly>
                </div>
            </div>
            <div class="section-divider"></div>
            <button type="submit" class="btn btn-primary btn-block">Edit Profile</button>
        </form>
        <a href="log.php" class="btn btn-secondary btn-block mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
