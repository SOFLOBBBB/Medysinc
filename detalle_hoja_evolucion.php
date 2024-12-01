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

// Incluir el archivo de conexión a la base de datos
include 'funciones/conecta.php';

// Llamar a la función conecta() para obtener la conexión
$conn = conecta();

// Obtener el ID de la hoja de evolución desde la URL
$id_hoja = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_hoja == 0) {
    echo "Hoja de evolución no válida.";
    exit();
}

// Consultar los detalles de la hoja de evolución, incluyendo el nombre y apellido de paciente y médico
$sql = "SELECT h.*, 
               u.nombre AS nombre_paciente, u.apellidos AS apellido_paciente, 
               m.nombre AS nombre_medico, m.apellido AS apellido_medico
        FROM hoja_evolucion h
        JOIN usuarios u ON h.id_usuario = u.id
        JOIN medicos m ON h.id_medico = m.id
        WHERE h.id = $id_hoja";
$result = $conn->query($sql);
$hoja = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Hoja de Evolución</title>
    <link rel="stylesheet" href="css/detalle_hoja_evolucion.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="js/notificaciones.js"></script>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="contenedor">
         <!-- Banner -->
         <div class="banner">
            <img src="src/banner-image2.png" alt="Medicamentos">
            <h1 class="titulo">Hoja de Evolución Medica</h1>
        </div>

        <div class="hoja-detalle">
            <div class="hoja-header">
                <h3>Fecha: <?php echo $hoja['fecha']; ?></h3>
                <p><strong>Paciente:</strong> <?php echo $hoja['nombre_paciente'] . " " . $hoja['apellido_paciente']; ?></p>
                <p><strong>Médico:</strong> <?php echo $hoja['nombre_medico'] . " " . $hoja['apellido_medico']; ?></p>
            </div>

            <div class="hoja-info">
                <div class="campo">
                    <strong>Diagnóstico:</strong>
                    <p><?php echo $hoja['diagnostico']; ?></p>
                </div>
                <div class="campo">
                    <strong>Tratamiento:</strong>
                    <p><?php echo $hoja['tratamiento']; ?></p>
                </div>
                <div class="campo">
                    <strong>Observaciones:</strong>
                    <p><?php echo $hoja['observaciones']; ?></p>
                </div>
                <div class="campo">
                    <strong>Signos Vitales:</strong>
                    <p><?php echo $hoja['signosVitales']; ?></p>
                </div>
                <div class="campo">
                    <strong>Sintomas:</strong>
                    <p><?php echo $hoja['sintomas']; ?></p>
                </div>
                <div class="campo">
                    <strong>Recomendaciones:</strong>
                    <p><?php echo $hoja['recomendaciones']; ?></p>
                </div>
                <div class="campo">
                    <strong>Nivel de Glucosa:</strong>
                    <p><?php echo $hoja['nivelGlucosa']; ?> mg/dL</p>
                </div>
                <div class="campo">
                    <strong>Hemoglobina Glicosilada:</strong>
                    <p><?php echo $hoja['hemoglobinaGlicosilada']; ?> %</p>
                </div>
                <div class="campo">
                    <strong>Antecedentes Familiares:</strong>
                    <p><?php echo $hoja['antecedentesFamiliares']; ?></p>
                </div>
                <div class="campo">
                    <strong>Peso:</strong>
                    <p><?php echo $hoja['peso']; ?> kg</p>
                </div>
                <div class="campo">
                    <strong>Altura:</strong>
                    <p><?php echo $hoja['altura']; ?> cm</p>
                </div>
                <div class="campo">
                    <strong>Circunferencia de Cintura:</strong>
                    <p><?php echo $hoja['circunferenciaCintura']; ?> cm</p>
                </div>
                <div class="campo">
                    <strong>Actividad Física:</strong>
                    <p><?php echo $hoja['actividadFisica']; ?></p>
                </div>
                <div class="campo">
                    <strong>Alimentación:</strong>
                    <p><?php echo $hoja['alimentacion']; ?></p>
                </div>
            </div>

            <a href="expedientes.php" class="btn-back">Volver a Expedientes</a>
        </div>
    </div>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>