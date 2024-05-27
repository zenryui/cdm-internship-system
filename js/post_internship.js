// post_internship.js
$(document).ready(function () {
    // Load existing internships
    loadInternships();

    // Handle form submission for creating new internship
    $('#internshipForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'connection.php',
            data: $(this).serialize() + '&action=create',
            success: function (response) {
                console.log(response); // Log the response to check for success
                loadInternships();
                $('#internshipForm')[0].reset();
            }
        });
    });

    // Load internships into the table
    function loadInternships() {
        $.ajax({
            type: 'POST',
            url: 'connection.php',
            data: { action: 'read' },
            success: function (response) {
                var internships = JSON.parse(response);
                var rows = '';
                internships.forEach(function (internship) {
                    rows += `<tr>
                        <td>${internship.Internship_ID}</td>
                        <td>${internship.Title}</td>
                        <td>${internship.Duration}</td>
                        <td>
                            <button class="btn btn-info viewBtn" data-id="${internship.Internship_ID}">View</button>
                            <button class="btn btn-warning editBtn" data-id="${internship.Internship_ID}">Edit</button>
                            <button class="btn btn-danger deleteBtn" data-id="${internship.Internship_ID}">Delete</button>
                        </td>
                    </tr>`;
                });
                $('#internshipTable tbody').html(rows);
            }
        });
    }

    // Handle view button click
    $(document).on('click', '.viewBtn', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'connection.php',
            data: { id: id, action: 'view' },
            success: function (response) {
                var internship = JSON.parse(response);
                $('#modalInternshipID').val(internship.Internship_ID);
                $('#modalTitleInput').val(internship.Title);
                $('#modalDescriptionInput').val(internship.Description);
                $('#modalRequirementsInput').val(internship.Requirements);
                $('#modalDurationInput').val(internship.Duration);
                $('#modalTitle').text('View Internship');
                $('#modalForm input, #modalForm textarea').attr('readonly', true);
                $('#modalSaveBtn').hide();
                $('#internshipModal').modal('show');
            }
        });
    });

    // Handle edit button click
    $(document).on('click', '.editBtn', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'connection.php',
            data: { id: id, action: 'view' },
            success: function (response) {
                var internship = JSON.parse(response);
                $('#modalInternshipID').val(internship.Internship_ID);
                $('#modalTitleInput').val(internship.Title);
                $('#modalDescriptionInput').val(internship.Description);
                $('#modalRequirementsInput').val(internship.Requirements);
                $('#modalDurationInput').val(internship.Duration);
                $('#modalTitle').text('Edit Internship');
                $('#modalForm input, #modalForm textarea').attr('readonly', false);
                $('#modalSaveBtn').show();
                $('#internshipModal').modal('show');
            }
        });
    });

    // Handle save changes button click in modal
    $('#modalForm').on('submit', function (e) {
        e.preventDefault();
        var id = $('#modalInternshipID').val();
        $.ajax({
            type: 'POST',
            url: 'connection.php',
            data: $(this).serialize() + '&action=update',
            success: function (response) {
                $('#internshipModal').modal('hide');
                loadInternships();
            }
        });
    });


    // Handle delete button click
    $(document).on('click', '.deleteBtn', function () {
        if (confirm('Are you sure you want to delete this internship?')) {
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'connection.php',
                data: { id: id, action: 'delete' },
                success: function (response) {
                    loadInternships();
                }
            });
        }
    });
});
