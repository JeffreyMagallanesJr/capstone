<?php
include("../../../connection.php");

$document_name = $category_name = $sub_category_name =  "";
$err_dn = '';
$err_cn = '';
$err_scn = '';
$uploadErr = '';

?> 
<script type="text/javascript">
    var sub_categories = [];

    <?php
        $sub_categories_query = "SELECT * FROM sub_category";  
        $sub_categories_result = mysqli_query($connection, $sub_categories_query);
        if ($sub_categories_result) {
            while ($row = $sub_categories_result->fetch_assoc()) {
                // Create an associative array for each row
                $data = [
                    'id' => $row['sub_category_id'],
                    'category_id' => $row['category_id'],
                    'sub_category_name' => $row['sub_category_name']
                ];
                // Encode the array as JSON and directly push it into the JavaScript array
                echo "sub_categories.push(" . json_encode($data) . ");\n";
            }
        }
    ?>
</script>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $document_name = htmlspecialchars($_POST["document_name"] ?? '');
    $category_name = htmlspecialchars($_POST["category_name"] ?? '');
    $sub_category_name = htmlspecialchars($_POST["sub_category_name"] ?? '');

    // Check for errors
    if($document_name == '' || $category_name == '' || $sub_category_name == '' || !isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        // Error handling
        if(!$document_name) {
            $err_dn = "Document name is required!";
        }
        if(!$category_name) {
            $err_cn = "Category name is required!";
        }
        if(!$sub_category_name) {
            $err_scn = "Subcategory name is required!";
        }
        if(!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $uploadErr = "Please select a file to upload.";
        }
    } else {
        // No error: Process file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        if(!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            $uploadErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif($_FILES["file"]["size"] > 5000000) {
            $uploadErr = "Sorry, your file is too large.";
        } elseif(!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $uploadErr = "Sorry, there was an error uploading your file.";
        } else {
            // File uploaded successfully, now insert into database
            $insert_query = "INSERT INTO documents (document_name, category_id, sub_category_id, image) 
                            VALUES ('$document_name', '$category_name', '$sub_category_name', '$target_file')";
            $insert_result = mysqli_query($connection, $insert_query);

            if ($insert_result) {
                echo "<script>alert('New document has been inserted!')</script>";
                echo "<script>window.location.href='../index.php';</script>";
            } else {
                echo "Error inserting document: " . mysqli_error($connection);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />   
    <link rel="icon" href="/capstone/template/assets/images/favicon.ico">
    <title>Digitalized Document Management System | Dashboard</title>

    <?php include('../../../components/common-styles.php') ?>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

    <div class="page-container">

        <?php include('../../../components/sidebar.php') ?>

        <div class="main-content">

            <div class="row">
                <?php include('../../../components/navbar.php') ?>
            </div>
             <div class="row">
            <div class="col-md-12">
                
                <div class="panel panel-primary" data-collapsed="0">
                
                    <div class="panel-heading">
                        <div class="panel-title">
                        <ol class="breadcrumb bc-3">
                            <li>
                                <a href="../index.php">Files</a>
                            </li>
                            <li class="active">
                                <strong>Add new file</strong>
                            </li>
                        </ol>
                        </div>
                        
                        <div class="panel-options">
                            <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                            <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        
                        <center><h2>Add New File</h2></center>
                        <form role="form" method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-groups-bordered"><br>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Document Name</label>
                                
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="document_name" value="<?php echo htmlspecialchars($document_name); ?>" placeholder="Document Name">
                                    <span class="error"><?php echo $err_dn; ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Category</label>
                                
                                <div class="col-sm-5">
                                    <select onchange="updateSubCategories()" class="form-control" name="category_name" id="category_name">
                                    <option selected>-Please select an option-</option>
                                    <?php
                                        $query = "SELECT category_id, category_name FROM category";
                                        $result = mysqli_query($connection, $query);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $category = $row['category_name'];
                                                $c_id = $row['category_id'];
                                                echo "<option value='$c_id'>$category</option>";
                                            }
                                        }
                                    ?>
                                    </select>
                                    
                                    <span class="error"><?php echo $err_cn; ?></span>
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Sub Category</label>
                                
                                <div class="col-sm-5">
                                    <select class="form-control" name="sub_category_name" id="sub_category_name">
                                        <option selected>-Please select a sub-category-</option>
                                    </select>
                                    <span class="error"><?php echo $err_scn; ?></span>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
                                function updateSubCategories() {
                                    var categoryId = document.getElementById('category_name').value;
                                    var subCategorySelect = document.getElementById('sub_category_name');

                                    // Clear current sub-category options
                                    subCategorySelect.innerHTML = '<option selected>-Please select a sub-category-</option>';

                                    // Filter sub_categories based on the selected category_id
                                    sub_categories.forEach(function(subCategory) {
                                        if (subCategory.category_id == categoryId) {
                                            var option = document.createElement('option');
                                            option.value = subCategory.id;
                                            option.textContent = subCategory.sub_category_name;
                                            subCategorySelect.appendChild(option);
                                        }
                                    });
                                }
                            </script>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Image</label>
                                
                                <div class="col-sm-2">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn btn-info btn-file">
                                            <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="file">
                                        </span>
                                        <span class="error"><?php echo $uploadErr; ?></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                
                </div>
            </div>
        </div>

            <hr />

            <!-- Footer -->
            <?php include('../../../components/footer.php') ?>
        </div>

    </div>

    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="/capstone/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/rickshaw/rickshaw.min.css">

    <!-- Bottom scripts (common) -->
    <?php include('../../../components/common-scripts.php') ?>


    <!-- Imported scripts on this page -->

    <!-- JavaScripts initializations and stuff -->
    <script src="/capstone/template/assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="/capstone/template/assets/js/neon-demo.js"></script>

</body>

</html>


