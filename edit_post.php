<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "blog";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get post ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing post data
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST["title"];
    $content = $_POST["content"];

    $update = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Post updated successfully!</p>";
        echo "<a href='view_posts.php'>← Back to Posts</a>";
        exit;
    } else {
        echo "<p style='color:red;'>Error updating post.</p>";
    }
}
?>

<!-- Edit Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Post</h2>

    <?php if (isset($post)): ?>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>

        <input type="submit" value="Update Post">
    </form>
    <?php else: ?>
        <p>Post not found.</p>
    <?php endif; ?>
</body>
</html>
