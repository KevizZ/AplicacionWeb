<?php
include_once("../Negocio/Persona.php");
include_once("../Repositorio/Database.php");

$id_incidente = $_POST["id_incidente"];

$id_persona = $_GET["id_persona"];

BD::unsetPersona($id_persona);

header("location: Index_Persona.php?id_incidente=" . $id_incidente);
?>