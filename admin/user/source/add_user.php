<?php
include("../../../connection.php");

$username = $password = $profile_name =  "";
$err_username = '';
$err_password = '';
$err_profile_name = '';
?> 

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $username = htmlspecialchars($_POST["username"] ?? '');
    $password = htmlspecialchars($_POST["password"] ?? '');
    $profile_name = htmlspecialchars($_POST["profile_name"] ?? '');

    // Check for errors
    if($username == '' || $password == '' || $profile_name == '') {
        // Error handling
        if(!$username) {
            $err_username = "Username is required!";
        }
        if(!$password) {
            $err_password = "Password is required!";
        }
        if(!$profile_name) {
            $err_profile_name = "Profile Name is required!";
        }
   
        } else {
            
            $insert_query = "INSERT INTO user (username, password, profile_name, account_type) 
                 VALUES ('$username', '$password', '$profile_name', 1)";

            $insert_result = mysqli_query($connection, $insert_query);

            if ($insert_result) {
                echo "<script>alert('New User has been added!')</script>";
                echo "<script>window.location.href='../index.php';</script>";
            } else {
                echo "Error adding User: " . mysqli_error($connection);
            }
        }
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />   
    <link rel="icon" href="/capstone/template/assets/images/favicon.ico">
    <title>Digitalized Document Management System | Dashboard</title>

    <?php include('../../../components/common-styles.php') ?>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

    <div class="page-container">

        <?php include('../../../components/sidebar.php') ?>

        <div class="main-content">

            <div class="row">
                <?php
                include('../../../components/navbar.php');
                renderNavbar($connection);
                ?>
            </div>
             <div class="row">
            <div class="col-md-12">
                
                <div class="panel panel-primary" data-collapsed="0">
                
                    <div class="panel-heading">
                        <div class="panel-title">
                        <ol class="breadcrumb bc-3">
                            <li>
                                <a href="../index.php">Users</a>
                            </li>
                            <li class="active">
                                <strong>Add New User</strong>
                            </li>
                        </ol>
                        </div>
                        
                        <div class="panel-options">
                            <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                            <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        
                        <center><h2>Add New User</h2></center>
                        <form role="form" method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-groups-bordered"><br>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Username</label>
                                
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Username" required>
                                    <span class="error"><?php echo $err_username; ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Password</label>
                                
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Password" required>
                                    <span class="error"><?php echo $err_password; ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Profile Name</label>
                                
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="profile_name" value="<?php echo htmlspecialchars($profile_name); ?>" placeholder="Profile Name" required>
                                    <span class="error"><?php echo $err_profile_name; ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                
                </div>
            </div>
        </div>

            <hr />

            <!-- Footer -->
            <?php include('../../../components/footer.php') ?>
        </div>

    </div>

    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="/capstone/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/rickshaw/rickshaw.min.css">

    <!-- Bottom scripts (common) -->
    <?php include('../../../components/common-scripts.php') ?>


    <!-- Imported scripts on this page -->

    <!-- JavaScripts initializations and stuff -->
    <script src="/capstone/template/assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="/capstone/template/assets/js/neon-demo.js"></script>

</body>

</html>


