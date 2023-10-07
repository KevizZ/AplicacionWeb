<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Incidentes</title>
    <link rel="stylesheet" href="../Static/estilo.css">
    <link rel="stylesheet" type="text/css" href="../Static/estilo_menu.css">
</head>

<body>
    <div class="container">
        <h1>Registro de Incidentes</h1>
        <form name="incident-form" method="post" enctype="multipart/form-data">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" required>

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
                <option value="Abierto">Activo</option>
                <option value="Cerrado">Cerrado</option>
                <option value="Pendiente">Pendiente</option>
            </select>

            <label for="archivo">Seleccionar Archivo:</label>
            <input type="file" name="archivo" id="archivo" required>
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
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los incidentes -->
                <?php
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
                        <td><button class='btn-modificar'><a href='Descargar_Archivo.php?archivo=" . $I->getArchivo() . "'>Archivo</a></button></td> 
                        <td><button class='btn-modificar'><a href='Modificar_Incidente.php?id_incidente=" . $I->getID() . "'>Modificar</a></button></td>
                        <td><button class='btn-eliminar'><a href='Baja_Incidente.php?id_incidente=" . $I->getID() . "'>Eliminar</a></button></td>
                        <td><button class='btn-evento'><a href='Index_Evento.php?id_incidente=" . $I->getID() . "'>Eventos</a></button></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="area"></div>
    <nav class="main-menu">
        <ul>
            <li>
                <a href="#">
                    <i class="fa fa-user fa-2x"></i>
                    <span class="nav-text">
                        Perfil
                    </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="Index_Incidente.php">
                    <i class="fa fa-file fa-2x"></i>
                    <span class="nav-text">
                        Ingresar Incidente
                    </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fa-book fa-2x"></i>
                    <span class="nav-text">
                        Incidentes
                    </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fa-camera-retro fa-2x"></i>
                    <span class="nav-text">
                        Survey Photos
                    </span>
                </a>

            </li>
            <li>
                <a href="#">
                    <i class="fa fa-film fa-2x"></i>
                    <span class="nav-text">
                        Surveying Tutorials
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-book fa-2x"></i>
                    <span class="nav-text">
                        Surveying Jobs
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-cogs fa-2x"></i>
                    <span class="nav-text">
                        Tools & Resources
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-map-marker fa-2x"></i>
                    <span class="nav-text">
                        Member Map
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-info fa-2x"></i>
                    <span class="nav-text">
                        Documentation
                    </span>
                </a>
            </li>
        </ul>

        <ul class="logout">
            <li>
                <a href="#">
                    <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>

</html>