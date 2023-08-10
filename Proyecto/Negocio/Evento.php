<?php
class Evento
{
    private $fecha;
    private $descripcion;
    private $estado;

    function __construct($f, $d, $e)
    {
        $this->fecha = $f;
        $this->descripcion = $d;
        $this->estado = $e;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getEstado()
    {
        return $this->estado;
    }
}

?>