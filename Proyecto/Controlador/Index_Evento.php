<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Evento</title>
    <link rel="stylesheet" href="../Static/estilo.css">
    <link rel="stylesheet" type="text/css" href="../Static/estilo_menu.css">
</head>
<body>
    <div class="container">
        <h1>Registor de Eventos</h1>
        <form name="incident-form" action="Alta_Evento.php" method="post">
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

            <input type="hidden" name="id_incidente" value="<?php echo $_GET["id_incidente"]; ?>">
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

                $Eventos = Evento::getEventos($_GET["id_incidente"]);

                foreach ($Eventos as $E) {
                    echo "<tr>
                        <td>" . $E->getID() . "</td>
                        <td>" . $E->getFecha() . "</td>
                        <td>" . $E->getTipo() . "</td>
                        <td>" . $E->getDescripcion() . "</td>
                        <td><button class='btn-modificar'><a href='Modificar_Evento.php?id=".$E->getID()."&id_incidente=".$_GET['id_incidente'] ."'>Modificar</a></button></td>  
                        <td><button class='btn-eliminar'><a href='Baja_Evento.php?id=".$E->getID()."&id_incidente=".$_GET['id_incidente'] ."'>Eliminar</a></button></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
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