<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />
    
    <link rel="icon" href="/capstone/template/assets/images/favicon.ico">
    
    <title>DMS | Calendar </title>
    
    <link rel="stylesheet" href="/capstone/template/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="/capstone/template/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/neon-core.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/neon-theme.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/neon-forms.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/custom.css">
    
    <script src="/capstone/template/assets/js/jquery-1.11.3.min.js"></script>
</head>
<body class="page-body" data-url="http://neon.dev">
    <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
        <?php include('../../components/sidebar.php') ?>
        <div class="main-content">
            <div class="row">

                <?php include('../../components/navbar.php') ?>
            </div>
            

    		<div class="calendar-env">
        <!-- Calendar Body -->
        <div class="calendar-body">
            <div id="calendar"></div>
        </div>

        <!-- Sidebar -->
        <div class="calendar-sidebar">
            <!-- new task form -->
            <div class="calendar-sidebar-row">
                <form role="form" id="add_event_form">
                    <div class="input-group minimal">
                        <input type="text" class="form-control" placeholder="Add event..." />
                        <div class="input-group-addon">
                            <i class="entypo-pencil"></i>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Events List -->
            <ul class="events-list" id="draggable_events">
                <li>
                    <p>Drag Events to Calendar Dates</p>
                </li>
                <li>
                    <a href="#">Sport Match</a>
                </li>
                <li>
                    <a href="#" class="color-blue" data-event-class="color-blue">Meeting</a>
                </li>
                <li>
                    <a href="#" class="color-orange" data-event-class="color-orange">Relax</a>
                </li>
                <li>
                    <a href="#" class="color-primary" data-event-class="color-primary">Study</a>
                </li>
                <li>
                    <a href="#" class="color-green" data-event-class="color-green">Family Time</a>
                </li>
            </ul>
        </div>
    </div>
    
    <hr />
    <!-- Footer -->
    <?php include('../../components/footer.php') ?>

    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="/capstone/template/assets/js/fullcalendar-2/fullcalendar.min.css">

    <!-- Bottom scripts (common) -->
    <script src="/capstone/template/assets/js/gsap/TweenMax.min.js"></script>
    <script src="/capstone/template/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="/capstone/template/assets/js/bootstrap.js"></script>
    <script src="/capstone/template/assets/js/joinable.js"></script>
    <script src="/capstone/template/assets/js/resizeable.js"></script>
    <script src="/capstone/template/assets/js/neon-api.js"></script>

    <!-- Imported scripts on this page -->
    <script src="/capstone/template/assets/js/moment.min.js"></script>
    <script src="/capstone/template/assets/js/fullcalendar-2/fullcalendar.min.js"></script>
    <script src="/capstone/template/assets/js/neon-calendar-2.js"></script>
    <script src="/capstone/template/assets/js/neon-chat.js"></script>

    <!-- JavaScripts initializations and stuff -->
    <script src="/capstone/template/assets/js/neon-custom.js"></script>

    <!-- Demo Settings -->
    <script src="/capstone/template/assets/js/neon-demo.js"></script>
</body>
</html>
