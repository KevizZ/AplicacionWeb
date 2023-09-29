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
        <form name="incident-form" action="Alta_Incidente.php" method="get">
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
            <button type="submit">Agregar Incidente</button>
        </form>
        <table name="incident-table">
            <thead>
            <tr>
                    <th>Indice</th>
                    <th>Descripcion</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
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
                        <td>" . $I->getFecha() . "</td>
                        <td>" . $I->getDescripcion() . "</td>
                        <td>" . $I->getPrioridad() . "</td>
                        <td>" . $I->getEstado() . "</td>
                        <td><button class='btn-modificar'><a href='Modificar_Incidente.
                        php?id=".$I->getID()."'>Modificar</a></button></td> 
                        <td><button class='btn-eliminar'><a href='Baja_Incidente.php?id=".$I->getID()."'>Eliminar</a></button></td>
                        <td><button class='btn-evento'><a href='Index_Evento.php?id=".$I->getID()."'>Eventos</a></button></td>
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
                <a href="https://jbfarrow.com">
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Perfil
                    </span>
                </a>
    
            </li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fa-globe fa-2x"></i>
                    <span class="nav-text">
                        Global Surveyors
                    </span>
                </a>
    
            </li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fa-comments fa-2x"></i>
                    <span class="nav-text">
                        Group Hub Forums
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