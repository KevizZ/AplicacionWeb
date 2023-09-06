<?php
class Usuario{

    private $cedula;
    private $nombre;
    private $correo;
    private $contraseña;

    function __construct($nombre,$cedula,$correo,$contraseña){
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->contraseña = $contraseña;
        $this->correo = $correo;
    }

    public function getCedula(){
        return $this->cedula;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getContraseña(){
        return $this->contraseña;
    }
    public function getCorreo(){
        return $this->correo;
    }
}
?>