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
<html lang="es">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Predicción de Diabetes</title>

        <link rel="stylesheet" href="css/ingreso_datos.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">

        <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-statistics@7.7.4"></script>
        <script src="js/notificaciones.js"></script>

    </head>

    <body>

        <?php include 'menu.php'; ?>

        <div class="contenedor">

            <div class="contenido">
                <div class="texto-contenido"><br>
                    <h1>Gráfica que mapea la cantidad de diabéticos entre 1980 y 2024.</h1>
                    <p class="introduce">Introduce el año que te interesa predecir:</p>
                    <div class="form-container">
                        <form action="resultados_diabetes.php" method="post">
                            <input type="number" name="anio" min="2025" max="2150" placeholder="Ingresa el año..." required>
                            <button class="boton" type="submit">Enviar</button>
                        </form>
                    </div>

                    <br><p class="nota-numerico">El valor debe ser mayor al año actual</p>
                </div>

                <div class="graficas">
                    <canvas id="diabetesChart" class="diabetesChart" width="500%" height="250%"></canvas>
                </div>
            </div>

            <div class="sabias-que">
                <img src="src/imagen-inferior-copy.png" alt="imagen-inferior" class="imagen-inferior">
                <h2>¿SABÍAS QUE?</h2>
                <br><p>La diabetes es una de las enfermedades más comunes en </p>
                <p>el mundo y ya afecta a más de 422 millones de personas.</p><br>
                <a href="recomendaciones_diabetes.php" class="boton boton-recomendaciones">Recomendaciones para prevenir</a><br>
            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                console.log("DOM completamente cargado y analizado");
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
                const paresDatos = años.map((año, index) => [año, valoresDiabetes[index]]);
                const { m: pendiente, b: intersección } = ss.linearRegression(paresDatos);
                console.log("Regresión lineal calculada:", { pendiente, intersección });
                const calcularRegresion = (año) => pendiente * año + intersección;
                const valoresPredichos = años.map(año => calcularRegresion(año));
                const contextoGrafico = document.getElementById('diabetesChart').getContext('2d');
                const grafico = new Chart(contextoGrafico, {
                    type: 'scatter',
                    data: {
                        labels: años,
                        datasets: [
                            {
                                label: 'Prevalencia real de diabetes',
                                data: valoresDiabetes,
                                backgroundColor: 'rgba(244, 209, 95, 0.7)', // Color de fondo con opacidad
                                borderColor: '#f4d15f', // Cambia el color a #f4d15f
                                borderWidth: 1,
                                showLine: false
                            },
                            {
                                label: 'Línea de regresión',
                                data: valoresPredichos,
                                borderColor: '#00cadc', // Color de la línea de regresión
                                borderWidth: 2, // Grosor de la línea de regresión
                                fill: false,
                                showLine: true
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
                                    text: 'Año',
                                    color: 'white' // Color del título en blanco
                                },
                                ticks: {
                                    color: 'white' // Color de los números en el eje X
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Personas con diabetes (millones)',
                                    color: 'white' // Color del título en blanco
                                },
                                ticks: {
                                    color: 'white' // Color de los números en el eje Y
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.2)' // Color de las líneas de fondo
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'white' // Color de las etiquetas de la leyenda
                                }
                            }
                        },
                        elements: {
                            line: {
                                borderColor: '#00cadc' // Color de la línea de regresión
                            }
                        }
                    }
                });
            });
        </script>

    </body>

</html>