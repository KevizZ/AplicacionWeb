<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Static/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Registor de Eventos</h1>
        <form name="incident-form" action="Alta_Evento.php" method="get">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" required>

            <label for="tipo">Tipo de Evento:</label>
            <select name="tipo" required>
                <option value=""></option>
                <option value="Reunion">Reunion</option>
                <option value="Resolucion">Resolucion</option>
                <option value="Entrevista">Entrevista</option>
            </select>

            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            
            <br>
            <br>
            <button type="submit">Agregar Incidente</button>
        </form>

        <table name="incident-table">
            <thead>
            <tr>
                    <th>Indice</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Descripcion</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los incidentes -->
                <?php
                include("../Negocio/Evento.php");


                $Eventos = Evento::getEventos();

                foreach ($Eventos as $I) {
                    echo "<tr>
                        <td>" . $I->getID() . "</td>
                        <td>" . $I->getFecha() . "</td>
                        <td>" . $I->getTipo() . "</td>
                        <td>" . $I->getDescripcion() . "</td>
                        <td><button class='btn-modificar' onclick='cargarPagina('Modificar_Incidente.php'><a href='Modificar_Incidente.php?id=".$I->getID()."'>Modificar</a></button></td>  
                        <td><button class='btn-eliminar'><a href='Baja_Evento.php?id=".$I->getID()."'>Eliminar</a></button></td>
                        <td><button class='btn-evento' onclick='cargarPagina('Index_Evento.php?".$I->getID()."')><a href='Index_Evento.php?id=".$I->getID()."'>Eventos</a></button></td>
                        </tr>";
                }

                ?>
            </tbody>
        </table>
    </div>
</body>
</html>