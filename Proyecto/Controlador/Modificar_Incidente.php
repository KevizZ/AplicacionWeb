<?php
include("../Negocio/Incidente.php");


if (isset($_GET["submit"])) {

    $IncidenteModificado = new Incidente($_GET["fecha"], $_GET["descripcion"], $_GET["prioridad"], $_GET["estado"]);
    $id = $_GET["id"];

    $sentencia = "UPDATE incidente SET  descripcion = ?, prioridad = ?, fecha = ?, estado = ? WHERE id = ?";
    $conexion = new Conexion();

    $consulta = $conexion->getConexion()->prepare($sentencia);

    $consulta->execute([
        $IncidenteModificado->getDescripcion(),
        $IncidenteModificado->getPrioridad(),
        $IncidenteModificado->getFecha(),
        $IncidenteModificado->getEstado(),
        $id
    ]);

}

?>

<div class="container">
    <h1>Modificar Incidente</h1>
    <form name="incident-form" method="get">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" required>

        <label for="prioridad">Prioridad</label>
        <select name="prioridad" required>
            <option value="">Seleccione un estado</option>
            <option value="Alta">Alta</option>
            <option value="Media">Media</option>
            <option value="Baja">Baja</option>
        </select>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="">Seleccione un estado</option>
            <option value="Abierto">Activo</option>
            <option value="Cerrado">Cerrado</option>
            <option value="Pendiente">Pendiente</option>
        </select>
        <br>
        <br>
        <button type="submit" name="submit">Modificar</button>
    </form>


    <style href="../Static/estilo.css">

    </style>