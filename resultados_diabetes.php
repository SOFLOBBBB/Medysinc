<?php

session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit();
}

$nombreUser = $_SESSION['idUser'];
$idUser = $_SESSION['nomUser'];
$correoUser = $_SESSION['correoUser'];
$rolUser = $_SESSION['rol'];

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Predicción de Diabetes</title>

        <link rel="stylesheet" href="css/styleResultados.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-statistics@7.7.4"></script>
        <script src="js/notificaciones.js"></script>

    </head>

    <body>

        <?php include 'menu.php'; ?>

        <div class="container">
            <div class="info">
                <div class="anos-texto-comienzo">
                    <h2 class="titulo-anos">Predicción de Diabetes para</h2>
                    <h2 class="anos-especificos-titulo"> <?php echo $_POST["anio"];?> </h2> <!-- Aqui va el año que se paso -->
                </div> 
                <h1 id="titulo-numeros" class="titulo-numeros"></h1> <!-- Aqui va el calculo de padecimientos -->
                <p>de personas con diabetes en el mundo.</p>
                <div class="recommendations">
                    <h3 class="recomendacion-texto">Recomendaciones para prevenir la diabetes</h3>
                    <ul>
                        <li>• Mantén un peso saludable y realiza actividad física regular</li>
                        <li>• Sigue una dieta balanceada rica en fibra y baja en azúcares</li>
                        <li>• Monitorea regularmente tus niveles de glucosa</li>
                        <li>• Consulta a tu médico para chequeos preventivos</li>
                        <li>• Mantén un estilo de vida activo y reduce el sedentarismo</li>
                    </ul>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="prediccionChart"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                console.log("DOM completamente cargado y analizado");

                // Datos proporcionados manualmente
                const datosHistoricos = [
                    {año: 1980, prevalenciaDiabetes: 104.54},
                    {año: 1981, prevalenciaDiabetes: 114.67},
                    {año: 1982, prevalenciaDiabetes: 117.90},
                    {año: 1983, prevalenciaDiabetes: 133.42},
                    {año: 1984, prevalenciaDiabetes: 135.85},
                    {año: 1985, prevalenciaDiabetes: 142.60},
                    {año: 1986, prevalenciaDiabetes: 150.66},
                    {año: 1987, prevalenciaDiabetes: 154.65},
                    {año: 1988, prevalenciaDiabetes: 161.25},
                    {año: 1989, prevalenciaDiabetes: 172.81},
                    {año: 1990, prevalenciaDiabetes: 183.37},
                    {año: 1991, prevalenciaDiabetes: 189.85},
                    {año: 1992, prevalenciaDiabetes: 193.47},
                    {año: 1993, prevalenciaDiabetes: 196.40},
                    {año: 1994, prevalenciaDiabetes: 208.02},
                    {año: 1995, prevalenciaDiabetes: 217.21},
                    {año: 1996, prevalenciaDiabetes: 219.58},
                    {año: 1997, prevalenciaDiabetes: 232.63},
                    {año: 1998, prevalenciaDiabetes: 237.90},
                    {año: 1999, prevalenciaDiabetes: 243.40},
                    {año: 2000, prevalenciaDiabetes: 254.14},
                    {año: 2001, prevalenciaDiabetes: 254.86},
                    {año: 2002, prevalenciaDiabetes: 264.43},
                    {año: 2003, prevalenciaDiabetes: 272.18},
                    {año: 2004, prevalenciaDiabetes: 281.69},
                    {año: 2005, prevalenciaDiabetes: 288.52},
                    {año: 2006, prevalenciaDiabetes: 293.00},
                    {año: 2007, prevalenciaDiabetes: 303.85},
                    {año: 2008, prevalenciaDiabetes: 310.97},
                    {año: 2009, prevalenciaDiabetes: 316.26},
                    {año: 2010, prevalenciaDiabetes: 326.30},
                    {año: 2011, prevalenciaDiabetes: 324.35},
                    {año: 2012, prevalenciaDiabetes: 334.53},
                    {año: 2013, prevalenciaDiabetes: 345.23},
                    {año: 2014, prevalenciaDiabetes: 354.00},
                    {año: 2015, prevalenciaDiabetes: 355.49},
                    {año: 2016, prevalenciaDiabetes: 365.05},
                    {año: 2017, prevalenciaDiabetes: 371.41},
                    {año: 2018, prevalenciaDiabetes: 374.24},
                    {año: 2019, prevalenciaDiabetes: 391.14},
                    {año: 2020, prevalenciaDiabetes: 388.47},
                    {año: 2021, prevalenciaDiabetes: 401.49},
                    {año: 2022, prevalenciaDiabetes: 411.24},
                    {año: 2023, prevalenciaDiabetes: 416.36},
                    {año: 2024, prevalenciaDiabetes: 422.92}
                ];

                const años = datosHistoricos.map(dato => dato.año);
                const valoresDiabetes = datosHistoricos.map(dato => dato.prevalenciaDiabetes);

                // Calcular la regresión lineal
                const paresDatos = años.map((año, index) => [año, valoresDiabetes[index]]);
                const { m: pendiente, b: intersección } = ss.linearRegression(paresDatos);
                console.log("Regresión lineal calculada:", { pendiente, intersección });

                // Función de la línea de regresión
                const calcularRegresion = (año) => pendiente * año + intersección;

                // Gráfico 2: Solo predicciones futuras

                // Años a implementar
                const añoLimite = <?php echo $_POST["anio"]; ?>;
                let añoActual = "2020";

                const añosFuturos = [];
                            
                // Llenamos el array hasta el año límite
                while (añoActual <= añoLimite) {
                    añosFuturos.push(añoActual);
                    añoActual++;
                }

                //const añosFuturos = [2025, 2026, 2027, 2028, 2029, 2030, 2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2045];
                const prediccionesFuturas = añosFuturos.map(año => calcularRegresion(año));
                console.log("Predicciones futuras:", prediccionesFuturas);

                // Obtener el último valor de la predicción
                const ultimaPrediccion = prediccionesFuturas[prediccionesFuturas.length - 1];
                // Actualizar el HTML con el último valor
                document.getElementById("titulo-numeros").textContent = `${ultimaPrediccion.toFixed(1)} mil`;

                const contextoPrediccion = document.getElementById('prediccionChart').getContext('2d');
                const graficoPrediccion = new Chart(contextoPrediccion, {
                    type: 'scatter',
                    data: {
                        labels: añosFuturos,
                        datasets: [
                            {
                                label: 'Predicciones futuras de diabetes',
                                data: prediccionesFuturas,
                                borderColor: 'rgb(230, 183, 80)',
                                borderWidth: 2,
                                fill: false,
                                showLine: true // Mostrar solo la línea de predicciones
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'linear',
                                position: 'bottom',
                                title: {
                                    display: true,
                                    text: 'Año'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Personas con diabetes (millones)'
                                }
                            }
                        }
                    }
                });
            });
        </script>

    </body>

</html>