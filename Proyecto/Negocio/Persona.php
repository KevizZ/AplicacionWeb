<?php
class Persona{

    private $cedula;
    private $nombre;
    private $apellido;

    function __construct($nombre,$cedula,$apellido){
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    public function getCedula(){
        return $this->cedula;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function geApellido(){
        return $this->apellido;
    }
}
?>