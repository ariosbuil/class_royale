<?php
include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    // Get user data from the form
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $mail = mysqli_real_escape_string($conn, $_POST['email']);
    $global_score = mysqli_real_escape_string($conn, $_POST['score']);
    $professor_id = mysqli_real_escape_string($conn, $_POST['professor']);

    // Sanitize and hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                
        $photo = uniqid() . "-" . $_FILES['photo']['name'];
        $photo_path = "../../../../img/students_img/" . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);

        $image_photo = addslashes(file_get_contents($photo_path));
        $query = "UPDATE Student SET name = '$name', surname = '$surname', password = '$hashedPassword', mail = '$mail', photo = '$image_photo', global_score = '$global_score', professor_id = '$professor_id' WHERE student_id = '$student_id'";
    } else {
        $query = "UPDATE Student SET name = '$name', surname = '$surname', password = '$hashedPassword', mail = '$mail', global_score = '$global_score', professor_id = '$professor_id' WHERE student_id = '$student_id'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        $update_msg = "Student updated successfully.";
        header("Location: student_management.php?update_msg=$update_msg");
        exit();
    } else {
        $error_msg = "Error updating student: " . mysqli_error($conn);
        header("Location: student_management.php?error_msg=$error_msg");
        exit();
    }
}
