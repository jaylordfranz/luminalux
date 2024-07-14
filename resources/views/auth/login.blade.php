<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 350px;
            max-width: 100%;
            background-color: #fff;
            padding: 40px 30px;
        }
        .card-title {
            font-size: 2.5em;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            font-size: 1.1em;
            font-weight: bold;
            color: #666;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            width: 100%;
            font-size: 1.1em;
            color: #333;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 15px;
            border-radius: 5px;
            width: 100%;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
        .footer-text a {
            color: #007bff;
            text-decoration: none;
        }
        .footer-text a:hover {
            text-decoration: underline;
        }
        .alert {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .divider {
            margin: 20px 0;
            border-bottom: 1px solid #ccc;
            text-align: center;
            position: relative;
        }
        .divider span {
            background-color: #fff;
            padding: 0 10px;
            position: relative;
            top: -14px;
            z-index: 1;
        }
        .divider:before {
            content: "";
            border-bottom: 1px solid #ccc;
            width: 100%;
            position: absolute;
            top: 50%;
            z-index: 0;
        }
        .google-login {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }
        .google-login a {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background-color: #000;
            color: #fff;
            border: 1px solid #000;
            padding: 15px;
            border-radius: 5px;
            width: 100%;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .google-login a:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="card-title">Sign In</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required>
                @error('password')
                    <span class="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>

        <div class="divider"><span>OR</span></div>

        <div class="google-login">
            <a href="{{ route('google-auth') }}">
                Login with Google
            </a>
        </div>

        <div class="footer-text">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
        </div>
    </div>
</body>
</html>