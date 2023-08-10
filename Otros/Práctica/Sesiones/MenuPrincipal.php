<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Incidentes</title>
  <link rel="stylesheet" href="estiloMenuPrincipal.css">
</head>
<body>
  <div class="container">
    <h1>Registro de Incidentes</h1>
    <div class="user-info">
      <h3 style="color:#76D7C4"><?php session_start(); echo $_SESSION["nombre"]?></h3>
      <a href="logout.html" class="logout">Cerrar sesión</a>
    </div>
    <div class="options">
      <a class="option">Registrar Incidente</a>
      <a class="option">Ver Incidentes</a>
    </div>
  </div>
</body>
</html>
