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

// Fetch internships posted by the employer
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Internship</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2>Create Internship Program</h2>
    <form id="internshipForm" method="post" action="submit_internship.php">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="requirements">Requirements:</label>
            <textarea class="form-control" id="requirements" name="requirements" required></textarea>
        </div>
        <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="text" class="form-control" id="duration" name="duration" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Internship</button>
    </form>
    <br>
    <h2>Internship Programs</h2>
    <table class="table table-bordered" id="internshipTable">
        <thead>
            <tr>
                <th>Internship ID</th>
                <th>Title</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['Internship_ID']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Duration']; ?></td>
                    <td>
                        <button class="btn btn-info" data-toggle="modal" data-target="#internshipModal" data-id="<?php echo $row['Internship_ID']; ?>" data-title="<?php echo $row['Title']; ?>" data-description="<?php echo $row['Description']; ?>" data-requirements="<?php echo $row['Requirements']; ?>" data-duration="<?php echo $row['Duration']; ?>">View/Edit</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- View/Edit Modal -->
<div class="modal" id="internshipModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">View Internship</h4>
                <button type="button" class="close" data-dismiss="modal">&times</button>
            </div>
            <div class="modal-body">
                <form id="modalForm" method="post" action="update_internship.php">
                    <input type="hidden" id="modalInternshipID" name="id">
                    <div class="form-group">
                        <label for="modalTitleInput">Title:</label>
                        <input type="text" class="form-control" id="modalTitleInput" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="modalDescriptionInput">Description:</label>
                        <textarea class="form-control" id="modalDescriptionInput" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modalRequirementsInput">Requirements:</label>
                        <textarea class="form-control" id="modalRequirementsInput" name="requirements" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modalDurationInput">Duration:</label>
                        <input type="text" class="form-control" id="modalDurationInput" name="duration" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="modalSave
Button">Save changes</button>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
</div>
</div>

</div>
<script>
$(document).ready(function() {
    $('#internshipModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var title = button.data('title');
        var description = button.data('description');
        var requirements = button.data('requirements');
        var duration = button.data('duration');
        
        var modal = $(this);
        modal.find('.modal-title').text('View/Edit Internship');
        modal.find('#modalInternshipID').val(id);
        modal.find('#modalTitleInput').val(title);
        modal.find('#modalDescriptionInput').val(description);
        modal.find('#modalRequirementsInput').val(requirements);
        modal.find('#modalDurationInput').val(duration);
    });
});
</script>
</body>
</html>