<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Incidentes</title>
    <link rel="stylesheet" href="estilo.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Registro de Incidentes</h1>
        <form name="incident-form" action="Alta_Incidente.php" method="get">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" required>

            <label for="prioridad">Prioridad</label>
            <select name="prioridad" required>
                <option value="">Seleccione un estado</option>
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
            </select>

            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="">Seleccione un estado</option>
                <option value="Abierto">Activo</option>
                <option value="Cerrado">Cerrado</option>
                <option value="Pendiente">Pendiente</option>
            </select>
            <br>
            <br>
            <button type="submit">Agregar Incidente</button>
        </form>

        <table name="incident-table">
            <thead>
            <tr>
                    <th>Indice</th>
                    <th>Descripcion</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los incidentes -->
                <?php
                include("../Negocio/Incidente.php");
                session_start();

                $_SESSION["Incidentes"] = Incidente::obtenerIncidentes();

                foreach ($_SESSION["Incidentes"] as $I) {
                    echo "<tr>
                        <td>" . $I->getID() . "</td>
                        <td>" . $I->getFecha() . "</td>
                        <td>" . $I->getDescripcion() . "</td>
                        <td>" . $I->getPrioridad() . "</td>
                        <td>" . $I->getEstado() . "</td>
                        <td><button class=''><a href='Modificar_Incidente.php?modificarId=".$I->getID()."'>Modificar</a></button></td>"  .
                        "<td><button class='btn-eliminar'><a href='Baja_Incidente.php?eliminarId=".$I->getID()."'>Eliminar</a></button></td>
                        </tr>";
                }

                ?>
            </tbody>
        </table>

    </div>

<style>
    .container {
    max-width: 600px;
    margin: 0 auto;
}

h1 {
    text-align: center;
    font-family: Verdana;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-top: 10px;
}

input[type="text"],
select {
    width: 100%;
    padding: 8px;
    font-size: 16px;
}

button {
    padding: 8px 16px;
    font-size: 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    margin-left: 40%;
}

.btn-eliminar {
    padding: 8px 16px;
    font-size: 16px;
    background-color: red;
    color: white;
    border: none;
    cursor: pointer;
    margin-left: 40%;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* Estilos para el modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
}

.modal-contenido {
    background-color: #fff;
    width: 400px;
    max-width: 90%;
    margin: 50px auto;
    padding: 20px;
    border-radius: 5px;

}

h2{
    text-align: center;
    font-family: Verdana;

}
/* Estilos adicionales para el formulario de edición */
#formularioEditar {
    margin-top: 20px;
}

#formularioEditar input,
#formularioEditar textarea {
    width: 100%;
    margin-bottom: 10px;
}

#formularioEditar button {
    margin-top: 10px;
}
</style>

</html>