<?php require_once("Verificador.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Datos Personales</title>
    <link rel="stylesheet" href="css/Configuración de Usuario.css">
</head>

<body>
    <h1>Configuración de Datos Personales</h1>
    <form id="user-settings-form">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="cedula">Cedula</label>
        <input type="text" id="cedula" name="cedula" required><br>

        <label for="cargo">Cargo:</label>
        <select id="cargo" name="cargo">
            <option value="director">Director</option>
            <option value="profesor">Profesor</option>
            <option value="adscrito">Adscrito</option>
            <option value="cap">CAP</option>
        </select><br>

        <label for="foto">Foto de Perfil:</label>
        <input type="file" id="foto" name="foto"><br>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        <button type="submit">Guardar Cambios</button>
    </form>

</body>

</html>



<?php
require("Menu_Lateral.php");
require("Estilo.php");
include("../Negocio/Usuario.php");


$id = $_SESSION["id_usuario"];

$conex = new Conexion();

$sql = "SELECT usuario.*, cargo.cargo as cargo
    FROM usuario 
    LEFT JOIN cargo ON usuario.id = cargo.id 
    WHERE usuario.id = ?";

$stmt = $conex->getConexion()->prepare($sql);

$stmt->execute([$id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo '<script>';
echo 'var nombre = "' . $row["nombre"] . '";';
echo 'var apellido = "' . $row["apellido"] . '";';
echo 'var cedula = "' . $row["cedula"] . '";';
echo 'var contraseña = "' . $row["contraseña"] . '";';
echo 'var correo = "' . $row["correo"] . '";';
echo 'var cargo = "' . $row["cargo"] . '";';
echo '</script>';



?>

<script>
    // Espera a que se cargue el DOM antes de ejecutar la función
    document.addEventListener("DOMContentLoaded", function () {
        cambiarValores();
    });

    function cambiarValores() {
        // Accede a los elementos del formulario por su nombre
        var apellidoElement = document.getElementsByName("apellido")[0];
        var nombreElement = document.getElementsByName("nombre")[0];
        var cedulaElement = document.getElementsByName("cedula")[0];
        var contraseñaElement = document.getElementsByName("contraseña")[0];
        var correoElement = document.getElementsByName("correo")[0];
        var cargoElement = document.getElementsByName("cargo")[0];

        // Asigna los valores de JavaScript a los elementos del formulario
        apellidoElement.value = apellido;
        nombreElement.value = nombre;
        cedulaElement.value = cedula;
        contraseñaElement.value = contraseña;
        correoElement.value = correo;
        cargoElement.value = cargo;
    }
</script>