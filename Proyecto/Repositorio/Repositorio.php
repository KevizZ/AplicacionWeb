<?php
include("Conexion.php");

class Repositorio
{
  private $pdo;

  public function __construct()
  {
    $conexion = new Conexion();
    $this->pdo = $conexion->getConexion();
  }

  public function obtenerIncidentes()
  {
    $Incidentes = [];

    $sql = "SELECT incidente.*, categoria.categoria, archivo.nombre
        FROM incidente
        LEFT JOIN categoria ON incidente.id = categoria.id
        LEFT JOIN archivo_incidente ON incidente.id = archivo_incidente.incidente_id
        LEFT JOIN archivo ON archivo_incidente.archivo_id = archivo.id";

    $stmt = $this->pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      // Crea un objeto Incidente
      $incidente = new Incidente(
        $row['fecha'],
        $row['descripcion'],
        $row['prioridad'],
        $row['estado'],
        $row['id']
      );

      // Agrega la propiedad "categoria" a tu objeto Incidente
      $incidente->setCategoria($row['categoria']);

      $incidente->setArchivo($row['nombre']);

      array_push($Incidentes, $incidente);
    }

    return $Incidentes;
  }

  public function obtenerEventos($id)
  {
    $Eventos = [];

    $sql = "SELECT evento.*, tipoEvento.tipo AS tipo, archivo.nombre AS nombre
    FROM evento
    LEFT JOIN tipoEvento ON evento.id = tipoEvento.id
    LEFT JOIN archivo_evento ON evento.id = archivo_evento.evento_id
    LEFT JOIN archivo ON archivo_evento.archivo_id = archivo.id
    WHERE evento.incidente_id = $id";


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

      $evento->setArchivo($row['nombre']);

      array_push($Eventos, $evento);
    }

    return $Eventos;
  }



}

?>