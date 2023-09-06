<?php
include("../Repositorio/Repositorio.php");

class Evento
{
    private $fecha;
    private $descripcion;
    private $tipo;
    private $id;

    function __construct($f, $d, $id)
    {
        $this->fecha = $f;
        $this->descripcion = $d;
        $this->id = $id;
    }

    public function setEvento()
    {
        $conexion = new Conexion();
        $query = "INSERT INTO evento (fecha, descripcion) VALUES (?, ?)";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([
            $this->getFecha(),
            $this->getDescripcion()
        ]);

        $query = "INSERT INTO tipoevento (tipo) VALUES (?,?)";
        $statement = $conexion->getConexion()->prepare($query);

        $statement->execute([
            $this->getID(),
            $this->getTipo()
        ]);
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

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public static function getEventos()
    {   
        $rep = new Repositorio;
        return $rep->obtenerEventos();
    }
}

?>