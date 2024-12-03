<?php
// Include the database connection file
include("../../connection.php");

// Check if document_id is passed in the URL
if (isset($_GET['document_id'])) {
    // Get and sanitize the document_id
    $document_id = (int)$_GET['document_id']; // Ensures it's an integer

    // Prepare the SQL query to select image path, MIME type, and calendar's date_time_reminder by joining calendar and documents tables
    $query = "
        SELECT 
            d.image, 
            d.mime_type, 
            c.date_time_reminder 
        FROM 
            documents d
        JOIN 
            calendar c ON d.document_id = c.document_id
        WHERE 
            d.document_id = ?
    ";

    $stmt = $connection->prepare($query);

    // Check if the query was prepared successfully
    if ($stmt === false) {
        die('Error preparing query: ' . $connection->error);
    }

    // Bind the document_id parameter to the query
    $stmt->bind_param("i", $document_id); // Bind integer parameter
    $stmt->execute();
    $stmt->store_result();

    // Check if the document exists and has an associated image and reminder
    if ($stmt->num_rows > 0) {
        // Bind the results to variables
        $stmt->bind_result($image_path, $mime_type, $date_time_reminder);
        $stmt->fetch();

        // Format the reminder time if necessary
        $date_time_reminder = date('Y-m-d H:i:s', strtotime($date_time_reminder));

        // Check if the file exists on the server
        if (file_exists($image_path)) {
            // Set the content type for the browser based on the MIME type of the image
            header("Content-Type: $mime_type");

            // Output the image data
            readfile($image_path);
            exit; // Exit to ensure the rest of the HTML code doesn't get executed when image is sent.
        } else {
            // If the file does not exist at the specified path
            $image_error = "Image file not found on the server.";
        }
    } else {
        // If no image path is found for the given document_id
        $image_error = "No document found for document ID: $document_id.";
    }

    // Close the statement
    $stmt->close();
} else {
    // If document_id is not provided in the URL
    $image_error = "No document ID provided.";
}

// Close the database connection
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Document Image</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            height: 100vh;
        }
        .modal {
            background-color: #333;
            border-radius: 10px;
            padding: 20px;
            max-width: 90%;
            max-height: 90%;
            position: relative;
        }
        .modal img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .actions a, .actions button {
            background-color: #4267B2;
            color: #fff;
            text-decoration: none;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .actions a:hover, .actions button:hover {
            background-color: #365899;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php if (isset($image_error)): ?>
        <p><?php echo htmlspecialchars($image_error); ?></p>
    <?php else: ?>
        <div class="modal">
            <span class="close" onclick="window.history.back();">&times;</span>
            <!-- Display the image from the database path -->
            <img src="path_to_images_folder/<?php echo htmlspecialchars($image_path); ?>" alt="Image">
            <div class="actions">
                <a href="path_to_images_folder/<?php echo htmlspecialchars($image_path); ?>" download>Download</a>
                <!-- Show the reminder time -->
                <p>Reminder: <?php echo htmlspecialchars($date_time_reminder); ?></p>
                <!-- Button to close the modal -->
                <button onclick="window.history.back();">Close</button>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
