<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="/DMS/template/assets/images/favicon.ico">

    <title>Digitalized Document Management System | Dashboard</title>

    <?php include('../../components/common-styles.php') ?>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

    <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

        <?php include('../../components/sidebar.php') ?>

        <div class="main-content">

            <div class="row">

                <!-- Profile Info and Notifications -->
                <?php include('../../components/navbar.php') ?>

            </div>

            <hr />

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

    <!-- JavaScripts initializations and stuff -->
    <script src="/DMS/template/assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="/DMS/template/assets/js/neon-demo.js"></script>

</body>

</html>