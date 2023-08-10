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
      $stmt = $this->pdo->query("SELECT * FROM datos");

      while($row = $stmt->fetch()){
        array_push($Incidentes, new Incidente( 
          $row['titulo'],
          $row['descripcion'],
          $row['categoria'],
          $row['gravedad'],
          $row['fecha'],
          $row['estado'],
          $row['id']
        ));
      }
      
      return $Incidentes;
    }
  }
  
?>