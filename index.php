<?php
include("connection.php");
include("login_validation.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System | Login</title>
    <link rel="icon" href="./template/assets/images/favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #1b242b;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 500px; 
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }
        .login-header img {
            display: block;
            margin: 0 auto 20px;
        }
        .description {
            text-align: center;
            font-size: 20px;
            margin-bottom: 25px;
            color: #333;
        }
        .error {
            color: #dc3545;
            font-size: 0.875em;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-header text-center">
            <img src="./template/assets/logo/mandalagan-logo.png" width="120" alt="Logo">
        </div>
        <h2 class="text-center mb-4">Login</h2>
        <p class="description">Digitalized Document Management System for Barangay Mandalagan</p>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" placeholder="Enter your username" required>
                </div>
                <span class="error"><?php echo $username_error ?? ''; ?></span>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <span class="error"><?php echo $password_error ?? ''; ?></span>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
