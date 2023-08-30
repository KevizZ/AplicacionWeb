<?php
  include("Conexion.php");

  class RepositorioIncidentes{
    private $pdo;

    public function __construct(){
      $conexion = new Conexion();
      $this->pdo = $conexion->getConexion();
    }

    public function obtenerIncidentes(){
      $Incidentes = [];
      $stmt = $this->pdo->query("SELECT * FROM incidente");

      while($row = $stmt->fetch()){
        array_push($Incidentes, new Incidente( 
          $row['descripcion'],
          $row['prioridad'],
          $row['fecha'],
          $row['estado'],
          $row['id']
        ));
      }
      
      return $Incidentes;
    }
  }
  
?>