<?php

$username = $password = "";
$username_error = $password_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $username_error = "Username is Required!";
    } else {
        $username = $_POST["username"];
    }

    if (empty($_POST["password"])) {
        $password_error = "Password is Required!";
    } else {
        $password = $_POST["password"];
    }

    if ($username && $password) {

        include("connection.php");

        $check_username = mysqli_query($connection, "SELECT * FROM admin WHERE username='$username'");

        $check_username_row = mysqli_num_rows($check_username);

        if ($check_username_row > 0) {

            while ($row = mysqli_fetch_assoc($check_username)) {

                $admin_id = $row["admin_id"];

                $db_password = $row["password"];

                if ($password == $db_password) {

                    echo "<script>window.location.href='./admin/dashboard.php'</script>";
                } else {

                    $password_error = "Password is incorrect!";
                }
            }
        } else {

            $username_error = "Username is not registered!";
        }
    }
}
