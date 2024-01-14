<?php

include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $professor_id = $_POST['professor_id'];

    $query = "DELETE FROM Professor WHERE professor_id = '$professor_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $delete_msg = "Professor deleted successfully.";
        header("Location: professor_management.php?delete_msg=$delete_msg");
        exit();
    } else {
        $error_msg = "Error deleting professor: " . mysqli_error($conn);
        header("Location: professor_management.php?error_msg=$error_msg");
        exit();
    }
}   

?>