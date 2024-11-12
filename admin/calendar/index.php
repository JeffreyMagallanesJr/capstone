<?php
include("../../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Activities query
    $query = "
        SELECT 
            d.document_id, 
            d.document_name, 
            c.category_name, 
            s.sub_category_name, 
            cal.date_time_reminder
        FROM 
            documents d
        JOIN 
            category c ON d.category_id = c.category_id
        JOIN 
            sub_category s ON d.sub_category_id = s.sub_category_id
        JOIN 
            calendar cal ON d.document_id = cal.document_id  
        WHERE 
            cal.date_time_reminder IS NOT NULL
        ORDER BY 
            cal.date_time_reminder ASC
    ";

    $activities_result = mysqli_query($connection, $query);
    $activities = array();
    while ($row = mysqli_fetch_assoc($activities_result)) {
        $activities[] = $row;
    }
    mysqli_free_result($activities_result);

    // Create an array to store events for each date
    $events_by_date = array();
    foreach ($activities as $activity) {
        $date = date('Y-m-d', strtotime($activity['date_time_reminder']));
        if (!isset($events_by_date[$date])) {
            $events_by_date[$date] = array();
        }
        $events_by_date[$date][] = $activity;
    }
}

$colors = array('color-blue', 'color-orange', 'color-primary', 'color-green');
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
    
    <title>DMS | Calendar </title>
    
    <link rel="stylesheet" href="/capstone/template/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="/capstone/template/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/neon-core.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/neon-theme.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/neon-forms.css">
    <link rel="stylesheet" href="/capstone/template/assets/css/custom.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" />
    
    <script src="/capstone/template/assets/js/jquery-1.11.3.min.js"></script>
</head>
<body class="page-body" data-url="http://neon.dev">
    <div class="page-container">
        <?php include('../../components/sidebar.php') ?>
        <div class="main-content">
            <div class="row">
                <?php
                include('../../components/navbar.php');
                renderNavbar($connection);
                ?>
            </div>

            <div class="calendar-env">
                <!-- Calendar Body -->
                <div id="calendar"></div>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>

            <!-- JavaScripts initializations and stuff -->
            <script src="/capstone/template/assets/js/neon-custom.js"></script>

            <!-- Demo Settings -->
            <script src="/capstone/template/assets/js/neon-demo.js"></script>

            <script>
                $(document).ready(function() {
                    var calendar = $('#calendar');
                    var events = <?= json_encode($events_by_date) ?>;

                    // Convert events to FullCalendar format
                    var formattedEvents = [];
                    $.each(events, function(date, events) {
                        $.each(events, function(index, event) {
                            formattedEvents.push({
                                title: event.document_name,
                                start: event.date_time_reminder,
                                backgroundColor: '<?= $colors[array_rand($colors)] ?>',
                                url: 'details.php?document_id=' + event.document_id // Add URL to direct to details.php
                            });
                        });
                    });

                    // Initialize FullCalendar
                    calendar.fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        defaultDate: new Date(),
                        navLinks: true,
                        editable: true,
                        eventLimit: true,
                        events: formattedEvents
                    });
                });
            </script>
        </div>
    </div>
</body>
</html>
