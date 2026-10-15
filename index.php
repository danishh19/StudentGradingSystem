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
    </table>
</body>
</html>