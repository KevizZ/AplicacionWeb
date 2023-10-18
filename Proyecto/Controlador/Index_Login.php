<!DOCTYPE html>
<html>

<head>
    <title>Iniciar Sesión</title>
</head>

<body>
    <div class="container">
        <div id="login-form" class="form-container active">
            <!-- Formulario de Inicio de Sesión -->
            <h2>Iniciar Sesión</h2>
            <form action="Controlador_Login.php" method="post">
                <label for="cedula">Cedula</label>
                <input type="text" name="cedula" required><br>

                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" required><br>

                <input type="submit" value="Iniciar Sesión">

                <input type="hidden" name="valor" value="login">
            </form>
            <p>No tienes una cuenta? <a href="#" id="show-register-form">Regístrate</a></p>
        </div>

        <div id="register-form" class="form-container">
            <!-- Formulario de Registro (inicialmente oculto) -->
            <h2>Registro</h2>
            <form action="Controlador_Login.php" method="post">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required><br>

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" required><br>

                <label for="cedula">Cedula</label>
                <input type="text" id="cedula" name="cedula" required><br>

                <label for="cargo">Rol:</label>
                <select id="cargo" name="cargo">
                    <option value="Director">Director</option>
                    <option value="Profesor">Profesor</option>
                    <option value="Adscripto">Adscripto</option>
                </select><br>

                <label for="foto">Foto de Perfil:</label>
                <input type="file" id="foto" name="foto"><br>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required><br>

                <label for="confirmar_contraseña">Confirmar Contraseña</label>
                <input type="password" name="confirmar_contraseña" required><br>

                <input type="hidden" name="valor" value="register">

                <input type="submit" value="Registrarse">
            </form>
            <p>¿Ya tienes una cuenta? <a href="#" id="show-login-form">Iniciar Sesión</a></p>
        </div>
    </div>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mostrar el formulario de registro al hacer clic en "Regístrate"
        document.getElementById("show-register-form").addEventListener("click", function () {
            document.getElementById("login-form").classList.remove("active");
            document.getElementById("register-form").classList.add("active");
        });

        // Mostrar el formulario de inicio de sesión al hacer clic en "Iniciar Sesión"
        document.getElementById("show-login-form").addEventListener("click", function () {
            document.getElementById("register-form").classList.remove("active");
            document.getElementById("login-form").classList.add("active");
        });
    });
</script>

</html>

<?php require "Estilo.php"; ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        text-align: center;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
    }

    .form-container {
        display: none;
    }

    .form-container.active {
        display: block;
    }

    /* Estilos generales para los formularios */
    form {
        max-width: 300px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
    }

    label {
        display: block;
        margin: 10px 0;
        color: #333;
        text-align: left;
        margin-left: 10px;
        margin-bottom: 0px;
    }

    input[type="text"],
    input[type="password"] {
        width: 90%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        margin-top: 20px;
        width: 50%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    a {
        text-decoration: none;
        color: #007bff;
    }

    a:hover {
        color: #0056b3;
    }

    p {
        margin-top: 10px;
    }

    /* Estilos específicos para el formulario de registro */
    #register-form {
        margin-top: 20px;
    }
</style>