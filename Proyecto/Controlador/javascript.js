// Ingresar Incidente.php
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
function abrirModal(indice) {
    document.getElementById("modalEditar").style.display = "block";

    // Guardar el índice en el Array
    GuardarIndice(indice);
}

function GuardarIndice(indice) {
    $.ajax({
        type: "POST",
        url: "Controlador_Incidente.php",
        data: { indice: indice },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

// Función para cerrar el modal de edición
function cerrarModal() {
    document.getElementById("modalEditar").style.display = "none";
}
// Fin de Ingresar Incidente.php;

