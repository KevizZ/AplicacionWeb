<?php
include("../Negocio/Evento.php");

    $Evento = new Evento($_GET["fecha"],$_GET["descripcion"]);
    $Evento->setTipo($_GET["tipo"]);

    $Evento->insertEvento($_GET["id"]);

?>