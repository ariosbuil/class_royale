<?php

include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $item_id = $_POST['item_id'];

    $query = "DELETE FROM Item WHERE item_id = '$item_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $delete_msg = "Item deleted successfully.";
        header("Location: item_management.php?delete_msg=$delete_msg");
        exit();
    } else {
        $error_msg = "Error deleting item: " . mysqli_error($conn);
        header("Location: item_management.php?error_msg=$error_msg");
        exit();
    }
}   

?>