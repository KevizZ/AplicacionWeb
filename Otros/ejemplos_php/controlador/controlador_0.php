
<?php
//http://localhost/ejemplos_php/controlador/controlador_0.php?
//nombre=gabriel
if (isset($_GET['nombre'])) {
    
    $nombre = $_GET['nombre'];

    echo "¡Hola, " . htmlspecialchars($nombre) . "! Bienvenido a nuestra página web.";
} else {
    
    echo "Por favor, ingrese su nombre en la URL.";
}
?>