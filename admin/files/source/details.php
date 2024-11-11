<?php
include("../../../connection.php");

// Check if document_id is provided
if (!isset($_GET['document_id']) || empty($_GET['document_id'])) {
    http_response_code(400);
    echo "Document ID is required";
    exit;
}

$document_id = (int)$_GET['document_id'];

// Prepare and execute the query to get image data
$query = "SELECT image, FROM documents WHERE document_id = $document_id?";
$stmt = mysqli_prepare($connection, $query);
if ($stmt === false) {
    http_response_code(500);
    echo "Database query failed";
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $document_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    http_response_code(404);
    echo "Image not found";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Set the appropriate header for the image type
header("Content-type: " . $row['image_type']);
echo $row['image'];
?>
