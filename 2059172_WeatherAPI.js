var input = document.querySelector(".input");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.querySelector(".close-btn").click();
  }
});  
function f() {
var location = "Worthing";
var location = document.querySelector(".input").value;
const api = 'http://api.openweathermap.org/data/2.5/weather?q='+location+'&appid=922d0531c05a033a1ca30e4e348c149d&units=metric';
 
fetch(api)
// Convert response string to json object
.then(data => data.json())
.then(data => {
    // Declare Variable to add inside html
    console.log(data)
    var cityName = data.name;
    var temp = data.main.temp;
    var description = data.weather[0].description;
    var iconCode = data.weather[0].icon;
    var icon = "http://openweathermap.org/img/w/" + iconCode + ".png";
    var humidity = data.main.humidity;
    var windSpeed = data.wind.speed;
    var pressure = data.main.pressure;
    // As date object return numeric value of month. Declare Array which returns informic month from numeric value
    const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN",
                        "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
    // Calling inbuit-in date object                    
    const d = new Date();
    // New Array which helps to return day
    var weekday = new Array(7);
        weekday[0] = "SUNDAY";
        weekday[1] = "MONDAY";
        weekday[2] = "TUESDAY";
        weekday[3] = "Wednesday";
        weekday[4] = "THRUSDAY";
        weekday[5] = "FRIDAY";
        weekday[6] = "SATURYDAY";
        
    // Declare Varible to get the current date and time
    var day = weekday[d.getDay()];
    var month = (monthNames[d.getMonth()]);
    var datee = d.getDate();
    var hour = (d.getHours());
    var minute = (d.getMinutes());

    // Writing above declared variable inside specific divisions and section
    document.getElementById("location").innerHTML = cityName;
    document.getElementById("temp").innerHTML = temp + '&deg;C';
    document.getElementById("description").innerHTML = description.charAt(0).toUpperCase() + description.slice(1);
    document.getElementById("humidity").innerHTML = 'Humidity: '+ humidity + '%';
    document.getElementById("wind").innerHTML = 'Wind Speed: '+ windSpeed + 'm/s';
    document.getElementById("pressure").innerHTML = 'Pressure: ' + pressure+'hPa';
    document.getElementById("date").innerHTML = day + ' | ' + month +' '+ datee + ' | ' +hour +':'+ minute;
    document.getElementById("icon").innerHTML = "<img src = \"http://openweathermap.org/img/w/" + iconCode + ".png\">";
})
.catch(err => {
    // Displays error in console
    console.log(err);
})
}   