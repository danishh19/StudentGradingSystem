<?php
include 'auth.php';
include 'db.php';
require_once 'helpers.php';

$result = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$result || $result < 1) {
    http_response_code(400);
    exit('A valid student result ID is required.');
}
$stmt = $conn->prepare('SELECT * FROM results WHERE result = ?');
$stmt->bind_param('i', $result);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
if (!$row) {
    http_response_code(404);
    exit('Student result not found.');
}
if (empty($_SESSION['delete_token'])) {
    $_SESSION['delete_token'] = bin2hex(random_bytes(32));
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['delete_token'], $token)) {
        http_response_code(403);
        $error = 'Please refresh this page and try again.';
    } else {
        $stmt = $conn->prepare('DELETE FROM results WHERE result = ?');
        $stmt->bind_param('i', $result);
        $stmt->execute();
        unset($_SESSION['delete_token']);
        header('Location: index.php');
        exit;
    }
}
// Use the first character of the student's name for the avatar.
if (function_exists('mb_substr')) {
    $initial = mb_substr($row['student_name'], 0, 1);
} else {
    $initial = substr($row['student_name'], 0, 1);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete result | Student Grading System</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main class="container delete-container">
            <a class="back-link" href="index.php">
                &larr; Back to student records
            </a>
            <section class="card delete-card" aria-labelledby="delete-title">
                <div class="delete-banner">
                    <span>
                        STUDENT RECORDS
                    </span>
                    <span>
                        RESULT MANAGEMENT
                    </span>
                </div>
                <div class="delete-content">
                    <div class="delete-icon" aria-hidden="true">
                        <svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18M9 6V4h6v2M5 6l1 14h12l1-14M10 10v6M14 10v6"/>
                        </svg>
                    </div>
                    <div class="eyebrow">
                        CONFIRM DELETION
                    </div>
                    <h1 id="delete-title">Delete this result?</h1>
                    <p class="delete-intro">Review the record below before removing it from the student results.</p>
                    <?php if ($error): ?>
                    <div class="error" role="alert">
                        <?php echo escape($error); ?>
                    </div>
                    <?php endif; ?>
                    <div class="delete-record">
                        <div class="delete-student">
                            <span class="student-avatar" aria-hidden="true">
                                <?php echo escape($initial); ?>
                            </span>
                            <div>
                                <strong><?php echo escape($row['student_name']); ?></strong>
                                <span>
                                    Matric no. &middot;
                                    <?php echo escape($row['matric_no']); ?>
                                </span>
                            </div>
                        </div>
                        <dl class="delete-details">
                            <div>
                                <dt>
                                    Subject
                                </dt>
                                <dd>
                                    <?php echo escape($row['subject_name']); ?>
                                </dd>
                            </div>
                            <div>
                                <dt>
                                    Subject code
                                </dt>
                                <dd>
                                    <?php echo escape($row['subject_code']); ?>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div class="delete-warning">
                        <span aria-hidden="true">
                            !
                        </span>
                        <p>
                            <strong>This action is permanent.</strong>
                            This result will be removed and cannot be recovered.
                        </p>
                    </div>
                    <form method="post" class="delete-actions">
                        <input type="hidden" name="token" value="<?php echo escape($_SESSION['delete_token']); ?>">
                        <a class="button secondary" href="index.php">
                            Keep result
                        </a>
                        <button type="submit" class="delete-submit">Yes, delete result</button>
                    </form>
                </div>
            </section>
            <footer class="page-footer">
                Student Grading System &middot; Academic Management
            </footer>
        </main>
    </body>
</html>
