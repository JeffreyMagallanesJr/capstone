<?php
include("../../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT user_id, username, password, profile_name
        FROM user 
        WHERE account_type = 1";
        
}

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
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
    <title>Digitalized Document Management System | Files</title>

    <?php include('../../components/common-styles.php') ?>

    <!-- DataTables and Select2 CSS -->
    <link rel="stylesheet" href="/capstone/template/assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/select2/select2.css">

    <!-- Custom Styling -->
    <style>
    .table-cont {
        background-color: #f9f9f9; 
    }

    .datatable th, .datatable td {
        font-weight: 1;
        color: #333; 
    }

    .btn {
        margin:1px;
        padding: 4px;
    }

    body {
        font-family: 'Arial', sans-serif; 
        color: black; 
    }

    .breadcrumb {
        background-color: #e9ecef; 
        padding:;
    }

    /* Modify the table appearance */
    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-bordered th {
        background-color: #f1f1f1;
        color:black;
        text-transform: uppercase;
    }

    .btn-primary, .btn-info, .btn-danger {
        font-weight: 100;
    }
</style>

</head>

<body class="page-body page-fade" data-url="http://neon.dev">

    <div class="page-container">
        <?php include('../../components/sidebar.php') ?>

        <div class="main-content">
            <div class="row">
                <?php include('../../components/navbar.php');
                renderNavbar($connection); 
                ?>
            </div>

            <hr />

            <div class="row">
                <div class="col-md-12">
                    <a href="source/add_user.php" class="btn btn-success">Add User</a>
                </div>
            </div><br>


            <div class="row table-cont">
                <div class="col-13">
                    <table class="table table-bordered datatable" id="table-4">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Profile Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop to display data from the database
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['password'] . "</td>";
                                echo "<td>" . $row['profile_name'] . "</td>";
                                echo "<td>";
                                echo "<a href='./source/Edit_file.php?user_id=" . $row['user_id'] . "' class='btn btn-sm btn-info text-uppercase'>Edit</a>";
                                
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Profile Name</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <?php include('../../components/footer.php') ?>
        </div>
    </div>

    <!-- Imported styles -->
    <link rel="stylesheet" href="/capstone/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/rickshaw/rickshaw.min.css">

    <!-- Common scripts -->
    <?php include('../../components/common-scripts.php') ?>

    <!-- DataTables and Select2 scripts -->
    <script src="/capstone/template/assets/js/datatables/datatables.js"></script>
    <script src="/capstone/template/assets/js/select2/select2.min.js"></script>

    <!-- Custom scripts -->
    <script src="/capstone/template/assets/js/neon-custom.js"></script>
    <script src="/capstone/template/assets/js/neon-demo.js"></script>
</body>
</html>

