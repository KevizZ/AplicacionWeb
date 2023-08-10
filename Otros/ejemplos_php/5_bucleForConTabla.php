<!DOCTYPE html>
<html>
<style>
table, th, td {
  border:1px solid black;
}
</style>

<body>

<h1>Tabla de personas</h1>


<?php
$personas = array ('Juan', 'Luis','Maria','Andrea');

echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "</tr>";


for ($i = 0;$i < count($personas); $i++) {
    echo "<tr>";
    echo "<td>" . $personas[$i] . "</td>";
    echo "</tr>";
    
}
echo "</table>";
?>

    
</body>
</html>