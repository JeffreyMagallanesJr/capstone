<?php
include("../../connection.php")

// Establish a database connection using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get user ID (this should come from your session or authentication system)
$user_id = 1; // Example user ID, replace with actual session value

// Fetch profile name and picture from the database
$stmt = $pdo->prepare("SELECT profile_name, profile_picture FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user data was found
if ($user) {
    $profile_name = htmlspecialchars($user['profile_name']); // Prevent XSS
    $profile_picture = htmlspecialchars($user['profile_picture']); // Prevent XSS
} else {
    // Default values if user not found
    $profile_name = "User";
    $profile_picture = "default.jpg"; // Use a placeholder image
}
?>
