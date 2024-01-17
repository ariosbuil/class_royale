<?php
include '../../../connection.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $mail = mysqli_real_escape_string($conn, $_POST['mail']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                
        $photo = uniqid() . "-" . $_FILES['photo']['name'];
        $photo_path = "../../../../img/students_img/" . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);

        $image_photo = addslashes(file_get_contents($photo_path));
        $query = "UPDATE Student SET name = '$name', surname = '$surname', password = '$hashedPassword', mail = '$mail', photo = '$image_photo' WHERE student_id = '$student_id'";
    } else {
        $query = "UPDATE Student SET name = '$name', surname = '$surname', password = '$hashedPassword', mail = '$mail' WHERE student_id = '$student_id'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        $update_msg = "Student updated successfully.";
        header("Location: student_profile.php?update_msg=$update_msg");
        exit();
    } else {
        $error_msg = "Error updating student: " . mysqli_error($conn);
        header("Location: student_profile.php?error_msg=$error_msg");
        exit();
    }
}

$query = "SELECT * FROM Student WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../../styles/student_profile.css" />
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- JavaScript -->
    <script src="./code.js"></script>
    <title>Profile</title>
</head>

<body>
    <div style="height: 100%;" class="cont-screen">
        <h1 style="padding: 10px;">Profile</h1>
        <form style="padding-left: 10px; display: flex; flex-direction: column; gap: 15px;" method="post" enctype="multipart/form-data">
            <div class="input-box">
                <label for="name">Nombre:</label>
                <input type="text" name="name" value="<?php echo $row['name']; ?>">
            </div>
            <div class="input-box">
                <label for="name">Surname:</label>
                <input type="text" name="surname" value="<?php echo $row['surname']; ?>">
            </div>
            <div class="input-box">
                <label for="name">Password:</label>
                <input type="text" name="password" value="<?php echo $row['password']; ?>">
            </div>
            <div class="input-box">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" value="<?php echo $row['mail']; ?>">
            </div>
            <div class="input-box">
                <label for="photo">Foto de Perfil:</label>
                <input type="file" name="photo">
            </div>
            <div class="input-box">
                <img style="width: 100px; height: 100px; border-radius: 50px;" src="data:image/jpeg;base64,<?php echo base64_encode($row['photo']); ?>" alt="Foto de Perfil">
            </div>
            <div class="input-box">
                <input type="submit" name="update_profile" value="Actualizar Perfil">
            </div>
        </form>
        <a style="padding: 10px; margin-top: 10px;" href="../../../pages/home/home_student.php">Go back</a>
    </div>
</body>

</html>