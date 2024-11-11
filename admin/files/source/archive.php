<?php
include("../../../connection.php");

<<<<<<< HEAD
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
=======
if (isset($_GET['document_id'])) {
    $document_id = intval($_GET['document_id']); // Sanitize input

    // Begin transaction for reliability
    mysqli_begin_transaction($connection);

    try {
        // Insert the document into the archive table
        $copy_query = "INSERT INTO archive SELECT * FROM documents WHERE document_id = $document_id";
        mysqli_query($connection, $copy_query);

        // Delete the document from the original table
        $delete_query = "DELETE FROM documents WHERE document_id = $document_id";
        mysqli_query($connection, $delete_query);

        // Commit the transaction
        mysqli_commit($connection);

        // Redirect with success message
        header("Location: /capstone/admin/documents.php?message=Document archived successfully");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if there is an error
        mysqli_rollback($connection);
        die("Error archiving document: " . mysqli_error($connection));
    }
} else {
    // Redirect if no document ID is provided
    header("Location: /capstone/admin/documents.php?error=No document ID provided");
    exit();
>>>>>>> origin/view_document
}
?>
