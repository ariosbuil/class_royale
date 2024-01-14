<?php

include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $student_id = $_POST['student_id'];

    $query = "DELETE FROM Student WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $delete_msg = "Student deleted successfully.";
        header("Location: student_management.php?delete_msg=$delete_msg");
        exit();
    } else {
        $error_msg = "Error deleting Student: " . mysqli_error($conn);
        header("Location: student_management.php?error_msg=$error_msg");
        exit();
    }
}   

?>