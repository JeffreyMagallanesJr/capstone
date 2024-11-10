<?php
include("../../../connection.php");

// Check if document_id is provided
if (!isset($_GET['document_id']) || empty($_GET['document_id'])) {
    http_response_code(400);
    echo "Document ID is required";
    exit;
}

$document_id = $_GET['document_id'];

// Prepare and execute the query
$query = "SELECT * FROM documents WHERE document_id = ?";
$stmt = mysqli_prepare($connection, $query);
if ($stmt === false) {
    http_response_code(500);
    echo "Database query failed";
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $document_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if document exists
if (!$result || mysqli_num_rows($result) == 0) {
    http_response_code(404);
    echo "Document not found";
    exit;
}

// Fetch the document information
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Document Details</title>
</head>
<body>
    <h1>Document Details</h1>
    <p>Document ID: <?= htmlspecialchars($row['document_id'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <p>Document Name: <?= htmlspecialchars($row['document_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <img src="image.php?document_id=<? urlencode($document_id) ?>" alt="Image">

    <!-- Add more document details or actions here -->
</body>
</html>
