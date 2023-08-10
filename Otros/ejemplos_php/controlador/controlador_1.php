<?php
//http://localhost/ejemplos_php/controlador/controlador_0.php?nombre=gabriel&ape=aramburu
if (isset($_GET['nombre']) && isset($_GET['ape'])) {
   
    $nombre = $_GET['nombre'];
    $apellido = $_GET['ape'];

    echo "¡Hola, " . htmlspecialchars($nombre) . " " .htmlspecialchars($apellido) . 
    "! Bienvenido a nuestra página web.";
} else {
   
    echo "Por favor, ingrese su nombre y apellido en la URL.";
}

?>