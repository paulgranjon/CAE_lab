<!-- display_voltages.php -->

<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$dbname = "zprodorg_lab_microbes_voltages_db";
$username = "zprodorg_shewa_user";
$password = "electro++120mV";

$dataLimit = 18; // Use an integer for limit

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//====== get data ================

$sql = "SELECT id, voltage0, voltage1, voltage2, voltage3, timeStamp FROM voltages ORDER BY timeStamp DESC LIMIT $dataLimit";
$result = $conn->query($sql);

$voltages_data = [];
while ($data = $result->fetch_assoc()) {
    $voltages_data[] = $data;
}

$timeStamp = array_column($voltages_data, 'timeStamp');
$voltage0 = json_encode(array_reverse(array_column($voltages_data, 'voltage0')), JSON_NUMERIC_CHECK);
$voltage1 = json_encode(array_reverse(array_column($voltages_data, 'voltage1')), JSON_NUMERIC_CHECK);
$voltage2 = json_encode(array_reverse(array_column($voltages_data, 'voltage2')), JSON_NUMERIC_CHECK);
$voltage3 = json_encode(array_reverse(array_column($voltages_data, 'voltage3')), JSON_NUMERIC_CHECK);
$timeStamp = json_encode(array_reverse($timeStamp), JSON_NUMERIC_CHECK);

$result->free();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <title>CAE Lab Microbial Voltages</title>
    <style>
        body {
            min-width: 310px;
            max-width: 1280px;
            height: 500px;
            margin: 0 auto;
            background-color: #000000;
            color: #aaaaaa; /* Set default text color */
        }
        h2 {
            font-family: Arial;
            font-size: 2.5rem;
            text-align: center;
        }
        .button {
            background-color: #009900;
            border: none;
            color: white;
            padding: 7px 7px;
            font-family: Arial;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 6px;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var voltage0 = <?php echo $voltage0; ?>;
        var voltage1 = <?php echo $voltage1; ?>;
        var voltage2 = <?php echo $voltage2; ?>;
        var voltage3 = <?php echo $voltage3; ?>;
        var timeStamp = <?php echo $timeStamp; ?>;

        // Convert timeStamp to Highcharts-compatible format (milliseconds since epoch)
        var categories = timeStamp.map(function(ts) {
            return new Date(ts).getTime(); // Convert to milliseconds
        });

        var chartV0 = new Highcharts.Chart({
            chart: {
                renderTo: 'chart-CAE_V0',
                type: 'spline',
                backgroundColor: '#222',
                plotBackgroundColor: '#222'
            },
            title: {
                text: 'Microbial Voltages',
                style: { color: '#aaaaaa' },
                align: 'left',
                x: 0,
                margin: 50
            },
            
            xAxis: {
                type: 'datetime',
                title: { text: 'Time', style: { color: '#aaaaaa' } },
                labels: {
                    formatter: function() {
                        return Highcharts.dateFormat('%d-%m_%Y %H:%M', this.value);
                    },
                    style: { color: '#aaaaaa' }
                }
            },
            yAxis: {
                title: { text: 'Millivolts', style: { color: '#aaaaaa' } },
                labels: { style: { color: '#aaaaaa' } },
                gridLineWidth: 0
            },
            credits: { enabled: false },
            series: [{
                name: 'Voltage 0',
                data: voltage0.map((v, i) => [categories[i], v]), // Combine timestamps and voltage data
                color: '#888800'
            },
            {
                name: 'Voltage 1',
                data: voltage1.map((v, i) => [categories[i], v]), // Combine timestamps and voltage data
                color: '#884400'
            },
            {
                name: 'Voltage 2',
                data: voltage2.map((v, i) => [categories[i], v]), // Combine timestamps and voltage data
                color: '#0088FF'
            },
            {
                name: 'Voltage 3',
                data: voltage3.map((v, i) => [categories[i], v]), // Combine timestamps and voltage data
                color: '#0044FF'
            }],
        });
    });
</script>
<div id="chart-CAE_V0" class="container"></div>
<a href="CAE_lab_display_20000.php" class="button">view all data</a>
<a href="download_csv.php" class="button">Download CSV</a>
<a href="voltage0_display.php" class="button">voltage 0</a>
<a href="voltage1_display.php" class="button">voltage 1</a>
<a href="voltage2_display.php" class="button">voltage 2</a>
<a href="voltage3_display.php" class="button">voltage 3</a>


<br>


</body>
</html>

<!--
  This code is derived from the excellent tutorial "Visualize Your Sensor Readings from Anywhere in the World (ESP32/ESP8266 + MySQL + PHP)" by
  Rui Santos aka randomnerd

  Complete project details at https://randomnerdtutorials.com/visualize-esp32-esp8266-sensor-readings-from-anywhere/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
-->
