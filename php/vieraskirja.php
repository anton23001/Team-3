<?php
// Tietokantayhteyden muodostaminen
$servername = "db";
$username = "root";
$password = "password";
$dbname = "user_data";

// Luo yhteys
$conn = new mysqli($servername, $username, $password, $dbname);

// Tarkista yhteys
if ($conn->connect_error) {
    die("Yhteys epäonnistui: " . $conn->connect_error);
}

// Vastaanota lomakkeen tiedot
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Tietojen lisääminen tietokantaan (eri taulu, kuin user-taulu)
$sql = "INSERT INTO guestbook (name, email, message) VALUES ('$name', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Ohjaa takaisin vieraskirjan/palautteen sivulle
header('Location: ../html/palaute.html');
exit();
?>