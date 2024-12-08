<?php
include("../../../connection.php");

$username = $password = $profile_name =  "";
$err_username = '';
$err_password = '';
$err_profile_name = '';


$user_id = $_GET['user_id'] ?? '';

$user_query = "SELECT username, password, profile_name FROM user WHERE user_id = '$user_id'";

$user_result = mysqli_query($connection, $user_query);

if ($user_result) {
    $user_data = $user_result->fetch_assoc();
    $user_name = $user_data['username'];
    $category_name = $user_data['password'];
    $sub_category_name = $user_data['profile_name'];
} else {
    echo "Error fetching user data: " . mysqli_error($connection);
}

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
        // No error: Update document
        $update_query = "UPDATE user 
                        SET username = '$username', 
                            password = '$password', 
                            profile_name = '$profile_name' 
                        WHERE user_id = '$user_id'";

        $update_result = mysqli_query($connection, $update_query);

        if ($update_result) {
            echo "<script>alert('User has been updated!')</script>";
            echo "<script>window.location.href='../index.php';</script>";
        } else {
            echo "Error updating document: " . mysqli_error($connection);
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
    <title>Edit User</title>

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
                                        <strong>Edit User</strong>
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

                            <center><h2>Edit User</h2></center>
                            <form role="form" method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-groups-bordered"><br>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Username</label>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Username">
                                        <span class="error"><?php echo $err_username; ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Password</label>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Password">
                                        <span class="error"><?php echo $err_password; ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Profile Name</label>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="profile_name" value="<?php echo htmlspecialchars($profile_name); ?>" placeholder="Profile Name">
                                        <span class="error"><?php echo $err_profile_name; ?></span>
                                    </div>
                                </div>

                               

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <hr />

            <?php include('../../../components/footer.php') ?>
        </div>

    </div>

    <link rel="stylesheet" href="/capstone/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/rickshaw/rickshaw.min.css">
    <?php include('../../../components/common-scripts.php') ?>
    <script src="/capstone/template/assets/js/neon-custom.js"></script>
    <script src="/capstone/template/assets/js/neon-demo.js"></script>

</body>

</html>
