<?php

header('Content-Type: application/json');

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Ctmdsbggpn900!!');
define('DB_NAME', 'sneakers');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT * FROM adidas_superstar_eg4958";
$result = $mysqli->query($query);

$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

$result->close();
$mysqli->close();

print json_encode($data);
