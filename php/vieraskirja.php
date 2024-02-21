<?php
// Tietokantayhteyden muodostaminen
$json=isset($_POST["henkilo"]) ? $_POST["henkilo"] : "";

//ehtolause jonka tarkoitus on ilmoittaa jos joku kenttä on tyhjä
if (!($henkilo=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}

//Tästä alkaa yhteyden avaus tietokantaan
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

//ht-suojaus laitettu valmiiksi
$init=parse_ini_file("./.ht.asetukset.ini");

try{
    //$yhteys=mysqli_connect("db", "root", "password", "user_data");

    //ht-suojaukseen tarvittava yhteys
    $yhteys=mysqli_connect($init["palvelin"], $init["tunnus"], $init["pass"], $init["tk"]);
}
catch(Exception $e){
    print "Yhteysvirhe";
    exit;
}

$sql="insert into guestbook (name, email, message) values(?, ?, ?)";

try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $henkilo->name, $henkilo->email, $henkilo->message);
    mysqli_stmt_execute($stmt);
    mysqli_close($yhteys);
    print "Viesti lähetetty<br>";

}
catch(Exception $e){
    print "Tapahtui joku virhe! Yritä myöhemmin uudelleen.";
}

function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $henkilo=json_decode($json, false);
    if (empty($henkilo->name) || empty($henkilo->email) || empty($henkilo->message)){
        return false;
    }
    return $henkilo;
}
?>
