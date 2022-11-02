<?php
// Connect to database
$mysqli = new mysqli("localhost","root","","weather_api");
if ($mysqli -> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
// Select weather data for given parameters
$sql = "SELECT *
FROM weatherdata
WHERE city = '{$_GET['city']}'
AND weather_when >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)
ORDER BY weather_when DESC limit 1";
$result = $mysqli -> query($sql);
// If 0 record found
if ($result->num_rows == 0) {
$url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $_GET['city'] . '&appid=922d0531c05a033a1ca30e4e348c149d&units=metric';
// Get data from openweathermap and store in JSON object
$data = file_get_contents($url);
$json = json_decode($data, true);
// Fetch required fields
$weather_description = $json['weather'][0]['description'];
$weather_temperature = $json['main']['temp'];
$weather_wind = $json['wind']['speed'];
// Set default timezone as Kathmandu
date_default_timezone_set('Asia/KATHMANDU');
$weather_when = date("Y-m-d H:i:s"); // now
$city = $json['name'];
$humidity = $json['main']['humidity'];
$pressure = $json['main']['pressure'];
$icon = $json['weather'][0]['icon'];
// Build INSERT SQL statement
$sql = "INSERT INTO weatherdata (weather_description, weather_temperature, weather_wind, weather_when, city, humidity, pressure, icon)
VALUES('{$weather_description}', '{$weather_temperature}', {$weather_wind}, '{$weather_when}', '{$city}', '{$humidity}', '{$pressure}', '{$icon}')";
// Run SQL statement and report errors
if (!$mysqli -> query($sql)) {
echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");
}
}

// Execute SQL query
$sql = "SELECT *
FROM weatherdata
WHERE city = '{$_GET['city']}'
AND weather_when >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)
ORDER BY weather_when DESC limit 1";
$result = $mysqli -> query($sql);
// Get data, convert to JSON and print
$row = $result -> fetch_assoc();
print json_encode($row);
// Free result set and close connection
$result -> free_result();
$mysqli -> close();
?>