<?php

include '../../connection.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Search for the username in the database
    $queryProfessor = "SELECT * FROM Professor WHERE name = '$username'";
    $queryStudent = "SELECT * FROM Student WHERE name = '$username'";

    $resultProfessor = mysqli_query($conn, $queryProfessor);
    $resultStudent = mysqli_query($conn, $queryStudent);

    if (!$resultProfessor || !$resultStudent) {
        die("Query Failed " . mysqli_error($conn));
    } else {
        $rowProfessor = mysqli_fetch_assoc($resultProfessor);
        $rowStudent = mysqli_fetch_assoc($resultStudent);

        // Verify the password for professor
        if ($rowProfessor && password_verify($password, $rowProfessor['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['professor_id'] = $rowProfessor['professor_id'];
            header("Location: ../home/home_professor.php");
        }
        // Verify the password for student
        elseif ($rowStudent && password_verify($password, $rowStudent['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['student_id'] = $rowStudent['student_id'];
            header("Location: ../home/home_student.php");
        } else {
            echo "<script>alert('Username or Password is incorrect')</script>";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../../styles/login.css">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <title>Log In</title>
</head>

<body>
    <div class="container">
        <div class="login-form">
            <form method="post">
                <img src="./../../../img/logo.png" alt="logo">
                <h1>Log In</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="input-box">
                    <input id="button-submit" type="submit" name="login" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>

</html>