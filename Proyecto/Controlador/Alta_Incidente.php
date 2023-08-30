<?php
include("../Negocio/Incidente.php");



$NuevoIncidente = new Incidente($_GET["fecha"], $_GET["descripcion"], $_GET["prioridad"], $_GET["estado"]);

$conexion = new Conexion();
$query = "INSERT INTO incidente (fecha, descripcion, prioridad, estado) VALUES (?, ?, ?, ?)";
$statement = $conexion->getConexion()->prepare($query);

$statement->execute([
    $NuevoIncidente->getFecha(),
    $NuevoIncidente->getDescripcion(),
    $NuevoIncidente->getPrioridad(),
    $NuevoIncidente->getEstado()
]);
header("location: Index_Incidente.php");

?>