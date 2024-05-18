$(document).ready(function () {
    // Load existing internships
    loadInternships();

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
                            <button class="btn btn-success applyBtn" data-id="${internship.Internship_ID}">Apply Now</button>
                        </td>
                    </tr>`;
                });
                $('#internshipTable tbody').html(rows);
            }
        });
    }

    // Handle apply button click
    $(document).on('click', '.applyBtn', function () {
        var id = $(this).data('id');
        $('#applyInternshipID').val(id);
        $('#applyModal').modal('show');
    });

    // Handle form submission for applying to internship
    $('#applyForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'application.php',
            data: $(this).serialize() + '&action=apply',
            success: function (response) {
                console.log(response); // Log the response to check for success
                $('#applyModal').modal('hide');
                $('#applyForm')[0].reset();
                alert("Application submitted successfully");
            }
        });
    });
});
