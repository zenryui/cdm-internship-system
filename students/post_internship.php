<!DOCTYPE html>
<html>
<head>
    <title>Internship Listings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-4">
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

<!-- Apply Modal -->
<div class="modal" id="applyModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Apply for Internship</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="applyForm">
                    <input type="hidden" id="applyInternshipID" name="internship_id">
                    <div class="form-group">
                        <label for="studentName">Name:</label>
                        <input type="text" class="form-control" id="studentName" name="student_name" required>
                    </div>
                    <div class="form-group">
                        <label for="studentEmail">Email:</label>
                        <input type="email" class="form-control" id="studentEmail" name="student_email" required>
                    </div>
                    <div class="form-group">
                        <label for="course">Course:</label>
                        <input type="text" class="form-control" id="course" name="course" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="post_internship.js"></script>
</body>
</html>
