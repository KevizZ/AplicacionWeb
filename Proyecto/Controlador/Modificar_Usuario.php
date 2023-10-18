<?php
include_once("../Negocio/Usuario.php");
include_once("../Repositorio/Database.php");

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

$hash_contraseña = password_hash($contraseña, PASSWORD_BCRYPT);

$usuario = new Usuario($cedula, $nombre, $apellido, $hash_contraseña, $correo);
$usuario->setCargo($cargo);

BD::updateUsuario($usuario);

header('location: Index_Perfil.php');
?>