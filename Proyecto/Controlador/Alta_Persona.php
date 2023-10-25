<?php
include_once("../Negocio/Persona.php");
include_once("../Repositorio/Database.php");

$id = $_POST["id_incidente"];

$cedula = $_POST["cedula"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];

$Persona = new Persona($cedula, $nombre, $apellido);

BD::setPersona($Persona);

header("location: Index_Persona.php?id_incidente=" . $id);
?>