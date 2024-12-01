<?php
// Incluir el archivo de conexión a la base de datos
include 'funciones/conecta.php';

// Llamar a la función conecta() para obtener la conexión
$conn = conecta();

// Iniciar sesión y verificar si el usuario está logueado
session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit();
}

$nombreUser = $_SESSION['idUser'];
$correoUser = $_SESSION['correoUser'];
$rolUser = $_SESSION['rol'];

// Obtener el ID del usuario logueado
$id_usuario = $_SESSION['idUser'];

// Determinar la página actual
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$productos_por_pagina = 5;  // Número de hojas de evolución por página
$inicio = ($pagina - 1) * $productos_por_pagina;

// Consulta para obtener las hojas de evolución del usuario logueado con paginación
$sql = "SELECT * FROM hoja_evolucion WHERE id_usuario = $id_usuario LIMIT $inicio, $productos_por_pagina";
$result = $conn->query($sql);

// Consulta para obtener el número total de hojas de evolución disponibles
$sql_total = "SELECT COUNT(*) AS total FROM hoja_evolucion WHERE id_usuario = $id_usuario";
$result_total = $conn->query($sql_total);
$total_hojas = $result_total->fetch_assoc()['total'];

// Calcular el total de páginas
$total_paginas = ceil($total_hojas / $productos_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente Médico</title>
    <link rel="stylesheet" href="css/expedientes.css?v=<?php echo time(); ?>">
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
            <img src="src/banner-image3.png" alt="Medicamentos">
            <h1 class="titulo">Expediente Médico</h1>
        </div>

        <!-- Contenedor de hojas de evolución -->
        <div class="expedientes">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($hoja = $result->fetch_assoc()): ?>
                    <?php
                    // Consulta para obtener el nombre del médico
                    $id_medico = $hoja['id_medico'];
                    $sql_medico = "SELECT nombre, apellido FROM medicos WHERE id = $id_medico";
                    $result_medico = $conn->query($sql_medico);
                    $medico = $result_medico->fetch_assoc();

                    // Consulta para obtener el nombre del usuario (si no es el mismo que el de la sesión)
                    $sql_usuario = "SELECT nombre, apellidos FROM usuarios WHERE id = $id_usuario";
                    $result_usuario = $conn->query($sql_usuario);
                    $usuario = $result_usuario->fetch_assoc();
                    ?>
                    <div class="hoja-evolucion">
                        <h3 class="hoja-titulo"><?php echo $hoja['fecha']; ?></h3>
                        <p><strong>Medico:</strong> <?php echo $medico['nombre'] . ' ' . $medico['apellido']; ?></p>
                        <p><strong>Paciente:</strong> <?php echo $usuario['nombre'] . ' ' . $usuario['apellidos']; ?></p>
                        <p><strong>Diagnóstico:</strong> <?php echo $hoja['diagnostico']; ?></p>
                        <p><strong>Tratamiento:</strong> <?php echo $hoja['tratamiento']; ?></p>
                        <a href="detalle_hoja_evolucion.php?id=<?php echo $hoja['id']; ?>" class="btn-detalle">Ver Detalle</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No tienes hojas de evolución registradas.</p>
            <?php endif; ?>
        </div>

        <!-- Paginación -->
        <div class="paginacion">
            <?php if ($pagina > 1): ?>
                <div class="pagina"><a href="?pagina=1">&laquo;&laquo; 1</a></div>
                <div class="pagina"><a href="?pagina=<?php echo $pagina - 1; ?>">&lt; Anterior</a></div>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <div class="pagina <?php echo $i == $pagina ? 'active' : ''; ?>">
                    <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </div>
            <?php endfor; ?>

            <?php if ($pagina < $total_paginas): ?>
                <div class="pagina"><a href="?pagina=<?php echo $pagina + 1; ?>">Siguiente &gt;</a></div>
                <div class="pagina"><a href="?pagina=<?php echo $total_paginas; ?>">Última &raquo;&raquo;</a></div>
            <?php endif; ?>

            <div class="pagina-actual">Estás en la página <?php echo $pagina; ?> de <?php echo $total_paginas; ?></div>
        </div>
    </div>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>