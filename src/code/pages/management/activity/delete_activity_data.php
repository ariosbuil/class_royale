<?php

include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $activity_id = $_POST['activity_id'];

    $query = "DELETE FROM Activity WHERE activity_id = '$activity_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $delete_msg = "Activity deleted successfully.";
        header("Location: activity_management.php?delete_msg=$delete_msg");
        exit();
    } else {
        $error_msg = "Error deleting activity: " . mysqli_error($conn);
        header("Location: activity_management.php?error_msg=$error_msg");
        exit();
    }
}   

?>