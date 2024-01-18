<?php
include '../../connection.php';
session_start();

$professor_id = $_SESSION['professor_id'];

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../../login/login.php");
}

?>


<div class="cont-header">
    <a href="../../home/home_professor.php"><img src="../../../../img/logo.png" alt="Logo"></a>


<?php
    $queryPhoto = "SELECT photo FROM Professor WHERE professor_id = '$professor_id'";
    $resultPhoto = mysqli_query($conn, $queryPhoto);
if ($resultPhoto && mysqli_num_rows($resultPhoto) > 0) {
    $rowPhoto = mysqli_fetch_assoc($resultPhoto);
    echo '<div id="profile-container">';
    echo '<img id="profile-image" style="border-radius: 100%; height: 60px; width: 60px;" src="data:image/jpeg;base64,' . base64_encode($rowPhoto['photo']) . ' " alt="Profile Picture">';
    ?>
    <ul id="profile-menu" class="hidden">
        <li><a href="../../login/logout_process.php">Log Out</a></li>
    </ul>
    <?php
    echo '</div>';
}

?>

</div>


<style>
    #profile-menu {
        list-style: none;
        padding: 15px; /* Ajusta el relleno según sea necesario */
        margin: 0;
        position: absolute;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        display: none;
        z-index: 1;
        width: 200px; 
        left: -125px; 
        top: 70px; 
    }

    #profile-menu li {
        padding: 10px;
    }

    #profile-menu a {
        text-decoration: none;
        color: #333;
    }

    #profile-image:hover {
        cursor: pointer;
    }

    #profile-container {
        position: relative;
        display: inline-block;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var profileImage = document.getElementById('profile-image');
        var profileMenu = document.getElementById('profile-menu');

        profileImage.addEventListener('click', function() {
            // Alternar la visibilidad del menú al hacer clic en la imagen
            profileMenu.style.display = (profileMenu.style.display === 'block') ? 'none' : 'block';
        });

        // Cerrar el menú si se hace clic fuera de él
        document.addEventListener('click', function(event) {
            var isClickInside = profileImage.contains(event.target) || profileMenu.contains(event.target);
            if (!isClickInside) {
                profileMenu.style.display = 'none';
            }
        });
    });
</script>
