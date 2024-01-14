<?php
include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    if (isset($_FILES['icon']) && $_FILES['icon']['error'] == UPLOAD_ERR_OK) {
                
        $icon = uniqid() . "-" . $_FILES['icon']['name'];
        $icon_path = "../../../../img/item_img/" . $icon;
        move_uploaded_file($_FILES['icon']['tmp_name'], $icon_path);

        $image_icon = addslashes(file_get_contents($icon_path));
        $query = "UPDATE Item SET name = '$name', description = '$description', icon = '$image_icon' WHERE item_id = '$item_id'";
    } else {
        $query = "UPDATE Item SET name = '$name', description = '$description' WHERE item_id = '$item_id'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        $update_msg = "Item updated successfully.";
        header("Location: item_management.php?update_msg=$update_msg");
        exit();
    } else {
        $error_msg = "Error updating professor: " . mysqli_error($conn);
        header("Location: item_management.php?error_msg=$error_msg");
        exit();
    }
}
