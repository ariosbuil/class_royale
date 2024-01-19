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
$query = "SELECT COUNT(*) as total FROM Activity";
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
$query = "SELECT * FROM Activity WHERE professor_id = '$professor_id' LIMIT $startIndex, " . RESULTS_PER_PAGE;
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
    <!-- GLOBAL CONFIGURATIONS -->
    <link rel="stylesheet" href="./../../../styles/global/global.css" />
    <link rel="stylesheet" href="./../../../styles/global/headers/header-professor.css" />
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Font Awesome -->
    <?php include '../../../layouts/fontawesome.php' ?>
    <link rel="stylesheet" href="../../../styles/activity_management.css">
    <!-- Bootstap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Activity Management</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <?php include '../../../layouts/header.php'; ?>
        </div>
        <div class="management">
            <div class="management-header">
                <h1>Activity Management</h1>
                <!-- <div class="filter">
                    <input type="text" id="activityFilter" name="filterText" placeholder="Filter activities...">
                </div> -->
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
                        <div class="result-name">
                            <h2><?php echo $row['name']; ?></h2>
                        </div>
                        <div class="action-buttons">
                            <div class="button">
                                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#updateModal" data-activity-id="<?php echo $row['activity_id']; ?>" data-project-id="<?php echo $row['project_id']; ?>" data-professor-id="<?php echo $row['professor_id']; ?>" data-name="<?php echo $row['name']; ?>" data-total-score="<?php echo $row['total_score']; ?>" data-activity-item-id="<?php echo $row['activity_item_id']; ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                            <div class="button">
                                <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-activity-id="<?php echo $row['activity_id']; ?>"><i class="fa-solid fa-x"></i></button>
                            </div>
                        </div>
                        <!-- Indicador visual -->
                        <?php if ($row['is_active']): ?>
                            <span style="color: green; margin-left: 10px;">Active</span>
                        <?php else: ?>
                            <span style="color: red; margin-left: 10px;">Inactive</span>
                        <?php endif; ?>
                    </div>
                <?php
                }
                ?>
                <div class="pages">
                    <?php
                    // Mostrar enlaces de paginación
                    for ($page = 1; $page <= $totalPages; $page++) {
                        $class = ($page == $currentPage) ? 'current' : '';
                        echo "<a href='activity_management.php?page=$page' class='$class circle'>$page</a> ";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <form action="insert_activity_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Activity</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="project">Select Project:</label>
                            <select name="project" class="form-control" required>
                                <option value="" disabled selected style="color: gray;">Select a Project...</option>
                                <?php
                                $query = "SELECT * FROM Project WHERE professor_id = '$professor_id'";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['project_id'] . "'>" . $row['name'];
                                        "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No projects available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="total_score">Total Score:</label>
                            <input type="number" name="total_score" class="form-control" required min="0" max="10">
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
                            <label for="is_active">Is Active:</label>
                            <input type="checkbox" name="is_active" value="1" checked>
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
    <form action="update_activity_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Activity</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="project">Select Project:</label>
                            <select name="project" class="form-control" id="edit-project-id" required>
                                <option value="" disabled selected style="color: gray;">Select a Project...</option>
                                <?php
                                $query = "SELECT * FROM Project WHERE professor_id = '$professor_id'";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['project_id'] . "'>" . $row['name'];
                                        "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No projects available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" id="edit-name">
                        </div>
                        <div class="form-group">
                            <label for="total_score">Total Score:</label>
                            <input type="number" name="total_score" class="form-control" required min="0" max="10" id="edit-total-score">
                        </div>
                        <div class="form-group">
                            <label for="item">Select Item:</label>
                            <select name="item" class="form-control" id="edit-activity-item-id" required>
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
                    </div>
                    <div class="form-group">
                        <label for="is_active">Is Active:</label>
                        <input type="checkbox" name="is_active" value="1" <?php echo isset($row['is_active']) && $row['is_active'] ? 'checked' : ''; ?>>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="activity_id" id="edit-activity-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="update" value="UPDATE">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Remove Confirmation Modal -->
    <form action="delete_activity_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Activity</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this activity?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="activity_id" id="delete-activity-id">
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
                    document.getElementById('edit-total-score').value = button.dataset.totalScore;
                    document.getElementById('edit-activity-item-id').value = button.dataset.activityItemId;
                    document.getElementById('edit-activity-id').value = button.dataset.activityId;
                });
            });

            var delete_buttons = document.querySelectorAll('.delete-btn');
            delete_buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('delete-activity-id').value = button.dataset.activityId;
                })
            })
        });

        // Handle the change in the filter field
        var activityFilter = document.getElementById('activityFilter');

        activityFilter.addEventListener('input', function() {
            // Get the value of the filter
            var filterText = activityFilter.value;

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the AJAX request
            xhr.open('POST', 'searchactivities.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // Handle the response of the request
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the content of activities with the results
                    var managementBody = document.querySelector('.management-body');
                    managementBody.innerHTML = xhr.responseText;
                }
            };

            // Send the request with the filter value
            xhr.send('filterText=' + encodeURIComponent(filterText));
        });
    </script>

</body>

</html>