<?php
require_once("Verificador.php");
require_once("Menu_Lateral.php");
require_once("../Repositorio/Repositorio.php");
require_once("../Repositorio/Database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personas Involucradas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-secondary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="text-center text-light">Buscador de Personas</h1>
            <form method="POST" class="col-md-6 bg-light rounded shadow">
                <div class="mb-3 mt-3">
                    <label for="cedula" class="form-label">Cedula</label>
                    <input type="text" class="form-control" id="cedula" name="cedula">
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido">
                </div>

                <input type="hidden" name="id_incidente"
                    value="<?php echo isset($_GET['id_incidente']) ? $_GET['id_incidente'] : (isset($_POST['id_incidente']) ? $_POST['id_incidente'] : ''); ?>">

                <input type="hidden" id="id_persona" name="id_persona" value="">

                <div class="text-center mt-3 mb-3">
                    <button id="btnPersonas" class="btn btn-warning align-left d-none">Personas</button>
                    <button type="submit" class="btn btn-primary" id="btnBuscar" name="buscar">Buscar</button>
                    <button type="submit" formaction="Alta_Persona.php" id="btnAñadir" class="btn btn-success"
                        name="añadir">Añadir</button>
                </div>
            </form>
        </div>

        <div class="table table-striped mt-4">
            <table class="table table-striped align-middle" id="tablaPersonas">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cedula = isset($_POST["cedula"]) ? $_POST["cedula"] : "";
                    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
                    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
                    $id_incidente = isset($_GET['id_incidente']) ? $_GET['id_incidente'] : (isset($_POST['id_incidente']) ? $_POST['id_incidente'] : '');

                    // Realiza la búsqueda en la base de datos utilizando los valores de $cedula, $nombre y $apellido
                    $personasEncontradas = BD::buscarPersonas($cedula, $nombre, $apellido, $id_incidente);

                    foreach ($personasEncontradas as $P) {
                        echo "<tr>
                        <td>" . $P->getId() . "</td>
                                <td>" . $P->getCedula() . "</td>
                                <td>" . $P->getNombre() . "</td>
                                <td>" . $P->getApellido() . "</td>
                                <td>
                                <button
                                type='button'
                                 class='btn btn-warning btnIncidentes' 
                                data-id_persona='" . $P->getId() . "'
                                data-cedula='" . $P->getCedula() . "'
                                data-nombre='" . $P->getNombre() . "'
                                data-apellido='" . $P->getApellido() . "'>Incidentes</button>
                                <a class='btn btn-danger' href='Baja_Persona.php?id_persona=" . $P->getId() . "'>Eliminar <i class='bi bi-trash'></i></a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="table table-striped mt-4">
            <table class="table table-striped table-hover  align-middle d-none" id="tablaIncidentes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Prioridad</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se mostrarán los incidentes -->
                    <?php
                    include_once("../Negocio/Incidente.php");

                    if (isset($_POST["id_persona"])) {

                        $Incidentes = BD::obtenerIncidentesPersonas($_POST["id_persona"]);
                        $P = BD::getPersona($_POST["id_persona"]);

                        foreach ($Incidentes as $I) {
                            echo "<tr>
                            <td>" . $I->getId() . "</td>
                            <td><div class='overflow-auto' style='white-space: nowrap;'>" . $I->getDescripcion() . "</div></td>
                            <td>" . $I->getCategoria() . "</td>
                            <td>" . $I->getPrioridad() . "</td>
                            <td>" . $I->getFecha() . "</td>
                            <td>" . $I->getEstado() . "</td>
                            <td>" . $P->getRol() . "</td>
                        ";
                        }


                    }



                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>

        function guardarEstadoTablas() {
            // Obtener los elementos y sus valores actuales
            const nombre = document.getElementById("nombre").value;
            const apellido = document.getElementById("apellido").value;
            const cedula = document.getElementById("cedula").value;
            const id_persona = document.getElementById("id_persona").value;

            // Guardar los valores en el almacenamiento local
            localStorage.setItem("nombre", nombre);
            localStorage.setItem("apellido", apellido);
            localStorage.setItem("cedula", cedula);
            localStorage.setItem("id_persona", id_persona);


            const tablaPersonas = document.getElementById("tablaPersonas");
            const tablaIncidentes = document.getElementById("tablaIncidentes");

            localStorage.setItem("tablaPersonasVisible", tablaPersonas.classList.contains("d-none"));
            localStorage.setItem("tablaIncidentesVisible", !tablaIncidentes.classList.contains("d-none"));
        }

        // Función para cargar el estado de visibilidad de las tablas y aplicarlo
        function cargarEstadoTablas() {
            // Cargar los valores almacenados desde el almacenamiento local
            const nombreGuardado = localStorage.getItem("nombre");
            const apellidoGuardado = localStorage.getItem("apellido");
            const cedulaGuardada = localStorage.getItem("cedula");
            const id_personaGuardado = localStorage.getItem("id_persona");

            // Asignar los valores a los elementos HTML
            document.getElementById("nombre").value = nombreGuardado;
            document.getElementById("apellido").value = apellidoGuardado;
            document.getElementById("cedula").value = cedulaGuardada;
            document.getElementById("id_persona").value = id_personaGuardado;

            const tablaPersonas = document.getElementById("tablaPersonas");
            const tablaIncidentes = document.getElementById("tablaIncidentes");

            const tablaPersonasVisible = localStorage.getItem("tablaPersonasVisible") === "false";
            const tablaIncidentesVisible = localStorage.getItem("tablaIncidentesVisible") === "true";

            if (tablaPersonasVisible) {
                tablaPersonas.classList.remove("d-none");
            } else {
                tablaPersonas.classList.add("d-none");
            }

            if (tablaIncidentesVisible) {
                tablaIncidentes.classList.remove("d-none");
                document.getElementById("btnPersonas").classList.remove("d-none");
            } else {
                tablaIncidentes.classList.add("d-none");
            }
        }


        // Cuando se carga la página, cargar el estado de visibilidad de las tablas desde el almacenamiento local
        window.addEventListener("load", function () {
            cargarEstadoTablas();
        });

        // Selección de botones de incidentes por clase
        const botonesIncidentes = document.querySelectorAll(".btnIncidentes");

        botonesIncidentes.forEach((boton) => {
            boton.addEventListener("click", function () {

                const nombre = document.getElementById("nombre");
                const apellido = document.getElementById("apellido");
                const cedula = document.getElementById("cedula");
                const id_persona = document.getElementById("id_persona");

                var tablaPersonas = document.getElementById("tablaPersonas");
                var tablaIncidentes = document.getElementById("tablaIncidentes");

                document.getElementById("btnPersonas").classList.remove("d-none");

                tablaIncidentes.classList.remove("d-none");
                tablaPersonas.classList.add("d-none");

                id_persona.value = this.getAttribute('data-id_persona');
                cedula.value = this.getAttribute('data-cedula');
                nombre.value = this.getAttribute('data-nombre');
                apellido.value = this.getAttribute('data-apellido');

                guardarEstadoTablas();

                document.querySelector("form").submit();

            });
        });


        document.getElementById("btnPersonas").addEventListener("click", function () {

            const nombre = document.getElementById("nombre");
            const apellido = document.getElementById("apellido");
            const cedula = document.getElementById("cedula");
            const id_persona = document.getElementById("id_persona");

            var tablaPersonas = document.getElementById("tablaPersonas");
            var tablaIncidentes = document.getElementById("tablaIncidentes");

            document.getElementById("btnPersonas").classList.add("d-none");

            tablaIncidentes.classList.add("d-none");
            tablaPersonas.classList.remove("d-none");

            id_persona.value = null;
            cedula.value = null;
            nombre.value = null;
            apellido.value = null;

            guardarEstadoTablas();

        });


    </script>

</body>

</html>

<style>
    .table td {
        max-width: 300px;
        /* Define el ancho máximo de todas las celdas de la tabla */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>