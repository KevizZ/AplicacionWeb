<?php
include_once("../Repositorio/Database.php");
include_once("../Negocio/Usuario.php");
$id = $_GET["id_registrado"];

// Obtengo el registrado
$usuario = BD::getRegistrado($id);

// Elimino el registrado
BD::unsetRegistrado($id);

// Le paso el registrado y lo replica en la tabla usuario
BD::setUsuario($usuario);

header('location: Index_Perfil.php');
?>