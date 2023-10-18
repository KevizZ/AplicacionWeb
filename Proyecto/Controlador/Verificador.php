<?php
session_start();


// Verifica si la sesión está activa
if (!isset($_SESSION["sesion_valida"]) || $_SESSION["sesion_valida"] !== true) {
    // La sesión no está activa, redirige al usuario al formulario de inicio de sesión
    header("Location: Index_Login.php");
    exit; // Asegúrate de que el script se detenga después de la redirección
} else if (isset($_GET["log"]) && $_GET["log"] == "logout") {
    $_SESSION["sesion_valida"] = false;
    $_SESSION["ci_usuario"] = null;
    header("Location: Index_Login.php");
}
?>