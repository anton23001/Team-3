<?php
$servername = "db";
$username = "root";
$password = "password";
$database = "user_data";

$yhteys = new mysqli($servername, $username, $password, $database);

if ($yhteys->connect_error) {
    include('../html/yhteysvirhe.html');
    die("Yhteysvirhe: " . $yhteys->connect_error);
} else {
    echo "Yhteys onnistui!";
}

$yhteys->close();
?>