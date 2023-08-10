<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="estiloLogin.css">
</head>

<body>
  <div class="login-container">
    <h1>Iniciar sesión</h1>
    <form method="get">
      <input type="text" name="nombre" placeholder="Usuario" required>
      <input type="password" name="contraseña" placeholder="Contraseña" required>
      <button type="submit">Enviar</button>
    </form>
  </div>
</body>
<?php 
    session_start();

    if($_GET["nombre"] == "pepe" && $_GET["contraseña"] == 123){
        $_SESSION["nombre"] = $_GET["nombre"];
        $_SESSION["sesion_valida"] = true;
        echo "<h2><center>El inicio de sesion ha sido correcto</h2>";
        header('Location: MenuPrincipal.php');


    }else {
        $_SESSION["sesion_valida"] = false;
        echo "<h2><center>Credenciales incorrectas</h2>";
    }
?>
</html>