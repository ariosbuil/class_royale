<?php
include '../../../connection.php';

session_start();
$projectId = $_GET['project_id'];
$professor_id = $_SESSION['professor_id'];

$rowProject = "SELECT * FROM Project WHERE project_id = $projectId";
$resultProject = mysqli_query($conn, $rowProject);
$resultProject = mysqli_fetch_assoc($resultProject);
$rowActivity = "SELECT * FROM Activity WHERE project_id = $projectId";
$resultActivity = mysqli_query($conn, $rowActivity);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../../../styles/user_manage_activity.css">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- JavaScript -->
    <!-- <script src="./code.js"></script> -->
    <title>ClassRoyale</title>
</head>

<body>
    <div class="cont-screen">
        <div class="header">
            <?php include '../../../layouts/header.php'; ?>
        </div>
        <div class="content-manage-screen">
            <div class="actual-project flex">
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($resultProject['photo']) . ' " alt="Project Picture">'; ?>
                <div class="actual-project-info">
                    <?php
                    echo '<h2>' . $resultProject['name'] . '</h2>';
                    echo '<p>' . $resultProject['description'] . '</p>';
                    ?>
                <div class="icons-modify flex">
                    <a href="./activity_management.php">
                        Edit Activity
                    </a>
                    <a href="./../project/project_management">
                        Edit Project
                    </a>
                </div>
                </div>
            </div>
            <div class="show-underline"></div>
            <div class="cont-projects-section">
                <!-- FILTER -->
                <div class="filter-by-projects">
                    <h4>Filter By: </h4>
                    <div class="button-filter-by">
                        <ul>
                            <li><a href="">filter</a></li>
                        </ul>
                    </div>
                </div>

                <!-- ! CARD ACT GO HERE -->
                <?php
                while ($actRow = mysqli_fetch_assoc($resultActivity)) {
                ?>
                    <div class="card-act-show flex">
                        <div class="card-act-info">
                            <h3><?php echo $actRow["name"] ?></h3>
                            <div class="button-skill">
                                <?php
                                    $rowItem = "SELECT * FROM Item WHERE item_id = $actRow[activity_item_id]";
                                    $resultItem = mysqli_query($conn, $rowItem);
                                    $resultItem = mysqli_fetch_assoc($resultItem);
                                    echo '<p>'.$resultItem['name'].'</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>