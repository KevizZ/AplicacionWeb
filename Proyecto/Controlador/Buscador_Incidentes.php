<!DOCTYPE html>
<html>
<head>
    <title>Buscar Incidentes</title>
</head>
<body>
    <h1>Buscar Incidentes</h1>
    <form method="POST">
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion">
        <input type="submit" value="Buscar">
    </form>
</body>
</html>

<?php
// Conexión a la base de datos (asegúrate de tener tus credenciales aquí)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Obtén la descripción de búsqueda desde el formulario
$descripcion = $_POST['descripcion'];

// Consulta SQL para buscar incidentes por descripción
$sql = "SELECT * FROM incidente WHERE descripcion LIKE '%$descripcion%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los resultados
    echo "<h2>Resultados de la búsqueda:</h2>";
    echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Prioridad</th>
            <th>Estado</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $row["id"] . "</td>
            <td>" . $row["fecha"] . "</td>
            <td>" . $row["descripcion"] . "</td>
            <td>" . $row["prioridad"] . "</td>
            <td>" . $row["estado"] . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron incidentes con esa descripción.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
