<?php
include_once("../Negocio/Incidente.php");
include_once("../Repositorio/Database.php");

$incidente_id = $_GET["id_incidente"]; // Asegúrate de obtener el ID del evento desde la URL correctamente

$archivo_evento = BD::unsetEventoPorIncidente($incidente_id);

$archivo_incidente = BD::unsetIncidente($incidente_id);

unlink($archivo_evento);
unlink($archivo_incidente);




header("location: Index_Incidente.php")



    ?>