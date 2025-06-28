<?php
$conn = mysqli_connect("localhost", "root", "", "blog");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $raw_password = $_POST["password"];
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT); // secure hash

    // Check if username exists
    $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        echo "<p style='color:red;'>Username already exists.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Registration successful. <a href='login.php'>Login here</a></p>";
        } else {
            echo "<p style='color:red;'>Error during registration.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>User Registration</h2>
    <form method="post">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
