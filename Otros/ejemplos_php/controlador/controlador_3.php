<?php 
//Ejemplo: http://localhost/ejemplos_php/controlador/controlador_3.php?valor1=2&valor2=10


if (isset($_GET['valor1']) && isset($_GET['valor2'])) {
    
    $resultado = $_GET['valor1'] + $_GET['valor2'];

    echo "El resultado de la suma es ". $resultado;
} else {
    
    echo "Por favor, ingrese el valor1 y valor2 en la URL.";
}

?>