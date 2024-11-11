<?php
include("../../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT d.document_id, d.document_name, c.category_name, s.sub_category_name, d.date_received, cal.date_time_reminder
        FROM documents d
        JOIN category c ON d.category_id = c.category_id
        JOIN sub_category s ON d.sub_category_id = s.sub_category_id
        LEFT JOIN calendar cal ON d.document_id = cal.document_id  
        WHERE cal.date_time_reminder IS NULL";
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
            padding: 2em !important;
        }
    </style>
</head>

<body class="page-body page-fade" data-url="http://neon.dev">

    <div class="page-container">
        <?php include('../../components/sidebar.php') ?>

        <div class="main-content">
            <div class="row">
                <?php include('../../components/navbar.php') ?>
            </div>

            <hr />

            <ol class="breadcrumb bc-3">
                <li>
                    <a href="#">Documents</a>
                </li>
                <li class="active">
                    <strong>Files</strong>
                </li>
            </ol>

            <div class="row">
                <div class="col-md-12">
                    <a href="source/add_file.php" class="btn btn-primary">Add File</a>
                </div>
            </div>

            <div class="row table-cont">
                <div class="col-13">
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            var $table4 = jQuery("#table-4");
                            $table4.DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5',
                                    'pdfHtml5'
                                ]
                            });
                        });
                    </script>

                    <table class="table table-bordered datatable" id="table-4">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Sub-category</th>
                                <th>Date Received</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop to display data from the database
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['document_name'] . "</td>";
                                echo "<td>" . $row['category_name'] . "</td>";
                                echo "<td>" . $row['sub_category_name'] . "</td>";
                                echo "<td>" . $row['date_received'] . "</td>";
                                echo "<td>";
                                echo "<a href='./source/Edit_file.php?document_id=" . $row['document_id'] . "' class='btn btn-sm btn-info text-uppercase'>Edit</a> ";
                                echo "<a href='./source/archive.php?document_id=" . $row['document_id'] . "' class='btn btn-sm btn-danger text-uppercase'>Archive</a> ";
                                echo "<a href='./source/details.php?document_id=" . $row['document_id'] . "' class='btn btn-sm btn-primary text-uppercase'>View</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Sub-category</th>
                                <th>Date Received</th>
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

