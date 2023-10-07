<?php
include("../Negocio/Evento.php");

    $Evento = new Evento($_POST["fecha"],$_POST["descripcion"]);
    $Evento->setTipo($_POST["tipo"]);

    $Evento->insertEvento($_POST["id_incidente"]);

    $id = $_POST["id_incidente"];
    $id_incidente = intval($id);
    header("location: Index_Evento.php?id_incidente=" . $id_incidente);
    exit;
?>