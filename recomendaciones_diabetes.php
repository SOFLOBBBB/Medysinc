<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recomendaciones</title>
        <link rel="stylesheet" href="css/stylesRecomendaciones.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
    </head>

    <body>
        <?php include 'menu.php'; ?>

        <div class="header_titulo">
            <h1>Recomendaciones para Prevenir la Diabetes</h1>
        </div>
        <div class="main-content">
            <section class="recommendations">
                <div class="card">
                    <h2>Mantén un peso saludable</h2>
                    <p>El sobrepeso aumenta el riesgo de diabetes tipo 2. Mantener un peso adecuado puede prevenir su desarrollo.</p>
                    <img src="src/card1.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Adopta una alimentación saludable</h2>
                    <p>Evita alimentos procesados y ricos en azúcar. Opta por frutas, verduras, granos integrales y grasas saludables.</p>
                    <img src="src/card2.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Mantente físicamente activo</h2>
                    <p>Realiza al menos 150 minutos de actividad física moderada por semana para mejorar la sensibilidad a la insulina.</p>
                    <img src="src/card3.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Controla el estrés</h2>
                    <p>El estrés prolongado afecta los niveles de glucosa. Practica técnicas de relajación como yoga o meditación.</p>
                    <img src="src/card4.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Duerme lo suficiente</h2>
                    <p>Un buen descanso mejora la regulación de la glucosa. Intenta dormir entre 7 y 8 horas por noche.</p>
                    <img src="src/card5.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Realiza chequeos regulares</h2>
                    <p>Monitorea tu glucosa y presión arterial regularmente, especialmente si tienes antecedentes familiares.</p>
                    <img src="src/card6.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Evita hábitos nocivos</h2>
                    <p>Dejar de fumar y moderar el consumo de alcohol reduce el riesgo de desarrollar diabetes.</p>
                    <img src="src/card7.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Mantente hidratado</h2>
                    <p>Prefiere agua sobre bebidas azucaradas para mantener un metabolismo saludable.</p>
                    <img src="src/card8.jpeg" alt="Peso saludable">
                </div>
                <div class="card">
                    <h2>Educa y motiva a tu familia</h2>
                    <p>Involucra a tus seres queridos en un estilo de vida saludable para prevenir juntos la diabetes.</p>
                    <img src="src/card9.jpeg" alt="Peso saludable">
                </div>
            </section>
        </div>
    </body>
</html>

</html>