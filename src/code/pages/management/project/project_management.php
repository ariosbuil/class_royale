<?php
include '../../../connection.php';

session_start();

$professor_id = $_SESSION['professor_id'];

define("RESULTS_PER_PAGE", 3);

/* Message */
// if (isset($_GET['insert_msg'])) {
//     echo "<h6>" . $_GET['insert_msg'] . "</h6>";
// }


// Total results
$query = "SELECT COUNT(*) as total FROM Project";
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
$query = "SELECT * FROM Project WHERE professor_id = '$professor_id' LIMIT $startIndex, " . RESULTS_PER_PAGE;
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
    <link rel="stylesheet" href="../../../styles/project_management.css">
    <!-- Bootstap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Project Management</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <?php include '../../../layouts/header.php'; ?>
        </div>
        <div class="management">
            <div class="management-header">
                <h1>Project Management</h1>
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
                            <h2><?php echo $row['name']; ?></h2>
                        </div>
                        <div class="result-desc">
                            <p><?php echo $row['description']; ?></p>
                        </div>
                        <div class="action-buttons">
                            <div class="button">
                                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#updateModal" data-project-id="<?php echo $row['project_id']; ?>" data-professor-id="<?php echo $row['professor_id']; ?>" data-name="<?php echo $row['name']; ?>" data-median-score="<?php echo $row['median_score']; ?>" data-project-item-id="<?php echo $row['project_item_id']; ?>" data-description="<?php echo $row['description'] ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                            <div class="button">
                                <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-project-id="<?php echo $row['project_id']; ?>"><i class="fa-solid fa-x"></i></button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="pages">
                    <?php
                    // Mostrar enlaces de paginación
                    for ($page = 1; $page <= $totalPages; $page++) {
                        $class = ($page == $currentPage) ? 'current' : '';
                        echo "<a href='project_management.php?page=$page' class='$class circle'>$page</a> ";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <form action="insert_project_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="total_score">Description:</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="total_score">Median Score:</label>
                            <input type="number" name="median_score" class="form-control" required min="0" max="10">
                        </div>
                        <div class="form-group">
                            <label for="item">Select Item:</label>
                            <select name="item" class="form-control" required>
                                <option value="" disabled selected style="color: gray;">Select an Item...</option>
                                <?php
                                $query = "SELECT * FROM Item";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['item_id'] . "'>" . $row['name'];
                                        "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No items available</option>";
                                }

                                ?>
                            </select>
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
    <form action="update_project_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" id="edit-name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="edit-description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="total_score">Median Score:</label>
                            <input type="number" name="median_score" class="form-control" required min="0" max="10" id="edit-median-score">
                        </div>
                        <div class="form-group">
                            <label for="item">Select Item:</label>
                            <select name="item" class="form-control" id="edit-project-item-id" required>
                                <option value="" disabled selected style="color: gray;">Select an Item...</option>
                                <?php
                                $query = "SELECT * FROM Item";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['item_id'] . "'>" . $row['name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No items available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="project_id" id="edit-project-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="update" value="UPDATE">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Remove Confirmation Modal -->
    <form action="delete_project_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this project?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="project_id" id="delete-project-id">
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
                    document.getElementById('edit-project-id').value = button.dataset.projectId;
                    document.getElementById('edit-name').value = button.dataset.name;
                    document.getElementById('edit-description').value = button.dataset.description;
                    document.getElementById('edit-median-score').value = button.dataset.medianScore;
                    document.getElementById('edit-project-item-id').value = button.dataset.projectItemId;
                });
            });

            var delete_buttons = document.querySelectorAll('.delete-btn');
            delete_buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('delete-project-id').value = button.dataset.projectId;
                })
            })
        });
    </script>

</body>

</html>