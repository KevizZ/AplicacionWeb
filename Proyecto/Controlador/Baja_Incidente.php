<?php
include("../Negocio/Incidente.php");

$incidente_id = $_GET["id_incidente"]; // Asegúrate de obtener el ID del evento desde la URL correctamente

Evento::deleteEvento($incidente_id);
Incidente::deleteIncidente($incidente_id);

header("location: Index_Incidente.php")



?>