<?php
include("../Repositorio/Conexion.php");

if(empty($_POST["usuario"]) && empty($_POST["contraseña"] )){
    echo 'Campos Vacios';
}

?>