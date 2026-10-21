<?php
include 'db.php';

$stmt = $conn->prepare("SELECT * FROM results");
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grading</title>
</head>
<body>
    <h1>Student Grading System</h1>
    <h3> Student Records</h3>
    <a href ="add.php">+ Add Result</a>

    <br><br>

    <input type="text" name="searchInput" placeholder="Student name, matric no., subject name" value = 
    "">
    
    <input type="submit" name="search" value="Search">
    
    <a href = "index.php">Show all</a>

    <br><br>

    <table border = "1">
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
    <?php
    
    $no = 1;
    while ($row = $results->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['matric_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
        echo "<td>" . number_format($row['test1'], 2) . "</td>";
        echo "<td>" . number_format($row['test2'], 2) . "</td>";
        echo "<td>" . number_format($row['final_exam'], 2) . "</td>";
        echo "<td>" . number_format($row['total_marks'], 2) . "</td>";
        echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
        echo "<td><a href='edit.php?id=" . $row['result'] . "'>Edit</a> | <a href='delete.php?id=" . $row['result'] . "'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
    </table>
</body>
</html>