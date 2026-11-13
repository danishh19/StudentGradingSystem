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
                        <div class="password-control">
                            <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                            <button type="button" id="toggle-password" class="password-toggle" aria-controls="password" aria-label="Show password" title="Show password" hidden>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                    <path id="password-icon-slash" d="m3 3 18 18" hidden />
                                </svg>
                            </button>
                        </div>
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
        <script>
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('toggle-password');

            passwordToggle.hidden = false;
            passwordToggle.addEventListener('click', () => {
                const showPassword = passwordInput.type === 'password';
                passwordInput.type = showPassword ? 'text' : 'password';
                const label = showPassword ? 'Hide password' : 'Show password';
                passwordToggle.setAttribute('aria-label', label);
                passwordToggle.title = label;
                document.getElementById('password-icon-slash').toggleAttribute('hidden', !showPassword);
            });
        </script>
    </body>
</html>
