<?php
// Connect to the database
$host = "localhost";
$user = "root";
$password = "";
$database = "blog";

$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Blog Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f0f0f0;
        }
        h2 {
            color: #333;
        }
        .post {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #007BFF;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .post h3 {
            margin-top: 0;
        }
        .post small {
            color: #666;
        }
        .edit-link,
        .delete-link {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            margin-right: 10px;
        }
        .edit-link {
            color: #007BFF;
        }
        .edit-link:hover,
        .delete-link:hover {
            text-decoration: underline;
        }
        .delete-link {
            color: red;
        }
        .back-link {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            color: #007BFF;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h2>All Blog Posts</h2>

    <!-- Show success message after deletion -->
    <?php if (isset($_GET['deleted'])): ?>
        <p style="color: green;">Post deleted successfully.</p>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <small><?php echo $row['created_at']; ?></small>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                
                <a class="edit-link" href="edit_post.php?id=<?php echo $row['id']; ?>">✏️ Edit</a>
                <a class="delete-link" href="delete_post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">🗑️ Delete</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>

    <a class="back-link" href="add_post.php">← Add New Post</a>

    <?php mysqli_close($conn); ?>
</body>
</html>
