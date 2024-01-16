<?php


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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800;900&display=swap"
    rel="stylesheet">
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
      <div class="search-bar">
        <div class="search-bar-container-show">
          <div class="flex">
            <input type="text" placeholder="What do you want?" />
            <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24">
              <path fill="currentColor"
                d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5q0-2.725 1.888-4.612T9.5 3q2.725 0 4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5q0-1.875-1.312-3.187T9.5 5Q7.625 5 6.313 6.313T5 9.5q0 1.875 1.313 3.188T9.5 14" />
            </svg>
          </div>
        </div>
      </div>
      <div class="login">
        <div class="menu">
          <ul>
            <li onclick="make_dropdown('dropdown-image-options', 'dropdown-image-options-content')">
              <a id="dropdown-image-options">
                <img src="./../../../img/iconos/user-example.jpeg" alt="">
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
          <div class="card-project">
            <img src="./../../../img/projects_and_events/React.png" alt="">
            <div class="card-project-info">
              <h3>Project Name</h3>
              <p class="card-description-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dicta dolorem
                aperiam necessitatibus.</p>
              <div class="creator-id">
                <p><span>Created By:</span> RandomProfessor</p>
              </div>
              <div class="button-skill">
                <p>React</p>
                <p>React</p>
              </div>
            </div>
          </div>
          <div class="card-project">
            <img src="./../../../img/projects_and_events/React.png" alt="">
            <div class="card-project-info">
              <h3>Project Name</h3>
              <p class="card-description-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dicta dolorem
                aperiam necessitatibus.</p>
              <div class="creator-id">
                <p><span>Created By:</span> RandomProfessor</p>
              </div>
              <div class="button-skill">
                <p>React</p>
                <p>React</p>
              </div>
            </div>
          </div>
          <div class="card-project">
            <img src="./../../../img/projects_and_events/React.png" alt="">
            <div class="card-project-info">
              <h3>Project Name</h3>
              <p class="card-description-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dicta dolorem
                aperiam necessitatibus.</p>
              <div class="creator-id">
                <p><span>Created By:</span> RandomProfessor</p>
              </div>
              <div class="button-skill">
                <p>React</p>
                <p>React</p>
              </div>
            </div>
          </div>
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
          <div class="card-event-upcoming flex">
            <img src="./../../../img/iconos/user-example.jpeg" alt="">
            <div class="card-section-info-shows">
              <h4>Event Name</h4>
              <p>Event Description</p>
            </div>
          </div>
          <div class="card-event-upcoming flex">
            <img src="./../../../img/iconos/user-example.jpeg" alt="">
            <div class="card-section-info-shows">
              <h4>Event Name</h4>
              <p>Event Description</p>
            </div>
          </div>
          <div class="card-event-upcoming flex">
            <img src="./../../../img/iconos/user-example.jpeg" alt="">
            <div class="card-section-info-shows">
              <h4>Event Name</h4>
              <p>Event Description</p>
            </div>
          </div>
          <div class="card-event-upcoming flex">
            <img src="./../../../img/iconos/user-example.jpeg" alt="">
            <div class="card-section-info-shows">
              <h4>Event Name</h4>
              <p>Event Description</p>
            </div>
          </div>  
        </div>
      </div>
    </div>
  </div>
</body>

</html>