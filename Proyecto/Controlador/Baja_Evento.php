<?php 
include("../Negocio/Evento.php");
   Evento::deleteEvento($_GET["id"]);

   $id = $_GET["id_incidente"];
    $id_incidente = intval($id);
    header("location: Index_Evento.php?id_incidente=" . $id_incidente);


?>