<?php require_once("Verificador.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Buscar Incidentes</title>
</head>

<body>
    <h1>Buscar Incidentes</h1>
    <form method="POST">
        <label for="fecha_inicio">Desde</label>
        <input type="date" name="fecha_inicio">

        <label for="fecha_fin">Hasta</label>
        <input type="date" name="fecha_fin">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" rows="4" cols="50"></textarea>

        <label for="categoria">Categoria</label>
        <select name="categoria">
            <option value="">Seleccione una categoría</option>
            <option value="Robo">Robo</option>
            <option value="Acoso">Acoso</option>
            <option value="Pelea">Pelea</option>
        </select>

        <label for="prioridad">Prioridad</label>
        <select name="prioridad">
            <option value="">Seleccione una prioridad</option>
            <option value="Alta">Alta</option>
            <option value="Media">Media</option>
            <option value="Baja">Baja</option>
        </select>

        <label for="estado">Estado</label>
        <select name="estado">
            <option value="">Seleccione un estado</option>
            <option value="Activo">Activo</option>
            <option value="Cerrado">Cerrado</option>
            <option value="Pendiente">Pendiente</option>
        </select>

        <button type="submit" value="Buscar">Buscar</button>
    </form>

    <?php
    include("../Negocio/Incidente.php");
    require "Menu_Lateral.php";
    require "Estilo.php";

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
            LEFT JOIN archivo ON archivo_incidente.incidente_id = archivo.id
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
    echo "<p>Resultados de la búsqueda ($numResultados)</p>";
    echo "<table name='incident-table'>
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

    echo "</tbody>
        </table>";
    ?>
</body>

</html>