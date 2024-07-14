<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Lumina Lux</h1>
            <h2 class="text-center">User Login</h2>
            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <p class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
            </form>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();




        var formData = {
            email: $('#email').val(),
            password: $('#password').val()
        };




        $.ajax({
            type: 'POST',
            url: '/api/login',
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function(response) {
                swal("Success", response.message, "success").then(function() {
                    window.location.href = response.redirect;
                });
            },
            error: function(xhr) {
                swal("Error", xhr.responseJSON.message, "error");
            }
        });
    });
});
</script>
</body>
</html>
