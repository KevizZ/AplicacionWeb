<?php
session_start(); // Asegúrate de iniciar la sesión

$_SESSION["sesion_valida"] = false;

include("../Repositorio/Conexion.php");
$conn = new Conexion();


if (isset($_POST["valor"])) {
    if ($_POST["valor"] == "login") {
        // Proceso de inicio de sesión
        $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
        $contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

        $sql = "SELECT id,cedula, contraseña FROM usuario WHERE cedula = ?";
        $stmt = $conn->getConexion()->prepare($sql);

        $stmt->execute([$cedula]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row['contraseña'];
        if ($row) {
            if (password_verify($contraseña, $row['contraseña'])) {
                echo "Logueo Exitoso";
                $_SESSION["sesion_valida"] = true;
                $_SESSION["id_usuario"] = $row["id"];
                header("location: Index_Incidente.php");
            } else {
                echo "Contraseña incorrecta";
                $_SESSION["sesion_valida"] = false;
            }
        } else {
            echo "Cuenta no encontrada";
            $_SESSION["sesion_valida"] = false;
        }
    } elseif ($_POST["valor"] == "register") {
        // Proceso de registro
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
        $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
        $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
        $foto = isset($_POST['foto']) ? $_POST['foto'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';
        $confirmar_contraseña = isset($_POST['confirmar_contraseña']) ? $_POST['confirmar_contraseña'] : '';

        if ($contraseña === $confirmar_contraseña) {
            // Las contraseñas coinciden
            // Generar un hash bcrypt de la contraseña
            $hash_contraseña = password_hash($contraseña, PASSWORD_BCRYPT);

            $pdo = new PDO("mysql:host=localhost;dbname=proyecto", "root", "");

            // Primero, inserta un registro en la tabla evento
            $query = "INSERT INTO usuario (cedula, nombre, apellido, contraseña, correo) VALUES (?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);

            $statement->execute([
                $cedula,
                $nombre,
                $apellido,
                $hash_contraseña,
                $email
            ]);
            $lastid = $pdo->lastInsertId();

            $query = "INSERT INTO cargo (id,cargo) VALUES (?,?)";

            $statement = $pdo->prepare($query);


            if (
                $statement->execute([
                    $lastid,
                    $cargo
                ])
            ) {
                header("location: Index_Login.php");
            } else {
                echo "Error al registrar la cuenta";
            }
        } else {
            echo "Las contraseñas no coinciden";
        }
    }
}
?>