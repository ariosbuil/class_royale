<?php
include "../../../connection.php";

session_start(); 

$professor_logged = $_SESSION['professor_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['add'])) {
    // Check the connection
    if (mysqli_connect_error()) {
        die("Error connecting to the database: " . mysqli_connect_error());
    }

    // Get user data from the form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $median_score = mysqli_real_escape_string($conn, $_POST['median_score']);
    $selectedItem_id = mysqli_real_escape_string($conn, $_POST['item']);

    if (isset($_FILES['photo'])) {
        $icon = uniqid() . "-" . $_FILES['photo']['name'];
        $icon_path = "../../../../img/projects_and_events/" . $icon;
        move_uploaded_file($_FILES['photo']['tmp_name'], $icon_path);

        $image_icon = addslashes(file_get_contents($icon_path));
    }

    // Perform the insertion into the database
    $query = "INSERT INTO Project (professor_id, name, median_score, project_item_id, photo, description) VALUES ('$professor_logged', '$name', '$median_score', '$selectedItem_id', '$image_icon', '$description')";
    $result = mysqli_query($conn, $query);

    // Close the connection to the database
    mysqli_close($conn);

    // Redirect to the project management page
    if ($result) {
        $insert_msg = "Project created successfully.";
        header("Location: project_management.php?update_msg=$insert_msg");
        exit();
    } else {
        $error_msg = "Error creating project: " . mysqli_error($conn);
        header("Location: project_management.php?error_msg=$error_msg");
        exit();
    }
} else {
    die("Access not allowed.");
}