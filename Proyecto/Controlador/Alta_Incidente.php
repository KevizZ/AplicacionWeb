<?php
include("../Negocio/Incidente.php");



$NuevoIncidente = new Incidente($_POST["fecha"], $_POST["descripcion"], $_POST["prioridad"], $_POST["estado"]);
$NuevoIncidente->setCategoria($_POST["categoria"]);

    // Obtén los datos del archivo subido
    $nombreArchivo = $_FILES['archivo']['name'];
    $tempArchivo = $_FILES['archivo']['tmp_name'];
    
    $pdo = new PDO("mysql:host=localhost;dbname=proyecto", "root", "");
    
    
    // Genera un nombre único para el archivo para evitar colisiones
    
    // Verifica si se subió un archivo
    if (!empty($nombreArchivo) && !empty($tempArchivo)) {
        // Define una ubicación donde guardar el archivo (por ejemplo, una carpeta en tu servidor)
        $directorioDestino = '../Archivos/';
    
        // Verifica si el directorio de destino existe, si no, créalo
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }
    
        $nombreArchivoFinal = $directorioDestino . uniqid() . '_' . $nombreArchivo;
    
        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO archivo (nombre) VALUES (?)";
        $statement = $pdo->prepare($query);
    
        $statement->execute([
            $nombreArchivoFinal
    
        ]);
    
        $lastId = $pdo->lastInsertId();
    
        $query = "INSERT INTO archivo_incidente (archivo_id, incidente_id) VALUES (?,?)";
        $statement = $pdo->prepare($query);
    
        $statement->execute([
            $lastId,
            $NuevoIncidente->insertIncidente()
        ]);
    
    
    
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