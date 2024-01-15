<?php
include '../../../connection.php';

session_start();

$professor_logged = $_SESSION['professor_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    // Get user data from the form
    $activity_id = mysqli_real_escape_string($conn, $_POST['activity_id']);
    $selectedProject_id = mysqli_real_escape_string($conn, $_POST['project']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $total_score = mysqli_real_escape_string($conn, $_POST['total_score']);
    $selectedItem_id = mysqli_real_escape_string($conn, $_POST['item']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
  
    $query = "UPDATE Activity SET project_id = '$selectedProject_id', professor_id = '$professor_logged', name = '$name', total_score = '$total_score', activity_item_id = '$selectedItem_id', is_active = '$is_active' WHERE activity_id = '$activity_id'";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        $update_msg = "Activity updated successfully.";
        header("Location: activity_management.php?update_msg=$update_msg");
        exit();
    } else {
        $error_msg = "Error updating activity: " . mysqli_error($conn);
        header("Location: activity_management.php?error_msg=$error_msg");
        exit();
    }
}
?>
