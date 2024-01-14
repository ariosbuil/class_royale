<?php
include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $professor_id = $_POST['professor_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['password'];
    $mail = $_POST['email'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                
        $photo = uniqid() . "-" . $_FILES['photo']['name'];
        $photo_path = "../../../../img/professors_img/" . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);

        $image_photo = addslashes(file_get_contents($photo_path));
        $query = "UPDATE Professor SET name = '$name', surname = '$surname', password = '$password', mail = '$mail', photo = '$image_photo' WHERE professor_id = '$professor_id'";
    } else {
        $query = "UPDATE Professor SET name = '$name', surname = '$surname', password = '$password', mail = '$mail' WHERE professor_id = '$professor_id'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        $update_msg = "Professor updated successfully.";
        header("Location: professor_management.php?update_msg=$update_msg");
        exit();
    } else {
        $error_msg = "Error updating professor: " . mysqli_error($conn);
        header("Location: professor_management.php?error_msg=$error_msg");
        exit();
    }
}
