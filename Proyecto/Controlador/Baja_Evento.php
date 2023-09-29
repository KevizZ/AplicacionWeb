<?php 
include("../Negocio/Evento.php");
   Evento::deleteEvento($_GET["id"]);
    header("location: Index_Evento.php");


?>