?php

include '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $project_id = $_POST['project_id'];

    $query = "DELETE FROM Project WHERE project_id = '$project_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $delete_msg = "Project deleted successfully.";
        header("Location: project_management.php?delete_msg=$delete_msg");
        exit();
    } else {
        $error_msg = "Error deleting project: " . mysqli_error($conn);
        header("Location: project_management.php?error_msg=$error_msg");
        exit();
    }
}   

?>