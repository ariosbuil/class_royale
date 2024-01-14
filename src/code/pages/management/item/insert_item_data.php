<?php
    include '../../../connection.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
  
        if (isset($_FILES['icon'])) {
            $icon = uniqid() . "-" . $_FILES['icon']['name'];
            $icon_path = "../../../../img/item_img/" . $icon;
            move_uploaded_file($_FILES['icon']['tmp_name'], $icon_path);

            $image_icon = addslashes(file_get_contents($icon_path));
        }

        $query = "INSERT INTO Item (name, description, icon) VALUES ('$name', '$description', '$image_icon')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query failed " . mysqli_error($conn) . " " . mysqli_errno($conn));
        } else {
            header("Location: item_management.php?");
        }
    } else {
        echo "Error";
    }
    
?>