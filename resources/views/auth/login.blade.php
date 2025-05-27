<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #fbc2eb, #f8a8c9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 25px;
            width: 350px;
            text-align: center;
        }
        .card-header {
            font-size: 26px;
            font-weight: bold;
            color: #444;
            margin-bottom: 15px;
        }
        .form-group {
            text-align: left;
        }
        .form-control {
            border: 2px solid #d1d3e2;
            border-radius: 8px;
            padding: 10px;
            font-size: 16px;
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 18px;
        }
        .btn-primary {
            background: #2575fc;
            border: none;
            border-radius: 8px;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background:rgb(12, 15, 110);
        }
        .btn-info {
            background: #20c997;
            border: none;
            border-radius: 8px;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-info:hover {
            background: #198f73;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">Alya's Hospital</div>
        <div class="card-header">Login</div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Email/Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required autofocus>
                </div>
                <div class="form-group password-container">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    <span class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggle-icon"></i>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <a href="{{ route('register') }}" class="btn btn-info mt-2">Registrasi</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>