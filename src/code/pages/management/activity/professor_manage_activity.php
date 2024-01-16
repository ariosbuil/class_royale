<?php
    include '../../../connection.php';

    if(isset($_GET['project_id']))
    {
        $id_proyecto = $_GET['project_id'];


    }
    else{
        // Rdireccionar a la home
    }

    session_start();
    $professor_id = $_SESSION['professor_id']

    $query = "SELECT name FROM Activity WHERE project_id = 1";
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- JavaScript -->
    <!-- <script src="./code.js"></script> -->
    <title>ClassRoyale</title>
</head>

<body>
    <div class="cont-screen">
        <div class="header">
            <div class="logo">
                <img src="./../../../../img/logo.png" alt="logo" />
            </div>
            <div class="cont-for-header-flex flex">
                <div class="menu">
                    <ul>
                        <li onclick="make_dropdown('dropdown-more-options', 'dropdown-more-options-content')">
                            <a id="dropdown-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M12.005 11.995v.01m0-4.01v.01m0 7.99v.01" />
                                </svg></a>
                            <ul id="dropdown-more-options-content">
                                <li><a href="./../home/home_professor.html">Home</a></li>
                                <li><a href="./../management/professor">Projects</a></li>
                                <li><a href="./../management/activity/activity_management.php">Activities</a></li>
                                <li><a href="./../management/item/item_management.php">Items</a></li>
                        </li>
                    </ul>
                    </ul>
                </div>
                <div class="login">
                    <div class="menu">
                        <ul>
                            <li onclick="make_dropdown('dropdown-image-options', 'dropdown-image-options-content')">
                                <a id="dropdown-image-options">
                                    <img src="./../../../../img/iconos/user-example.jpeg" alt="">
                                </a>
                                <ul id="dropdown-image-options-content">
                                    <li><a href="">Change Image</a></li>
                                    <li><a href="">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <div class="content-manage-screen">
            <div class="actual-project flex">
                <img src="./../../../../img/iconos/user-example.jpeg" alt="">
                <div class="actual-project-info">
                    <h2>Project Name</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt inventore temporibus eius
                        magnam, explicabo, placeat exercitationem eveniet libero quod fugit dolores similique fuga a
                        totam quae atque et dolore modi!</p>
                </div>
                <div class="icons-modify flex">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24">
                            <path fill="#ffffff"
                                d="M3 21v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15q.4 0 .775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                        </svg>
                    </a>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 256 256">
                            <path fill="#ffffff"
                                d="M228 128a12 12 0 0 1-12 12h-76v76a12 12 0 0 1-24 0v-76H40a12 12 0 0 1 0-24h76V40a12 12 0 0 1 24 0v76h76a12 12 0 0 1 12 12" />
                        </svg>
                    </a>
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

                <!-- ! CARD PROJECTS GO HERE -->
                <div class="card-act-show flex">
                    <div class="card-act-info">
                        <h3>Activity 1</h3>
                        <div class="button-skill">
                            <p>Skill</p>
                            <p>Skill</p>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio iste necessitatibus iusto, fugit aspernatur rem voluptatem cupiditate accusantium velit amet.</p>
                    </div>
                    <div class="edit-delete-options">
                        <div class="icons-modify flex">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24">
                                    <path fill="#ffffff"
                                        d="M3 21v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15q.4 0 .775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                                </svg>
                            </a>
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 256 256">
                                    <path fill="#ffffff"
                                        d="M228 128a12 12 0 0 1-12 12h-76v76a12 12 0 0 1-24 0v-76H40a12 12 0 0 1 0-24h76V40a12 12 0 0 1 24 0v76h76a12 12 0 0 1 12 12" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>