<!DOCTYPE html>
<html>
<head>
    <title>Update Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 0 auto;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        select {
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php

    if(isset($_REQUEST["document_id"]) && is_numeric($_REQUEST["document_id"])) {
        $document_id = $_REQUEST["document_id"];

        include("connection.php");

        $get_record = mysqli_query($connection, "SELECT * FROM documents WHERE document_id='$document_id'");

        if(mysqli_num_rows($get_record) > 0) {

            $row_edit = mysqli_fetch_assoc($get_record);
            $document_name = $row_edit["document_name"];
            $category = $row_edit["category_name"];
            $sub_category = $row_edit["sub_category_name"];
        } else {

            echo "Document does not exist!";
            exit; 
        }
    } else {

        echo "Invalid or missing Document!";
        exit; 
    }
    ?>

    <form method="POST" action="update_document.php">
        <input type="hidden" name="document_id" value="<?php echo $document_id; ?>">
        <label for="new_document_ame">Document:</label><br>
        <input type="text" id="new_eq_name" name="new_eq_name" value="<?php echo isset($EQ_name) ? htmlspecialchars($EQ_name) : ''; ?>"><br>
        <label for="new_eq_model">Model:</label><br>
        <input type="text" id="new_eq_model" name="new_eq_model" value="<?php echo isset($EQ_model) ? htmlspecialchars($EQ_model) : ''; ?>"><br>
        <label for="new_status">Status:</label><br>
        <select id="new_status" name="new_status">
           <option value="Available" <?php { echo "selected"; } ?>>Available</option>
            <option value="In Use" <?php { echo "selected"; } ?>>In Use</option>

        <input type="submit" value="Update">
    </form>
</body>
</html>
