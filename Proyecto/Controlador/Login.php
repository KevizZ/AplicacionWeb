<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register - MagtimusPro</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="css/Login y Register.css">
</head>
<body>

        <main>

            <div class="contenedor__todo">
                <div class="caja__trasera">
                    <div class="caja__trasera-login">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <p>Inicia sesión para entrar en la página</p>
                        <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                    </div>
                    <div class="caja__trasera-register">
                        <h3>¿Aún no tienes una cuenta?</h3>
                        <p>Regístrate para que puedas iniciar sesión</p>
                        <button id="btn__registrarse">Regístrarse</button>
                    </div>
                </div>

                <!--Formulario de Login y registro-->
                <div class="contenedor__login-register">
                    <!--Login-->
                    <form action="" class="formulario__login">
                        <h2>Iniciar Sesión</h2>
                        <input type="text" placeholder="Correo Electronico">
                        <input type="password" placeholder="Contraseña">
                        <button>Entrar</button>
                    </form>

                    <!--Register-->
                    <form action="controlador_registro_usuario.php" method="POST" class="formulario__register">
                        <h2>Regístrarse</h2>
                        <input type="text" placeholder="Nombre Completo" name="nombre_completo">
                        <input type="text" placeholder="Apellido Completo" name="apellido_completo">
                        <input type="text" placeholder="Cedula Completo" name="cedula_completo">
                        <input type="text" placeholder="Correo Electronico" name="correo electronico_coompleto">
                        <input type="password" placeholder="Contraseña" name="contraseña_completo">
                        <div class="input-contenedor">
				                  <i class="fas fa-user icon"></i>
				                  <select name="rol" id="rol">
					                  <option value="director">Director</option>
					                  <option value="profesor">Profesor</option>
					                  <option value="adscripto">Adscripto</option>
				                  </select>
			            </div>
                        <button>Regístrarse</button>
                    </form>
                </div>
            </div>

        </main>

        <script src="javascript/Login y Register.js"></script>
</body>
</html>