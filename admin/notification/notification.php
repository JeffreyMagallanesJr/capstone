<?php
include("../../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get current date-time
    $currentDateTime = date("Y-m-d H:i:s");

    // Query to get reminders that are due or in the future
    $query = "
        SELECT d.document_id, d.document_name, cal.date_time_reminder
        FROM documents d
        JOIN calendar cal ON d.document_id = cal.document_id
        WHERE cal.date_time_reminder IS NOT NULL
        AND d.is_archived != 1
        AND cal.date_time_reminder <= '$currentDateTime'  -- Check if reminder is due or in the past
        AND cal.is_read = 0  -- Unread reminders
    ";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    $notifications = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $documentName = $row['document_name'];
        $reminderDate = $row['date_time_reminder'];
        
        // Store reminder data for notifications
        $notifications[] = [
            'document_name' => $documentName,
            'reminder_date' => $reminderDate
        ];

        // Optionally mark as read after sending the notification
        $updateQuery = "UPDATE calendar SET is_read = 1 WHERE document_id = {$row['document_id']}";
        mysqli_query($connection, $updateQuery);
    }

    $newNotification = count($notifications) > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Notification Sound -->
    <audio id="notification-sound" src="notification.mp3" preload="auto"></audio>

</head>
<body>

<?php if ($newNotification): ?>
    <script>
        // Play the notification sound when new notifications exist
        document.getElementById('notification-sound').play();

        // Toastr Notifications for each due reminder
        <?php foreach ($notifications as $notification): ?>
            toastr.info("Reminder for <?php echo $notification['document_name']; ?>: <?php echo $notification['reminder_date']; ?>");
        <?php endforeach; ?>
    </script>
<?php endif; ?>

<!-- Document list and other HTML content here -->

</body>
</html>
