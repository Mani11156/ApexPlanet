<?php
// Connect to the MySQL database
$host = "localhost";
$user = "root";
$password = "";
$database = "blog";

$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from form
    $title = $_POST["title"];
    $content = $_POST["content"];
    $created_at = date("Y-m-d H:i:s");

    // Use prepared statement to insert safely
    $stmt = $conn->prepare("INSERT INTO posts (title, content, created_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $created_at);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Post added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
</head>
<body>
    <h2>Add a New Blog Post</h2>
    <form method="post" action="">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Add Post">
    </form>
</body>
</html>

