<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "blog";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'id' is passed in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the DELETE query
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to view_posts.php after deletion
        header("Location: view_posts.php?deleted=1");
        exit;
    } else {
        echo "Error deleting post.";
    }

    $stmt->close();
}

$conn->close();
?>
