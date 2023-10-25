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

        // Consulta para obtener el ID del usuario
        $sqlObtenerID = "SELECT id FROM usuario WHERE cedula = ?";
        $stmtObtenerID = $pdo->prepare($sqlObtenerID);
        $stmtObtenerID->execute([$usuario->getCedula()]);
        $result = $stmtObtenerID->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $usuarioID = $result['id'];

            // Consulta para actualizar los datos del usuario
            $sqlUsuario = "UPDATE usuario SET cedula =?,nombre=?, apellido=?, contraseña=?, correo=? WHERE id = ?";
            $stmtUsuario = $pdo->prepare($sqlUsuario);
            $stmtUsuario->execute([
                $usuario->getCedula(),
                $usuario->getNombre(),
                $usuario->getApellido(),
                $usuario->getContraseña(),
                $usuario->getCorreo(),
                $usuarioID
            ]);

            // Consulta para actualizar el cargo del usuario
            $sqlCargo = "UPDATE cargo SET cargo=? WHERE id = ?";
            $stmtCargo = $pdo->prepare($sqlCargo);
            $stmtCargo->execute([
                $usuario->getCargo(),
                $usuarioID
            ]);
        }
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

        // Verifica si ya existen registros en la tabla usuario
        $countQuery = "SELECT COUNT(*) FROM usuario";
        $countStatement = $pdo->query($countQuery);
        $cantidadUsuarios = $countStatement->fetchColumn();

        if ($cantidadUsuarios == 0) {
            BD::setUsuario($usuario);

        } else {
            $query = "INSERT INTO registro (cedula, nombre, apellido, contraseña, correo, cargo) VALUES (?, ?, ?, ?, ?, ?)";
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
    }


    static function setPersona($Persona)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $query = "INSERT INTO persona (cedula,nombre,apellido) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $Persona->getCedula(),
            $Persona->getNombre(),
            $Persona->getApellido()
        ]);
    }

    static function unsetPersona($persona_id)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $query = "DELETE FROM persona WHERE persona.id = $persona_id";
        $statement = $pdo->prepare($query);

        $statement->execute();
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

    static function vincularPersonaIncidente($incidente_id, $rol, $persona_ci)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $obteneridpersona = "SELECT id FROM persona WHERE persona.cedula = ?";
        $stmt = $pdo->prepare($obteneridpersona);
        $stmt->execute([$persona_ci]);

        // Obtenemos el resultado de la consulta
        $persona_id = $stmt->fetchColumn();

        // Verifica si ya existe un registro con los mismos datos
        $verificarQuery = "SELECT COUNT(*) FROM persona_rol_incidente WHERE incidente_id = ? AND persona_id = ?";
        $verificarStatement = $pdo->prepare($verificarQuery);
        $verificarStatement->execute([$incidente_id, $persona_id]);
        $existeRegistro = $verificarStatement->fetchColumn();

        if ($existeRegistro == 0) {
            // No existe un registro con los mismos datos, puedes insertarlo
            $insertQuery = "INSERT INTO persona_rol_incidente (incidente_id, rol, persona_id) VALUES (?,?,?)";
            $insertStatement = $pdo->prepare($insertQuery);
            $insertStatement->execute([$incidente_id, $rol, $persona_id]);
        }
    }


    static function desvincularPersonaIncidente($persona_id)
    {

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Primero, inserta un registro en la tabla evento
        $query = "DELETE FROM persona_rol_incidente WHERE persona_rol_incidente.persona_id = ?";
        $statement = $pdo->prepare($query);

        $statement->execute([
            $persona_id
        ]);
    }

    public static function buscarPersonas($cedula, $nombre, $apellido, $id_incidente)
    {
        $personasEncontradas = array();

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Construir la consulta SQL
        $sql = "SELECT DISTINCT persona.* FROM persona WHERE 1=1"; // La condición 1=1 permite agregar condiciones dinámicamente

        if (!empty($cedula)) {
            $sql .= " AND cedula = :cedula";
        }

        if (!empty($nombre)) {
            $sql .= " AND nombre LIKE :nombre";
        }

        if (!empty($apellido)) {
            $sql .= " AND apellido LIKE :apellido";
        }

        // Agregar la condición para excluir personas involucradas en el incidente específico
        if (!empty($id_incidente)) {
            $sql .= " AND persona.id NOT IN (
                SELECT persona_id FROM persona_rol_incidente WHERE incidente_id = :id_incidente
            )";
        }

        // Preparar la consulta
        $stmt = $pdo->prepare($sql);

        if (!empty($cedula)) {
            $stmt->bindParam(':cedula', $cedula);
        }

        if (!empty($nombre)) {
            $nombre = "%" . $nombre . "%"; // Agregar comodines % para búsqueda parcial
            $stmt->bindParam(':nombre', $nombre);
        }

        if (!empty($apellido)) {
            $apellido = "%" . $apellido . "%"; // Agregar comodines % para búsqueda parcial
            $stmt->bindParam(':apellido', $apellido);
        }

        // Bind the incident ID parameter
        if (!empty($id_incidente)) {
            $stmt->bindParam(':id_incidente', $id_incidente, PDO::PARAM_INT);
        }

        // Ejecutar la consulta
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $persona = new Persona(
                    $row["cedula"],
                    $row["nombre"],
                    $row["apellido"],
                    $row["id"]
                );
                array_push($personasEncontradas, $persona);
            }
        }

        return $personasEncontradas;
    }



    static function obtenerPersonasIncidente($id)
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $sql = "SELECT persona.*, persona_rol_incidente.rol as rol
        FROM persona
        LEFT JOIN persona_rol_incidente ON persona.id = persona_rol_incidente.persona_id
        WHERE persona_rol_incidente.incidente_id = :id OR :id IS NULL";


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $Personas = [];

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $Persona = new Persona(
                    $row["cedula"],
                    $row["nombre"],
                    $row["apellido"],
                    $row["id"]
                );
                $Persona->setRol($row["rol"]);

                array_push($Personas, $Persona);
            }
        }
        return $Personas;
    }

    static function getTiposEvento()
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $opcionesPersonalizadas = array(); // Aquí almacenarás las opciones personalizadas recuperadas de la base de datos
        // Realiza una consulta a la base de datos para obtener las opciones personalizadas
        $query = "SELECT tipo FROM tipoevento";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $opcionesPersonalizadas[] = $row['tipo'];
            }
        }
        $opcionesPersonalizadas = array_unique($opcionesPersonalizadas);

        return $opcionesPersonalizadas;
    }

    static function getRoles()
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $opcionesPersonalizadas = array(); // Aquí almacenarás las opciones personalizadas recuperadas de la base de datos
        // Realiza una consulta a la base de datos para obtener las opciones personalizadas
        $query = "SELECT rol FROM persona_rol_incidente";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $opcionesPersonalizadas[] = $row['rol'];
            }
        }
        $opcionesPersonalizadas = array_unique($opcionesPersonalizadas);

        return $opcionesPersonalizadas;
    }


    static function obtenerIncidentesPersonas($idPersona)
    {
        $Incidentes = [];

        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        $sql = "SELECT incidente.*, categoria.categoria, archivo.nombre
            FROM incidente
            LEFT JOIN categoria ON incidente.id = categoria.id
            LEFT JOIN archivo_incidente ON incidente.id = archivo_incidente.incidente_id
            LEFT JOIN archivo ON archivo_incidente.archivo_id = archivo.id
            LEFT JOIN persona_rol_incidente ON incidente.id = persona_rol_incidente.incidente_id
            WHERE persona_rol_incidente.persona_id = :idPersona";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPersona', $idPersona, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $incidente = new Incidente(
                $row['fecha'],
                $row['descripcion'],
                $row['prioridad'],
                $row['estado'],
                $row['id']
            );

            $incidente->setCategoria($row['categoria']);
            $incidente->setArchivo($row['nombre']);

            array_push($Incidentes, $incidente);
        }

        return $Incidentes;
    }

}

?>