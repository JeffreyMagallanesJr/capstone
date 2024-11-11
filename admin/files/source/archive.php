<?php
include("../../../connection.php");

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
}
?>
