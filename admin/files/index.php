<?php
include("../../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT d.document_id, d.document_name, c.category_name, s.sub_category_name, d.date_received 
        FROM documents d
        JOIN category c ON d.category_id = c.category_id
        JOIN sub_category s ON d.sub_category_id = s.sub_category_id";
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

    <link rel="icon" href="/DMS/template/assets/images/favicon.ico">

    <title>Digitalized Document Management System | Files</title>

    <?php include('../../components/common-styles.php') ?>

    <link rel="stylesheet" href="/DMS/template/assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="/DMS/template/assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="/DMS/template/assets/js/select2/select2.css">

    <style>
        .table-cont {
            padding: 2em !important;
        }
    </style>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

    <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

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
                <div class="col-12">
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
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['document_name'] . "</td>";
                                echo "<td>" . $row['category_name'] . "</td>";
                                echo "<td>" . $row['sub_category_name'] . "</td>";
                                // If date_received is a date type column, you can format it as per your requirement
                                echo "<td>" . $row['date_received'] . "</td>";
                                // Add your action buttons or any other data as needed
                                echo "<td>";
                                echo "<button class='btn btn-sm btn-info text-uppercase'>Update</button>";
                                echo "<button class='btn btn-sm btn-danger text-uppercase'>Archive</button>";
                                echo "<a href='./source/details.php' class='btn btn-sm btn-primary text-uppercase'>View</a>";
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

    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="/DMS/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/DMS/template/assets/js/rickshaw/rickshaw.min.css">

    <!-- Bottom scripts (common) -->
    <?php include('../../components/common-scripts.php') ?>


    <!-- Imported scripts on this page -->
    <script src="/DMS/template/assets/js/datatables/datatables.js"></script>
    <script src="/DMS/template/assets/js/select2/select2.min.js"></script>

    <!-- JavaScripts initializations and stuff -->
    <script src="/DMS/template/assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="/DMS/template/assets/js/neon-demo.js"></script>

</body>

</html>