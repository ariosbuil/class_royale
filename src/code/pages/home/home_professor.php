<?php

include '../../connection.php';

session_start();

$query = 'SELECT * FROM Project WHERE professor_id = ' . $_SESSION['professor_id'];
$result = mysqli_query($conn, $query);

$query2 = 'SELECT * FROM Project WHERE professor_id = ' . $_SESSION['professor_id'];
$result2 = mysqli_query($conn, $query2);

?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./../../styles/home_styles.css" />
  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <!-- JavaScript -->
  <script src="./code.js"></script>
  <title>ClassRoyale</title>
</head>

<body>
  <div class="cont-screen">
    <div class="header">
      <div class="logo">
        <img src="./../../../img/logo.png" alt="logo" />
      </div>
      <div class="menu">
        <ul>
          <li onclick="make_dropdown('dropdown-more-options', 'dropdown-more-options-content')">
            <a id="dropdown-more-options">
              <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.005 11.995v.01m0-4.01v.01m0 7.99v.01" />
              </svg></a>
            <ul id="dropdown-more-options-content">
              <li><a href="./../home/home_professor.php">Home</a></li>
              <li><a href="./../management//project/project_management.php">Projects</a></li>
              <li><a href="./../management/activity/activity_management.php">Activities</a></li>
              <li><a href="./../management/item/item_management.php">Items</a></li>
              <li><a href="./../managment/student/student_management.php">Students</a></li>
          </li>
        </ul>
        </ul>
      </div>
      <div class="search-bar">
        <div class="search-bar-container-show">
          <div class="flex">
            <input type="text" placeholder="What do you want?" />
            <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24">
              <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5q0-2.725 1.888-4.612T9.5 3q2.725 0 4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5q0-1.875-1.312-3.187T9.5 5Q7.625 5 6.313 6.313T5 9.5q0 1.875 1.313 3.188T9.5 14" />
            </svg>
          </div>
        </div>
      </div>
      <div class="login">
        <div class="menu">
          <ul>
            <li onclick="make_dropdown('dropdown-image-options', 'dropdown-image-options-content')">
              <a id="dropdown-image-options">
                <?php
                $photo_professor = "SELECT photo FROM Professor WHERE professor_id = " . $_SESSION['professor_id'];
                echo "<img style='width: 80px; height: 80px;' src='data:image/jpeg;base64," . base64_encode(mysqli_fetch_assoc(mysqli_query($conn, $photo_professor))['photo']) . "'>";
                ?>
              </a>
              <ul id="dropdown-image-options-content">
                <li><a href="../login/logout_process.php">Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- CONTENT HOME -->
    <div class="content-home-screen flex">
      <!-- PROJECTS FILTER -->
      <div class="projects-shows">
        <h2>PROJECTS</h2>
        <!-- FILTER -->
        <div class="filter-by-projects">
          <h4>Filter By: </h4>
          <div class="button-filter-by">
            <ul>
              <li><a href="">filter</a></li>
            </ul>
          </div>
        </div>
        <!-- PROJECTS -->
        <div class="show-projects">
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <div class="card-project">
              <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['photo']) . ' " alt="Project Picture">'; ?>
              <div class="card-project-info">
                <h3><?php echo $row["name"] ?></h3>
                <p class="card-description-text"><?php echo $row["description"] ?></p>
                <div class="creator-id">
                  <p><span>Created By:</span>
                    <?php
                    $queryName = "SELECT name, surname FROM Professor WHERE professor_id = " . $row["professor_id"];
                    $resultName = mysqli_query($conn, $queryName);
                    $rowName = mysqli_fetch_assoc($resultName);
                    echo $rowName["name"] . " " . $rowName["surname"];
                    ?>
                  </p>
                </div>
                <div class="button-skill">
                  <p>React</p>
                  <p>React</p>
                </div>
              </div>
              <div class="button-look-project">
                <?php
                echo "<a href='./../management/activity/professot_manage_activity.php?project_id=" . $row['project_id'] . "'><svg xmlns='http://www.w3.org/2000/svg' width='128' height='128' viewBox='0 0 24 24'><path d='M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5'/></svg></a>";
                ?>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      <!-- EVENTS -->
      <div class="events-shows">
        <div class="calendar-section-shows">
          <h3>January 2024</h3>
          <div class="grid">
            <div id="calendar">
              <script>
                createCalendar();
              </script>
            </div>
          </div>
        </div>
        <div class="event-section-shows">
          <h3>Upcoming Events</h3>
          <?php
          while ($row2 = mysqli_fetch_assoc($result2)) {
          ?>
            <div class="card-event-upcoming flex">
              <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row2['photo']) . ' " alt="Project Picture">'; ?>
              <div class="card-section-info-shows">
                <p><?php echo $row2["name"] ?></p>
                <p class="card-description-text"><?php echo $row2["description"] ?></p>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</body>

</html>