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
    JOIN activated_employer e ON i.Company_ID = e.Company_ID
    WHERE i.status = 'Posted'";
$internshipsResult = $conn->query($internshipsQuery);


// Fetch applications by status
$statuses = ['All', 'Approved', 'Rejected', 'Pending', 'Cancelled'];
$applicationsByStatus = [];

foreach ($statuses as $status) {
    $applicationsQuery = "SELECT ai.id, ai.internship_ID, ai.title, ai.company_ID, ai.company_name, ai.status, ai.resume_path 
                          FROM application_internship ai 
                          WHERE ai.student_email = ?";
    
    if ($status !== 'All') {
        $applicationsQuery .= " AND ai.status = ?";
    }
    
    $applicationsStmt = $conn->prepare($applicationsQuery);

    if ($status === 'All') {
        $applicationsStmt->bind_param("s", $student_email);
    } else {
        $applicationsStmt->bind_param("ss", $student_email, $status);
    }

    $applicationsStmt->execute();
    $applicationsResult = $applicationsStmt->get_result();
    $applicationsByStatus[$status] = $applicationsResult->fetch_all(MYSQLI_ASSOC);
    $applicationsStmt->close();
}

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
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="shortcut icon" href="../assets/img/nvidalogo.png">


    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: #7d8da1;
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .section-divider-top {
            border-bottom: 2px solid #e9ecef;
            margin: 50px 0;
        }

        .section-divider-bot {
            border-bottom: 2px solid #e9ecef;
            margin: 25px 0;
        }

        .dashboard-table {
            font-size: 12px;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
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

        /* for modal */
        .form-group {
            margin: 20px;
        }

        .btn {
            margin-left: 20px;
        }

        /* Scrollable table */
        .table-responsive {
            overflow-y: auto;
        }

        .scrollable-table {
            max-height: 250px;
            overflow-y: auto;
            display: block;
        }

        h2 {
            text-align: center;
        }
        

    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="container mt-4">
    <div class="section-divider-top"></div>
    <h2>Available Internships</h2>
    <form class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" id="search" placeholder="Search by ID, duration, title, company, location" style="margin-left: 800px; font-size: 12px;">
        </div>
    </form>
    <div class="scrollable-table">
    <table class="modern-table dashboard-table" id="internships-table">
            <thead>
                <tr>
                    <th>Internship ID</th>
                    <th>Requirements</th>
                    <th>Duration</th>
                    <th>Description</th>
                    <th>Title</th>
                    <!-- <th>Company ID</th> -->
                    <th>Company</th>
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
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['Location']; ?></td>
        <td>
            <?php 
                // Check if the student has already applied for this internship
                $applied = false;
                $appliedStatus = '';
                foreach ($applicationsByStatus as $status => $applications) {
                    if ($status !== 'Cancelled') {
                        foreach ($applications as $application) {
                            if ($application['internship_ID'] == $row['Internship_ID']) {
                                $applied = true;
                                $appliedStatus = $application['status'];
                                break 2;
                            }
                        }
                    }
                }
            ?>
            <?php if ($applied && $appliedStatus === 'Approved'): ?>
                <button class="btn btn-success" disabled style="font-size: 12px; font-weight: 600;">Applied</button>
            <?php else: ?>
                <button class="btn btn-success apply-btn" style="font-size: 12px; font-weight: 600;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#applyModal" 
                        data-id="<?php echo $row['Internship_ID']; ?>" 
                        data-title="<?php echo $row['Title']; ?>" 
                        data-company-id="<?php echo $row['Company_ID']; ?>" 
                        data-company-name="<?php echo $row['name']; ?>"
                        data-requirements="<?php echo $row['Requirements']; ?>"
                        data-description="<?php echo $row['Description']; ?>" 
                        <?php echo $applied ? 'disabled' : ''; ?>>
                    <?php echo $applied ? 'Applied' : 'Apply'; ?>
                </button>
            <?php endif; ?>
        </td>
    </tr>
<?php endwhile; ?>

            </tbody>
        </table>
    </div>
</div>
    
    <div id="no-results" class="alert alert-warning" style="display: none; max-width: 500px; text-align: center; margin-left: 400px;">No Results</div>
<div class="section-divider-bot"></div>

    <div class="container mt-4">
    <h2>Application History</h2>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved-tab-pane" type="button" role="tab" aria-controls="approved-tab-pane" aria-selected="false">Approved</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected-tab-pane" type="button" role="tab" aria-controls="rejected-tab-pane" aria-selected="false">Rejected</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">Pending</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled-tab-pane" type="button" role="tab" aria-controls="cancelled-tab-pane" aria-selected="false">Cancelled</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <?php foreach ($statuses as $status): ?>
                <div class="tab-pane fade <?php echo $status === 'All' ? 'show active' : ''; ?>" id="<?php echo strtolower($status); ?>-tab-pane" role="tabpanel" aria-labelledby="<?php echo strtolower($status); ?>-tab">
                    <div class="scrollable-table">
                    <table class="modern-table dashboard-table">
                            <thead>
                                <tr>
                                    <th>Internship ID</th>
                                    <th>Title</th>
                                    <!-- <th>Company ID</th> -->
                                    <th>Company Name</th>
                                    <th>Status</th>
                                   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applicationsByStatus[$status] as $application): ?>
                                    <tr>
                                        <td><?php echo $application['internship_ID']; ?></td>
                                        <td><?php echo $application['title']; ?></td>
                                        <!-- <td><?php echo $application['company_ID']; ?></td> -->
                                        <td><?php echo $application['company_name']; ?></td>
                                        <td><?php echo $application['status']; ?></td>

                                        <td>
                                            <?php if ($application['status'] === 'Pending'): ?>
                                                <button class="btn btn-danger cancel-btn" style="font-size: 12px; font-weight: 600;" data-id="<?php echo $application['internship_ID']; ?>">Cancel</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (empty($applicationsByStatus[$status])): ?>
                        <div class="alert alert-warning mt-2" style="max-width: 200px; float: right;">No Applications</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal for Applying to Internship -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="applyForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Apply for Internship</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
    <div class="form-group row">
        <div class="col">
            <label for="internshipID">Internship ID</label>
            <input type="text" class="form-control" id="internshipID" name="internshipID" readonly>
        </div>
        <div class="col">
            <label for="internshipTitle">Job Title</label>
            <input type="text" class="form-control" id="internshipTitle" name="internshipTitle" readonly>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            <label for="requirements">Requirements</label>
            <textarea class="form-control" id="requirements" name="requirements" rows="3" readonly></textarea>
        </div>
        <div class="col">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" readonly></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            <label for="companyName">Company Name</label>
            <input type="text" class="form-control" id="companyName" name="companyName" readonly>
        </div>
        <div class="col">
            <label for="companyID">Company ID</label>
            <input type="text" class="form-control" id="companyID" name="companyID" readonly>
        </div>
    </div>
    <!-- generate pdf -->
    <div class="form-group row">
        <div class="col">
            <a href="pdf.php" style="text-decoration: none; color: red;">
                <i class="fas fa-file-pdf"></i><span style="color: grey;"> Generate Resume</span>
            </a>
            <a href="pdf.php" class="btn" style="font-size: 12px; color: red; font-weight: 550; margin-left: 60px;" download>Download</a>
            <a href="edit_profile.php" style="text-decoration: none; color: #75A47F; margin-left: 60px;">💻Create</a>
        </div>
    </div>
    <div class="form-group row">
        <label for="resumeFile">Upload Resume</label>
        <input type="file" class="form-control" id="resumeFile" name="resumeFile" required>
    </div>
</div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Search functionality
    $('#search').on('input', function() {
        const searchValue = $(this).val().toLowerCase();
        let found = false;

        $('#internships-tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            if (rowText.includes(searchValue)) {
                $(this).show();
                found = true;
            } else {
                $(this).hide();
            }
        });

        $('#no-results').toggle(!found);
    });

// Apply button click handler
$('.apply-btn').on('click', function() {
    var internshipID = $(this).data('id');
    var internshipTitle = $(this).data('title');
    var companyID = $(this).data('company-id');
    var companyName = $(this).data('company-name');
    var requirements = $(this).data('requirements'); // assuming you have data-requirements attribute in the button
    var description = $(this).data('description'); // assuming you have data-description attribute in the button
    
    // Set values in the modal form
    $('#internshipID').val(internshipID);
    $('#internshipTitle').val(internshipTitle);
    $('#companyID').val(companyID);
    $('#companyName').val(companyName);
    $('#requirements').val(requirements);
    $('#description').val(description);
});


    // Apply form submission handler
    $('#applyForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: 'submit_application.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Application submitted successfully!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#applyModal').modal('hide');
                            location.reload(); // Reload to update application history
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error submitting application. Please try again.'
                });
            }
        });
    });

    // Cancel button click handler
    $('.cancel-btn').on('click', function() {
        var internshipID = $(this).data('id');
        var $row = $(this).closest('tr'); // Find the table row of the cancelled application
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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
                    data: { internshipID: internshipID },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire(
                                'Cancelled!',
                                'Your application has been cancelled.',
                                'success'
                            ).then(() => {
                                // Enable the "Apply" button in the available internships table
                                $('#internships-tbody tr').each(function() {
                                    if ($(this).find('td').eq(0).text() == internshipID) {
                                        $(this).find('.apply-btn')
                                            .prop('disabled', false)
                                            .text('Apply')
                                            .removeClass('btn-secondary')
                                            .addClass('btn-info');
                                    }
                                });
                                
                                $row.remove(); // Remove the cancelled application row from the history table
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response,
                            });
                        }
                    }
                });
            }
        });
    });
});
</script>


<script>
           function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        }
</script>

</body>
</html>
