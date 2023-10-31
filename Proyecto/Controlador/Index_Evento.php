<?php require_once("Verificador.php");
require_once("Menu_Lateral.php");
require_once("../Repositorio/Database.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Eventos</title>
    <!-- Incluir CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-secondary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="text-center text-white">Gestión de Eventos</h1>
            <form name="event-form" class="col-md-6 bg-light rounded shadow" action="Alta_Evento.php" method="post"
                enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="1" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Evento</label>
                    <select class="form-select" name="tipo">
                        <option value=""></option>
                        <?php
                        $opcionesPersonalizadas = BD::getTiposEvento();
                        // Agrega las opciones personalizadas recuperadas de la base de datos al select
                        foreach ($opcionesPersonalizadas as $opcion) {
                            echo "<option value='" . $opcion . "'>" . $opcion . "</option>";
                        }
                        ?>
                    </select>
                    <input type="text" class="form-control" name="tipo_personalizado" placeholder="Tipo Personalizado">

                </div>

                <div class="mb-3">
                    <label for="archivo" class="form-label">Seleccionar Archivo</label>
                    <input type="file" class="form-control" name="archivo" id="archivo" required>
                </div>
                <input type="hidden" name="id_incidente" value="<?php echo $_GET['id_incidente']; ?>">

                <div class="text-center mt-3 mb-3">
                    <button type="submit" class="btn btn-primary">Agregar Evento</button>
                </div>
            </form>
        </div>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Archivo</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once("../Negocio/Evento.php");

                $Eventos = Evento::getEventos($_GET['id_incidente']);

                foreach ($Eventos as $E) {
                    echo "<tr>
                        <td>" . $E->getID() . "</td>
                        <td>" . $E->getFecha() . "</td>
                        <td>" . $E->getTipo() . "</td>
                        <td><div class='overflow-auto' style='white-space: nowrap;'>" . $E->getDescripcion() . "</div></td>
                        <td>
                            <a class='btn btn-primary' target='_blank' href='" . $E->getArchivo() . "'>
                            <i class='bi bi-eye'></i></a>
                            <a class='btn btn-success' href='Descargar_Archivo.php?archivo=" . $E->getArchivo() . "'>
                            <i class='bi bi-download'></i></a>
                        </td>
                        <td>
                        <a  class='btn btn-danger' href='Baja_Evento.php?id=" . $E->getID() . "&id_incidente=" . $_GET['id_incidente'] . "'>Eliminar
                        <i class='bi bi-trash'></i></a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Incluir JS de Bootstrap 5 al final del archivo -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>