<?php
require_once("../Repositorio/Database.php");
$id = $_GET["id_persona"];

BD::desvincularPersonaIncidente($id);
$id_incidente = $_GET["id_incidente"];

header("location: Index_Buscador-Persona.php?id_incidente=" . $id_incidente);

?>