<?php 
include 'Usuario.php';

$personas = array(
    new Usuario("Lucas", 20),
    new Usuario("Juan", 30)); 

    for($i = 0; $i < count($personas); $i++){
    echo "Nombre: ". $personas[$i]->getNombre() . "<br> Edad: ". $personas[$i]->getEdad(). "<br><br>";
}

?>