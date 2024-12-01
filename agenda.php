<?php  
// Iniciar la sesión y conectar a la base de datos
session_start(); // Asegúrate de que esto esté al principio del archivo
require 'funciones/conecta.php';
$con = conecta();

// Verificar si el usuario está logueado
if (!isset($_SESSION['idUser'])) {
    header("Location: login.php"); // Redirige a la página de login si no está logueado
    exit; // Detiene la ejecución del código
}

// Obtener el ID del usuario desde la sesión
$usuario_id = $_SESSION['idUser']; 

// Obtener el mes y el año actual (o el mes seleccionado por el usuario)
$mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
$anio = isset($_GET['anio']) ? (int)$_GET['anio'] : date('Y');

// Ajuste de año si el mes pasa de diciembre a enero o viceversa
if ($mes < 1) {
    $mes = 12;
    $anio--;
} elseif ($mes > 12) {
    $mes = 1;
    $anio++;
}

// Array de nombres de los meses en español
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

// Obtener el nombre del mes en español
$nombre_mes = $meses[$mes];

// Verificar si se ha enviado un formulario para guardar una cita
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fecha'])) {
    $titulo = $_POST['titulo'];
    $nota = $_POST['nota'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Insertar la cita en la base de datos
    $stmt = $con->prepare("INSERT INTO citas (usuario_id, fecha, hora, titulo, nota) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('issss', $usuario_id, $fecha, $hora, $titulo, $nota);
    $stmt->execute();

    // Obtener el ID de la cita recién insertada
    $cita_id = $stmt->insert_id;

    // Crear una notificación asociada con la cita
    $mensaje = "Tienes una cita el $fecha a las $hora: $titulo";
    $stmt_notificacion = $con->prepare("INSERT INTO notificaciones (usuario_id, cita_id, mensaje) VALUES (?, ?, ?)");
    $stmt_notificacion->bind_param('iis', $usuario_id, $cita_id, $mensaje);
    $stmt_notificacion->execute();

    // Redirigir para evitar el reenvío del formulario
    header("Location: agenda.php?mes=$mes&anio=$anio");
    exit;
}

// Verificar si se ha solicitado eliminar una cita
if (isset($_GET['eliminar']) && isset($_GET['cita_id'])) {
    $cita_id = (int)$_GET['cita_id'];
    $stmt = $con->prepare("DELETE FROM citas WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param('ii', $cita_id, $usuario_id);
    $stmt->execute();
    header("Location: agenda.php?mes=$mes&anio=$anio"); // Redirige después de eliminar
    exit;
}

// Calcular los días del mes
$primer_dia = date('N', strtotime("$anio-$mes-01")); // Día de la semana del primer día del mes
$ultimo_dia = date('t', strtotime("$anio-$mes-01")); // Último día del mes

// Obtener las citas del usuario en el mes y año actual
$stmt = $con->prepare("SELECT id, fecha, hora, titulo, nota FROM citas WHERE usuario_id = ? AND MONTH(fecha) = ? AND YEAR(fecha) = ?");
$stmt->bind_param('iii', $usuario_id, $mes, $anio);
$stmt->execute();
$result = $stmt->get_result();
$citas = [];
while ($row = $result->fetch_assoc()) {
    $citas[$row['fecha']][] = $row; // Agrupar citas por fecha
}

// Obtener las notificaciones no leídas del usuario
$stmt_notificaciones = $con->prepare("SELECT id, mensaje, creada_en FROM notificaciones WHERE usuario_id = ? AND leida = 0 ORDER BY creada_en DESC");
$stmt_notificaciones->bind_param('i', $usuario_id);
$stmt_notificaciones->execute();
$notificaciones = $stmt_notificaciones->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Medisync</title>
    <link rel="stylesheet" href="css/agenda.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="js/notificaciones.js"></script>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="contenedor">
    <div class="header">
        <h1>Agenda</h1>
        <h2><?php echo $nombre_mes . ' ' . $anio; ?></h2>
        <div class="nav-agenda">
            <a href="agenda.php?mes=<?php echo $mes == 1 ? 12 : $mes - 1; ?>&anio=<?php echo $mes == 1 ? $anio - 1 : $anio; ?>">&#8592; Mes Anterior</a> |
            <a href="agenda.php?mes=<?php echo $mes == 12 ? 1 : $mes + 1; ?>&anio=<?php echo $mes == 12 ? $anio + 1 : $anio; ?>">Mes Siguiente &#8594;</a>
        </div>
    </div>

    <section class="agenda-contenido">
        <section class="calendario">
            <table>
                <thead>
                    <tr>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dia = 1;
                    for ($i = 0; $i < 6; $i++) {
                        echo '<tr>';
                        for ($j = 1; $j <= 7; $j++) {
                            if ($i == 0 && $j < $primer_dia) {
                                echo '<td></td>';
                            } elseif ($dia > $ultimo_dia) {
                                echo '<td></td>';
                            } else {
                                $fecha = "$anio-" . str_pad($mes, 2, "0", STR_PAD_LEFT) . "-" . str_pad($dia, 2, "0", STR_PAD_LEFT);
                                echo '<td>';
                                echo '<strong>' . $dia . '</strong>';
                                if (isset($citas[$fecha])) {
                                    foreach ($citas[$fecha] as $cita) {
                                        echo '<div class="nota">';
                                        echo '<p><strong>' . $cita['titulo'] . '</strong></p>';
                                        echo '<p>a las ' . $cita['hora'] . '</p>'; 
                                        echo '<p>' . $cita['nota'] . '</p>';
                                        echo '<a href="agenda.php?mes=' . $mes . '&anio=' . $anio . '&eliminar=1&cita_id=' . $cita['id'] . '" class="boton-eliminar">Eliminar</a>';
                                        echo '</div>';
                                    }
                                }
                                echo '</td>';
                                $dia++;
                            }
                        }
                        echo '</tr>';
                        if ($dia > $ultimo_dia) {
                            break;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section class="formulario">
            <h3>Agregar Cita</h3>
            <form action="agenda.php?mes=<?php echo $mes; ?>&anio=<?php echo $anio; ?>" method="POST">
                <input type="date" name="fecha" required>
                <input type="time" name="hora" required>
                <input type="text" name="titulo" placeholder="Título de la cita" required>
                <textarea name="nota" placeholder="Detalles adicionales..." required></textarea>
                <button type="submit">Agregar Cita</button>
            </form>
        </section>
    </div>
</div>
</body>
</html>