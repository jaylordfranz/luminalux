<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Lumina Lux</h1>
            <h2 class="text-center">User Sign Up</h2>
            <form id="registerForm">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </form>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();




        var formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val()
        };




        $.ajax({
            type: 'POST',
            url: '/api/register',
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function(response) {
                swal("Success", response.message, "success").then(function() {
                    window.location.href = response.redirect;
                });
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessages = [];
                $.each(errors, function(key, value) {
                    errorMessages.push(value[0]);
                });
                swal("Error", errorMessages.join("\n"), "error");
            }
        });
    });
});
</script>
</body>
</html>
