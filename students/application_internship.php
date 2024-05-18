<?php
session_start();
require_once("../connection/connection.php");

// Check if the user is not logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Assuming user data is stored in the session
$user_data = $_SESSION['user_data']; 
$user_id = $user_data['id']; // Replace with actual session variable for user ID

// Fetch student data
$studentQuery = "SELECT name, email, course FROM activated_student WHERE id = ?";
$stmt = $conn->prepare($studentQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($student_name, $student_email, $student_course);
$stmt->fetch();
$stmt->close();

// Fetch internships and their corresponding employer details
$sql = "SELECT i.Internship_ID, i.Requirements, i.Duration, i.Description, i.Title, i.Company_ID, e.name, e.Location 
        FROM internship i 
        JOIN activated_employer e ON i.Company_ID = e.Company_ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Internships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2>Available Internships</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Internship ID</th>
                <th>Requirements</th>
                <th>Duration</th>
                <th>Description</th>
                <th>Title</th>
                <th>Company ID</th>
                <th>Company Name</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['Internship_ID']; ?></td>
                    <td><?php echo $row['Requirements']; ?></td>
                    <td><?php echo $row['Duration']; ?></td>
                    <td><?php echo $row['Description']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Company_ID']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['Location']; ?></td>
                    <td>
                        <button class="btn btn-info apply-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#applyModal" 
                                data-id="<?php echo $row['Internship_ID']; ?>" 
                                data-title="<?php echo $row['Title']; ?>" 
                                data-company-id="<?php echo $row['Company_ID']; ?>" 
                                data-company-name="<?php echo $row['name']; ?>">Apply</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Apply Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Apply for Internship</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="applyForm" action="submit_application.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo $student_name; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="student_email" class="form-label">Student Email</label>
                        <input type="email" class="form-control" id="student_email" name="student_email" value="<?php echo $student_email; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="student_course" class="form-label">Student Course</label>
                        <input type="text" class="form-control" id="student_course" name="student_course" value="<?php echo $student_course; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="internship_ID" class="form-label">Internship ID</label>
                        <input type="text" class="form-control" id="internship_ID" name="internship_ID" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Internship Title</label>
                        <input type="text" class="form-control" id="title" name="title" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="company_ID" class="form-label">Company ID</label>
                        <input type="text" class="form-control" id="company_ID" name="company_ID" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="resume" class="form-label">Upload Resume</label>
                        <input type="file" class="form-control" id="resume" name="resume" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.apply-btn').on('click', function() {
            var data = $(this).data();
            $('#internship_ID').val(data.id);
            $('#title').val(data.title);
            $('#company_ID').val(data.companyId);
            $('#company_name').val(data.companyName);
        });
    });
</script>
</body>
</html>
