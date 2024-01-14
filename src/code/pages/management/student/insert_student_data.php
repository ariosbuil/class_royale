<?php
include "../../../connection.php";

session_start(); // Inicia la sesión (asegúrate de llamar a session_start() al principio de tu script)

if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['add'])) {
    // Check the connection
    if (mysqli_connect_error()) {
        die("Error connecting to the database: " . mysqli_connect_error());
    }

    // Get user data from the form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $mail = mysqli_real_escape_string($conn, $_POST['email']);
    $global_score = mysqli_real_escape_string($conn, $_POST['score']);
    $selected_professorId = mysqli_real_escape_string($conn, $_POST['professor']);

    // Sanitize and hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Verify if we send any image
    if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
        $photo = uniqid() . "-" . $_FILES['photo']['name'];
        $photo_path = "../../../../img/students_img/" . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);

        $image_photo = addslashes(file_get_contents($photo_path));
    } else {
        // We don't send any image
        $image_photo = ""; 
    }

    // Perform the insertion into the database
    $query = "INSERT INTO Student (professor_id, name, surname, password, mail, photo, global_score) VALUES ('$selected_professorId', '$name', '$surname', '$hashedPassword', '$mail', '$image_photo', '$global_score')";
    $result = mysqli_query($conn, $query);

    // Close the connection to the database
    mysqli_close($conn);

    // Redirect
    header("Location: student_management.php");
} else {
    die("Access not allowed.");
}
