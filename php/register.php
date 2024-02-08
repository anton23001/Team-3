<?php
$json=isset($_POST["henkilo"]) ? $_POST["henkilo"] : "";

//ehtolause jonka tarkoitus on ilmoittaa jos joku kenttä on tyhjä
if (!($henkilo=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}
//avataan yhteys tietokantaan
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

//!!TÄMÄ ON OPETTAJALTA SAATU VINKKI!! 
// $tulos=mysqli_query($yhteys, "select * from user where user_account=$henkilo->tunnus");
// if ($rivi=mysqli_fetch_object($tulos)){
//     print "Käyttäjätunnus on jo olemassa";
//     exit;
// }


//Tarkistaa että löytyykö tietokannasta jo sama käyttäjätunnus
$sql="select * from user where user_account = ?";

    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 's', $henkilo->tunnus);
    mysqli_stmt_execute($stmt);
    $sql=mysqli_stmt_get_result($stmt);
    if($rivi=mysqli_fetch_object($sql)){
        print "Käyttäjätunnus on varattu";
        exit;
    }

//Tarkistetaan että löytyykö tietokannasta jo sama sähköpostiosoite 
$sql="select * from user where email = ?";

    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 's', $henkilo->email);
    mysqli_stmt_execute($stmt);
    $sql=mysqli_stmt_get_result($stmt);
    if($rivi=mysqli_fetch_object($sql)){
        print "Sähköposti on varattu";
        exit;
    }

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//joihin laitetaan muuttujien arvoja

$sql="insert into user (user_account, etunimi, sukunimi, email, password) values(?, ?, ?, ?, SHA2(?, 256))";

try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $henkilo->tunnus, $henkilo->etunimi, $henkilo->sukunimi, $henkilo->email, $henkilo->password);
    mysqli_stmt_execute($stmt);
    mysqli_close($yhteys);
    print "Rekisteröinti onnistui";
}
catch(Exception $e){
    print "Tapahtui joku virhe! Yritä myöhemmin uudelleen.";
}
?>


<?php
//funktio joka tarkistaa onko kentät täynnä
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $henkilo=json_decode($json, false);
    if (empty($henkilo->tunnus) || empty($henkilo->etunimi) || empty($henkilo->sukunimi) || empty($henkilo->email) || empty($henkilo->password)){
        return false;
    }
    return $henkilo;
}
?>