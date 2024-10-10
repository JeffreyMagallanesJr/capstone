<?php
include("connection.php");
$document_id = $_POST['document_id'];

mysqli_query($connection, "DELETE FROM documents WHERE document_id = '$document_id' ");

echo "<script language='javascript'>alert('Documents has been deleted!')</script>";
echo "<script>window.location.href='index.php';</script>";

?>