<?php
include("../Repositorio/Conexion.php");

$id = $_GET['eliminarId'];

$sql = "DELETE FROM incidente WHERE id = ?";

$conexion = new Conexion();

$statement = $conexion->getConexion()->prepare($sql);


$statement->execute([$id]);
header("location: Index_Incidente.php");

?>