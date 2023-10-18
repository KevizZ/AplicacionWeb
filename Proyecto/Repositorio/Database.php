<?php
include_once("Conexion.php");
include_once("Repositorio.php");
include_once("../Negocio/Evento.php");
class BD
{
    private $pdo;

    function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getConexion();
    }
    static function getUsuario($usuario_cedula)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $sql = "SELECT usuario.*, cargo.cargo as cargo
            FROM usuario 
            LEFT JOIN cargo ON cargo.id = usuario.id
            WHERE usuario.cedula = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$usuario_cedula]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Usuario = new Usuario(
                $row["cedula"],
                $row["nombre"],
                $row["apellido"],
                $row["contraseña"],
                $row["correo"],
                $row["id"]
            );

            $Usuario->setCargo($row["cargo"]);
            return $Usuario;
        }

    }


    static function getIncidente($incidente_id)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $sql = "SELECT incidente.*, categoria.categoria, archivo.nombre
        FROM incidente
        LEFT JOIN categoria ON incidente.id = categoria.id
        LEFT JOIN archivo_incidente ON incidente.id = archivo_incidente.incidente_id
        LEFT JOIN archivo ON archivo_incidente.archivo_id = archivo.id
        WHERE incidente.id = $incidente_id";

        $stmt = $pdo->query($sql);

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

        }

        return $incidente;
    }

    // Obtiene la ubicación del archivo de un Incidente
    static function getArchivoIncidente($incidente_id)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();
        $sql = "SELECT archivo.nombre
        FROM incidente 
        LEFT JOIN archivo_incidente ON incidente.id = archivo_incidente.incidente_id
        LEFT JOIN archivo ON archivo_incidente.archivo_id = archivo.id
        WHERE incidente.id = $incidente_id";

        $statement = $pdo->query($sql);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['nombre'];
    }

    // Obtiene la ubicación del archivo de un Evento
    static function getArchivoEvento($evento_id)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $sql = "SELECT archivo.nombre
                FROM evento 
                LEFT JOIN archivo_evento ON evento.id = archivo_evento.evento_id
                LEFT JOIN archivo ON archivo_evento.archivo_id = archivo.id
                WHERE evento.id = :evento_id";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(':evento_id', $evento_id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            // Si no se encontró un archivo asociado al evento directamente, puedes buscar por incidente_id
            $sql = "SELECT archivo.nombre
                    FROM evento 
                    LEFT JOIN archivo_evento ON evento.id = archivo_evento.evento_id
                    LEFT JOIN archivo ON archivo_evento.archivo_id = archivo.id
                    WHERE evento.incidente_id = :evento_id";

            $statement = $pdo->prepare($sql);
            $statement->bindParam(':evento_id', $evento_id, PDO::PARAM_INT);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
        }

        return ($row !== false) ? $row['nombre'] : null;
    }


    static function setArchivoIncidente($Incidente)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();
        $query = "INSERT INTO archivo (nombre) VALUES (?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $Incidente->getArchivo()

        ]);

        $lastId = $pdo->lastInsertId();

        $query = "INSERT INTO archivo_incidente (archivo_id, incidente_id) VALUES (?,?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $lastId,
            // Obtengo el id del incidente
            BD::setIncidente($Incidente)
        ]);

    }

    static function setArchivoEvento($Evento, $id_incidente)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();
        $query = "INSERT INTO archivo (nombre) VALUES (?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $Evento->getArchivo()

        ]);

        $lastId = $pdo->lastInsertId();

        $query = "INSERT INTO archivo_evento (archivo_id, evento_id) VALUES (?,?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $lastId,
            // Obtengo el id del evento
            BD::setEvento($Evento, $id_incidente)
        ]);

    }
    static function setIncidente($Incidente)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO incidente (fecha, descripcion, prioridad, estado) VALUES (?, ?, ?, ?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $Incidente->getFecha(),
            $Incidente->getDescripcion(),
            $Incidente->getPrioridad(),
            $Incidente->getEstado()
        ]);

        // Obtener el último ID insertado
        $lastId = $pdo->lastInsertId();

        $query = "INSERT INTO categoria(id,categoria) VALUES (?,?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $lastId,
            $Incidente->getCategoria()
        ]);

        return $lastId;
    }

    static function setEvento($Evento, $incidente_id)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO evento (descripcion, fecha, incidente_id) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $Evento->getDescripcion(),
            $Evento->getFecha(),
            $incidente_id
        ]);

        // Obtener el último ID insertado
        $lastId = $pdo->lastInsertId();

        $query = "INSERT INTO tipoevento(id,tipo) VALUES (?,?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $lastId,
            $Evento->getTipo()
        ]);

        return $lastId;
    }

    static function unsetEvento($evento_id)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $nombreArchivo = BD::getArchivoEvento($evento_id);

        if (!empty($nombreArchivo)) {
            // Verifica que se haya obtenido un nombre de archivo válido
            $queryEliminarArchivo = "DELETE FROM archivo WHERE nombre = ?";
            $stmtEliminarArchivo = $pdo->prepare($queryEliminarArchivo);
            $stmtEliminarArchivo->execute([$nombreArchivo]);
        }

        // Elimina el evento después de eliminar el archivo si es necesario
        $query = "DELETE FROM evento WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$evento_id]);

        return $nombreArchivo;
    }


    static function unsetEventoPorIncidente($evento_id)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Paso 1: Obtener el nombre del archivo asociado al event
        $nombreArchivo = BD::getArchivoEvento($evento_id);

        $query = "DELETE FROM evento WHERE incidente_id = ?";
        $statement = $pdo->prepare($query);

        $statement->execute([$evento_id]);

        // Paso 3: Eliminar el archivo de la base de datos
        if (!empty($nombreArchivo)) {
            // Verifica que se haya obtenido un nombre de archivo válido
            $queryEliminarArchivo = "DELETE FROM archivo WHERE nombre = ?";
            $stmtEliminarArchivo = $pdo->prepare($queryEliminarArchivo);
            $stmtEliminarArchivo->execute([$nombreArchivo]);

        }
        return $nombreArchivo;
    }


    static function unsetIncidente($incidente_id)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();
        // Paso 1: Obtener el nombre del archivo asociado al incidente
        $nombreArchivo = BD::getArchivoIncidente($incidente_id);

        // Paso 2: Eliminar el incidente de la base de datos
        $queryEliminarIncidente = "DELETE FROM incidente WHERE id = ?";
        $stmtEliminarIncidente = $pdo->prepare($queryEliminarIncidente);
        $stmtEliminarIncidente->execute([$incidente_id]);

        // Paso 3: Eliminar el archivo de la base de datos
        if (!empty($nombreArchivo)) {
            // Verifica que se haya obtenido un nombre de archivo válido
            $queryEliminarArchivo = "DELETE FROM archivo WHERE nombre = ?";
            $stmtEliminarArchivo = $pdo->prepare($queryEliminarArchivo);
            $stmtEliminarArchivo->execute([$nombreArchivo]);

        }

        return $nombreArchivo;
    }
    static function updateUsuario($usuario)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Consulta para actualizar los datos del usuario
        $sqlUsuario = "UPDATE usuario SET nombre=?, apellido=?, contraseña=?, correo=? WHERE cedula=?";
        $stmtUsuario = $pdo->prepare($sqlUsuario);
        $stmtUsuario->execute([
            $usuario->getNombre(),
            $usuario->getApellido(),
            $usuario->getContraseña(),
            $usuario->getCorreo(),
            $usuario->getCedula()
        ]);

        // Consulta para actualizar el cargo del usuario
        $sqlCargo = "UPDATE cargo SET cargo=? WHERE id = (SELECT id FROM usuario WHERE cedula=?)";
        $stmtCargo = $pdo->prepare($sqlCargo);
        $stmtCargo->execute([
            $usuario->getCargo(),
            $usuario->getCedula()
        ]);
    }


    static function updateIncidente($Incidente, $incidente_id)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Actualización de la tabla incidente
        $queryIncidente = "UPDATE incidente 
            SET fecha = ?, descripcion = ?, prioridad = ?, estado = ? 
            WHERE id = ?";
        $statementIncidente = $pdo->prepare($queryIncidente);

        $statementIncidente->execute([
            $Incidente->getFecha(),
            $Incidente->getDescripcion(),
            $Incidente->getPrioridad(),
            $Incidente->getEstado(),
            $incidente_id
        ]);

        // Actualización de la tabla categoria (si es necesario)
        $queryCategoria = "UPDATE categoria SET categoria = ? WHERE id = ?";
        $statementCategoria = $pdo->prepare($queryCategoria);

        $statementCategoria->execute([
            $Incidente->getCategoria(),
            $incidente_id
        ]);

        $queryArchivo = "UPDATE archivo
        SET nombre = ?
        WHERE id IN (
            SELECT archivo_id
            FROM archivo_incidente
            WHERE incidente_id = ?
        );
        ";

        $statementArchivo = $pdo->prepare($queryArchivo);

        $statementArchivo->execute([
            $Incidente->getArchivo(),
            $incidente_id
        ]);
    }

    static function setUsuario($usuario)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO usuario (cedula, nombre, apellido, contraseña, correo) VALUES (?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $usuario->getCedula(),
            $usuario->getNombre(),
            $usuario->getApellido(),
            $usuario->getContraseña(),
            $usuario->getCorreo()
        ]);

        $lastid = $pdo->lastInsertId();

        $query = "INSERT INTO cargo (id,cargo) VALUES (?,?)";

        $statement = $pdo->prepare($query);
        $statement->execute([
            $lastid,
            $usuario->getCargo()
        ]);
    }

    static function setRegistrado($usuario)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Primero, inserta un registro en la tabla evento
        $query = "INSERT INTO registro (cedula, nombre, apellido, contraseña, correo,cargo) VALUES (?, ?, ?, ?, ?,?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $usuario->getCedula(),
            $usuario->getNombre(),
            $usuario->getApellido(),
            $usuario->getContraseña(),
            $usuario->getCorreo(),
            $usuario->getCargo()
        ]);
    }

    static function getRegistrado($id)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Primero, inserta un registro en la tabla evento
        $query = "SELECT * FROM registro WHERE registro.id = ?";
        $statement = $pdo->prepare($query);

        $statement->execute([$id]);

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $Usuario = new Usuario(
                $row["cedula"],
                $row["nombre"],
                $row["apellido"],
                $row["contraseña"],
                $row["correo"],
                $row["id"]
            );

            $Usuario->setCargo($row["cargo"]);
            return $Usuario;
        }
    }

    static function unsetRegistrado($id)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Primero, inserta un registro en la tabla evento
        $query = "DELETE FROM registro WHERE registro.id = ?";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $id
        ]);
    }



}
?>