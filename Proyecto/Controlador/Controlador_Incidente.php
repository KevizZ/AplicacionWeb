<?php
session_start();
include("Ingresar_Incidente.php");

if ($_GET['function'] == 'EliminarIncidente') {

    // Obtén el ID
    $id = $_GET['id'];

    $sql = "DELETE FROM datos WHERE id = ?;
                ALTER TABLE datos DROP COLUMN id; 
                ALTER TABLE datos ADD `id` INT(10) NOT NULL AUTO_INCREMENT , ADD PRIMARY KEY (`id`);";

    $conexion = new Conexion();

    $statement = $conexion->getConexion()->prepare($sql);


    $statement->execute([$id]);

}

if ($_GET['function'] == 'GuardarIndice') {

    // Obtén el ID
    $id = $_GET['parametro'];

    // Llama la función para eliminar
    GuardarIndice($id);


}

if ($_GET['function'] == 'EditarIncidente') {

    $incidente = new Incidente($_GET["titulo"], $_GET["descripcion"], $_GET["categoria"], $_GET["gravedad"], $_GET["fecha"], $_GET["estado"]);
    $conexion = new Conexion();
    $query =
        "DELETE FROM datos WHERE id = :id;
    INSERT INTO datos (titulo, descripcion, categoria, gravedad, fecha, estado) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $conexion->getConexion()->prepare($query);

    $statement->bindParam(':id', $_SESSION["indice"]);

    $statement->execute([
        $incidente->getTitulo(),
        $incidente->getDescripcion(),
        $incidente->getCategoria(),
        $incidente->getGravedad(),
        $incidente->getFecha(),
        $incidente->getEstado()
    ]);
}


function GuardarIndice($I)
{
    $_SESSION["Indice"] = $I;
}


?>