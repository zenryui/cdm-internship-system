<?php
session_start();
include '../connection/connection.php'; // Ensure this path is correct based on your file structure

// Check if the employer is logged in
if (!isset($_SESSION['employer_data'])) {
    header("Location: index.php");
    exit();
}

$employer_data = $_SESSION['employer_data'];
$company_id = $employer_data['Company_ID']; // Fetching the company ID from the session employer data

// Fetch all internships posted by the employer
$sql = "SELECT * FROM internship WHERE Company_ID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die("Error executing statement: " . $stmt->error);
}

// Initialize arrays for different statuses
$all_internships = [];
$posted_internships = [];
$declined_internships = [];
$pending_internships = [];

while ($row = $result->fetch_assoc()) {
    $all_internships[] = $row;
    if ($row['Status'] === 'Posted') {
        $posted_internships[] = $row;
    } elseif ($row['Status'] === 'Declined') {
        $declined_internships[] = $row;
    } elseif ($row['Status'] === 'Pending') {
        $pending_internships[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Internship</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 Library -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="shortcut icon" href="../assets/img/nvidia.png">
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

    .table-wrapper {
        max-height: 380px;
        overflow-y: auto;
        margin-top: 20px;
    }

    h2 {
        text-align: center;
    }
</style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="section-divider-top"></div>
<div class="container mt-4">

    <!-- Nav & Tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="posted-tab" data-bs-toggle="tab" data-bs-target="#posted-tab-pane" type="button" role="tab" aria-controls="posted-tab-pane" aria-selected="false">Posted</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="declined-tab" data-bs-toggle="tab" data-bs-target="#declined-tab-pane" type="button" role="tab" aria-controls="declined-tab-pane" aria-selected="false">Declined</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">Pending</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- All Internships Tab -->
        <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
            <h2 class="mt-4" style="font-size: 1.5rem;">All Internship Programs <span class="material-symbols-outlined" style="color: blue;">
                work</span>
                <!-- Create Internship Toggle Button -->
            <button type="button" class="btn btn-success mt-0" style="margin-left: 970px; font-size: 12px;" data-bs-toggle="modal" data-bs-target="#createInternshipModal">
                Create Internship
            </button></span></h2>
            <div class="table-wrapper">
                <table class="modern-table dashboard-table" id="internshipTable">
                    <thead>
                        <tr>
                            <th>Internship ID</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_internships as $internship): ?>
                            <tr>
                                <td><?php echo $internship['Internship_ID']; ?></td>
                                <td><?php echo $internship['Title']; ?></td>
                                <td><?php echo $internship['Duration']; ?></td>
                                <td><?php echo $internship['Status']; ?></td>
                                <td>
                                    <button class="btn btn-success" style="font-size: 12px; font-weight: 400; margin-left: 0px;" data-bs-toggle="modal" data-bs-target="#internshipModal" data-id="<?php echo $internship['Internship_ID']; ?>" data-title="<?php echo $internship['Title']; ?>" data-description="<?php echo $internship['Description']; ?>" data-requirements="<?php echo $internship['Requirements']; ?>" data-duration="<?php echo $internship['Duration']; ?>">Edit</button>
                                    <button class="btn btn-danger-border-subtle" style="font-size: 12px; font-weight: 400; color: red; margin-left: 10px;" onclick="deleteInternship(<?php echo $internship['Internship_ID']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Posted Internships Tab -->
        <div class="tab-pane fade" id="posted-tab-pane" role="tabpanel" aria-labelledby="posted-tab" tabindex="0">
            <h2 class="mt-4" style="font-size: 1.5rem;">Posted Internship Programs <span class="material-symbols-outlined" style="color: limegreen;">
thumb_up
</span></h2>
            <div class="table-wrapper">
                <table class="modern-table dashboard-table" id="postedInternshipTable">
                    <thead>
                        <tr>
                            <th>Internship ID</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posted_internships as $internship): ?>
                            <tr>
                                <td><?php echo $internship['Internship_ID']; ?></td>
                                <td><?php echo $internship['Title']; ?></td>
                                <td><?php echo $internship['Duration']; ?></td>
                                <td><?php echo $internship['Status']; ?></td>
                                <td>
                                    <button class="btn btn-success" style="font-size: 12px; font-weight: 400; margin-left: 0px;" data-bs-toggle="modal" data-bs-target="#internshipModal" data-id="<?php echo $internship['Internship_ID']; ?>" data-title="<?php echo $internship['Title']; ?>" data-description="<?php echo $internship['Description']; ?>" data-requirements="<?php echo $internship['Requirements']; ?>" data-duration="<?php echo $internship['Duration']; ?>">Edit</button>
                                    <button class="btn btn-danger-border-subtle" style="font-size: 12px; font-weight: 400; color: red; margin-left: 10px;" onclick="deleteInternship(<?php echo $internship['Internship_ID']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Declined Internships Tab -->
        <div class="tab-pane fade" id="declined-tab-pane" role="tabpanel" aria-labelledby="declined-tab" tabindex="0">
            <h2 class="mt-4" style="font-size: 1.5rem;">Declined Internship Programs <span class="material-symbols-outlined" style="color: red;">
thumb_down
</span></h2>
            <div class="table-wrapper">
                <table class="modern-table dashboard-table" id="declinedInternshipTable">
                    <thead>
                        <tr>
                            <th>Internship ID</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($declined_internships as $internship): ?>
                            <tr>
                                <td><?php echo $internship['Internship_ID']; ?></td>
                                <td><?php echo $internship['Title']; ?></td>
                                <td><?php echo $internship['Duration']; ?></td>
                                <td><?php echo $internship['Status']; ?></td>
                                <td>
                                    <button class="btn btn-success" style="font-size: 12px; font-weight: 400; margin-left: 0px;" data-bs-toggle="modal" data-bs-target="#internshipModal" data-id="<?php echo $internship['Internship_ID']; ?>" data-title="<?php echo $internship['Title']; ?>" data-description="<?php echo $internship['Description']; ?>" data-requirements="<?php echo $internship['Requirements']; ?>" data-duration="<?php echo $internship['Duration']; ?>">Edit</button>
                                    <button class="btn btn-danger-border-subtle" style="font-size: 12px; font-weight: 400; color: red; margin-left: 10px;" onclick="deleteInternship(<?php echo $internship['Internship_ID']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pending Internships Tab -->
        <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
            <h2 class="mt-4" style="font-size: 1.5rem;">Pending Internship Programs<span class="material-symbols-outlined" style="color: orange;">
pending_actions
</span></h2>
            <div class="table-wrapper">
                <table class="modern-table dashboard-table" id="pendingInternshipTable">
                    <thead>
                        <tr>
                            <th>Internship ID</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_internships as $internship): ?>
                            <tr>
                                <td><?php echo $internship['Internship_ID']; ?></td>
                                <td><?php echo $internship['Title']; ?></td>
                                <td><?php echo $internship['Duration']; ?></td>
                                <td><?php echo $internship['Status']; ?></td>
                                <td>
                                    <button class="btn btn-success" style="font-size: 12px; font-weight: 400; margin-left: 0px;" data-bs-toggle="modal" data-bs-target="#internshipModal" data-id="<?php echo $internship['Internship_ID']; ?>" data-title="<?php echo $internship['Title']; ?>" data-description="<?php echo $internship['Description']; ?>" data-requirements="<?php echo $internship['Requirements']; ?>" data-duration="<?php echo $internship['Duration']; ?>">Edit</button>
                                    <button class="btn btn-danger-border-subtle" style="font-size: 12px; font-weight: 400; color: red; margin-left: 10px;" onclick="deleteInternship(<?php echo $internship['Internship_ID']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    

    <!-- Modal for Create Internship -->
    <div class="modal fade" id="createInternshipModal" tabindex="-1" aria-labelledby="createInternshipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createInternshipModalLabel">Create Internship</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createInternshipForm" method="POST" action="submit_internship.php">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="requirements">Requirements</label>
                            <textarea class="form-control" id="requirements" name="requirements" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Create</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Internship Details Modal -->
<div class="modal fade" id="internshipModal" tabindex="-1" aria-labelledby="internshipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="internshipModalLabel">Internship Program</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="internshipDetailsForm" method="post" action="submit_internship.php">
                    <input type="hidden" name="internship_id" id="internship_id">
                    <div class="form-group">
                        <label for="internship_title">Title:</label>
                        <input type="text" class="form-control" id="internship_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="internship_description">Description:</label>
                        <textarea class="form-control" id="internship_description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="internship_requirements">Requirements:</label>
                        <textarea class="form-control" id="internship_requirements" name="requirements" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="internship_duration">Duration:</label>
                        <input type="text" class="form-control" id="internship_duration" name="duration" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Script for handling delete action -->
<script>
// Create internship sweetalert
$(document).ready(function() {
    // Handle form submission for creating an internship
    $('#createInternshipForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to create this internship?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, create it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'submit_internship.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire(
                            'Created!',
                            'Your internship has been created.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page after creation
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'There was an error creating the internship.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

// Edit Internship Sweetalert
$(document).ready(function() {
    $('#internshipDetailsForm').on('submit', function(e) {
        e.preventDefault(); // Prevent form submission

        Swal.fire({
            title: 'Save Changes',
            text: "Are you sure you want to save the changes to this internship?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'submit_internship.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire(
                            'Saved!',
                            'The internship details have been updated.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        Swal.fire(
                            'Error!',
                            'There was an error updating the internship.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

//Delete internship Sweetalert
function deleteInternship(internshipID) {
    Swal.fire({
        title: 'Delete Internship',
        text: "Are you sure you want to delete this internship?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'submit_internship.php',
                type: 'POST',
                data: { delete_internship_id: internshipID },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'The internship has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the internship.',
                        'error'
                    );
                }
            });
        }
    });
}

// Script for populating the internship modal with existing data
$('#internshipModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var internshipID = button.data('id');
    var title = button.data('title');
    var description = button.data('description');
    var requirements = button.data('requirements');
    var duration = button.data('duration');

    var modal = $(this);
    modal.find('#internship_id').val(internshipID);
    modal.find('#internship_title').val(title);
    modal.find('#internship_description').val(description);
    modal.find('#internship_requirements').val(requirements);
    modal.find('#internship_duration').val(duration);
});


        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        }

</script>
</body>
</html>