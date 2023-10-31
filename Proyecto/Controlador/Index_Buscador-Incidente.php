<?php require_once("Verificador.php");
require "Menu_Lateral.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Incidentes</title>
    <!-- Incluir CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Estilo.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-secondary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="text-center text-white">Buscador de Incidentes</h1>
            <form method="POST" class="col-md-6 mt-3 align-items-center bg-light rounded shadow">
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label">Desde</label>
                        <input type="date" class="form-control" name="fecha_inicio">
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_fin" class="form-label">Hasta</label>
                        <input type="date" class="form-control" name="fecha_fin">
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="1"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" name="categoria">
                            <option value="">Seleccione una categoría</option>
                            <option value="Robo">Robo</option>
                            <option value="Acoso">Acoso</option>
                            <option value="Pelea">Pelea</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="prioridad" class="form-label">Prioridad</label>
                        <select class="form-select" name="prioridad">
                            <option value="">Seleccione una prioridad</option>
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" name="estado">
                            <option value="">Seleccione un estado</option>
                            <option value="Activo">Activo</option>
                            <option value="Cerrado">Cerrado</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                    </div>

                    <div class="col-md-12 text-center mt-3 mb-3">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>


        <style>
        </style>
        <?php
        include_once("../Negocio/Incidente.php");

        $conn = new Conexion();

        $variables = ['descripcion', 'prioridad', 'categoria', 'estado', 'fecha_inicio', 'fecha_fin'];

        foreach ($variables as $variable) {
            if (isset($_POST[$variable])) {
                ${$variable} = $_POST[$variable];
            } else {
                ${$variable} = '';
            }

        }

        // Consulta SQL inicial
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id'; // Por defecto, se ordena por la columna 'id'
        $direction = 'ASC'; // Dirección ascendente por defecto
        
        if (isset($_GET['sort']) && $_GET['sort'] === $sort) {
            // Cambia la dirección si la misma columna se hace clic nuevamente
            $direction = $direction === 'ASC' ? 'DESC' : 'ASC';
        }

        $sql = "SELECT incidente.*, COUNT(incidente.id),categoria.categoria AS categoria, archivo.nombre as nombre
            FROM incidente
            LEFT JOIN categoria ON incidente.id = categoria.id
            LEFT JOIN archivo_incidente ON incidente.id = archivo_incidente.incidente_id
            LEFT JOIN archivo ON archivo_incidente.archivo_id = archivo.id
            WHERE 1 = 1"; // La condición "1 = 1" se usa como punto de partida para construir la consulta dinámicamente
        
        if (!empty($descripcion)) {
            $sql .= " AND descripcion LIKE '%$descripcion%'";
        }

        if (!empty($prioridad)) {
            $sql .= " AND prioridad = '$prioridad'";
        }

        if (!empty($categoria)) {
            $sql .= " AND categoria = '$categoria'";
        }

        if (!empty($estado)) {
            $sql .= " AND estado = '$estado'";
        }

        if (!empty($fecha_inicio)) {
            $sql .= " AND fecha >= '$fecha_inicio'";
        }

        if (!empty($fecha_fin)) {
            $sql .= " AND fecha <= '$fecha_fin'";
        }

        $sql .= " GROUP BY incidente.id ORDER BY $sort $direction"; // Agrega la ordenación a la consulta
        
        $stmt = $conn->getConexion()->query($sql);

        // Obtener el número de resultados
        $numResultados = $stmt->rowCount();

        // Resto del código para mostrar los resultados en una tabla
        echo "<p class='text-white'>Resultados de la búsqueda ($numResultados)</p>";
        echo "<table name='incident-table' class='table table-striped mt-4 align-middle'>
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
                    <th>Involucrados</th>
                </tr>
            </thead>
            <tbody>";

        $Incidentes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea un objeto Incidente
            $incidente = new Incidente(
                $row['fecha'],
                $row['descripcion'],
                $row['prioridad'],
                $row['estado'],
                $row['id']
            );

            // Agrega la propiedad "categoria" a tu objeto Incidente
            $incidente->setCategoria($row['categoria']);

            $incidente->setArchivo($row['nombre']);

            array_push($Incidentes, $incidente);
        }

        foreach ($Incidentes as $I) {
            echo "<tr>
                <td>" . $I->getID() . "</td>
                <td><div class='overflow-auto' style='white-space: nowrap;'>" . $I->getDescripcion() . "</div></td>
                <td>" . $I->getCategoria() . "</td>
                <td>" . $I->getPrioridad() . "</td>
                <td>" . $I->getFecha() . "</td>
                <td>" . $I->getEstado() . "</td>
                <td>
    <a class='btn btn-primary' target='_blank' href='" . $I->getArchivo() . "'><i class='bi bi-eye'></i></a>
    <a class='btn btn-success' href='Descargar_Archivo.php?archivo=" . $I->getArchivo() . "'> <i class='bi bi-download'></i></a>
</td>
<td><a class='btn btn-warning' href='Index_Modificar-Incidente.php?id_incidente=" . $I->getID() . "'>Modificar <i class='bi bi-pencil'></i></a></td>
<td><a class='btn btn-danger' href='Baja_Incidente.php?id_incidente=" . $I->getID() . "'>Eliminar <i class='bi bi-trash'></i></a></td>
<td><a class='btn btn-info' href='Index_Evento.php?id_incidente=" . $I->getID() . "'>Eventos <i class='bi bi-calendar'></i></a></td>
<td><a class='btn btn-warning' href='Index_Buscador-Persona.php?id_incidente=" . $I->getID() . "'>Gestionar <i class='bi bi-people-fill'></i></i></a></td>
</tr>
";
        }

        echo "</tbody>
            </table>";
        ?>

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