<?php
include_once("../Repositorio/Database.php");
$id = $_GET["id_registrado"];

BD::unsetRegistrado($id);

header('location: Index_Perfil.php');
?>