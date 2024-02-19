<?php
//Ohjataan käyttäjä takaisin kirjautumaan jos ei ole kirjautunut
session_start();
if (!isset($_SESSION["henkilo"])){
    header("Location:../html/login.html");
    exit;
}
?>

<?php
include "../html/header.html";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$init=parse_ini_file("./.ht.asetukset.ini");

try{
    
    $yhteys=mysqli_connect($init["palvelin"], $init["tunnus"], $init["pass"], $init["tk"]);
}
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}
// henkilölistan tulostaminen taulukkoon
$tulos=mysqli_query($yhteys, "select user_account from user");
if (mysqli_num_rows($tulos) > 0){
    print "<table border='1'>";
while ($rivi=mysqli_fetch_object($tulos)){
    print "<tr><td>$rivi->user_account\n";
}
print "</table>";
} else {
    print "Ei ole muita!";
}
mysqli_close($yhteys);




include "../html/footer.html";
?>



