// voltages_post_data.php

<?php

$servername = "localhost";
$dbname = "zprodorg_lab_microbes_voltages_db";
$username = "zprodorg_shewa_user";
$password = "electro++120mV";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Log the incoming data for debugging
file_put_contents('debug.log', print_r($data, true)); // This will create a debug.log file with the incoming data

// Check if the required data is present
if (!isset($data['voltage0'], $data['voltage1'], $data['voltage2'], $data['voltage3'])) {
    die("Error: Missing data");
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO voltages (voltage0, voltage1, voltage2, voltage3) VALUES (?, ?, ?, ?)");
$stmt->bind_param("dddd", $voltage0, $voltage1, $voltage2, $voltage3);

// Set parameters
$voltage0 = $data['voltage0'];
$voltage1 = $data['voltage1'];
$voltage2 = $data['voltage2'];
$voltage3 = $data['voltage3']; 

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>

<!--
  This code is derived from the excellent tutorial "Visualize Your Sensor Readings from Anywhere in the World (ESP32/ESP8266 + MySQL + PHP)" by
  Rui Santos aka randomnerd

  Complete tutorial at https://randomnerdtutorials.com/visualize-esp32-esp8266-sensor-readings-from-anywhere/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
-->
