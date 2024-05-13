$(document).ready(function(){
    $("#searchForm").submit(function(event){
        event.preventDefault(); // Prevent the form from submitting

        var email = $("input[name='email']").val();

        $.ajax({
            type: "POST",
            url: "search-email.php",
            data: {email: email},
            success: function(response){
                $("#SearchEmailContainer").html(response);
            }
        });
    });
});
