<?php
include("../Repositorio/Conexion.php");
class Usuario
{

    private $cedula;
    private $nombre;
    private $apellido;
    private $correo;
    private $contraseña;

    function __construct($cedula, $nombre, $apellido, $contraseña, $correo)
    {
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->contraseña = $contraseña;
        $this->correo = $correo;
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
}
?>