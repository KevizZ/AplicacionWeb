<!DOCTYPE html>
<html>

<head>
    <title>Iniciar Sesión</title>
    <!-- Incluir CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-secondary">
    <div class="container mt-5">
        <div id="login-form" class="row justify-content-center form-container active">
            <!-- Formulario de Inicio de Sesión -->
            <h2 class="text-center text-white">Iniciar Sesión</h2>
            <form action="Controlador_Login.php" class="col-md-6 bg-light rounded p-4 shadow" method="post">
                <div class="mb-3">
                    <label for="cedula" class="form-label">Cedula</label>
                    <input type="text" name="cedula" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <input type="password" name="contraseña" class="form-control" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Iniciar Sesión">

                <input type="hidden" name="valor" value="login">
            </form>
            <p class="text-center text-white">No tienes una cuenta? <a href="#" id="show-register-form">Regístrate</a>
            </p>
        </div>

        <div id="register-form" class="row justify-content-center form-container">
            <!-- Formulario de Registro (inicialmente oculto) -->
            <h2 class="text-center text-white">Registro</h2>
            <form action="Controlador_Login.php" class="col-md-6 bg-light rounded p-4 shadow" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="cedula" class="form-label">Cedula</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="cargo" class="form-label">Rol:</label>
                    <select id="cargo" name="cargo" class="form-select">
                        <option value="Director">Director</option>
                        <option value="Profesor">Profesor</option>
                        <option value="Adscripto">Adscripto</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirmar_contraseña" class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="confirmar_contraseña" class="form-control" required>
                </div>

                <input type="hidden" name="valor" value="register">

                <input type="submit" class="btn btn-primary" value="Registrarse">
            </form>
            <p class="text-center text-white">¿Ya tienes una cuenta? <a href="#" id="show-login-form">Iniciar Sesión</a>
            </p>
        </div>
    </div>
    <!-- Incluir JS de Bootstrap 5 al final del archivo -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Mostrar el formulario de registro al hacer clic en "Regístrate"
            document.getElementById("show-register-form").addEventListener("click", function () {
                document.getElementById("login-form").classList.remove("active");
                document.getElementById("register-form").classList.add("active");
            });

            // Mostrar el formulario de inicio de sesión al hacer clic en "Iniciar Sesión"
            document.getElementById("show-login-form").addEventListener("click", function () {
                document.getElementById("register-form").classList.remove("active");
                document.getElementById("login-form").classList.add("active");
            });
        });
    </script>
</body>
<style>
    .form-container {
        display: none;
    }

    .form-container.active {
        display: flex;
    }
</style>
</style>

</html>