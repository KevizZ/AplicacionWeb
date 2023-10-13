<?php
// Obtén el identificador del archivo desde la consulta (por ejemplo, el nombre del archivo)
$identificador = $_GET['archivo'];


// Determina la ubicación del archivo en el servidor
$rutaArchivo =  $identificador;

// Verifica si el archivo existe
if (file_exists($rutaArchivo)) {
    // Configura las cabeceras para la descarga
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($rutaArchivo) . '"');
    header('Content-Length: ' . filesize($rutaArchivo));

    // Lee y envía el contenido del archivo al navegador
    readfile($rutaArchivo);
} else {
    // Si el archivo no existe, muestra un mensaje de error o redirige a una página de error
    echo 'El archivo no existe.';
    echo $identificador; 
}
?>
