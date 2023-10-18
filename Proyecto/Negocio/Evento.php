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