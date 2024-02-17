<?php
// Tietokantayhteyden muodostaminen
$servername = "db";
$username = "root";
$password = "password";
$dbname = "user_data";

// Vai pitääkö tehdä vastaavasti, kuin muissa esim:
//$yhteys=mysqli_connect($init["palvelin"], $init["tunnus"], $init["pass"], $init["tk"]);

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
    echo "Tiedot lisätty onnistuneesti.";
} else {
    echo "Virhe: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Ohjaa takaisin vieraskirjan/palautteen sivulle
header('Location: ../html/palaute.html');
exit();
?>