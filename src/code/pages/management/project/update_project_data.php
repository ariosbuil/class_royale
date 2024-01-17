<?php
include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $project_id = mysqli_real_escape_string($conn, $_POST['project_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $median_score = mysqli_real_escape_string($conn, $_POST['median_score']);
    $selectedItem_id = mysqli_real_escape_string($conn, $_POST['item']);

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {

        $icon = uniqid() . "-" . $_FILES['photo']['name'];
        $icon_path = "../../../../img/projects_and_events/" . $icon;
        move_uploaded_file($_FILES['photo']['tmp_name'], $icon_path);

        $image_icon = addslashes(file_get_contents($icon_path));
        $query = "UPDATE Project SET name = '$name', median_score = '$median_score', project_item_id = '$selectedItem_id', photo = '$image_icon', description = '$description' WHERE project_id = '$project_id'";
    } else {
        $query = "UPDATE Project SET name = '$name', median_score = '$median_score', project_item_id = '$selectedItem_id', description = '$description' WHERE project_id = '$project_id'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        $update_msg = "Project updated successfully.";
        header("Location: project_management.php?update_msg=$update_msg");
        exit();
    } else {
        $error_msg = "Error updating project: " . mysqli_error($conn);
        header("Location: project_management.php?error_msg=$error_msg");
        exit();
    }
}