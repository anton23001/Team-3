<?php
/*Jos käyttäjä ei ole kirjautunut ohjataan hänet login-sivulle
Muussa tapauksessa toivotetaan hänet tervetulleeksi*/
session_start();
if (!isset($_SESSION["henkilo"])){
    header("Location:../html/login.html");
    exit;
}
include "../html/header.html";

print "<h2>Tervetuloa, ".$_SESSION["henkilo"]." Olet kirjatunut tietotekniikkasivustolle!</h2>";

?>

<?php
include "../html/footer.html";
?>



