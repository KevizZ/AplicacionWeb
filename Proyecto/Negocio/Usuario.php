<?php
class Usuario{

    private $identificacion;
    private $nombre;
    private $contraseña;

    function __construct($i,$n,$c){
        $this->identificacion = $i;
        $this->nombre = $n;
        $this->contraseña = $c;
    }

    public function getIdentificacion(){
        return $this->identificacion;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getContraseña(){
        return $this->contraseña;
    }
}
?>