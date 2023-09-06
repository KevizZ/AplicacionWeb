<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Sitio Web</title>
</head>

<body>
    <div class="sidebar">
        <!-- Contenido del menú lateral -->
        <ul>
            <li><a href="javascript:void(0);" onclick="cargarPagina('Index_Incidente.php')">Registro de Incidentes</a>
            </li>
            <!-- Agrega más enlaces para tus páginas aquí -->
        </ul>
        <!-- Icono de menú para contraer la barra lateral -->
    </div>
    <div class="content">
        <!-- Aquí se cargará el contenido de las páginas -->
    </div>


</body>

</html>

<style>
    body {
        display: flex;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    /* Estilos para el contenido principal */
    .content {
        flex: 1;
        padding: 20px;
        /* Espaciado interno para el contenido principal */
    }

    /* Estilos para la barra lateral */
    .sidebar {
        background-color: #007BFF;
        /* Color de fondo celeste */
        color: white;
        /* Texto en color blanco */
        width: 250px;
        /* Ancho de la barra lateral */
        height: 100vh;
        /* Altura del viewport */
        padding: 20px;
        /* Espaciado interno para el contenido de la barra lateral */
        transition: width 0.3s;
        /* Transición suave para la animación de contraer/expandir */
    }


</style>

<script src="scripts.js">
</script>