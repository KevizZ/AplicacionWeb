<?php
require_once("Verificador.php");
require_once("Menu_Lateral.php");
require_once("../Repositorio/Repositorio.php");
require_once("../Repositorio/Database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Static/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Incidente</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Modificar Incidente</h1>
        <form name="incident-form" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" name="descripcion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria" class="form-select" required>
                    <option value="">Seleccione una categoría</option>
                    <option value="Robo">Robo</option>
                    <option value="Acoso">Acoso</option>
                    <option value="Pelea">Pelea</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select name="prioridad" class="form-select" required>
                    <option value="">Seleccione una prioridad</option>
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select name="estado" class="form-select" required>
                    <option value="">Seleccione un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Cerrado">Cerrado</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="archivo" class="form-label">Seleccionar Archivo:</label>
                <input type="file" name="archivo" id="archivo" class="form-control" required>
            </div>

            <input type="hidden" name="id_incidente" value="<?php echo $_GET["id_incidente"]; ?>">
            <br>
            <br>
            <button type="submit" name="enviar" class="btn btn-primary">Actualizar</button>
        </form>

        <?php
        include_once("../Negocio/Incidente.php");
        include_once("../Repositorio/Database.php");

        $id = $_GET["id_incidente"];
        $incidente = BD::getIncidente($id);

        // Imprime los valores del objeto como variables JavaScript
        echo '<script>';
        echo 'var fecha = "' . $incidente->getFecha() . '";';
        echo 'var descripcion = "' . $incidente->getDescripcion() . '";';
        echo 'var categoria = "' . $incidente->getCategoria() . '";';
        echo 'var prioridad = "' . $incidente->getPrioridad() . '";';
        echo 'var estado = "' . $incidente->getEstado() . '";';
        echo '</script>';

        if (isset($_POST["enviar"])) {
            $Incidente = new Incidente($_POST["fecha"], $_POST["descripcion"], $_POST["prioridad"], $_POST["estado"]);
            $Incidente->setCategoria($_POST["categoria"]);

            $nombreArchivo = BD::getArchivoIncidente($id);
            $rutaArchivo = $nombreArchivo;
            unlink($rutaArchivo);

            $nombreArchivo = $_FILES['archivo']['name'];
            $tempArchivo = $_FILES['archivo']['tmp_name'];
            $directorioDestino = '../Archivos/';
            $nombreArchivoFinal = $directorioDestino . uniqid() . '_' . $nombreArchivo;

            move_uploaded_file($tempArchivo, $nombreArchivoFinal);

            $Incidente->setArchivo($nombreArchivoFinal);
            BD::updateIncidente($Incidente, $id);
        }
        ?>

        <script>
            // Espera a que se cargue el DOM antes de ejecutar la función
            document.addEventListener("DOMContentLoaded", function () {
                cambiarValores();
            });

            function cambiarValores() {
                // Accede a los elementos del formulario por su nombre
                var fechaElement = document.getElementsByName("fecha")[0];
                var descripcionElement = document.getElementsByName("descripcion")[0];
                var categoriaElement = document.getElementsByName("categoria")[0];
                var prioridadElement = document.getElementsByName("prioridad")[0];
                var estadoElement = document.getElementsByName("estado")[0];
                var archivoElement = document.getElementsByName("archivo")[0];

                // Asigna los valores de JavaScript a los elementos del formulario
                fechaElement.value = fecha;
                descripcionElement.value = descripcion;
                categoriaElement.value = categoria;
                prioridadElement.value = prioridad;
                estadoElement.value = estado;
                archivoElement.value = ''; // Establecer el valor de un input de tipo "file" no es seguro debido a problemas de seguridad
            }
        </script>
    </div>
</body>

</html>