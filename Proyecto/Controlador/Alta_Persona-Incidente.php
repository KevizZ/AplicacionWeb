<?php
include_once("../Negocio/Persona.php");
include_once("../Repositorio/Database.php");

$incidente_id = $_POST["id_incidente"];

$rol = isset($_POST["rol"]) ? $_POST["rol"] : "";

if (empty($rol)) {
    $rol = isset($_POST["rol_personalizado"]) ? $_POST["rol_personalizado"] : "";
}

$persona_ci = $_POST["cedula"];


BD::vincularPersonaIncidente($incidente_id, $rol, $persona_ci);

header("location: Index_Buscador-Persona.php?id_incidente=" . $incidente_id);
?>