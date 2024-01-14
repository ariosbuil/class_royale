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
    $selectedProject_id = mysqli_real_escape_string($conn, $_POST['project']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $total_score = mysqli_real_escape_string($conn, $_POST['total_score']);
    $selectedItem_id = mysqli_real_escape_string($conn, $_POST['item']);

    // Perform the insertion into the database
    $query = "INSERT INTO Activity (project_id, professor_id, name, total_score, activity_item_id) VALUES ('$selectedProject_id', '$professor_logged', '$name', '$total_score', '$selectedItem_id')";
    $result = mysqli_query($conn, $query);

    // Close the connection to the database
    mysqli_close($conn);

    // Redirect
    header("Location: activity_management.php");
} else {
    die("Access not allowed.");
}
