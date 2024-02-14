<?php
session_start();
$json=isset($_POST["henkilo"]) ? $_POST["henkilo"] : "";

//ilmoittaa jos joku kenttä on jäänyt tyhjäksi
if (!($henkilo=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$init=parse_ini_file("./.ht.asetukset.ini");

try{
    //$yhteys=mysqli_connect("db", "root", "password", "user_data");
    $yhteys=mysqli_connect($init["palvelin"], $init["tunnus"], $init["pass"], $init["tk"]);
}
catch(Exception $e){
    print "Yhteysvirhe";
    exit;
}

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//haku kohdistetaan tietueeseen, jossa on tietty tunnus ja salasana
$sql="select * from user where user_account=? and password=SHA2(?, 256)";
try{
    //Valmistellaan sql-lause
    $stmt=mysqli_prepare($yhteys, $sql);
    //Sijoitetaan muuttujat oikeisiin paikkoihin
    mysqli_stmt_bind_param($stmt, 'ss', $henkilo->tunnus, $henkilo->password);
    //Suoritetaan sql-lause
    mysqli_stmt_execute($stmt);
    //Koska luetaan prepared statementilla, tulos haetaan
    //metodilla mysqli_stmt_get_result($stmt);
    $sql=mysqli_stmt_get_result($stmt);
    if ($rivi=mysqli_fetch_object($sql)){
        $_SESSION["henkilo"]="$henkilo->tunnus";
        print "ok";
        exit;
    }
    //Suljetaan tietokantayhteys
    mysqli_close($yhteys);
    print "tunnus tai salasana ei täsmää";
}
catch(Exception $e){
    print "Jokin virhe!";
}
?>


<?php
//tarkistaa jos joku kenttä on jäänyt tyhjäksi
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $henkilo=json_decode($json, false);
    if (empty($henkilo->tunnus) || empty($henkilo->password)){
        return false;
    }
    return $henkilo;
}
?>