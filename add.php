<?php
include 'auth.php';
include 'db.php';
require_once 'helpers.php';
require 'grading.php';
// Start with empty fields when the form first opens.
$row = [
    'student_name' => '',
    'matric_no' => '',
    'subject_name' => '',
    'subject_code' => '',
    'test1' => '',
    'test2' => '',
    'final_exam' => ''
];
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Keep submitted values so the form can show them again after an error.
    foreach ($row as $field => $value) {
        $row[$field] = $_POST[$field] ?? '';
    }
    try {
        $marks = calculateResult($row);
        $stmt = $conn->prepare('INSERT INTO results (student_name, matric_no, subject_name, subject_code, test1, test2, final_exam, total_marks, grade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssdddds', $row['student_name'], $row['matric_no'], $row['subject_name'], $row['subject_code'], $marks['test1'], $marks['test2'], $marks['final_exam'], $marks['total_marks'], $marks['grade']);
        $stmt->execute();
        header('Location: index.php');
        exit;
    } catch (InvalidArgumentException $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add result | Student Grading System</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main class="container">
            <div class="page-heading">
                <div>
                    <div class="eyebrow">
                        ACADEMIC MANAGEMENT
                    </div>
                    <h1>Add result</h1>
                    <p class="muted">Enter student details and assessment results.</p>
                </div>
            </div>
            <section class="card form-card">
                <div class="card-heading">
                    <h2>Result details</h2>
                    <p class="muted">Student information and assessment marks</p>
                </div>
                <div class="form-body">
                    <?php 
                    if ($error): 
                    ?>
                    <p class="error" role="alert"><?php echo escape($error); ?></p>
                    <?php 
                endif; 
                ?>
                    <form method="post">
                        <div class="form-grid">
                            <div class="field">
                                <label for="student_name">Student Name</label>
                                <input id="student_name" type="text" name="student_name" value="<?php echo escape($row['student_name']); ?>">
                            </div>
                            <div class="field">
                                <label for="matric_no">Matric No</label>
                                <input id="matric_no" type="text" name="matric_no" value="<?php echo escape($row['matric_no']); ?>">
                            </div>
                            <div class="field">
                                <label for="subject_name">Subject Name</label>
                                <input id="subject_name" type="text" name="subject_name" value="<?php echo escape($row['subject_name']); ?>">
                            </div>
                            <div class="field">
                                <label for="subject_code">Subject Code</label>
                                <input id="subject_code" type="text" name="subject_code" value="<?php echo escape($row['subject_code']); ?>">
                            </div>
                            <div class="field">
                                <label for="test1">Test 1 (out of 20)</label>
                                <input id="test1" type="number" name="test1" min="0" max="20" step="0.01" required value="<?php echo escape($row['test1']); ?>">
                            </div>
                            <div class="field">
                                <label for="test2">Test 2 (out of 30)</label>
                                <input id="test2" type="number" name="test2" min="0" max="30" step="0.01" required value="<?php echo escape($row['test2']); ?>">
                            </div>
                            <div class="field">
                                <label for="final_exam">Final Exam (out of 50)</label>
                                <input id="final_exam" type="number" name="final_exam" min="0" max="50" step="0.01" required value="<?php echo escape($row['final_exam']); ?>">
                            </div>
                        </div>
                        <div class="form-actions">
                            <a class="button secondary" href="index.php">
                                Cancel
                            </a>
                            <input type="submit" name="save" value="Save">
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>
