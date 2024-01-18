<?php
include '../../../connection.php';

/* Message */
// if (isset($_GET['insert_msg'])) {
//     echo "<h6>" . $_GET['insert_msg'] . "</h6>";
// }

define("RESULTS_PER_PAGE", 3); 


// Total results
$query = "SELECT COUNT(*) as total FROM Item";
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
$query = "SELECT * FROM Item LIMIT $startIndex, " . RESULTS_PER_PAGE;
$result = mysqli_query($conn, $query);

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
    <link rel="stylesheet" href="../../../styles/item_management.css">
    <!-- Bootstap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Item Management</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <?php include './../../../layouts/header.php' ?>
        </div>
        <div class="management">
            <div class="management-header">
                <h1>Item Management</h1>
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
                            <?php echo '<img style="width: 60px; height: 60px; border-radius: 100%;" src="data:image/jpeg;base64,' . base64_encode($row['icon']) . ' " alt="Profile Picture">'; ?>
                        </div>
                        <div class="result-name">
                            <h2><?php echo $row['name']; ?></h2>
                        </div>
                        <div class="action-buttons">
                            <div class="button">
                                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#updateModal" data-item-id="<?php echo $row['item_id']; ?>" data-name="<?php echo $row['name']; ?>" data-description="<?php echo $row['description']; ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                            <div class="button">
                                <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-id="<?php echo $row['item_id']; ?>"><i class="fa-solid fa-x"></i></button>
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
            echo "<a href='item_management.php?page=$page' class='$class circle'>$page</a> ";
        }
        ?>
    </div>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <form action="insert_item_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="surname">Description:</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon:</label>
                            <input type="file" name="icon" class="form-control">
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
    <form action="update_item_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" id="edit-name">
                        </div>
                        <div class="form-group">
                            <label for="surname">Description:</label>
                            <textarea name="description" class="form-control" id="edit-description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon:</label>
                            <input type="file" name="icon" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="item_id" id="edit-item-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="update" value="UPDATE">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Remove Confirmation Modal -->
    <form action="delete_item_data.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this item?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="item_id" id="delete-item-id">
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
                    document.getElementById('edit-description').value = button.dataset.description;
                    document.getElementById('edit-item-id').value = button.dataset.itemId;
                });
            });

            var delete_buttons = document.querySelectorAll('.delete-btn');
            delete_buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('delete-item-id').value = button.dataset.itemId;
                })
            })
        });
    </script>
</body>

</html>