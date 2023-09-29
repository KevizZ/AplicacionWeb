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
    private $Eventos = array();
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

        $conexion = new Conexion();
        $query = "INSERT INTO incidente (fecha, descripcion, prioridad, estado) VALUES (?, ?, ?, ?)";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([
            $this->fecha,
            $this->descripcion,
            $this->prioridad,
            $this->estado
        ]);
    }

    public function updateIncidente()
    {

        $conexion = new Conexion();
        $query = "UPDATE incidente 
        SET fecha = ?, descripcion = ?, prioridad = ?, estado = ? 
        WHERE id = $this->id";

        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([
            $this->fecha,
            $this->descripcion,
            $this->prioridad,
            $this->estado
        ]);
    }

    public static function deleteIncidente($incidente_id)
    {
        $conexion = new Conexion();
        
        $query = "DELETE FROM incidente WHERE id = ?";
        $stmt = $conexion->getConexion()->prepare($query);
        $stmt->execute([$incidente_id]);
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

    public static function obtenerIncidentes()
    {
        $rep = new Repositorio;
        return $rep->obtenerIncidentes();
    }
}
?>