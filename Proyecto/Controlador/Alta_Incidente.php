<?php
include_once("../Negocio/Incidente.php");
include_once("../Repositorio/Database.php");

$Incidente = new Incidente($_POST["fecha"], $_POST["descripcion"], $_POST["prioridad"], $_POST["estado"]);
$Incidente->setCategoria($_POST["categoria"]);

// Obtén los datos del archivo subido
$nombreArchivo = $_FILES['archivo']['name'];
$tempArchivo = $_FILES['archivo']['tmp_name'];


// Verifica si se subió un archivo
if (!empty($nombreArchivo) && !empty($tempArchivo)) {
    // Define una ubicación donde guardar el archivo (por ejemplo, una carpeta en tu servidor)
    $directorioDestino = '../Archivos/';

    // Verifica si el directorio de destino existe, si no, créalo
    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }

    // Genera un nombre único para el archivo para evitar colisiones
    $nombreArchivoFinal = $directorioDestino . uniqid() . '_' . $nombreArchivo;

    $Incidente->setArchivo($nombreArchivoFinal);
    // Guardo el nombre del archivo en la Base de Datos y lo relaciono con el incidente
    BD::setArchivoIncidente($Incidente);

    if (move_uploaded_file($tempArchivo, $nombreArchivoFinal)) {
        echo 'Archivo subido con éxito y guardado en la base de datos.';
    } else {
        echo 'Error al subir el archivo.';
    }
} else {
    echo 'No se seleccionó ningún archivo.';
}


header("location: Index_Incidente.php");



?>