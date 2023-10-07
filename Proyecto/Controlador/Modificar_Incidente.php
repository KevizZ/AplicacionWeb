<?php
include("../Negocio/Incidente.php");

$NuevoIncidente = new Incidente($_POST["fecha"], $_POST["descripcion"], $_POST["prioridad"], $_POST["estado"]);
$NuevoIncidente->setCategoria($_POST["categoria"]);

$Incidente->updateIncidente($_GET["id_incidente"]);

header("location: Index_Incidente.php");
?>