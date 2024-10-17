<?php
// Initialize error variables
$document_nameErr = $category_nameErr = $sub_category_nameErr = $uploadErr = "";
$document_name = $category = $sub_category = $date_time_reminder = "";

if (isset($_REQUEST["document_id"]) && is_numeric($_REQUEST["document_id"])) {
    $document_id = intval($_REQUEST["document_id"]); // Ensure it's an integer
    
    include("connection.php");

    // Using prepared statement for security
    $stmt = $connection->prepare("SELECT * FROM documents WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    $get_record = $stmt->get_result();

    if ($get_record->num_rows > 0) {
        $row_edit = $get_record->fetch_assoc();
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

// Fetch categories and subcategories from the database
$categories = [];
$sub_categories = [];
$category_query = "SELECT category_id, category_name FROM category";
$category_result = mysqli_query($connection, $category_query);
if ($category_result) {
    while ($row = mysqli_fetch_assoc($category_result)) {
        $categories[] = $row; // Store categories for later use
    }
}

// Fetch subcategories
$sub_category_query = "SELECT sub_category_id, sub_category_name, category_id FROM sub_category";
$sub_category_result = mysqli_query($connection, $sub_category_query);
if ($sub_category_result) {
    while ($row = mysqli_fetch_assoc($sub_category_result)) {
        $sub_categories[] = $row; // Store subcategories for later use
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data here
    $document_name = htmlspecialchars($_POST["document_name"]);
    $category_id = intval($_POST["category_name"]);
    $sub_category_id = intval($_POST["sub_category_name"]);
    $date_time_reminder = $_POST["date_time_reminder"];

    // Handle file upload securely
    if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        if (in_array($_FILES['file']['type'], $allowed_types)) {
            $upload_dir = 'uploads/';
            $file_path = $upload_dir . basename($_FILES['file']['name']);
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
                // File upload successful
            } else {
                $uploadErr = "File upload failed!";
            }
        } else {
            $uploadErr = "Invalid file type!";
        }
    }

    // Further process or save the data...
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

<body class="page-body page-fade" data-url="http://neon.dev">
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
                                    <li><a href="../index.php">Files</a></li>
                                    <li class="active"><strong>Add new activity</strong></li>
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
                            <center><h2>Add New Activity</h2></center>
                            <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal form-groups-bordered">
                                <br>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Document Name</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="document_name" value="<?php echo htmlspecialchars($document_name); ?>" placeholder="Document Name">
                                        <span class="error"><?php echo $document_nameErr; ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-5">
                                        <select onchange="updateSubCategories()" class="form-control" name="category_name" id="category_name">
                                            <option selected>-Please select an option-</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
                                            <?php endforeach; ?>
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
                                        <span class="error"><?php echo $sub_category_nameErr; ?></span>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    var sub_categories = <?php echo json_encode($sub_categories); ?>;

                                    function updateSubCategories() {
                                        var categoryId = document.getElementById('category_name').value;
                                        var subCategorySelect = document.getElementById('sub_category_name');

                                        subCategorySelect.innerHTML = '<option selected>-Please select a sub-category-</option>';

                                        sub_categories.forEach(function(subCategory) {
                                            if (subCategory.category_id == categoryId) {
                                                var option = document.createElement('option');
                                                option.value = subCategory.sub_category_id;
                                                option.textContent = subCategory.sub_category_name;
                                                subCategorySelect.appendChild(option);
                                            }
                                        });
                                    }
                                </script>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Date and Time Reminder</label>
                                    <div class="col-sm-5">
                                        <input type="datetime-local" class="form-control" name="date_time_reminder" value="<?php echo htmlspecialchars($date_time_reminder); ?>">
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
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
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
            <?php include('../../../components/footer.php') ?>
        </div>
    </div>

    <!-- Bottom scripts -->
    <?php include('../../../components/common-scripts.php') ?>
</body>

</html>
