<?php
include_once("../Negocio/Evento.php");
include_once("../Repositorio/Database.php");
$id = $_GET["id"];

$rutaArchivo = BD::unsetEvento($id);

unlink($rutaArchivo); // Elimina el archivo físico

$id = $_GET["id_incidente"];
$id_incidente = intval($id);
header("location: Index_Evento.php?id_incidente=" . $id_incidente);


?>