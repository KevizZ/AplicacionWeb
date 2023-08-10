<?php
include("../Repositorio/Repositorio_Incidentes.php");

class Incidente
{

    private $id;
    private $titulo;
    private $descripcion;
    private $categoria;
    private $gravedad;
    private $fecha;
    private $estado;
    private $Eventos = array();
    private $Usuarios = array();

    public function __construct($titulo, $descripcion, $categoria, $gravedad, $fecha, $estado, $id = '0')
    {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->gravedad = $gravedad;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->id = $id;
    }

    public function agregarEvento($evento)
    {

    }

    public function eliminarEvento()
    {

    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getGravedad()
    {
        return $this->gravedad;
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
        $rep = new RepositorioIncidentes;
        return $rep->obtenerIncidentes();
    }
}
?>