<?php 

include 'Usuario.php';

$personas = array (
    new Usuario("pepe",18),
    new Usuario("maria",18));

for ($i = 0;$i < count($personas); $i++) {
    echo $personas[$i]->getNombre() . " " . $personas[$i]->getEdad();
    echo '<br></br>';
    
}

?>