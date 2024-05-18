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
    <form id="internshipForm">
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
            <!-- Internship rows will be added here by JavaScript -->
        </tbody>
    </table>
</div>

<!-- View/Edit Modal -->
<div class="modal" id="internshipModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">View Internship</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form id="modalForm">
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
                    <button type="submit" class="btn btn-primary" id="modalSaveBtn">Save Changes</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="post_internship.js"></script>
</body>
</html>
