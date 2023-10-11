<?php
include_once("../Repositorio/Repositorio.php");
include_once("../Negocio/Evento.php");


class Incidente
{

    private $id;
    private $descripcion;
    private $prioridad;
    private $fecha;
    private $estado;
    private $categoria;
    private $archivo;
    private $Usuarios = array();


    public function __construct($fecha, $descripcion, $prioridad, $estado, $id = '0')
    {
        $this->descripcion = $descripcion;
        $this->prioridad = $prioridad;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->id = $id;
    }

    public function insertIncidente()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=proyecto", "root", "");

        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO incidente (fecha, descripcion, prioridad, estado) VALUES (?, ?, ?, ?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $this->fecha,
            $this->descripcion,
            $this->prioridad,
            $this->estado
        ]);

        // Obtener el último ID insertado
        $lastId = $pdo->lastInsertId();

        $query = "INSERT INTO categoria(id,categoria) VALUES (?,?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $lastId,
            $this->categoria
        ]);

        return $lastId;
    }

    public function updateIncidente($id)
    {
        $conexion = new Conexion();

        // Actualización de la tabla incidente
        $queryIncidente = "UPDATE incidente 
            SET fecha = ?, descripcion = ?, prioridad = ?, estado = ? 
            WHERE id = ?";
        $statementIncidente = $conexion->getConexion()->prepare($queryIncidente);

        $statementIncidente->execute([
            $this->fecha,
            $this->descripcion,
            $this->prioridad,
            $this->estado,
            $id
        ]);

        // Actualización de la tabla categoria (si es necesario)
        $queryCategoria = "UPDATE categoria SET categoria = ? WHERE id = ?";
        $statementCategoria = $conexion->getConexion()->prepare($queryCategoria);

        $statementCategoria->execute([
            $this->categoria,
            $id
        ]);

        $queryArchivo = "UPDATE archivo
        SET nombre = ?
        WHERE id IN (
            SELECT archivo_id
            FROM archivo_incidente
            WHERE incidente_id = ?
        );
        ";

        $statementArchivo = $conexion->getConexion()->prepare($queryArchivo);

        $statementArchivo->execute([
            $this->archivo,
            $id
        ]);
    }

    public static function deleteIncidente($incidente_id)
    {
        $conexion = new Conexion();

        // Paso 1: Obtener el nombre del archivo asociado al incidente
        $query = "SELECT archivo.nombre
                  FROM incidente
                  LEFT JOIN archivo_incidente ON incidente.id = archivo_incidente.incidente_id
                  LEFT JOIN archivo ON archivo_incidente.archivo_id = archivo.id
                  WHERE incidente.id = ?";
        $stmt = $conexion->getConexion()->prepare($query);
        $stmt->execute([$incidente_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombreArchivo = $row['nombre'];

        // Paso 2: Eliminar el incidente de la base de datos
        $queryEliminarIncidente = "DELETE FROM incidente WHERE id = ?";
        $stmtEliminarIncidente = $conexion->getConexion()->prepare($queryEliminarIncidente);
        $stmtEliminarIncidente->execute([$incidente_id]);

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
            }
        }
    }



    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrioridad()
    {
        return $this->prioridad;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
    public function getEstado()
    {
        return $this->estado;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }
    public function getArchivo()
    {
        return $this->archivo;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;
    }


    public static function obtenerIncidentes()
    {
        $rep = new Repositorio;
        return $rep->obtenerIncidentes();
    }
}
?>