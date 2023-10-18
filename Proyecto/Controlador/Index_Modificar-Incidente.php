<?php require_once("Verificador.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Static/estilo.css">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <h1>Modificar Incidente</h1>
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
                <option value="Activo">Activo</option>
                <option value="Cerrado">Cerrado</option>
                <option value="Pendiente">Pendiente</option>
            </select>

            <label for="archivo">Seleccionar Archivo:</label>
            <input type="file" name="archivo" id="archivo" required>

            <input type="hidden" name="id_incidente" value="<?php echo $_GET["id_incidente"]; ?>">
            <br>
            <br>
            <button type="submit" name="enviar">Actualizar</button>
        </form>

        <?php
        include_once("../Negocio/Incidente.php");
        require "Menu_Lateral.php";
        require 'Estilo.php';

        $id = $_GET["id_incidente"];

        $incidente = BD::getIncidente($id);

        // Imprime los valores del objeto como variables JavaScript
        echo '<script>';
        echo 'var fecha = "' . $incidente->getFecha() . '";';
        echo 'var descripcion = "' . $incidente->getDescripcion() . '";';
        echo 'var categoria = "' . $incidente->getCategoria() . '";';
        echo 'var prioridad = "' . $incidente->getPrioridad() . '";';
        echo 'var estado = "' . $incidente->getEstado() . '";';
        echo 'var archivo = "' . $incidente->getArchivo() . '";';
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
                archivoElement.value = archivo; // Este valor se establecerá en el input de tipo "file" (puede no tener el efecto deseado)
            }
        </script>

</body>

</html>