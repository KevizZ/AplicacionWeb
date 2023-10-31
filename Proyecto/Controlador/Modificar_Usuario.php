<?php
include_once("../Negocio/Usuario.php");
include_once("../Repositorio/Database.php");
session_start();

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

$usuario1 = BD::getUsuario($_SESSION["ci_usuario"]);

// Verifico que la contraseña no sea la misma que tenía Encriptada y no la encripto devuelta.
if ($contraseña != $usuario1->getContraseña()) {
    $contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
}

$usuario = new Usuario($cedula, $nombre, $apellido, $contraseña, $correo);
$usuario->setCargo($cargo);
$usuario->setId($usuario1->getId());


BD::updateUsuario($usuario);

$_SESSION["ci_usuario"] = $cedula;

header("location: Index_Perfil.php");

?>