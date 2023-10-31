<?php
class Usuario
{

    private $cedula;
    private $nombre;
    private $apellido;
    private $correo;
    private $contraseña;
    private $cargo;
    private $id;

    function __construct($cedula, $nombre, $apellido, $contraseña, $correo, $id = "0")
    {
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->contraseña = $contraseña;
        $this->correo = $correo;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
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
    public function getContraseña()
    {
        return $this->contraseña;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function getCargo()
    {
        return $this->cargo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }
}
?>