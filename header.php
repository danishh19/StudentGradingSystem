<header class="topbar">
    <a class="brand" href="index.php">
        <span class="logo-placeholder">
            <img class="school-logo" src="images/Kolej-Ungku-Deramat.png" alt="Kolej Ungku Deramat logo">
        </span>
        <div>
            <div class="brand-title">
                Student Grading System
            </div>
            <div class="brand-subtitle">
                School Management Portal
            </div>
        </div>
    </a>
    <div class="account">
        <span class="muted">
            Welcome,
            <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
        </span>
        <a class="button secondary" href="logout.php">
            Logout
        </a>
    </div>
</header>
