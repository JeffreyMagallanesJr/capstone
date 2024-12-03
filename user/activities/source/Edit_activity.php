<?php
include("../../../connection.php");

$document_id = $document_name = $category_name = $sub_category_name = $date_time_reminder =  "";
$err_dn = '';
$err_cn = '';
$err_scn = '';
$uploadErr = '';

// Get document ID from URL parameter
$document_id = $_GET['document_id'] ?? '';

// Fetch document data from database
$document_query = "SELECT d.document_id, d.document_name, d.category_id, d.sub_category_id, cal.date_time_reminder
                   FROM documents d
                   JOIN calendar cal ON d.document_id = cal.document_id  
                   WHERE cal.date_time_reminder IS NOT NULL AND d.document_id = '$document_id'";
$document_result = mysqli_query($connection, $document_query);

if ($document_result) {
    $document_data = $document_result->fetch_assoc();
    $document_name = $document_data['document_name'];
    $category_name = $document_data['category_id'];
    $sub_category_name = $document_data['sub_category_id'];
    $date_time_reminder = $document_data['date_time_reminder'];
} else {
    echo "Error fetching document data: " . mysqli_error($connection);
}

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
    $date_time_reminder = htmlspecialchars($_POST["date_time_reminder"] ?? '');

    // Check for errors
    if($document_name == '' || $category_name == '' || $sub_category_name == '') {
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
    } else {
        // No error: Update document
        $update_query_documents = "UPDATE documents 
                        SET document_name = '$document_name', 
                            category_id = '$category_name', 
                            sub_category_id = '$sub_category_name' 
                        WHERE document_id = '$document_id'";

        $update_query_calendar = "UPDATE calendar 
                        SET date_time_reminder = '$date_time_reminder' 
                        WHERE document_id = '$document_id'";

        $update_result_documents = mysqli_query($connection, $update_query_documents);
        $update_result_calendar = mysqli_query($connection, $update_query_calendar);

        if ($update_result_documents && $update_result_calendar) {
            echo "<script>alert('Document has been updated!')</script>";
            echo "<script>window.location.href='../index.php';</script>";
        } else {
            echo "Error updating document: " . mysqli_error($connection);
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
    <title>Edit Document</title>

    <?php include('../../components/common-styles.php') ?>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

    <div class="page-container">

        <?php include('../../components/sidebar.php') ?>

        <div class="main-content">

            <div class="row">
                <?php
                include('../../components/navbar.php');
                renderNavbar($connection);
                ?>
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
                                        <strong>Edit Document</strong>
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

                            <center><h2>Edit Document</h2></center>
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
                                                    $selected = ($c_id == $category_name) ? 'selected' : '';
                                                    echo "<option value='$c_id' $selected>$category</option>";
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

                                    
                                    subCategorySelect.innerHTML = '<option selected>-Please select a sub-category-</option>';

                                    var selectedSubCategoryId = "<?php echo $sub_category_name; ?>";
                                    
                                    sub_categories.forEach(function(subCategory) {
                                        if (subCategory.category_id == categoryId) {
                                            var option = document.createElement('option');
                                            option.value = subCategory.id;
                                            option.textContent = subCategory.sub_category_name;

                                            if (subCategory.id == selectedSubCategoryId) {
                                                option.selected = true;
                                            }

                                            subCategorySelect.appendChild(option);
                                        }
                                    });
                                }

                                document.addEventListener("DOMContentLoaded", updateSubCategories);
                            </script>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Date and Time Reminder</label>
                                    <div class="col-sm-5">
                                        <input type="datetime-local" class="form-control" name="date_time_reminder" 
                                            value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($date_time_reminder))); ?>">
                                    </div>
                                </div>


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
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <hr />

            <?php include('../../components/footer.php') ?>
        </div>

    </div>

    <link rel="stylesheet" href="/capstone/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/capstone/template/assets/js/rickshaw/rickshaw.min.css">
    <?php include('../../components/common-scripts.php') ?>
    <script src="/capstone/template/assets/js/neon-custom.js"></script>
    <script src="/capstone/template/assets/js/neon-demo.js"></script>

</body>

</html>
