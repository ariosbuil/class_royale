<?php
include '../../../connection.php';

define("RESULTS_PER_PAGE", 3); 

/* Message */
// if (isset($_GET['insert_msg'])) {
//     echo "<h6>" . $_GET['insert_msg'] . "</h6>";
// }


// Total results
$query = "SELECT COUNT(*) as total FROM Student";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalResults = $row['total'];

// Total number of pages
$totalPages = ceil($totalResults / RESULTS_PER_PAGE);

// Current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate start index for the results
$startIndex = ($currentPage - 1) * RESULTS_PER_PAGE;

// Get the results for the current page
$query = "SELECT * FROM Student LIMIT $startIndex, " . RESULTS_PER_PAGE;
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- GLOBAL CONFIGURATIONS -->
    <link rel="stylesheet" href="./../../../styles/global/global.css" />
    <link rel="stylesheet" href="./../../../styles/global/headers/header-professor.css" />
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Font Awesome -->
    <?php include '../../../layouts/fontawesome.php' ?>
    <link rel="stylesheet" href="../../../styles/student_management.css">
    <!-- Bootstap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Student Management</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <?php include '../../../layouts/header.php'; ?>
        </div>
        <div style="padding: 10px" class="management">
            <div class="management-header">
                <h1>Student Management</h1>
                <div class="button">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <form action="insert_massive.php" method="post" enctype="multipart/form-data">
                        <label for="file">Select CSV file:</label>
                        <input id="file" type="file" name="file" accept=".csv" required>
                        <button type="submit">Import Students</button>
                    </form>
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
                                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#updateModal" data-student-id="<?php echo $row['student_id']; ?>" data-name="<?php echo $row['name']; ?>" data-surname="<?php echo $row['surname']; ?>" data-email="<?php echo $row['mail']; ?>" data-password="<?php echo $row['password']; ?>" data-score="<?php echo $row['global_score']; ?>" data-current-professor="<?php echo $row['professor_id']; ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                            <div class="button">
                                <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-student-id="<?php echo $row['student_id']; ?>"><i class="fa-solid fa-x"></i></button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="pagination">
        <?php
        // Mostrar enlaces de paginación
        for ($page = 1; $page <= $totalPages; $page++) {
            echo "<a href='student_management.php?page=$page' class='$class circle'>$page</a> ";
        }
        ?>
    </div>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <form action="insert_student_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname:</label>
                            <input type="text" name="surname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="score">Score:</label>
                            <input type="number" name="score" class="form-control" required min="0" max="10">
                        </div>
                        <div class="form-group">
                            <label for="professor">Select Professor:</label>
                            <select name="professor" class="form-control" required>
                                <option value="" disabled selected style="color: gray;">Select a Professor...</option>
                                <?php
                                $query = "SELECT professor_id, name, surname FROM Professor";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $professor_name = $row['name'] . " " . $row['surname'];
                                        echo "<option value='" . $row['professor_id'] . "'>" . $professor_name . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No professors available</option>";
                                }

                                ?>
                            </select>
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
    <form action="update_student_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Student</h1>
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
                        <div class="form-group">
                            <label for="score">Score:</label>
                            <input type="number" name="score" class="form-control" id="edit-score">
                        </div>
                        <div class="form-group">
                            <label for="professor">Select Professor:</label>
                            <select name="professor" class="form-control" required id="edit-professor">
                            <option value="" disabled selected style="color: gray;">Select a Professor...</option>
                                <?php
                                $query = "SELECT professor_id, name, surname FROM Professor";
                                $result = mysqli_query($conn, $query);
                            
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $professor_name = $row['name'] . " " . $row['surname'];
                                        $selected = ($row['professor_id'] == $currentProfessorId) ? 'selected' : '';
                                        echo "<option value='" . $row['professor_id'] . "' $selected>" . $professor_name . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No professors available</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="student_id" id="edit-student-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="update" value="UPDATE">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Remove Confirmation Modal -->
    <form action="delete_student_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this student?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="student_id" id="delete-student-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="delete" value="DELETE">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Bootstrap -->
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
                    document.getElementById('edit-score').value = button.dataset.score;
                    document.getElementById('edit-student-id').value = button.dataset.studentId;
                    document.getElementById('edit-professor').value = button.dataset.currentProfessor;
                });
            });

            var delete_buttons = document.querySelectorAll('.delete-btn');
            delete_buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('delete-student-id').value = button.dataset.studentId;
                })
            })
        });
    </script>

</body>

</html>