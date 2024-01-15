function make_dropdown(dropdown_id, dropdown_content_id) {
  console.log(dropdown_id)
  console.log(dropdown_content_id)
  var dropdown = document.getElementById(dropdown_id);
  var dropdown_content = document.getElementById(dropdown_content_id);
  if (dropdown_content.style.display == "none") {
    dropdown_content.style.display = "block";
  } else {
    dropdown_content.style.display = "none";
  }
}

function createCalendar() {
    const date = new Date();
    const month = date.getMonth(); // get the current month
    const year = date.getFullYear(); // get the current year
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const weekdays = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]; // Start with Monday
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = '';

    // Add weekdays to the calendar
    for(let i = 0; i < 7; i++){
        calendar.innerHTML += "<div class='weekday'>" + weekdays[i] + "</div>";
    }

    // Adjust the loop to start with Monday
    for(let i = (firstDay.getDay() + 6) % 7; i > 0; i--){
        calendar.innerHTML += "<div class='prev-date'></div>";
    }

    for(let i = 1; i <= lastDay.getDate(); i++){
      if(i === date.getDate() && month === date.getMonth() && year === date.getFullYear()){
          calendar.innerHTML += "<div class='today day'>" + i + "</div>";
      } else if(i < date.getDate() && month === date.getMonth() && year === date.getFullYear()){
          calendar.innerHTML += "<div class='before-today day'>" + i + "</div>";
      } else {
          calendar.innerHTML += "<div class='day'>" + i + "</div>";
      }
  }
}
