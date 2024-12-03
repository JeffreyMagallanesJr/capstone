<?php
include("../../../connection.php");

// Get document ID from URL parameter
$document_id = $_GET['document_id'] ?? '';

if ($document_id) {
    // Update the is_archived field to 1 (True) for the specified document
    $update_query = "UPDATE documents SET is_archived = 1 WHERE document_id = '$document_id'";
    $update_result = mysqli_query($connection, $update_query);

    if ($update_result) {
        // After successful update, redirect back to the documents list page
        echo "<script>alert('Document has been archived!')</script>";
        echo "<script>window.location.href='../index.php';</script>";
    } else {
        echo "Error archiving document: " . mysqli_error($connection);
    }
} else {
    echo "No document ID provided.";
}
?>
