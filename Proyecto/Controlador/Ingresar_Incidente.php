<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Incidentes</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <div class="container">
        <h1>Registro de Incidentes</h1>
        <form name="incident-form" action="Ingresar_Incidente.php" method="get">
            <label for="titulo">Título del Incidente:</label>
            <input type="text" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" required>

            <label for="categoria">Categoría:</label>
            <input type="text" name="categoria" required>

            <label for="gravedad">Gravedad:</label>
            <select name="gravedad" required>
                <option value="">Seleccione un grado</option>
                <option value="Leve">Leve</option>
                <option value="Medio">Medio</option>
                <option value="Grave">Grave</option>
            </select>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>

            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="">Seleccione un estado</option>
                <option value="Abierto">Abierto</option>
                <option value="En Progreso">En Progreso</option>
                <option value="Cerrado">Cerrado</option>
            </select>
            <br>
            <br>
            <button type="submit" onclick="">Agregar Incidente</button>
        </form>

        <table name="incident-table">
            <thead>
                <tr>
                    <th>Indice</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Gravedad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los incidentes -->
                <?php
                include("../Negocio/Incidente.php");
                session_start();


                //Verifico que no este vacío el campo Titulo y lo cargue, para que no marque error en pantalla.
                if (!empty($_GET["titulo"])) {
                    $NuevoIncidente = new Incidente($_GET["titulo"], $_GET["descripcion"], $_GET["categoria"], $_GET["gravedad"], $_GET["fecha"], $_GET["estado"]);
                }

                //Verifico si el incidente es difernete al último ingresado para que no se creen solos al reinciar la página.
                if (isset($NuevoIncidente) && $NuevoIncidente != $_SESSION["IncidenteAnterior"]) {

                    $conexion = new Conexion();
                    $query = "INSERT INTO datos (titulo, descripcion, categoria, gravedad, fecha, estado) VALUES (?, ?, ?, ?, ?, ?)";
                    $statement = $conexion->getConexion()->prepare($query);

                    $statement->execute([
                        $NuevoIncidente->getTitulo(),
                        $NuevoIncidente->getDescripcion(),
                        $NuevoIncidente->getCategoria(),
                        $NuevoIncidente->getGravedad(),
                        $NuevoIncidente->getFecha(),
                        $NuevoIncidente->getEstado()
                    ]);

                    $_SESSION["IncidenteAnterior"] = $NuevoIncidente;
                }

                $_SESSION["Incidentes"] = Incidente::obtenerIncidentes();

                foreach ($_SESSION["Incidentes"] as $I) {
                    echo "<tr>
                        <td>" . $I->getID() . "</td>
                        <td>" . $I->getTitulo() . "</td>
                        <td>" . $I->getDescripcion() . "</td>
                        <td>" . $I->getCategoria() . "</td>
                        <td>" . $I->getGravedad() . "</td>
                        <td>" . $I->getFecha() . "</td>
                        <td>" . $I->getEstado() . "</td>
                        <td><button onclick='abrirModal(" . $I->getID() . ")'>Editar</button></td>" .
                        "<td><button class='btn-eliminar' type='submit' onclick='EliminarIncidente(" . $I->getID() . ")'>Eliminar</button></td>
                        </tr>";
                }

                ?>
            </tbody>
        </table>

    </div>

    <!-- Estructura del modal -->
    <div id="modalEditar" class="modal">
        <div class="modal-contenido">
            <h2>Editar Incidente</h2>
            <form id="formularioEditar" action="Ingresar_Incidente.php" method="get">
                <label for="titulo">Título del Incidente:</label>
                <input type="text" name="titulo" required>

                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" required>

                <label for="categoria">Categoría:</label>
                <input type="text" name="categoria" required>

                <label for="gravedad">Gravedad:</label>
                <select name="gravedad" required>
                    <option value="">Seleccione un grado</option>
                    <option value="Leve">Leve</option>
                    <option value="Medio">Medio</option>
                    <option value="Grave">Grave</option>
                </select>

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" required>

                <label for="estado">Estado:</label>
                <select name="estado" required>
                    <option value="">Seleccione un estado</option>
                    <option value="Abierto">Abierto</option>
                    <option value="En Progreso">En Progreso</option>
                    <option value="Cerrado">Cerrado</option>
                </select>
                <!-- Otros campos de edición -->
                <tr>
                    <td><button type="submit" onclick="EditarIncidente()">Guardar</button></td>
                    <td><button type="button" onclick="cerrarModal()">Cerrar</button></td>
                </tr>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function EliminarIncidente(id) {
            $.ajax({
                type: 'GET',
                url: 'Controlador_Incidente.php',
                data: {
                    id: id,
                    function: 'EliminarIncidente',
                },
                success: function (response) {
                    console.log('Llamada a función exitosa');
                    location.reload();
                },
                error: function () {
                    console.log('Error al llamar a la función');
                }
            });
        }

        function EditarIncidente() {
            $.ajax({
                url: 'Controlador_Incidente.php', // Ruta al archivo PHP que contiene la función
                type: 'GET', // Método HTTP utilizado
                data: { function: 'EditarIncidente' }, // Datos adicionales que deseas enviar al servidor (si los hay)
                success: function (response) {
                    // Manejar la respuesta del servidor (si es necesario)
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Manejar errores de la llamada AJAX (si los hay)
                    console.log(error);
                }
            });
        }
        // Función para abrir el modal de edición
        function abrirModal(i) {
            document.getElementById("modalEditar").style.display = "block";

            // Guardo el indice en el Array, del Incidente al que se le apretó el botón "Editar"
            GuardarIndice(i);
            function GuardarIndice(parametro) {
                $.ajax({
                    type: 'GET',
                    url: 'Controlador_Incidente.php',
                    data: {
                        parametro: parametro,
                        function: "GuardarIndice"
                    },
                    success: function (response) {
                        console.log('Llamada a función exitosa');
                        console.log(response);

                    },
                    error: function () {
                        console.log('Error al llamar a la función');
                    }
                });

            }

        }

        // Función para cerrar el modal de edición
        function cerrarModal() {
            document.getElementById("modalEditar").style.display = "none";
        }

    </script>
</body>

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