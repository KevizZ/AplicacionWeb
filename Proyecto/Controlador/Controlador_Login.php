<?php
include_once("../Negocio/Usuario.php");
include_once("../Repositorio/Database.php");

session_start();

// Inicializar la variable de sesión
$_SESSION["sesion_valida"] = false;

try {
    if (isset($_POST["valor"])) {
        if ($_POST["valor"] == "login") {
            // Proceso de inicio de sesión
            $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
            $contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

            $usuario = BD::getUsuario($cedula);

            var_dump($usuario);

            if (!$usuario) {
                throw new Exception("Usuario no encontrado.");
            }

            if (password_verify($contraseña, $usuario->getContraseña())) {
                $_SESSION["sesion_valida"] = true;
                $_SESSION["ci_usuario"] = $usuario->getCedula();
                header("location: Index_Incidente.php");
            } else {
                throw new Exception("Contraseña incorrecta.");
            }
        } elseif ($_POST["valor"] == "register") {
            // Proceso de registro
            // Proceso de registro
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
            $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
            $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
            $correo = isset($_POST['email']) ? $_POST['email'] : '';
            $contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';
            $confirmar_contraseña = isset($_POST['confirmar_contraseña']) ? $_POST['confirmar_contraseña'] : '';


            // Las contraseñas coinciden
            if ($contraseña === $confirmar_contraseña) {
                // Generar un hash bcrypt de la contraseña
                $hash_contraseña = password_hash($contraseña, PASSWORD_BCRYPT);

                $Usuario = new Usuario($cedula, $nombre, $apellido, $hash_contraseña, $correo);
                $Usuario->setCargo($cargo);

                BD::setRegistrado($Usuario);
                header("location: Index_Login.php");
            }
            // Si se ha completado el registro exitosamente, redirigir al usuario a la página de inicio de sesión
            header("location: Index_Login.php");
        } else {
            throw new Exception("Valor desconocido en el formulario.");
        }
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
    // Puedes redirigir al usuario a una página de error y mostrar el mensaje de error allí.
    // También puedes mostrar un mensaje de error en la misma página si lo prefieres.
    echo "Error: " . $error_message;
}
?>