<?php
include_once("../Repositorio/Repositorio.php");

class Evento
{
    private $fecha;
    private $descripcion;
    private $tipo;
    private $id;
    private $archivo;

    function __construct($f, $d, $id = 0)
    {
        $this->fecha = $f;
        $this->descripcion = $d;
        $this->id = $id;
    }

    public function insertEvento($incidente_id)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=proyecto", "root", "");

        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO evento (descripcion, fecha, incidente_id) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $this->descripcion,
            $this->fecha,
            $incidente_id
        ]);

        // Obtener el último ID insertado
        $lastId = $pdo->lastInsertId();

        $query = "INSERT INTO tipoevento(id,tipo) VALUES (?,?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $lastId,
            $this->tipo
        ]);

        return $lastId;
    }


    public static function deleteEvento($incidente_id)
    {

        $conexion = new Conexion();

        // Paso 1: Obtener el nombre del archivo asociado al evento
        $query = "SELECT archivo.nombre as nombre
        FROM evento
        LEFT JOIN archivo_evento ON evento.id = archivo_evento.evento_id
        LEFT JOIN archivo ON archivo_evento.archivo_id = archivo.id
        WHERE evento.incidente_id = ?";
        $stmt = $conexion->getConexion()->prepare($query);
        $stmt->execute([$incidente_id]);

        // Verifica si la consulta devolvió algún resultado
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nombreArchivo = $row['nombre'];
        } else {
            // La consulta no devolvió ningún resultado, maneja esta situación según tus necesidades
            $nombreArchivo = "Archivo no encontrado"; // Un mensaje predeterminado o lo que desees mostrar
        }


        $query = "DELETE FROM tipoEvento WHERE id = ?;";

        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([$incidente_id]);


        $query = "DELETE FROM evento WHERE id = ?";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([$incidente_id]);

        // Paso 3: Eliminar el archivo de la base de datos
        if (!empty($nombreArchivo)) {
            // Verifica que se haya obtenido un nombre de archivo válido
            $queryEliminarArchivo = "DELETE FROM archivo WHERE nombre = ?";
            $stmtEliminarArchivo = $conexion->getConexion()->prepare($queryEliminarArchivo);
            $stmtEliminarArchivo->execute([$nombreArchivo]);

            // Paso 4: Eliminar el archivo físico del sistema de archivos
            $rutaArchivo = $nombreArchivo;

            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo); // Elimina el archivo físico
            } else {
                echo "Archivo no encontrado";
            }
        }

    }

    public function getFecha()
    {
        return $this->fecha;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getArchivo()
    {
        return $this->archivo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;
    }

    public static function getEventos($id)
    {
        $rep = new Repositorio;
        return $rep->obtenerEventos($id);
    }
}

?>