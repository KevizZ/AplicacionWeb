<?php require_once("Verificador.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Eventos</title>
</head>

<body>
    <div class="container">
        <h1>Gestión de Eventos</h1>
        <form name="incident-form" action="Alta_Evento.php" method="post" enctype="multipart/form-data">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" required>

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" rows="4" cols="50" required></textarea>

            <label for="tipo">Tipo de Evento</label>
            <select name="tipo" required>
                <option value=""></option>
                <option value="Reunion">Reunion</option>
                <option value="Resolucion">Resolucion</option>
                <option value="Entrevista">Entrevista</option>
            </select>

            <label for="archivo">Seleccionar Archivo</label>
            <input type="file" name="archivo" id="archivo" required>

            <input type="hidden" name="id_incidente" value="<?php echo $_GET["id_incidente"]; ?>">
            <br>
            <br>
            <button type="submit">Agregar Evento</button>
        </form>

        <table name="incident-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Descripcion</th>
                    <th>Archivo</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los incidentes -->
                <?php
                require 'Menu_Lateral.php';
                require 'Estilo.php';
                include("../Negocio/Evento.php");

                $Eventos = Evento::getEventos($_GET["id_incidente"]);

                foreach ($Eventos as $E) {
                    echo "<tr>
                        <td>" . $E->getID() . "</td>
                        <td>" . $E->getFecha() . "</td>
                        <td>" . $E->getTipo() . "</td>
                        <td>" . $E->getDescripcion() . "</td>
                        <td><button class='btn-modificar'><a target='_blank'href='" . $E->getArchivo() . "'>Ver</a></button>
                        <button class='btn-modificar'><a href='Descargar_Archivo.php?archivo=" . $E->getArchivo() . "'>Descargar</a></button></td> 
                        <td><button class='btn-eliminar'><a href='Baja_Evento.php?id=" . $E->getID() . "&id_incidente=" . $_GET['id_incidente'] . "'>Eliminar</a></button></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>