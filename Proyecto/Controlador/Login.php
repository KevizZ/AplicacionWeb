<!DOCTYPE html>
<html>

<head>
    <title>Registro de Usuario</title>

    <style>
        .login {
            width: 1440px;
            height: 900px;
        }

        body {
            font-family: sans-serif;
            background: #2c3e50;
            color: #fff;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            border: 2px solid #34495e;
            border-radius: 10px;
            background: #34495e;
        }

        label {
            display: block;
            margin-top: 15px;
        }


        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;

        }


        button {
            width: 100%;
            padding: 10px;
            border: none;
            margin-top: 15px;
            border-radius: 5px;
            background: #e67e22;
            color: #fff;
            font-size: 1.1em;
            cursor: pointer;
        }

        #messages {
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="login">
        <h1>Inicio de Sesión</h1>

        <form id="loginForm" action="Index.php" method="get">

            <label for="usuario">Nombre de usuario:</label>
            <input type="text" id="username" name="usuario" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="password" name="contraseña" required minlength="6">

            <button type="submit">Registrarse</button>

            <div id="messages"></div>

        </form>
    </div>

    <div id="registro">
        <h1>Registro</h1>

        <form id="registerForm" action="Index.php" method="get">

            <label for="usuario">Nombre de usuario:</label>
            <input type="text" id="username" name="usuario" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="password" name="contraseña" required minlength="6">

            <button type="submit">Registrarse</button>

            <div id="messages"></div>

        </form>
    </div>

</body>

<script>
    function cer
    function cerrarModal() {
        document.getElementById("registro").style.display = "none";
    }
</script>

</html>

<?php
include("../Repositorio/Conexion.php");

if (isset($_GET["usuario"], $_GET["contraseña"])) {
    $_SESSION["usuario"] = $_GET["usuario"];
    $_SESSION["contraseña"] = $_GET["contraseña"];

    function VerificarUsuario()
    {
        $query = "SELECT * FROM registro WHERE usuario = :u AND contraseña = :c";

        $Conexion = new Conexion();
        $statement = $Conexion->getConexion()->prepare($query);

        $statement->bindParam(":u", $_SESSION["usuario"]);
        $statement->bindParam(":c", $_SESSION["contraseña"]);

        $statement->execute();
        // Verifico si hubo coincidencias en la Base de Datos
        $resultado = $statement->fetchColumn();
        if ($resultado > 0) {
            $_SESSION["sesion_valida"] = true;
        } else {
            $query = "INSERT INTO pre_registro (usuario, contraseña) VALUES (:u,:c)";
            $statement = $Conexion->getConexion()->prepare($query);
            $statement->bindParam(":u", $_SESSION["usuario"]);
            $statement->bindParam(":c", $_SESSION["contraseña"]);

            $statement->execute();
        }

    }

    VerificarUsuario();
}



?>