<?php require_once("Verificador.php");
require 'Menu_Lateral.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Incidentes</title>
    <!-- Incluir CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Estilo.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mt-3">Registro de Incidentes</h1>
        <form name="incident-form" method="post" enctype="multipart/form-data" class="mt-3">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" name="categoria" required>
                    <option value="">Seleccione una categoría</option>
                    <option value="Robo">Robo</option>
                    <option value="Acoso">Acoso</option>
                    <option value="Pelea">Pelea</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select class="form-select" name="prioridad" required>
                    <option value="">Seleccione una prioridad</option>
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select class="form-select" name="estado" required>
                    <option value="">Seleccione un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Cerrado">Cerrado</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="archivo" class="form-label">Seleccionar Archivo</label>
                <input type="file" class="form-control" name="archivo" id="archivo">
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary" formaction="Alta_Incidente.php">Agregar Incidente</button>
            </div>
        </form>
        <table class="table table-striped table-hover  align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Archivo</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                    <th>Eventos</th>
                    <th>Involucrados</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los incidentes -->
                <?php
                include_once("../Negocio/Incidente.php");

                $Incidentes = Incidente::obtenerIncidentes();

                foreach ($Incidentes as $I) {
                    echo "<tr>
                        <td>" . $I->getID() . "</td>
                        <td><div class='overflow-auto'>" . $I->getDescripcion() . "</div></td>
                        <td>" . $I->getCategoria() . "</td>
                        <td>" . $I->getPrioridad() . "</td>
                        <td>" . $I->getFecha() . "</td>
                        <td>" . $I->getEstado() . "</td>
                        <td>
                        <a class='btn btn-primary' target='_blank' href='" . $I->getArchivo() . "'>Ver <i class='bi bi-eye'></i></a>
                        <a class='btn btn-success' href='Descargar_Archivo.php?archivo=" . $I->getArchivo() . "'>Descargar <i class='bi bi-download'></i></a>
                    </td>
                    <td><a class='btn btn-warning' href='Index_Modificar-Incidente.php?id_incidente=" . $I->getID() . "'>Modificar <i class='bi bi-pencil'></i></a></td>
                    <td><a class='btn btn-danger' href='Baja_Incidente.php?id_incidente=" . $I->getID() . "'>Eliminar <i class='bi bi-trash'></i></a></td>
                    <td><a class='btn btn-info' href='Index_Evento.php?id_incidente=" . $I->getID() . "'>Eventos <i class='bi bi-calendar'></i></a></td>
                    <td><a class='btn btn-warning' href='Index_Buscador-Persona.php?id_incidente=" . $I->getID() . "'>Gestionar <i class='bi bi-people-fill'></i></i></a></td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Incluir JS de Bootstrap 5 al final del archivo -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
<style>
    .table td {
        max-width: 300px;
        /* Define el ancho máximo de todas las celdas de la tabla */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>


</html>