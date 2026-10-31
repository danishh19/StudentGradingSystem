<?php
include 'db.php'; 
?>

<h2>Add Results</h2>

<form method = "post">
    Student Name: <input type = "text" name = "student_name"><br>
    Matric No: <input type = "text" name = "matric_no"><br>
    Subject Name: <input type = "text" name = "subject_name"><br>
    Subject Code: <input type = "text" name = "subject_code"><br>
    Test 1: <input type = "number" name = "test1"><br>
    Test 2: <input type = "number" name = "test2"><br>
    Final Exam: <input type = "number" name = "final_exam"><br>
    Total Marks: <input type = "number" name = "total_marks"><br>
    Grade: <input type = "text" name = "grade"><br>
    <input type = "submit" name = "back" value = "Back" onclick = "window.location.href='index.php'; return false;">
    <input type = "submit" name = "save" value = "Save">
</form>

<?php

if (isset($_POST['save'])) {
    $student_name = $_POST['student_name'];
    $matric_no = $_POST['matric_no'];
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $final_exam = $_POST['final_exam'];
    $total_marks = $_POST['total_marks'];
    $grade = $_POST['grade'];

    $conn->query("INSERT INTO results (student_name, matric_no, subject_name, subject_code, test1, test2, final_exam, total_marks, grade) VALUES ('$student_name', '$matric_no', '$subject_name', '$subject_code', $test1, $test2, $final_exam, $total_marks, '$grade')");

    $header = "Location: index.php";

}
?>