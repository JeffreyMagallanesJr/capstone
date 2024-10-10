<!DOCTYPE html>
<html>
<head>
   
    <title>Delete Equipment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
        }
        .confirmation-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 50%;
            margin: 0 auto;
        }
        h4 {
            margin-bottom: 20px;
            color: #333;
        }
        .equipment-details {
            margin-bottom: 20px;
        }
        .equipment-details span {
            font-weight: bold;
            color: red;
        }
        .btn-primary {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #c82333;
        }
        .btn-delete {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-left: 10px;
        }
        .btn-delete:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="confirmation-box">
    <?php
    if (isset($_REQUEST['document_id']) && !empty($_REQUEST['document_id'])) {
        $document_id = $_REQUEST['document_id'];

        include("connection.php");

        $query = mysqli_query($connection, "SELECT * FROM documents WHERE document_id='$document_id'");

        if ($row = mysqli_fetch_assoc($query)) {
            $document_name = $row["document_name"];
            $category_name = $row["category_name"];
            $sub_category_name = $row["sub_category_name"];
            ?>
            <h4>You're about to delete the following document:</h4>
            <div class="document-details">
                <p><span>Document Name:</span> <?php echo $document_name; ?></p>
                <p><span>Category:</span> <?php echo $category_name; ?></p>
                <p><span>Sub Category:</span> <?php echo $sub_category_name; ?></p>
            </div>
            <form method="POST" action="Delete.php">
                <input type="hidden" name="id" value="<?php echo $document_id; ?>">
                <input type="submit" name="btnDelete" value="Confirm Delete" class="btn-primary">
                <a href="index.php" class="btn-delete">Cancel</a>
            </form>
        <?php
        } else {
            echo "<p>Error: Document not found!</p>";
        }
    } else {
        echo "<p>Error: Missing id parameter!</p>";
    }
    ?>
</div>

</body>
</html>
