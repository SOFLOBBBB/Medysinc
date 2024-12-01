document.addEventListener("DOMContentLoaded", () => {
    const botonNotificaciones = document.getElementById("notificaciones-boton");
    const barraNotificaciones = document.getElementById("barra-notificaciones");
    const cerrarNotificaciones = document.getElementById("cerrar-notificaciones");
    const indicadorNotificaciones = document.getElementById("indicador-notificaciones");
    const listaNotificaciones = document.getElementById("lista-notificaciones");

    // Hacer una solicitud AJAX al servidor para obtener las notificaciones
    fetch('obtener_notificaciones.php')
    .then(response => response.text())  // Cambiar a text() para obtener la respuesta completa
    .then(data => {
        try {
            const jsonData = JSON.parse(data);  // Intentar parsear como JSON
            if (jsonData.length > 0) {
                indicadorNotificaciones.classList.add("activo");
                jsonData.forEach(notificacion => {
                    const li = document.createElement("li");
                    li.textContent = notificacion.mensaje;
                    listaNotificaciones.appendChild(li);
                });
            }
        } catch (error) {
            // Manejo del error de parseo, sin mostrar en consola
        }
    })
    .catch(error => {
        // Manejo de errores de la solicitud, sin mostrar en consola
    });

    // Abrir la barra de notificaciones
    botonNotificaciones.addEventListener("click", () => {
        barraNotificaciones.classList.toggle("ocultar");
    });

    // Cerrar la barra de notificaciones
    cerrarNotificaciones.addEventListener("click", () => {
        barraNotificaciones.classList.add("ocultar");
    });
});