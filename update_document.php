<?php
include("connection.php");
include("nav.php");

if(isset($_POST["document_id"], $_POST["new_document_name"], $_POST["new_category"], $_POST["new_sub_category"])) {
    
    $document_id = $_POST["document_id"];
    $new_document_name = mysqli_real_escape_string($connection, $_POST["new_document_name"]);
    $new_category = mysqli_real_escape_string($connection, $_POST["new_category"]);
    $new_sub_category = mysqli_real_escape_string($connection, $_POST["new_sub_category"]);

    $update_query = "UPDATE document SET document_name='$new_document_name', category_name='$new_category', sub_category_name='$new_sub_category' WHERE document_id='$document_id'";
    $result = mysqli_query($connection, $update_query);

    if($result) {
        echo "<script>alert('Document has been updated!');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "Error updating document: " . mysqli_error($connection);
    }
}
?>
