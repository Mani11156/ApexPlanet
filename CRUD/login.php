<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "blog");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = $user["username"];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p style='color:red;'>Invalid login credentials.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>User Login</h2>
    <form method="post">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
