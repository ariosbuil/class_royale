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
    <link rel="stylesheet" href="../../styles/login.css">
    <title>Login Professor</title>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <form method="post">
                <h1 style="margin-bottom: 5px; text-align: center;">Login Professor</h1>
                <div class="input-box">
                    <input style="padding: 5px; border-radius: 5px; margin-bottom: 5px;" type="text" name="username" placeholder="Username">
                </div>
                <div class="input-box">
                    <input style="padding: 5px; border-radius: 5px; margin-bottom: 5px;" type="password" name="password" placeholder="Password">
                </div>
                <div class="input-box">
                    <input style="padding: 5px; border-radius: 5px;" type="submit" name="login" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>
</html>