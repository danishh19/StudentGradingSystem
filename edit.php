    <?php include 'db.php';
    // edit.php — UPDATE (the "U" in CRUD)
    // Loads one student's current details into a form, then saves the changes.

    // $_GET is a built-in PHP array that holds values coming from the URL.
    // The list page links here as edit.php?id=3.
    $result = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($result === false || $result === null) {
        exit('A valid student result ID is required.');
    }

    // Fetch only the student whose result ID was supplied in the URL.
    // The question mark is replaced safely with $result by bind_param().
    $stmt = $conn->prepare("SELECT * FROM results WHERE result = ?");
    $stmt->bind_param("i", $result);
    $stmt->execute();
    $obtain = $stmt->get_result();

    // fetch_assoc() reads the single row we found into $row (values read by column name).
    $row = $obtain->fetch_assoc();
    if (!$row) {
        exit('Student result not found.');
    }
    ?>
    <h2>Edit Student</h2>

    <!--
    The same kind of form as add.php, but each field is PRE-FILLED using
    value="<?php // echo $row['...']; ?>"  so the user sees the current data
    and can change it. <?php // echo ... ?> prints a PHP value into the HTML.
    -->
    <form method="post">
    Student Name: <input type="text" name="student_name" value="<?php echo htmlspecialchars($row['student_name']); ?>"><br>
    Matric No: <input type="text" name="matric_no" value="<?php echo htmlspecialchars($row['matric_no']); ?>"><br>
    Subject Name: <input type="text" name="subject_name" value="<?php echo htmlspecialchars($row['subject_name']); ?>"><br>
    Subject Code: <input type="text" name="subject_code" value="<?php echo htmlspecialchars($row['subject_code']); ?>"><br>
    Test1: <input type="text" name="test1" value="<?php echo number_format($row['test1']); ?>"><br>
    Test2: <input type="text" name="test2" value="<?php echo number_format($row['test2']); ?>"><br>
    Final Exam: <input type="text" name="final_exam" value="<?php echo number_format($row['final_exam']); ?>"><br>
    Total Marks: <input type="text" name="total_marks" value="<?php echo number_format($row['total_marks']); ?>"><br>
    Grade: <input type="text" name="grade" value="<?php echo $row['grade']; ?>"><br>
    <input type="submit" name="back" value="Back" onclick="window.location.href='index.php'; return false;">
    <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Process the form only when the Update button is clicked.
    if(isset($_POST['update'])){
    // Read the values submitted from the edit form.
    $student_name   = $_POST['student_name'];
    $matric_no = $_POST['matric_no'];
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $final_exam = $_POST['final_exam'];
    $total_marks = $_POST['total_marks'];
    $grade = $_POST['grade'];

    // Update only the selected student's record.
    // The type string contains one type for each value passed to bind_param():
    // s = string, d = decimal number, and i = integer.
    $stmt = $conn->prepare("UPDATE results SET student_name = ?, matric_no = ?, subject_name = ?, subject_code = ?, test1 = ?, test2 = ?, final_exam = ?, total_marks = ?, grade = ? WHERE result = ?");
    $stmt->bind_param("ssssddddsi", $student_name, $matric_no, $subject_name, $subject_code, $test1, $test2, $final_exam, $total_marks, $grade, $result);
    $stmt->execute();

    // Redirect back to the list to see the updated student.
    header("Location: index.php");
    exit;
    }
    ?>