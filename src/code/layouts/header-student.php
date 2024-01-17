<?php
include '../../connection.php';
session_start();

?>


<div class="cont-header">
    <a href="../../home/home_student.php"><img src="../../../../img/logo.png" alt="Logo"></a>


    <?php
    if ($student_id) {
        $queryPhoto = "SELECT photo FROM Student WHERE student_id = '$student_id'";
        $resultPhoto = mysqli_query($conn, $queryPhoto);
        if ($resultPhoto && mysqli_num_rows($resultPhoto) > 0) {
            $rowPhoto = mysqli_fetch_assoc($resultPhoto);
            echo '<div id="profile-container">';
            echo '<img id="profile-image" border-radius: 100%;" src="data:image/jpeg;base64,' . base64_encode($rowPhoto['photo']) . ' " alt="Profile Picture">';
    ?>
            <ul id="profile-menu" class="hidden">
                <li style="border-bottom: 1px solid black;"><a href="#">Change Image</a></li>
                <li><a href="../../login/logout_process.php">Log Out</a></li>
            </ul>
    <?php
            echo '</div>';
        }
    }
    ?>

</div>


<style>
    
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