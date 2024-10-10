<?php
include("connection.php");
include("login_validation.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="./template/assets/images/favicon.ico">

    <title>Digitalized Document Management System | Login</title>

    <link rel="stylesheet" href="./template/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="./template/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="./template/assets/css/bootstrap.css">
    <link rel="stylesheet" href="./template/assets/css/neon-core.css">
    <link rel="stylesheet" href="./template/assets/css/neon-theme.css">
    <link rel="stylesheet" href="./template/assets/css/neon-forms.css">
    <link rel="stylesheet" href="./template/assets/css/custom.css">

    <script src="./template/assets/js/jquery-1.11.3.min.js"></script>

</head>

<body class="page-body login-page login-form-fall" data-url="http://neon.dev">


    <!-- This is needed when you send requests via Ajax -->
    <script type="text/javascript">
        var baseurl = '';
    </script>

    <div class="login-container">

        <div class="login-header login-caret">

            <div class="login-content">

                <a href="index.html" class="logo">
                    <img src="./template/assets/logo/mandalagan-logo.png" width="120" alt="" />
                </a>

                <p class="description">
                    Digitalized Document Management with Scheduling: <br>
                    <span class="font-italic">A User Centric for Barangay Mandalagan</span>
                </p>
            </div>

        </div>

        <div class="login-progressbar">
            <div></div>
        </div>

        <div class="login-form">

            <div class="login-content">

                <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class="form-group">

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-user"></i>
                            </div>

                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" placeholder="Username" autocomplete="off" autofocus />
                            <span class="error"><?php echo $username_error; ?></span><br>
                        </div>

                    </div>

                    <div class="form-group">

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-key"></i>
                            </div>

                            <input type="password" class="form-control" value="<?php echo $password; ?>" name="password" id="password" placeholder="Password" autocomplete="off" />
                            <span class="error"><?php echo $password_error; ?></span>
                        </div>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="entypo-login"></i>
                            Login
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>


    <!-- Bottom scripts (common) -->
    <script src="./template/assets/js/gsap/TweenMax.min.js"></script>
    <script src="./template/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="./template/assets/js/bootstrap.js"></script>
    <script src="./template/assets/js/joinable.js"></script>
    <script src="./template/assets/js/resizeable.js"></script>
    <script src="./template/assets/js/neon-api.js"></script>
    <script src="./template/assets/js/jquery.validate.min.js"></script>
    <script src="./template/assets/js/neon-login.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="./template/assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="./template/assets/js/neon-demo.js"></script>

</body>

</html>