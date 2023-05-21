<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body style="margin: 50px;">
    <h1>Adidas</h1>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Shoe</th>
                <th>Name</th>
                <th>Available</th>
            </tr>
        </thead>
    
        <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "sneakers";

            //create connection
            $connection = new mysqli($servername, $username, $password, $database);

             // Check connection
			if ($connection->connect_error) {
				die("Connection failed: " . $connection->connect_error);
			}

            // read all row from database table
			$sql = "SELECT * FROM sneakers_adidas";
			$result = $connection->query($sql);
        
            if (!$result) {
				die("Invalid query: " . $connection->error);
			}
            // read data of each row
			while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>". $row["shoes"] . "</td>
                    <td><a href=\"adidas_superstar_eg4958.php?id=" . $row["name"] . "\">". $row["name"] . "</td>
                    <td>". $row["style_count"] . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </tabel>
</body>
</html>
