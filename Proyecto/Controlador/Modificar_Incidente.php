<?php
include("../Negocio/Incidente.php");


if (isset($_GET["submit"])) {

    $IncidenteModificado = new Incidente($_GET["fecha"], $_GET["descripcion"], $_GET["prioridad"], $_GET["estado"]);

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


    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            font-family: Verdana;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            font-size: 16px;
        }

        button {
            padding: 8px 16px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 40%;
        }

        .btn-eliminar {
            padding: 8px 16px;
            font-size: 16px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 40%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Estilos para el modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
        }

        .modal-contenido {
            background-color: #fff;
            width: 400px;
            max-width: 90%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 5px;

        }

        h2 {
            text-align: center;
            font-family: Verdana;

        }

        /* Estilos adicionales para el formulario de edición */
        #formularioEditar {
            margin-top: 20px;
        }

        #formularioEditar input,
        #formularioEditar textarea {
            width: 100%;
            margin-bottom: 10px;
        }

        #formularioEditar button {
            margin-top: 10px;
        }
    </style>