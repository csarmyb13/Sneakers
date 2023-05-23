<?php
$servername = "localhost";
$username = "root";
$password = "Ctmdsbggpn900!!";
$database = "sneakers";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$date_sold = '';
$price = '';

$sql = "SELECT * FROM `adidas_superstar_eg4958` ORDER BY date_sold ASC ";
$result = mysqli_query($connection, $sql);

// Loop through the returned data
while ($row = mysqli_fetch_array($result)) {
    $date_sold = $date_sold . '"' . $row['date_sold'] . '",';
    $price = $price . $row['price'] . ',';
}

$date_sold = trim($date_sold, ",");
$price = trim($price, ",");

// Convert prices to numbers
$price = explode(",", $price);
$price = array_map('floatval', $price);

// Calculate market metrics
$average = array_sum($price) / count($price);
$high = max($price);
$low = min($price);

echo "<script>";
echo "var priceData = [" . implode(",", $price) . "];";
echo "</script>";
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Data</title>
    <style type="text/css">
        body {
            font-family: Arial;
            margin: 20px;
            padding: 0;
            color: #333;
            background: #f2f2f2;
        }
        .container {
            background: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-family: Arial;
        }
        p {
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        ul {

        }
    </style>
</head>
<body>
    <header>
        <h1>Adidas Superstar</h1>
    </header>
    <main>
        <div class="container">
            <h2>Adidas Superstar EG4958</h2>
            <canvas id="chart" style="width: 400vh; height: 50vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
        </div>
        <div>
            <h3>Market Metrics</h3>
            <ul>
                <li>Average: $<?php echo number_format($average, 2); ?></li>
                <li>High: $<?php echo number_format($high, 2); ?></li>
                <li>Low: $<?php echo number_format($low, 2); ?></li>
            </ul>
        </div>
    </main>


    <script>
        var ctx = document.getElementById("chart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $date_sold; ?>],
                datasets: [{
                    label: 'Sales History',
                    data: priceData,
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(255,255,255)',
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 5, // Increase by $5
                            callback: function(value, index, values) {    
                                return '$' + (parseFloat(value) * 5).toFixed(2); // Format tick label as price
                            }
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 20
                        }
                    }]
                },
                tooltips: {
                    mode: 'index'
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        fontColor: 'rgb(255,255,255)',
                        fontSize: 16
                    }
                }
            }
        });
    </script>
</body>
</html>
