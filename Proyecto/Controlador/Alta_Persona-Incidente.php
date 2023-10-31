<?php
include_once("../Negocio/Persona.php");
include_once("../Repositorio/Database.php");

$incidente_id = $_POST["id_incidente"];

$persona_ci = $_POST["cedula"];

$evento_id = $_POST["evento"];

$rol = isset($_POST["rol"]) ? $_POST["rol"] : "";

if (empty($rol)) {
    $rol = isset($_POST["rol_personalizado"]) ? $_POST["rol_personalizado"] : "";
}
if (isset($_POST["evento"]) && $_POST["evento"] != -1) {
    $evento = $_POST["evento"];
    BD::vincularPersonaEvento($evento, $persona_ci);
}

BD::vincularPersonaIncidente($incidente_id, $rol, $persona_ci);


header("location: Index_Buscador-Persona.php?id_incidente=" . $incidente_id);
?>