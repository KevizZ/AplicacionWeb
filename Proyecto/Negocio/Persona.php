<?php
class Persona
{
    private $cedula;
    private $nombre;
    private $apellido;
    private $id;
    private $rol;
    private $cantidadIncidentes;
    function __construct($cedula, $nombre, $apellido, $id = '0')
    {
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getRol()
    {
        return $this->rol;
    }
    public function getCedula()
    {
        return $this->cedula;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }
    public function setRol($rol)
    {
        $this->rol = $rol;
    }
    public function getCantidadIncidentes()
    {
        return $this->cantidadIncidentes;
    }
    public function setCantidadIncidentes($incidentes)
    {
        $this->cantidadIncidentes = $incidentes;
    }
}
?>