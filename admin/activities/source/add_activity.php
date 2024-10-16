<?php
include("../../../connection.php");

$document_name = $category_name = $sub_category_name = $document_nameErr = $category_nameErr = $sub_category_nameErr = $date_time_reminder = $uploadErr = "";

?>

<script type="text/javascript">
    var sub_categories = [];

    <?php
        $sub_categories_query = "SELECT * FROM sub_category";  
        $sub_categories_result = mysqli_query($connection, $sub_categories_query);
        if ($sub_categories_result) {
            while ($row = $sub_categories_result->fetch_assoc()) {
                
                $data = [
                    'id' => $row['sub_category_id'],
                    'category_id' => $row['category_id'],
                    'sub_category_name' => $row['sub_category_name']
                ];
                
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
    $date_time_reminder = htmlspecialchars($_POST["date_time_reminder"] ?? '');

    


    if($document_name == '' || $category_name =='' || $sub_category_name == '' ||  !isset($_FILES['file'])  || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        // ERROR
        if(!$document_name) {
            $document_nameErr = "Document name is required!";
        }
        if(!$category_name) {
            $category_nameErr = "Category name is required!";
        }
        if(!$sub_category_name) {
            $sub_category_nameErr = "Subcategory name is required!";
        }
        if(!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $uploadErr = "Please select a file to upload.";
        }
    } else {
        //NO ERROR
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if(!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            $uploadErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        if($_FILES["file"]["size"] > 5000000) {
            $uploadErr = "Sorry, your file is too large.";
        }
        if(!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $uploadErr = "Sorry, there was an error uploading your file.";
        } else {
                $insert_query = "INSERT INTO documents(document_name, category_id, sub_category_id, date_time_reminder) VALUES ('$document_name', '$category_name', '$sub_category_name', '$date_time_reminder')";
                $insert_result = mysqli_query($connection, $insert_query);
        
                if ($insert_result) {
                    echo "<script>alert('New Activity has been inserted!')</script>";
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

    <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

        <?php include('../../../components/sidebar.php') ?>

        <div class="main-content">

            <div class="row">

                <!-- Profile Info and Notifications -->
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

                    <strong>Add new activity</strong>
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
                        
                  <center>  <h2>Add New Activity</h2> <form role="form" method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-groups-bordered"><br>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Document Name</label>
                                
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="document_name"value="<?php echo htmlspecialchars($document_name); ?>" placeholder="Document Name">
                                    <span class="error"><?php echo $document_nameErr; ?></span>
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
                                    
                                    <span class="error"><?php echo $category_nameErr; ?></span>
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Sub Category</label>
                                
                                <div class="col-sm-5">
                                    
                                    <select class="form-control" name="sub_category_name" id="sub_category_name">
                                        <option selected>-Please select a sub-category-</option>
                                    </select>
                                    <!-- <input type="text" class="form-control" name="sub_category_name"value="<?php echo htmlspecialchars($sub_category_name); ?>" placeholder="Sub Category"> -->
                                    <span class="error"><?php echo $sub_category_nameErr; ?></span>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
                                // Function to update sub-categories based on selected category
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
                                <label for="field-1" class="col-sm-3 control-label">Date and Time Reminder</label>
                                
                                <div class="col-sm-5">
                                <input type="datetime-local"class="form-control" name="date_time_reminder" value="<?php echo htmlspecialchars($date_time_reminder); ?>">
                                </div>
                            </div>
                          
                           <br>
                            
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
                                <button type="submit" class="btn btn-success">
                                    Submit
                                </button>
                                </div>
                            </div>
                        </form>
                        
                    </form>
                
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


