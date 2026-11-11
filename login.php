<?php
session_start();
include 'db.php';
require_once 'helpers.php';

$error = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    // Check username in users table
    $stmt = $conn->prepare(
        "SELECT username, password FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) {

        session_regenerate_id(true);
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
        <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
        <title>Login | Sekolah Kudrat</title>
        <link rel="stylesheet"
          href="style.css?v=<?php echo file_exists(__DIR__ . '/style.css') ? filemtime(__DIR__ . '/style.css') : time(); ?>">
    </head>
    <body class="login-page">
        <main class="login-shell">
            <section class="login-card" aria-labelledby="login-title">
                <div class="login-brand">
                    <div class="logo-placeholder">
                        <img class="school-logo" src="images/Kolej-Ungku-Deramat.png" alt="Kolej Ungku Deramat logo">
                    </div>
                    <div class="eyebrow">
                        KUDRAT MANAGEMENT PORTAL
                    </div>
                    <h1 id="login-title">Welcome back.</h1>
                    <p>Sign in to the Student Grading System</p>
                </div>
                <?php if ($error !== ''): ?>
                <div class="error" role="alert">
                    <?php echo escape($error); ?>
                </div>
                <?php endif; ?>
                <form method="post">
                    <div class="field">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" placeholder="Enter your username" value="<?php echo escape($username); ?>" autocomplete="username" required>
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                    </div>
                    <button type="submit" name="login">Sign in</button>
                </form>
                <p class="login-footer">
                    &copy;
                    <?php echo date('Y'); ?>
                    KUDRAT Student Grading System
                </p>
            </section>
        </main>
    </body>
</html>
