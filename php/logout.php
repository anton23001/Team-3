<?php
session_start();
unset($_SESSION["henkilo"]);
header("Location:../html/login.html");
?>