<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MEDISYNC</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="css/stylePortada.css?v=<?php echo time(); ?>">
    </head>

    <body>
        <header>
            <div class="logo">
                <p class="letra-logo">MEDISYNC</p>
            </div>
            <nav>
                <ul>
                    <li><a class="boton" href="expedientes.php">Expedientes</a></li>
                    <li><a class="boton" href="farmacia.php">Farmacia</a></li>
                    <li><a class="boton agenda" href="agenda.php">Agenda</a></li>
                    <li><a class="boton boton-predictor" href="ingreso_anos.php">Predictor</a></li>
                </ul>
            </nav>
        </header>

        <section id="portada" class="portada">
            <div class="portada-content">
                <!--<h1><span class="highlight">ESTIMACIÓN</span></h1>
                <p class="subtext">DE <span class="highlight">DIABETES</span> PROYECCIONES</p>
                <p class="subtext">PARA EL <span class="highlight">FUTURO</span></p>-->
            </div>
            <div class="hero">
                <p class="conoce">Conoce más sobre Medisync</p>
                <div class="scroll-down">⌄</div>
            </div>
        </section>

        <section id="que-es" class="que-es">
            <div class="que-es-content">
                <h2>¿QUÉ ES?</h2>
                <p>Es un sistema experto médico diseñado para ayudar en la predicción de enfermedades, como la diabetes, utilizando algoritmos como la regresión lineal y logística, se dirige a usuarios y médicos con el fin de consultar, gestionar, actualizar y predecir información médica clave para mejorar la toma de decisiones en salud.</p>
            </div>
            <img src="src/doctora.png" alt="quees-image" class="quees-image">
        </section>

        <section id="problematica" class="problematica">
            <img src="src/problematica.png" alt="Doctor" class="doctor-image">
            <div class="problematica-content">
                <h2>PROBLEMÁTICA</h2>
                <p>Actualmente, el diagnóstico temprano de enfermedades crónicas, como la diabetes, es un desafío debido a la falta de herramientas accesibles para la predicción de riesgos. Los métodos convencionales pueden ser tardíos y caros.</p>
            </div>
        </section>

        <section id="objetivo" class="objetivo">
            <div class="objetivo-content">
                <h2>OBJETIVO</h2>
                <p>El objetivo de Medisync es proporcionar una herramienta accesible y confiable para predecir riesgos de salud, facilitando una gestión integral de la información médica y promoviendo la prevención y tratamiento oportuno de enfermedades crónicas.</p>
            </div>
            <img src="src/objetivo.png" alt="Objetivo" class="objetivo-image">
        </section>

        <footer>
            <div class="footer-content">
                <div id="mas-info">Más información:</div>
                <a href="https://www.instagram.com/medisync" class="social-link">
                    <i class="fab fa-instagram"></i> Medysinc
                </a>
                <a href="https://www.facebook.com/medisync" class="social-link">
                    <i class="fab fa-facebook"></i> Medysinc
                </a>
                <a href="https://www.twitter.com/medisync" class="social-link">
                    <i class="fab fa-twitter"></i> Medysinc
                </a>
            </div>
        </footer>
    </body>
</html>
