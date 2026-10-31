<?php include 'db.php';
// delete.php — DELETE (the "D" in CRUD)
// This page has no HTML of its own. It just deletes one student
// and then immediately sends the user back to the list.

// Read which result to remove from the URL (delete.php?id=5 -> $result = 5).
$result = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($result === false || $result === null) {
    exit('A valid student result ID is required.');
}

// Delete only the result whose ID was supplied in the URL.
// The WHERE clause is essential because it prevents all records from being deleted.
$stmt = $conn->prepare("DELETE FROM results WHERE result = ?");
$stmt->bind_param("i", $result);
$stmt->execute();

// header("Location: ...") redirects the browser back to the list page.
header("Location: index.php");
exit;  // Make sure no more code runs after the redirect.
?>