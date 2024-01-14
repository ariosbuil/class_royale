<?php
include '../../../connection.php';

/* Message */
// if (isset($_GET['insert_msg'])) {
//     echo "<h6>" . $_GET['insert_msg'] . "</h6>";
// }


$query = "SELECT * FROM Professor";
$result = mysqli_query($conn, $query);

/* Para hacer el icono del usuario logueado

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query = "SELECT * FROM Professor WHERE name = '$username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $photo = $row['photo'];
    } else {
        Si no hay sesión iniciada, se redirige al login
        header("Location: ../../login/login_professor.php?message=Please login before accessing the page");
    }

*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <?php include '../../../layouts/fontawesome.php' ?>
    <link rel="stylesheet" href="../../../styles/professor_management.css">
    <!-- Bootstap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Professor Management</title>
</head>

<body>
    <div class="container">
        <div class="header">
            
        </div>
        <div class="management">
            <div class="management-header">
                <h1>Professor Management</h1>
                <div class="button">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="management-body">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="result-item">
                        <div class="result-photo">
                            <?php echo '<img style="width: 60px; height: 60px; border-radius: 100%;" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . ' " alt="Profile Picture">'; ?>
                        </div>
                        <div class="result-name">
                            <h2><?php echo $row['name'] . " " . $row['surname']; ?></h2>
                        </div>
                        <div class="action-buttons">
                            <div class="button">
                                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#updateModal" data-professor-id="<?php echo $row['professor_id']; ?>" data-name="<?php echo $row['name']; ?>" data-surname="<?php echo $row['surname']; ?>" data-email="<?php echo $row['mail']; ?>" data-password="<?php echo $row['password']; ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                            <div class="button">
                                <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-professor-id="<?php echo $row['professor_id']; ?>"><i class="fa-solid fa-x"></i></button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <form action="insert_professor_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Professor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname:</label>
                            <input type="text" name="surname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="add" value="ADD">
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Update Modal -->
    <form action="update_professor_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Professor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" id="edit-name">
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname:</label>
                            <input type="text" name="surname" class="form-control" id="edit-surname">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" id="edit-email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" id="edit-password">
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="professor_id" id="edit-professor-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="update" value="UPDATE">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Remove Confirmation Modal -->
    <form action="delete_professor_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Professor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this professor?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="professor_id" id="delete-professor-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="delete" value="DELETE">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Bootsrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var edit_buttons = document.querySelectorAll('.edit-btn');
            edit_buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('edit-name').value = button.dataset.name;
                    document.getElementById('edit-surname').value = button.dataset.surname;
                    document.getElementById('edit-email').value = button.dataset.email;
                    document.getElementById('edit-password').value = button.dataset.password;
                    document.getElementById('edit-professor-id').value = button.dataset.professorId;
                });
            });

            var delete_buttons = document.querySelectorAll('.delete-btn');
            delete_buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('delete-professor-id').value = button.dataset.professorId;
                })
            })
        });
    </script>

</body>

</html>