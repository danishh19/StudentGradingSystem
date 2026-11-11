<?php
include 'auth.php';
include 'db.php';
require_once 'helpers.php';
$results = $conn->query('SELECT * FROM results ORDER BY result DESC');

$resultLabel = 'results';
if ($results->num_rows === 1) {
    $resultLabel = 'result';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Records | Student Grading System</title>
        <link rel="stylesheet" href="style.css?v=<?php echo filemtime(__DIR__ . '/style.css'); ?>">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main class="container">
            <div class="page-heading">
                <div>
                    <div class="eyebrow">
                        ACADEMIC MANAGEMENT
                    </div>
                    <h1>Student records</h1>
                    <p class="muted">Manage student results and keep track of academic performance.</p>
                </div>
                <a class="button" href="add.php">
                    + Add result
                </a>
            </div>
            <section class="card" aria-labelledby="records-title">
                <div class="card-heading">
                    <h2 id="records-title">Student results</h2>
                    <p class="muted">Student information, assessment marks and grades</p>
                </div>
                <form class="searchbar" id="search-form" role="search">
                    <input type="search" id="searchInput" name="searchInput" aria-label="Search student results" placeholder="Search by student, matric no. or subject">
                    <button type="submit">Search</button>
                    <a href="index.php">
                        Show all
                    </a>
                    <span class="record-count" id="record-count" aria-live="polite">
                        <?php echo $results->num_rows; ?> <?php echo $resultLabel; ?>
                    </span>
                </form>
                <div class="table-scroll">
                    <table class="records-table">
                        <colgroup>
                            <col class="column-number">
                            <col class="column-student">
                            <col class="column-matric">
                            <col class="column-subject">
                            <col class="column-assessment" span="3">
                            <col class="column-result" span="2">
                            <col class="column-actions">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Student Name</th>
                                <th>Matric No.</th>
                                <th>Subject</th>
                                <th>Test 1 (20)</th>
                                <th>Test 2 (30)</th>
                                <th>Final (100)</th>
                                <th>Total</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($row = $results->fetch_assoc()): ?>
                            <?php
                            $gradeClass = '';
                            if ($row['grade'] === 'A') {
                                $gradeClass = 'grade-high';
                            } elseif ($row['grade'] === 'F') {
                                $gradeClass = 'grade-low';
                            }
                            ?>
                            <tr class="result-row">
                                <td><?php echo $no++; ?></td>
                                <td><?php echo escape($row['student_name']); ?></td>
                                <td><?php echo escape($row['matric_no']); ?></td>
                                <td><?php echo escape($row['subject_name']); ?></td>
                                <td><?php echo escape($row['test1']); ?></td>
                                <td><?php echo escape($row['test2']); ?></td>
                                <td><?php echo escape($row['final_exam']); ?></td>
                                <td><?php echo escape($row['total_marks']); ?></td>
                                <td>
                                    <span class="grade-badge <?php echo $gradeClass; ?>">
                                        <?php echo escape($row['grade']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a class="button secondary" href="edit.php?id=<?php echo (int) $row['result']; ?>">Edit
                                    </a>
                                    <a class="button danger" href="delete.php?id=<?php echo (int) $row['result']; ?>">Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <tr id="empty-row" <?php if ($results->num_rows > 0) echo 'hidden'; ?>>
                                <td colspan="10" class="empty-state">
                                    <strong id="empty-title">No results to display</strong>
                                    <span id="empty-description">Add a result to get started.</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <footer class="page-footer">
                KUDRAT Student Grading System &middot; Academic Management
            </footer>
        </main>
        <script src="search.js"></script>
    </body>
</html>
