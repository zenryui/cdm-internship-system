<?php
require_once("../connection/connection.php");
require_once '../dompdf/vendor/autoload.php'; // Include Dompdf library

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
        border-radius: 20px;
        padding-left: 50px;
    }
    </style>
</head>
<body>
    <table style=" margin-top: 2.5rem;">
    <thead>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td style="font-size: 1.5rem; font-weight: bold;">' . getUserData('name', $user_data) . '</td>
        <td><img src="../assets/img/id-card.png" alt="Profile Picture"</td>
    </tr>
    <tr>
        <td>' . getUserData('address', $user_data) . '</td>
    </tr>
    <tr>
        <td>Contact No.:' . getUserData('contact_no', $user_data) . '</td>
    </tr>
    <tr>
        <td>Email address: <span style="color: #6DC5D1;";>' . getUserData('email', $user_data) . '</span></td>
    </tr>

    </thead>
    </table>

    <h4 style="margin-bottom: 10px;"> OBJECTIVE: </h4>
    <textarea style="width: 584px; height: 70px; text-align:center; font-family: "Arial", sans-serif;">' . getUserData('objective', $user_data) . '</textarea>
    <h1 style="margin-bottom: -10px;  margin-top: -10px;">_________________________________</h1>

    <table>
    <thead>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <h4>PERSONAL INFORMATION</h4>
    <tr>
        <td style="width: 270px;">Birthdate:</td>
        <td>' . getUserData('birthday', $user_data) . '</td>
    </tr>
    <tr>
        <td>Birthplace:</td>
        <td>' . getUserData('birthplace', $user_data) . '</td>
    </tr>
    <tr>
        <td>Citizenship</td>
        <td>' . getUserData('citizenship', $user_data) . '</td>
    </tr>
    <tr>
        <td>Religion</td>
        <td>' . getUserData('religion', $user_data) . '</td>
    </tr>
    <tr>
        <td>Languages Spoken</td>
        <td>' . getUserData('languages_spoken', $user_data) . '</td>
    </tr>
    <tr>
        <td>Civil Status</td>
        <td>' . getUserData('civil_status', $user_data) . '</td>
    </tr>
    </thead>
    </table>
    <h1 style="margin-bottom: 25px;  margin-top: -10px;">_________________________________</h1>

    <table class="educ" style="margin-top: -37px;">
    <thead>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <h4>EDUCATIONAL BACKGROUND</h4>
    <tr>
        <td style="width: 450px;"><strong>' . getUserData('course', $user_data) . '</strong></td>
    </tr>
    <tr>
        <td>' . getUserData('tertiary_education', $user_data) . '</td>
        <td><strong>' . getUserData('tertiary_year', $user_data) . '</strong></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Secondary Education</strong></td>
</tr>
    <tr>
        <td>' . getUserData('secondary_education', $user_data) . '</td>
        <td><strong>' . getUserData('secondary_year', $user_data) . '</strong></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Primary Education</strong></td>
</tr>
    <tr>
        <td>' . getUserData('primary_education', $user_data) . '</td>
        <td><strong>' . getUserData('primary_year', $user_data) . '</strong></td>
</tr>
    </thead>
</table>   
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