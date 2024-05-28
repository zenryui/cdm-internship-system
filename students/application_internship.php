<?php
session_start();
require_once("../connection/connection.php");

// Check if the user is not logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit;
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
$internshipsQuery = "
    SELECT i.Internship_ID, i.Requirements, i.Duration, i.Description, i.Title, i.Company_ID, e.name, e.Location 
    FROM internship i 
    JOIN activated_employer e ON i.Company_ID = e.Company_ID";
$internshipsResult = $conn->query($internshipsQuery);

// Fetch student's application history
$applicationsQuery = "
SELECT ai.id, ai.internship_ID, ai.title, ai.company_ID, ai.company_name, ai.status, ai.resume_path
FROM application_internship ai
WHERE ai.student_email = ?";
$applicationsStmt = $conn->prepare($applicationsQuery);
$applicationsStmt->bind_param("s", $student_email);
$applicationsStmt->execute();
$applicationsResult = $applicationsStmt->get_result();

$appliedInternships = [];
$internshipStatus = [];
while ($row = $applicationsResult->fetch_assoc()) {
    $appliedInternships[] = $row['internship_ID'];
    $internshipStatus[$row['internship_ID']] = $row['status'];
}
$applicationsStmt->close();
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../assets/img/nvidia.png">
</head>
<body>
<div class="container mt-4">
    <h2>Available Internships</h2>
    <form class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" id="search" placeholder="Search by ID, duration, title, company, location">
        </div>
    </form>
    <table class="table table-bordered" id="internships-table">
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
        <tbody id="internships-tbody">
            <?php while($row = $internshipsResult->fetch_assoc()): ?>
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
                    <?php if (in_array($row['Internship_ID'], $appliedInternships) && ($internshipStatus[$row['Internship_ID']] == 'Pending' || $internshipStatus[$row['Internship_ID']] == 'Approved')): ?>
    <button class="btn btn-secondary" disabled>Applied</button>
<?php else: ?>          
    <button class="btn btn-info apply-btn" 
            data-bs-toggle="modal" 
            data-bs-target="#applyModal" 
            data-id="<?php echo $row['Internship_ID']; ?>" 
            data-title="<?php echo $row['Title']; ?>" 
            data-company-id="<?php echo $row['Company_ID']; ?>" 
            data-company-name="<?php echo $row['name']; ?>">Apply</button>
<?php endif; ?>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <div id="no-results" class="alert alert-warning" style="display: none;">No Results</div>


    <table class="table table-bordered">

        <thead>
            <tr>
                <th>ID</th>
                <th>Internship ID</th>
                <th>Title</th>
                <th>Company ID</th>
                <th>Company Name</th>
                <th>Status</th>
                <th>Resume Path</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="applications-tbody">
            <?php foreach($applicationsResult as $application): ?>
                <tr data-id="<?php echo $application['id']; ?>">
                    <td><?php echo $application['id']; ?></td>
                    <td><?php echo $application['internship_ID']; ?></td>
                    <td><?php echo $application['title']; ?></td>
                    <td><?php echo $application['company_ID']; ?></td>
                    <td><?php echo $application['company_name']; ?></td>
                    <td><?php echo $application['status']; ?></td>
                    <td><a href="<?php echo $application['resume_path']; ?>" target="_blank">View Resume</a></td>
                    <td>
                        <?php if ($application['status'] == 'Pending'): ?>
                            <button class="btn btn-danger cancel-btn" data-id="<?php echo $application['id']; ?>">Cancel</button>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Cancel</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
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
                <form id="applyForm" enctype="multipart/form-data">
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
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.apply-btn').on('click', function () {
        var internshipID = $(this).data('id');
        var title = $(this).data('title');
        var companyID = $(this).data('company-id');
        var companyName = $(this).data('company-name');
        
        $('#internship_ID').val(internshipID);
        $('#title').val(title);
        $('#company_ID').val(companyID);
        $('#company_name').val(companyName);
    });

    $('#applyForm').on('submit', function (e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: 'submit_application.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Application submitted successfully!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#applyModal').modal('hide');
                        location.reload();
                    }
                });
            },
            error: function (response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error submitting application. Please try again.'
                });
            }
        });
    });

    $('.cancel-btn').on('click', function () {
        var applicationID = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to cancel this application?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'cancel_application.php',
                    type: 'POST',
                    data: { id: applicationID },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cancelled',
                            text: 'Application cancelled successfully!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function (response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error cancelling application. Please try again.'
                        });
                    }
                });
            }
        });
    });

    $("#search").on("input", function() {
        var searchTerm = $(this).val().toLowerCase();
        var noResults = true;
        
        $("#internships-tbody tr").each(function() {
            var rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(searchTerm) === -1) {
                $(this).hide();
            } else {
                $(this).show();
                noResults = false;
            }
        });

        $("#no-results").toggle(noResults);
    });
});
</script>
</body>
</html>
