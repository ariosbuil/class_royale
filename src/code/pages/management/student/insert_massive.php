<?php
include "../../../connection.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file has been selected
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $filename = $_FILES["file"]["name"];
        $tempPath = $_FILES["file"]["tmp_name"];

        // Check the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (strtolower($extension) !== 'csv') {
            die("Error: Please select a CSV file.");
        }

        $professorId = $_SESSION['professor_id'];

        // Process the CSV file
        $handle = fopen($tempPath, "r");
        if ($handle !== false) {

            // Check the connection
            if (mysqli_connect_error()) {
                die("Error connecting to the database: " . mysqli_connect_error());
            }

            // Iterate over the rows of the CSV
            while (($row = fgetcsv($handle)) !== false) {
                // Get data from the row
                $name = mysqli_real_escape_string($conn, $row[0]);
                $surname = mysqli_real_escape_string($conn, $row[1]);
                $password = mysqli_real_escape_string($conn, $row[2]);
                $mail = mysqli_real_escape_string($conn, $row[3]);
                $photo = mysqli_real_escape_string($conn, $row[4]);
                $global_score = mysqli_real_escape_string($conn, $row[5]);


                // Perform the insertion into the database
                $query = "INSERT INTO Student (professor_id, name, surname, password, mail, photo, global_score) VALUES ('$professorId', '$name', '$surname', '$password', '$mail', '$photo', '$global_score')";
                $result = mysqli_query($conn, $query);

                // Check the result of the insertion
                if ($result) {
                    echo "User imported: Name: $name";
                } else {
                    echo "Error in the insertion: " . mysqli_error($conn);
                }
            }

            // Close the connection
            mysqli_close($conn);

            fclose($handle);
        } else {
            die("Error opening the CSV file.");
        }
    } else {
        die("Error: No file selected for import.");
    }
} else {
    die("Access not allowed.");
}
?>
