
<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check username in users table
    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check username and password
    if ($user && $password === $user['password']) {

        $_SESSION['username'] = $user['username'];

        header("Location: index.php");
        exit;

    } else {

        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Grading Login</title>
</head>
<body>

    <h2>Student Grading System</h2>
    <h3>Admin Login</h3>

    <form method="post">

        Username:
        <input type="text" name="username" required>
        <br><br>

        Password:
        <input type="password" name="password" required>
        <br><br>

        <input type="submit" name="login" value="Login">

    </form>

    <p><?php echo htmlspecialchars($error); ?></p>

</body>
</html>
