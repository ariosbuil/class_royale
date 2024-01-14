<?php 

include '../../connection.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM Professor WHERE name = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Failed " . mysqli_error($conn));
    } else {
        $row = mysqli_fetch_assoc($result);
        if ($row['name'] == $username && $row['password'] == $password) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['professor_id'] = $row['professor_id'];
            header("Location: ../management/student/student_management.php");
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
    <link rel="stylesheet" href="../../styles/professor_login.css">
    <title>Login Professor</title>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <form method="post">
                <h1>Login Professor</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="input-box">
                    <input type="submit" name="login" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>
</html>