<?php
$username = $password = "";
$username_error = $password_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $username_error = "Username is required!";
    } else {
        $username = $_POST["username"];
    }

    if (empty($_POST["password"])) {
        $password_error = "Password is required!";
    } else {
        $password = $_POST["password"];
    }

    if ($username && $password) {

        include("connection.php");

        // Query to check username
        $query = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Get database password and account type
            $db_password = $row["password"];
            $account_type = $row["account_type"];

            // Verify password (assumes plain text, change to password_verify if using hashing)
            if ($password == $db_password) {
                if ($account_type == 0) {
                    echo "<script>window.location.href='./admin/dashboard.php'</script>";
                } else {
                    echo "<script>window.location.href='./user/dashboard.php'</script>";
                }
            } else {
                $password_error = "Password is incorrect!";
            }
        } else {
            $username_error = "Username is not registered!";
        }
    }
}
?>
