<?php
include '../../../connection.php';

session_start();

$professor_id = $_SESSION['professor_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el valor del filtro
    $filterText = mysqli_real_escape_string($conn, $_POST['filterText']);

    // Construir la consulta con LIKE
    $queryFilter = "SELECT * FROM Activity WHERE professor_id = '$professor_id' AND name LIKE '%$filterText%'";
    $resultFilter = mysqli_query($conn, $queryFilter);

    // Construir la salida HTML con los resultados
    while ($rowFilter = mysqli_fetch_assoc($resultFilter)) {
        echo "<div class='result-item'>
          <div class='result-name'>
              <h2>" . $rowFilter['name'] . "</h2>
          </div>
          <div class='action-buttons'>
              <div class='button'>
                  <button class='edit-btn' data-bs-toggle='modal' data-bs-target='#updateModal' data-activity-id='" . $rowFilter['activity_id'] . "' data-project-id='" . $rowFilter['project_id'] . "' data-professor-id='" . $rowFilter['professor_id'] . "' data-name='" . $rowFilter['name'] . "' data-total-score='" . $rowFilter['total_score'] . "' data-activity-item-id='" . $rowFilter['activity_item_id'] . "'>
                      <i class='fa-solid fa-pencil'></i> Edit
                  </button>
              </div>
              <div class='button'>
                  <button class='delete-btn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-activity-id='" . $rowFilter['activity_id'] . "'>
                      <i class='fa-solid fa-x'></i> Delete
                  </button>
              </div>
          </div>
      </div>";

              
    }
}
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delegar eventos de clic al cuerpo del documento
        document.body.addEventListener('click', function (event) {
            // Verificar si el clic ocurrió en un botón de edición
            if (event.target.classList.contains('edit-btn')) {
                // Obtener los atributos de datos del botón de edición
                var activityId = event.target.getAttribute('data-activity-id');
                var projectId = event.target.getAttribute('data-project-id');
                var professorId = event.target.getAttribute('data-professor-id');
                var name = event.target.getAttribute('data-name');
                var totalScore = event.target.getAttribute('data-total-score');
                var activityItemId = event.target.getAttribute('data-activity-item-id');

                // Hacer algo con los datos, por ejemplo, mostrarlos en la consola
                console.log('Editar actividad:', activityId, projectId, professorId, name, totalScore, activityItemId);
            }

            // Verificar si el clic ocurrió en un botón de eliminación
            if (event.target.classList.contains('delete-btn')) {
                // Obtener el atributo de datos del botón de eliminación
                var activityId = event.target.getAttribute('data-activity-id');

                // Hacer algo con el dato, por ejemplo, mostrarlo en la consola
                console.log('Eliminar actividad:', activityId);
            }
        });
    });
</script>

