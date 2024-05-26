<?php
session_start();
require '../connection/connection.php'; // Include your database connection

// Check if the employer is logged in
if (!isset($_SESSION['employer_data'])) {
    header('Location: index.php');
    exit;
}

$employer_data = $_SESSION['employer_data'];

// Ensure company_id exists in session data
if (!isset($employer_data['Company_ID'])) {
    echo "Error: company_id not found in session data.";
    exit;
}

$company_id = $employer_data['Company_ID']; // Get the company_id from the session data

// Fetch the applications for the internships posted by the currently logged-in employer
$sql = "SELECT ai.*, e.name as company_name, i.title
        FROM application_internship ai
        JOIN internship i ON ai.internship_ID = i.Internship_ID
        JOIN activated_employer e ON i.Company_ID = e.Company_ID
        WHERE e.Company_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
    .btn-group {
        display: flex;
        gap: 10px;
    }

    body {
        font-family: 'Poppins', sans-serif;
        font-size: 8px;
        color: #7d8da1;
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .section-divider-top {
        border-bottom: 2px solid #e9ecef;
        margin: 50px 0;
    }

    .dashboard-table {
        font-size: 10px;
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

    .btn:disabled, .btn[disabled] {
        cursor: not-allowed !important;
    }

    .table-wrapper {
        max-height: 380px;
        overflow-y: auto;
        margin-top: 20px;
    }

    .search-input {
        margin-bottom: 20px;
        width: 100%;
        padding: 10px;
        font-size: 14px;
    }
    </style>

</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="section-divider-top"></div>
<div class="container mt-5">
    <h2 style="font-size: 1.5rem;">Application List <span class="material-symbols-outlined">
patient_list
</span></h2>
<div class="section-divider"></div>
    <input type="text" id="searchInput" class="form-control search-input" placeholder="Search for applications...">
    <div class="table-wrapper">
        <table class="modern-table dashboard-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Student Email</th>
                <th>Student Course</th>
                <!-- <th>Internship ID</th> -->
                <th>Job Title</th>
                <!-- <th>Company Name</th> -->
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="applicationTableBody">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row['student_email']; ?></td>
                    <td><?php echo $row['student_course']; ?></td>
                    <!-- <td><?php echo $row['internship_ID']; ?></td> -->
                    <td><?php echo $row['title']; ?></td>
                    <!-- <td><?php echo $row['company_name']; ?></td> -->
                    <td id="status-<?php echo $row['id']; ?>"><?php echo $row['status']; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-success" style="font-size: 10px; font-weight: 400;" onclick="confirmChangeStatus(<?php echo $row['id']; ?>, 'Approved')" <?php if ($row['status'] === 'Approved' || $row['status'] === 'Rejected' || $row['status'] === 'Cancelled') echo 'disabled'; ?>>Approve</button>
                            <button class="btn btn-danger" style="font-size: 10px; font-weight: 400;" onclick="confirmChangeStatus(<?php echo $row['id']; ?>, 'Rejected')" <?php if ($row['status'] === 'Approved' || $row['status'] === 'Rejected' || $row['status'] === 'Cancelled') echo 'disabled'; ?>>Reject</button>
                            <a href="../students/<?php echo $row['resume_path']; ?>" class="btn" style="font-size: 12px; font-weight: 400; color: grey;" target="_blank">View</a>
                            <a href="../students/<?php echo $row['resume_path']; ?>" class="btn" style="font-size: 12px; font-weight: 400; color: grey;" download>Download</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmChangeStatus(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to ${status.toLowerCase()} this application?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `Yes, ${status.toLowerCase()} it!`
    }).then((result) => {
        if (result.isConfirmed) {
            changeStatus(id, status);
        }
    });
}

function changeStatus(id, status) {
    $.ajax({
        url: 'update_status.php',
        method: 'POST',
        data: { id: id, status: status },
        success: function(response) {
            console.log('Response:', response); // Debug log
            if (response === 'success') {
                $('#status-' + id).text(status);
                Swal.fire(
                    `${status}!`,
                    `Application has been ${status.toLowerCase()}.`,
                    'success'
                );
                // Disable both buttons if the status is Approved or Rejected
                if (status === 'Approved' || status === 'Rejected') {
                    $(`button[onclick="confirmChangeStatus(${id}, 'Approved')"]`).prop('disabled', true);
                    $(`button[onclick="confirmChangeStatus(${id}, 'Rejected')"]`).prop('disabled', true);
                }
            } else if (response === 'email_error') {
                Swal.fire(
                    'Failed!',
                    'Email failed to send, but the status was updated.',
                    'error'
                );
            } else if (response === 'update_error') {
                Swal.fire(
                    'Failed!',
                    'Failed to update status in the database.',
                    'error'
                );
            } else if (response === 'application_not_found') {
                Swal.fire(
                    'Failed!',
                    'Application not found.',
                    'error'
                );
            } else {
                Swal.fire(
                    'Success!',
                    `Application has been ${status.toLowerCase()}.`,
                    'success'
                );
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error); // Debug log
            Swal.fire(
                'Failed!',
                'Failed to update status.',
                'error'
            );
        }
    });
}


// Search function
$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        var visible = false;
        $("#applicationTableBody tr").filter(function() {
            var isMatch = $(this).text().toLowerCase().indexOf(value) > -1;
            $(this).toggle(isMatch);
            if (isMatch) {
                visible = true;
            }
        });
        if (!visible) {
            Swal.fire('No Result', 'No applications matched your search.', 'info');
        }
    });
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
