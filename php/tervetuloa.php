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

<!-- html koodia jolla saadaan painikkeet ja haku valikko  -->
<header class="Header-part">
        <!-- Contains main header and logout button. -->
        
        <!-- uloskirjautumispainike -->
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
include "../html/footer.html";
?>



