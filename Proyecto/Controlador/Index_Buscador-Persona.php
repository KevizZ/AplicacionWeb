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
            <h1 class="text-center text-white">Gestión de Personas Involucradas</h1>
            <form class=" col-md-6 mt-4 bg-light rounded shadow" method="POST">
                <div class="mb-3 mt-3">
                    <label for="cedula" class="form-label">Cedula</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-select" name="rol">
                        <option value=""></option>
                        <?php
                        $roles = BD::getRoles();
                        // Agrega las opciones personalizadas recuperadas de la base de datos al select
                        foreach ($roles as $rol) {
                            echo "<option value='" . $rol . "'>" . $rol . "</option>";
                        }
                        ?>
                    </select>
                    <input type="text" class="form-control" name="rol_personalizado"
                        placeholder="Rol Personalizado (El rol agregado aquí aparecerá en la caja de arriba para seleccionar)">

                </div>

                <div class="mb-3">
                    <label for="evento" class="form-label">Evento</label>
                    <select class="form-select" name="evento">
                        <option value="-1">Selecciona un evento</option>
                        <?php
                        $Eventos = BD::getEventosIncidente($_GET["id_incidente"]);
                        foreach ($Eventos as $E) {
                            echo "<option value='" . $E->getID() . "'>" . $E->getDescripcion() . "</option>";
                        }
                        ?>
                    </select>
                </div>


                <input type="hidden" name="id_incidente"
                    value="<?php echo isset($_GET['id_incidente']) ? $_GET['id_incidente'] : (isset($_POST['id_incidente']) ? $_POST['id_incidente'] : ''); ?>">

                <div class="text-center mb-3">
                    <button type="submit" formaction="Alta_Persona-Incidente.php" class="btn btn-success"
                        value="Añadir">Añadir</button>
                    <button type="submit" class="btn btn-primary" value="Buscar" formnovalidate>Buscar</button>
                </div>
            </form>
        </div>

        <div class="table-container mt-3">
            <h2 class="text-center text-white">Involucrados</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Rol</th>
                            <th>Evento</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id_incidente = isset($_GET['id_incidente']) ? $_GET['id_incidente'] : (isset($_POST['id_incidente']) ? $_POST['id_incidente'] : '');

                        $Personas = BD::obtenerPersonasIncidente($_GET["id_incidente"]);

                        foreach ($Personas as $P) {
                            echo "<tr>
                        <td>" . $P->getId() . "</td>
                        <td>" . $P->getCedula() . "</td>
                        <td>" . $P->getNombre() . "</td>
                        <td>" . $P->getApellido() . "</td>
                        <td>" . $P->getRol() . "</td>
                        <td>" . BD::getPersonaEvento($P->getId()) . "</td>
                        <td>
                            <a class='btn btn-danger' href='Baja_Persona-Incidente.php?id_persona=" . $P->getId() . "&id_incidente=" . $id_incidente . "'>Quitar <i class='bi bi-trash'></i></a>
                        </td>
                    </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-container mt-3">
            <h2 class="text-center text-white">Personas</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm align-middle">
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
                        $id_incidente = isset($_GET['id_incidente']) ? $_GET['id_incidente'] : (isset($_POST['id_incidente']) ? $_POST['id_incidente'] : '');

                        $cedula = isset($_POST["cedula"]) ? $_POST["cedula"] : "";
                        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
                        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";

                        $personasEncontradas = BD::buscarPersonas($cedula, $nombre, $apellido, $id_incidente);

                        foreach ($personasEncontradas as $P) {
                            echo "<tr>
                        <td>" . $P->getId() . "</td>
                        <td>" . $P->getCedula() . "</td>
                        <td>" . $P->getNombre() . "</td>
                        <td>" . $P->getApellido() . "</td>
                        <td>
                            <a class='btn btn-success add-person-button' 
                            data-cedula='" . $P->getCedula() . "'
                            data-nombre='" . $P->getNombre() . "'
                            data-apellido='" . $P->getApellido() . "'>Añadir</a>
                        </td>
                    </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cedulaPersona = document.getElementById('cedula');
            const nombrePersona = document.getElementById('nombre');
            const apellidoPersona = document.getElementById('apellido');
            const addPersonButtons = document.querySelectorAll('.add-person-button');

            addPersonButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Obtén los datos de la persona desde los atributos data
                    const cedula = this.getAttribute('data-cedula');
                    const nombre = this.getAttribute('data-nombre');
                    const apellido = this.getAttribute('data-apellido');

                    console.log(cedula);

                    // Llena los campos del formulario de persona con los datos
                    cedulaPersona.value = cedula;
                    nombrePersona.value = nombre;
                    apellidoPersona.value = apellido;
                });
            });
        });
    </script>

</body>
<style>
</style>

</html>