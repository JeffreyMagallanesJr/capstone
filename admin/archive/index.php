<?php
include("../../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT d.document_id, d.document_name, c.category_name, s.sub_category_name, 
                     d.date_received, d.is_archived, cal.date_time_reminder
              FROM documents d
              JOIN category c ON d.category_id = c.category_id
              JOIN sub_category s ON d.sub_category_id = s.sub_category_id
              LEFT JOIN calendar cal ON d.document_id = cal.document_id
              WHERE d.is_archived = 1";
              
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
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

    <title>Digitalized Document Management System | Archived Documents</title>

    <?php include('../../components/common-styles.php') ?>

    <link rel="stylesheet" href="/capstone/template/assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/select2/select2.css">

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
                <?php 
                include('../../components/navbar.php');
                renderNavbar($connection);
                ?>
            </div>

            <hr />

            <ol class="breadcrumb bc-3">
                <li>
                    <a href="#">Documents</a>
                </li>
                <li class="active">

                    <strong>Activities</strong>
                </li>
            </ol>
            <div class="row">
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
                    <th>Document Name</th>
                    <th>Category</th>
                    <th>Sub-category</th>
                    <th>Date Received</th>
                    <th>Reminder Date</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    // Determine document type based on the presence of a date_time_reminder
                    $documentType = is_null($row['date_time_reminder']) ? "File" : "Activity";
                    
                    echo "<tr>";
                    echo "<td>" . $row['document_name'] . "</td>";
                    echo "<td>" . $row['category_name'] . "</td>";
                    echo "<td>" . $row['sub_category_name'] . "</td>";
                    echo "<td>" . $row['date_received'] . "</td>";
                    
                    // Display reminder date if it's an activity, otherwise show "N/A"
                    echo "<td>" . ($documentType === "Activity" ? $row['date_time_reminder'] : "N/A") . "</td>";
                    
                    echo "<td>" . $documentType . "</td>";
                    
                    echo "<td>";
                    echo "<a href='./restore.php?document_id=" . $row['document_id'] . "' class='btn btn-sm btn-info text-uppercase'>Restore</a>";
                    echo "<a href='./details.php?document_id=" . $row['document_id'] . "' class='btn btn-sm btn-primary text-uppercase'>View</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Document Name</th>
                    <th>Category</th>
                    <th>Sub-category</th>
                    <th>Date Received</th>
                    <th>Reminder Date</th>
                    <th>Type</th>
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
    <link rel="stylesheet" href="/capstone/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/rickshaw/rickshaw.min.css">

    <!-- Bottom scripts (common) -->
    <?php include('../../components/common-scripts.php') ?>


    <!-- Imported scripts on this page -->
    <script src="/capstone/template/assets/js/datatables/datatables.js"></script>
    <script src="/capstone/template/assets/js/select2/select2.min.js"></script>

    <!-- JavaScripts initializations and stuff -->
    <script src="/capstone/template/assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="/capstone/template/assets/js/neon-demo.js"></script>

</body>

</html>
