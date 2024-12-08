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

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

/**
 * Function to render the navbar based on the logged-in user.
 */
function renderNavbar($connection) {
    // Ensure the user is logged in
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Fetch the profile name based on the logged-in user's ID
        $userQuery = "SELECT profile_name FROM user WHERE user_id = $userId";
        
        $stmt = $connection->prepare($userQuery);
        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $userResult = $stmt->get_result();
            $user = $userResult->fetch_assoc();
            $stmt->close();
        }
    }
}

        $profileName = !empty($user['profile_name']) ? htmlspecialchars($user['profile_name']) : 'Barangay Secretary';

        // Current date and time
        $currentDateTime = date("Y-m-d H:i:s");

        // Notifications query (past reminders)
        $query = "
            SELECT d.document_id, d.document_name, c.category_name, s.sub_category_name, cal.date_time_reminder
            FROM documents d
            JOIN category c ON d.category_id = c.category_id
            JOIN sub_category s ON d.sub_category_id = s.sub_category_id
            JOIN calendar cal ON d.document_id = cal.document_id
            WHERE cal.date_time_reminder <= ? AND d.is_archived != 1
        ";

        $stmt = $connection->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $currentDateTime);
            $stmt->execute();
            $activities_result = $stmt->get_result();
        }

        // Reminders query (future reminders)
        $reminders_query = "
            SELECT d.document_id, d.document_name, cal.date_time_reminder
            FROM documents d
            JOIN calendar cal ON d.document_id = cal.document_id
            WHERE cal.date_time_reminder > ? AND d.is_archived != 1
        ";

        $stmt = $connection->prepare($reminders_query);
        if ($stmt) {
            $stmt->bind_param("s", $currentDateTime);
            $stmt->execute();
            $reminders_result = $stmt->get_result();
        }

        // History query (all reminders)
        $history_query = "
            SELECT d.document_name, cal.date_time_reminder
            FROM documents d
            JOIN calendar cal ON d.document_id = cal.document_id
            WHERE d.is_archived != 1
        ";

        $stmt = $connection->prepare($history_query);
        if ($stmt) {
            $stmt->execute();
            $history_result = $stmt->get_result();
        }
        ?>

        <div class="col-md-6 col-sm-8 clearfix" style="display: inline; width: 100%;">
            <ul class="user-info pull-left pull-none-xsm">
                <li class="profile-info dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Profile">
                        <img src="/capstone/profile/user.jpg" alt="" class="img-circle" width="44" />
                        <strong><?php echo $profileName; ?></strong>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/capstone/user/calendar/index.php" title="Calendar"><i class="entypo-calendar"></i> Calendar</a></li>
                        <li><a href="/capstone/index.php" title="Log Out"><i class="entypo-logout right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="user-info pull-right pull-right-xs pull-none-xsm">
                <!-- Notifications dropdown -->
                <li class="notifications dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notification">
                        <i class="entypo-bell"></i>
                        <span class="badge badge-info"><?php echo mysqli_num_rows($activities_result); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                        if (mysqli_num_rows($activities_result) > 0) {
                            while ($row = $activities_result->fetch_assoc()) {
                                $timeAgo = timeAgo($row['date_time_reminder']);
                                echo "<li><a href='#' title='" . htmlspecialchars($row['document_name']) . "'>";
                                echo "<i class='entypo-doc-text'></i> Reminder for {$row['document_name']} (Due: {$row['date_time_reminder']})";
                                echo "<br><span class='line small'>$timeAgo</span></a></li>";
                            }
                        } else {
                            echo "<li><a href='#'>No reminders</a></li>";
                        }
                        ?>
                    </ul>
                </li>

                <!-- Reminders dropdown -->
                <li class="notifications dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Reminders">
                        <i class="entypo-clock"></i>
                        <span class="badge badge-secondary"><?php echo mysqli_num_rows($reminders_result); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                        if (mysqli_num_rows($reminders_result) > 0) {
                            while ($row = $reminders_result->fetch_assoc()) {
                                $timeAgo = timeAgo($row['date_time_reminder']);
                                echo "<li><a href='#' title='" . htmlspecialchars($row['document_name']) . "'>";
                                echo "<i class='entypo-bell'></i> Upcoming reminder for {$row['document_name']} (Due: {$row['date_time_reminder']})";
                                echo "<br><span class='line small'>$timeAgo</span></a></li>";
                            }
                        } else {
                            echo "<li><a href='#'>No upcoming reminders</a></li>";
                        }
                        ?>
                    </ul>
                </li>

                <!-- History dropdown -->
                <li class="notifications dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="History">
                        <i class="entypo-back-in-time"></i>
                        <span class="badge badge-warning"><?php echo mysqli_num_rows($history_result); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                        if (mysqli_num_rows($history_result) > 0) {
                            while ($row = $history_result->fetch_assoc()) {
                                $timeAgo = timeAgo($row['date_time_reminder']);
                                echo "<li><a href='#' title='" . htmlspecialchars($row['document_name']) . "'>";
                                echo "<i class='entypo-doc-text'></i> {$row['document_name']} added on {$row['date_time_reminder']}";
                                echo "<br><span class='line small'>$timeAgo</span></a></li>";
                            }
                        } else {
                            echo "<li><a href='#'>No history</a></li>";
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    
