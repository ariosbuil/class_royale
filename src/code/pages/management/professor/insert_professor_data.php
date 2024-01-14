<?php
    include '../../../connection.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $image_photo = "";
        
        if (isset($_FILES['photo'])) {
            $photo = uniqid() . "-" . $_FILES['photo']['name'];
            $photo_path = "../../../../img/professors_img/" . $photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);

            $image_photo = addslashes(file_get_contents($photo_path));
        }

        $query = "INSERT INTO Professor (name, surname, password, mail, photo) VALUES ('$name', '$surname', '$password', '$email', '$image_photo')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query failed " . mysqli_error($conn) . " " . mysqli_errno($conn));
        } else {
            header("Location: professor_management.php");
        }
    } else {
        echo "Error";
    }
    
?>