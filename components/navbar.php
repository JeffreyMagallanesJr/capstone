<?php
function timeAgo($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $string = [
        'year' => $diff->y,
        'month' => $diff->m,
        'day' => $diff->d,
        'hour' => $diff->h,
        'minute' => $diff->i,
        'second' => $diff->s,
    ];
    foreach ($string as $key => &$value) {
        if ($value) {
            $value = $value . ' ' . $key . ($value > 1 ? 's' : '');
        } else {
            unset($string[$key]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function renderNavbar($connection) {
    // Current date and time
    $currentDateTime = date("Y-m-d H:i:s");

    // Notifications query (for reminders that have passed or are equal to current date-time)
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
            cal.date_time_reminder <= '$currentDateTime' 
            AND d.is_archived != 1
    ";

    $activities_result = mysqli_query($connection, $query);

    // Reminders query (for reminders that are in the future)
    $reminders_query = "
        SELECT 
            d.document_id, 
            d.document_name, 
            cal.date_time_reminder
        FROM 
            documents d
        JOIN 
            calendar cal ON d.document_id = cal.document_id  
        WHERE 
            cal.date_time_reminder > '$currentDateTime'
            AND d.is_archived != 1
    ";

    $reminders_result = mysqli_query($connection, $reminders_query);

    // History query (all documents with their date-time reminders)
    $history_query = "
        SELECT 
            d.document_name, 
            cal.date_time_reminder
        FROM 
            documents d
        JOIN 
            calendar cal ON d.document_id = cal.document_id
        WHERE 
            d.is_archived != 1
    ";

    $history_result = mysqli_query($connection, $history_query);
    ?>

    <div class="col-md-6 col-sm-8 clearfix" style="display: inline; width: 100%;">
        <ul class="user-info pull-left pull-none-xsm">
            <li class="profile-info dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Profile">
                    <img src="/capstone/Profile/admin.jpg" alt="" class="img-circle" width="44" />
                   <strong> Admin </strong>
                </a>
                <ul class="dropdown-menu">
                    <li class="caret"></li>
                    <li><a href="/capstone/admin/calendar/index.php" title="Calendar"><i class="entypo-calendar"></i> Calendar</a></li>
                    <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                        <ul class="list-inline links-list pull-right">
                            <li><a href="/capstone/index.php" title="Log Out"><i class="entypo-logout right"></i> Log Out</a></li>
                        </ul>
                    </div>
                </ul>
            </li>
        </ul>

        <ul class="user-info pull-right pull-right-xs pull-none-xsm">
            <!-- Notifications dropdown -->
            <li class="notifications dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" title="Notification">
                    <i class="entypo-bell"></i>
                    <span class="badge badge-info"><?php echo mysqli_num_rows($activities_result); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" style="max-height: 300px; overflow-y: auto; min-width: 200px; padding: 10px 15px;">
                    <?php 
                    if (mysqli_num_rows($activities_result) > 0) {
                        while ($row = mysqli_fetch_assoc($activities_result)) {
                            $now = timeAgo($row['date_time_reminder']);
                            echo "<li>";
                            echo "<a href='#' title='{$row['document_name']}'>";
                            echo "<i class='entypo-doc-text'></i> Reminder for {$row['document_name']} (Due: {$row['date_time_reminder']})";
                            echo "<br><span class='line small'>$now</span>";
                            echo "</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li><a href='#'>No reminders</a></li>";
                    }
                    ?>
                </ul>
            </li>

            <!-- Reminders dropdown -->
            <li class="notifications dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" title="Reminders">
                    <i class="entypo-clock"></i>
                    <span class="badge badge-secondary"><?php echo mysqli_num_rows($reminders_result); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" style="max-height: 300px; overflow-y: auto; min-width: 200px; padding: 10px 15px;">
                    <?php 
                    if (mysqli_num_rows($reminders_result) > 0) {
                        while ($row = mysqli_fetch_assoc($reminders_result)) {
                            $timeAgo = timeAgo($row['date_time_reminder']);
                            echo "<li>";
                            echo "<a href='#' title='{$row['document_name']}'>";
                            echo "<i class='entypo-bell'></i> Upcoming reminder for {$row['document_name']} (Due: {$row['date_time_reminder']})";
                            echo "<br><span class='line small'>$timeAgo</span>";
                            echo "</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li><a href='#'>No upcoming reminders</a></li>";
                    }
                    ?>
                </ul>
            </li>

            <!-- History dropdown -->
            <li class="notifications dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" title="History">
                    <i class="entypo-back-in-time"></i>
                    <span class="badge badge-warning"><?php echo mysqli_num_rows($history_result); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" style="max-height: 300px; overflow-y: auto; min-width: 200px; padding: 10px 15px;">
                    <?php 
                    if (mysqli_num_rows($history_result) > 0) {
                        while ($row = mysqli_fetch_assoc($history_result)) {
                            $timeAgo = timeAgo($row['date_time_reminder']);
                            echo "<li>";
                            echo "<a href='#' title='{$row['document_name']}'>";
                            echo "<i class='entypo-doc-text'></i> You added {$row['document_name']} with a reminder on {$row['date_time_reminder']}";
                            echo "<br><span class='line small'>$timeAgo</span>";
                            echo "</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li><a href='#'>No history</a></li>";
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>

    <?php
}
?>
