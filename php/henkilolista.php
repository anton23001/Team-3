<?php
//Ohjataan käyttäjä takaisin kirjautumaan jos ei ole kirjautunut
session_start();
if (!isset($_SESSION["henkilo"])){
    header("Location:../html/login.html");
    exit;
}
?>
<!-- html koodia jolla saadaan painikkeet ja haku valikko  -->
    <header class="Header-part">
        <!-- Contains main header and logout button. -->
        <button onclick="location.href='../php/logout.php'" type="button" class="logout"> Kirjaudu ulos</button> 
        <h1 class="Headline"> Tietotekniikkasivusto </h1>
        <p> <i>Tietotekniikkaan liittyv&auml;&auml; tietoa tietotekniikasta kiinnostuneille.</i> </p>
    </header>

    <nav id="navigation-bar">
        <!-- Contains navigation menu with Home, Uutiset, Arvostelut, Keskustelut -->

        <ul>
            <button onclick="location.href='../php/tervetuloa.php'" type="button" class="lista">Home</button>
            <button onclick="location.href='../php/henkilolista.php'" type="button" class="lista">Muut käyttäjät</button>
        </ul>
    </nav>
    <!-- html-koodi loppuu -->
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
//henkilölistan tulostaminen taulukkoon
$tulos=mysqli_query($yhteys, "select user_account from user");
print "<table border='1'>";
while ($rivi=mysqli_fetch_object($tulos)){
    print "<tr><td>$rivi->user_account\n";
}
print "</table>";
mysqli_close($yhteys);

include "../html/footer.html";
?>



