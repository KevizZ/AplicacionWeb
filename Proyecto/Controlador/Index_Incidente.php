<?php require_once("Verificador.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Incidentes</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Registro de Incidentes</h1>
        <form name="incident-form" method="post" enctype="multipart/form-data">
            <label for="fecha" name="fecha">Fecha</label>
            <input type="date" name="fecha" required>

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" rows="4" cols="50" required></textarea>

            <label for="categoria">Categoria</label>
            <select name="categoria" required>
                <option value="">Seleccione un estado</option>
                <option value="Robo">Robo</option>
                <option value="Acoso">Acoso</option>
                <option value="Pelea">Pelea</option>
            </select>

            <label for="prioridad">Prioridad</label>
            <select name="prioridad" required>
                <option value="">Seleccione una prioridad</option>
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
            </select>

            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="">Seleccione un estado</option>
                <option value="Activo">Activo</option>
                <option value="Cerrado">Cerrado</option>
                <option value="Pendiente">Pendiente</option>
            </select>

            <label for="archivo">Seleccionar Archivo</label>
            <input type="file" name="archivo" id="archivo">
            <br>
            <br>
            <button type="submit" formaction="Alta_Incidente.php">Agregar Incidente</button>
        </form>
        <table name="incident-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Archivo</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                    <th>Eventos</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los incidentes -->
                <?php
                require 'Menu_Lateral.php';
                require 'Estilo.php';
                include("../Negocio/Incidente.php");

                $Incidentes = Incidente::obtenerIncidentes();



                foreach ($Incidentes as $I) {
                    echo "<tr>
                        <td>" . $I->getID() . "</td>
                        <td>" . $I->getDescripcion() . "</td>
                        <td>" . $I->getCategoria() . "</td>
                        <td>" . $I->getPrioridad() . "</td>
                        <td>" . $I->getFecha() . "</td>
                        <td>" . $I->getEstado() . "</td>
                        <td><button class='btn-modificar'><a target='_blank'href='" . $I->getArchivo() . "'>Ver</a></button>
                        <button class='btn-modificar'><a href='Descargar_Archivo.php?archivo=" . $I->getArchivo() . "'>Descargar</a></button></td> 
                        <td><button class='btn-modificar'><a href='Modificar_Incidente.php?id_incidente=" . $I->getID() . "'>Modificar</a></button></td>
                        <td><button class='btn-eliminar'><a href='Baja_Incidente.php?id_incidente=" . $I->getID() . "'>Eliminar</a></button></td>
                        <td><button class='btn-evento'><a href='Index_Evento.php?id_incidente=" . $I->getID() . "'>Eventos</a></button></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    </hmtl>