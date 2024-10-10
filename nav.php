<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            padding-top: 20px;
            height: 700px;
        }
        .sidebar a {
            display: flex;
            padding: 12px 16px;
            color: #fff;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
            height: auto;
            border-radius: 150px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <img src="logo.jpg" alt="Company Logo">
    </div>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_file.php">Add File</a>
    <a href="add_activity.php">Add Activity</a>
    <a href="files.php">Files</a>
    <a href="activities.php">Activities</a>
    <a href="archive.php">Archive</a>
    <!-- Add more links as needed -->
</div>



</body>
</html>
