<?php
require_once("Verificador.php");
require("Menu_Lateral.php");
require("Estilo.php");
include_once("../Negocio/Usuario.php");
include_once("../Repositorio/Database.php");

$ci = $_SESSION["ci_usuario"];

$usuario = BD::getUsuario($ci);

// Verifica el cargo del usuario
$cargo = $usuario->getCargo();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Datos Personales</title>
</head>

<body>
    <h1>Configuración de Datos Personales</h1>
    <form id="user-settings-form" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="cedula">Cedula</label>
        <input type="text" id="cedula" name="cedula" required><br>

        <label for="cargo">Cargo</label>
        <?php if ($cargo === "Director") { ?>
            <input type="text" id="cedula" name="cargo" required><br>
        <?php } else { ?>

            <select id="cargo" name="cargo">
                <option value="Profesor">Profesor</option>
                <option value="Adscripto">Adscripto</option>
            </select><br>

        <?php } ?>


        <label for="foto">Foto de Perfil:</label>
        <input type="file" id="foto" name="foto"><br>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        <button type="submit" formaction="Modificar_Usuario.php">Guardar Cambios</button>
    </form>

    <!-- Mostrar tabla adicional solo si el usuario es "Director" -->
    <?php if ($cargo === "Director") { ?>
        <h2>Verificar Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cedula</th>
                    <th>Correo</th>
                    <th>Cargo</th>
                    <th>Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $Usuarios = Repositorio::obtenerRegistrados();

                foreach ($Usuarios as $U) {
                    echo "<tr>
                        <td>" . $U->getId() . "</td>
                        <td>" . $U->getNombre() . "</td>
                        <td>" . $U->getApellido() . "</td>
                        <td>" . $U->getCedula() . "</td>
                        <td>" . $U->getCorreo() . "</td>
                        <td>" . $U->getCargo() . "</td>
                        <td><button class='btn-modificar'><a href='Alta_Usuario.php?id_registrado=" . $U->getID() . "'>Aceptar</a></button>
                        <button class='btn-eliminar'><a href='Baja_Registrado.php?id_registrado=" . $U->getID() . "'>Denegar</a></button></td>
                    </tr>";
                }
    } ?>
        </tbody>
    </table>

</body>

</html>



<?php
require("Menu_Lateral.php");
require("Estilo.php");
include_once("../Negocio/Usuario.php");

$ci = $_SESSION["ci_usuario"];

$usuario = BD::getUsuario($ci);


echo '<script>';
echo 'var nombre = "' . $usuario->getNombre() . '";';
echo 'var apellido = "' . $usuario->getApellido() . '";';
echo 'var cedula = "' . $usuario->getCedula() . '";';
echo 'var contraseña = "' . $usuario->getContraseña() . '";';
echo 'var correo = "' . $usuario->getCorreo() . '";';
echo 'var cargo = "' . $usuario->getCargo() . '";';
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

        // Asigna el valor del campo "cargo" seleccionando la opción correcta en el elemento "select"
        <?php if ($cargo !== "Director") { ?>
            for (var i = 0; i < cargoElement.options.length; i++) {
                if (cargoElement.options[i].value === cargo) {
                    cargoElement.selectedIndex = i;
                    break;
                }
            }
        <?php } else { ?>
            cargoElement.value = cargo;
        <?php } ?>
    }

</script>