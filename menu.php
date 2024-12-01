<header>
    <div class="notificacion">
        <button id="notificaciones-boton" class="notificaciones-boton">
            <img src="src/icon-notificacion.png" alt="Notificaciones" class="notificacion-img" />
            <span id="indicador-notificaciones" class="indicador-rojo"></span>
        </button>
        <div id="barra-notificaciones" class="barra-notificaciones ocultar">
            <div class="notificaciones-header">
                <h3>Notificaciones</h3>
                <button id="cerrar-notificaciones" class="cerrar-notificaciones">X</button>
            </div>
            <ul id="lista-notificaciones" class="lista-notificaciones">
                <!-- Aquí se cargarán las notificaciones dinámicamente -->
            </ul>
        </div>
    </div>
    <a class="boton-home" href="salir.php">
        <img src="src/casaVuelta.png" alt="home" class="home-img">
    </a>
    <nav>
        <ul>
            <?php
                if ($_SESSION["rol"] == 2) {
                    echo '<li><a class="boton" href="hoja_Evolucion.php">Hoja EVO</a></li>';
                }
            ?>
            <li><a class="boton" href="expedientes.php">Expedientes</a></li>
            <li><a class="boton" href="farmacia.php">Farmacia</a></li>
            <li><a class="boton agenda" href="agenda.php">Agenda</a></li>
            <li><a class="boton boton-predictor" href="ingreso_anos.php">Predictor</a></li>
        </ul>
    </nav>
</header>