<?php
include("connection.php");
include("nav.php");

$document_name = $category_name = $sub_category_name = $document_nameErr = $category_nameErr = $sub_category_nameErr = $uploadErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    if (empty($_POST["document_name"])) {
        $document_nameErr = "Document name is required!";
    } else {
        $document_name = htmlspecialchars($_POST["document_name"]);
    }

    if (empty($_POST["category_name"])) {
        $category_nameErr = "Category name is required!";
    } else {
        $category_name = htmlspecialchars($_POST["category_name"]);
    }

    if (empty($_POST["sub_category_name"])) {
        $sub_category_nameErr = "Subcategory name is required!";
    } else {
        $sub_category_name = htmlspecialchars($_POST["sub_category_name"]);
    }

    
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif ($_FILES["file"]["size"] > 5000000) { 
            $uploadErr = "Sorry, your file is too large.";
        } else {
            
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            
                $category_query = "SELECT category_id FROM category WHERE category_name = '$category_name'";
                $category_result = mysqli_query($connection, $category_query);

                if ($category_result && mysqli_num_rows($category_result) > 0) {
                    $category_row = mysqli_fetch_assoc($category_result);
                    $category_id = $category_row['category_id'];

                    $sub_category_query = "SELECT sub_category_id FROM sub_category WHERE sub_category_name = '$sub_category_name'";
                    $sub_category_result = mysqli_query($connection, $sub_category_query);

                    if ($sub_category_result && mysqli_num_rows($sub_category_result) > 0) {
                        $sub_category_row = mysqli_fetch_assoc($sub_category_result);
                        $sub_category_id = $sub_category_row['sub_category_id'];

                        // Insert new document into documents table with image path
                        $insert_query = "INSERT INTO documents (document_name, category_id, sub_category_id, image) 
                                         VALUES ('$document_name', '$category_id', '$sub_category_id', '$target_file')";
                        $insert_result = mysqli_query($connection, $insert_query);
                        
                        if ($insert_result) {
                            echo "<script>alert('New document has been inserted!')</script>";
                            echo "<script>window.location.href='index.php';</script>";
                        } else {
                            echo "Error inserting document: " . mysqli_error($connection);
                        }
                    } else {
                        $sub_category_nameErr = "Subcategory not found!";
                    }
                } else {
                    $category_nameErr = "Category not found!";
                }
            } else {
                $uploadErr = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $uploadErr = "Please select a file to upload.";
    }
}
?>


<body>
    <div class="container">
        <h2>Add New Document</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            Document Name: <input type="text" name="document_name" value="<?php echo htmlspecialchars($document_name); ?>"><br>
            <span class="error"><?php echo $document_nameErr; ?></span><br>

            Category Name: <input type="text" name="category_name" value="<?php echo htmlspecialchars($category_name); ?>"><br>
            <span class="error"><?php echo $category_nameErr; ?></span><br>

            Subcategory Name: <input type="text" name="sub_category_name" value="<?php echo htmlspecialchars($sub_category_name); ?>"><br>
            <span class="error"><?php echo $sub_category_nameErr; ?></span><br>

            Select Image: <input type="file" name="file"><br>
            <span class="error"><?php echo $uploadErr; ?></span><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
