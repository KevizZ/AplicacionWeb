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
    }


    public static function deleteEvento($evento_id)
    {
        $conexion = new Conexion();

        $query = "DELETE FROM tipoEvento WHERE id = ?;";

        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([$evento_id]);


        $query = "DELETE FROM evento WHERE id = ?";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([$evento_id]);


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

    public static function getEventos($id)
    {
        $rep = new Repositorio;
        return $rep->obtenerEventos($id);
    }
}

?>