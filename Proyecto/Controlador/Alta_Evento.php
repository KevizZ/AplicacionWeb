<?php
include("../Negocio/Evento.php");

                $conexion = new Conexion();

                // Primero, inserta un registro en la tabla evento
                $query = "INSERT INTO evento (descripcion, fecha, incidente_id) VALUES (?, ?, ?)";
                $statement = $conexion->getConexion()->prepare($query);
        
                $statement->execute([
                    $this->descripcion,
                    $this->fecha,
                    $incidente_id
                ]);
        
                $evento_id = "SELECT LAST_INSERT_ID() FROM ?";
        
                $statement = $conexion->getConexion()->prepare($evento_id);
        
                $statement->execute([
                    "evento"
                ]);
                
                // Después, inserta un registro en la tabla tipoevento
                $query = "INSERT INTO tipoevento (id, tipo) VALUES (?, ?)";
                $statement = $conexion->getConexion()->prepare($query);
        
                $statement->execute([
                    $evento_id,
                    $this->tipo
                ]);
               
?>