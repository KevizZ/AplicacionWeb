
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const menuIcon = document.querySelector('.menu-icon');
  
    if (sidebar.style.width === '0px' || sidebar.style.width === '') {
        sidebar.style.width = '250px'; // Expandir la barra lateral
        menuIcon.style.left = '230px'; // Mover el icono de menú a la derecha
    } else {
        sidebar.style.width = '0px'; // Contraer la barra lateral
        menuIcon.style.left = '0px'; // Mover el icono de menú a la izquierda
    }
}

toggleSidebar();

// Función para cargar el contenido de las páginas
function cargarPagina(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.content').innerHTML = data;
        })
        .catch(error => {
            console.error('Error al cargar la página:', error);
        });
}

// Escuchar clics en los enlaces del menú lateral y cargar páginas
document.addEventListener('DOMContentLoaded', function() {
    var enlaces = document.querySelectorAll('.sidebar a');
    enlaces.forEach(function(enlace) {
        enlace.addEventListener('click', function(event) {
            event.preventDefault();
            var url = enlace.getAttribute('href');
            cargarPagina(url);
        });
    });
});

// Cargar la primera página al cargar la página principal
document.addEventListener('DOMContentLoaded', function() {
    cargarPagina('Index_Incidente.php'); // Cambia esto al nombre de tu primera página
});



