<?php
include("../Repositorio/Repositorio.php");
include("../Negocio/Evento.php");

class Incidente
{

    private $id;
    private $descripcion;
    private $prioridad;
    private $fecha;
    private $estado;
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

    public function addEvento($evento)
    {
        
    }

    public function removeEvento()
    {

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