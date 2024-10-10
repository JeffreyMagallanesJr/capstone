<?php
$selected_category = $_GET['category_name'];

$query_id = "SELECT category_id FROM category WHERE category_name = '$selected_category'";
$result_id = mysqli_query($connection, $query_id);
$row_id = mysqli_fetch_assoc($result_id);
$category_id = $row_id['category_id'];

$query_sub_category_name = "SELECT sub_category_name FROM sub_category WHERE category_id = '$category_id'";
$result_sub_category_name = mysqli_query($connection, $query_sub_category_name);

$sub_category_options = "";
while ($row_name = mysqli_fetch_assoc($result_sub_category_name)) {
    $sub_category_name = $row_name['sub_category_name'];
    $sub_category_options .= "<option>$sub_category_name</option>";
}

echo $sub_category_options;
?>
