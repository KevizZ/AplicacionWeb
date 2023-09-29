<?php
include("../Negocio/Incidente.php");



$NuevoIncidente = new Incidente($_GET["fecha"], $_GET["descripcion"], $_GET["prioridad"], $_GET["estado"]);

$NuevoIncidente->insertIncidente();
header("location: Index_Incidente.php");

?>