<?php
  include("Conexion.php");

  class Repositorio{
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
          $row['fecha'],
          $row['descripcion'],
          $row['prioridad'],
          $row['estado'],
          $row['id']
          
        ));
      }
      
      return $Incidentes;
    }

    public function obtenerEventos() {
      $Eventos = [];
  
      // Realiza una consulta SQL que involucra las tablas evento y tipoEvento
      $sql = "SELECT evento.*, tipoEvento.tipo AS tipo
              FROM evento
              LEFT JOIN tipoEvento ON evento.id = tipoEvento.id";
  
      $stmt = $this->pdo->query($sql);
  
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          // Crea un objeto Evento
          $evento = new Evento(
              $row['fecha'],
              $row['descripcion'],
              $row['id']
          );
  
          // Agrega la propiedad "tipo" a tu objeto Evento
          $evento->setTipo($row['tipo']);
  
          array_push($Eventos, $evento);
      }
  
      return $Eventos;
  }
  
  
  
  }
  
?>