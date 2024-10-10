<?php
include("connection.php");
include("sidebar.php");

$searchTerm = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($connection, $_GET['search']);
    
    $query = "SELECT d.document_id, d.document_name, c.category_name, s.sub_category_name 
              FROM documents d
              JOIN category c ON d.category_id = c.category_id
              JOIN sub_category s ON d.sub_category_id = s.sub_category_id
              WHERE d.document_name LIKE '%$searchTerm%'
              OR c.category_name LIKE '%$searchTerm%'
              OR s.sub_category_name LIKE '%$searchTerm%'";
} else {
    $query = "SELECT d.document_id, d.document_name, c.category_name, s.sub_category_name 
              FROM documents d
              JOIN category c ON d.category_id = c.category_id
              JOIN sub_category s ON d.sub_category_id = s.sub_category_id";
}

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
        }
        .options a {
            margin-right: 10px;
            text-decoration: none;
            color: #333;
        }
        .options a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="search-form">
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" class="search-input" name="search" placeholder="Search by document name" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <input type="submit" class="search-btn" value="Search">
        </form>
    </div>

    <table>
        <tr>
            <th>Document Name</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Options</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $document_id = $row["document_id"];
            $document_name = htmlspecialchars($row["document_name"]);
            $category = htmlspecialchars($row["category_name"]);
            $sub_category = htmlspecialchars($row["sub_category_name"]);

            echo "<tr>
                    <td>$document_name</td>
                    <td>$category</td>
                    <td>$sub_category</td>
                    <td class='options'>
                        <a href='Edit.php?id=$document_id'>Update</a>
                        <a href='confirm_delete.php?id=$document_id'>Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
