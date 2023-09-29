<?php
include_once("../Repositorio/Repositorio.php");

class Evento
{
    private $fecha;
    private $descripcion;
    private $tipo;
    private $id;

    function __construct($f, $d, $id = 0)
    {
        $this->fecha = $f;
        $this->descripcion = $d;
        $this->id = $id;
    }

    public function insertEvento($incidente_id)
    {
        $conexion = new Conexion();

        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO evento (descripcion, fecha, incidente_id) VALUES (?, ?, ?)";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([
            $this->descripcion,
            $this->fecha,
            $incidente_id
        ]);

        $pdo = new PDO('mysql:host=test;dbname=proyecto', 'root', '');
        $pdo->exec("INSERT INTO evento (descripcion, fecha, incidente_id) VALUES (?, ?, ?)");

        $evento_id = "SELECT LAST_INSERT_ID() FROM ?";

        $statement = $conexion->getConexion()->prepare($evento_id);

        $statement->execute([
            "evento"
        ]);
        
        // Después, inserta un registro en la tabla tipoevento
        $query = "INSERT INTO tipoevento (id, tipo) VALUES (?, ?)";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([
            $evento_id,
            $this->tipo
        ]);
    }


    public static function deleteEvento($evento_id)
    {
        $conexion = new Conexion();

        $query = "DELETE FROM tipoEvento WHERE id IN (SELECT id FROM evento WHERE id = ?);";

        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([$evento_id]);


        $query = "DELETE FROM evento WHERE id = ?";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([$evento_id]);

        // Selecciono los elemetnos de TipoEvento que esten asociados a los eventos con el id correspondiente


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

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public static function getEventos()
    {
        $rep = new Repositorio;
        return $rep->obtenerEventos();
    }
}

?>