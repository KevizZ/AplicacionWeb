<?php
require_once("Verificador.php");
require("Menu_Lateral.php");
include_once("../Repositorio/Database.php");
include_once("../Negocio/Usuario.php");

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
    <!-- Agregar los enlaces a Bootstrap 5 y tu archivo de estilo CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Configuración de Datos Personales</h1>
        <form id="user-settings-form" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula</label>
                <input type="text" id="cedula" name="cedula" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <?php if ($cargo === "Director") { ?>
                    <input type="text" id="cargo" name="cargo" class="form-control">
                <?php } else { ?>
                    <select id="cargo" name="cargo" class="form-select" required>
                        <option value="Profesor">Profesor</option>
                        <option value="Adscripto">Adscripto</option>
                    </select>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            </div>

            <div class="text-center mt-3">
                <button type="submit" formaction="Modificar_Usuario.php" class="btn btn-primary">Guardar
                    Cambios</button>
            </div>
        </form>
    </div>

    <!-- Mostrar tabla adicional solo si el usuario es "Director" -->
    <?php if ($cargo === "Director") { ?>
        <div class="container mt-4">
            <h2 class="text-center">Solicitudes de Usuario</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cédula</th>
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
                            <td>
                            <a class='btn btn-success' href='Alta_Usuario.php?id_registrado=" . $U->getID() . "'>Aceptar <i class='bi bi-check'></i></a>
                            <a class='btn btn-danger' href='Baja_Registrado.php?id_registrado=" . $U->getID() . "'>Denegar <i class='bi bi-trash'></i></a>
                        </td>
                        </tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    <?php }

    $ci = $_SESSION["ci_usuario"];

    $usuario = BD::getUsuario($ci);

    echo '<script>';
    echo 'var nombre = "' . $usuario->getNombre() . '";';
    echo 'var apellido = "' . $usuario->getApellido() . '";';
    echo 'var cedula = "' . $usuario->getCedula() . '";';
    echo 'var contraseña = "' . $usuario->getContraseña() . '";';
    echo 'var correo = "' . $usuario->getCorreo() . '";';
    echo 'var cargo = "' . $usuario->getCargo() . '";';
    echo '</script>'; ?>

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
</body>

</html>