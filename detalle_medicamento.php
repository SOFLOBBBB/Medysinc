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

// Obtener el ID del medicamento desde la URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Verificar que el ID sea válido
if ($id == 0) {
    echo "Producto no encontrado.";
    exit;
}

// Consulta para obtener los detalles del medicamento por ID
$sql = "SELECT * FROM medicamentos WHERE id = $id AND elimina = 0";
$result = $conn->query($sql);

// Verificar si se encontró el medicamento
if ($result->num_rows == 0) {
    echo "Producto no disponible o eliminado.";
    exit;
}

// Obtener el medicamento
$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle del Medicamento</title>
        <link rel="stylesheet" href="css/detalle_medicamento.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap" rel="stylesheet">
        <script src="js/notificaciones.js"></script>
    </head>

    <body>

        <?php include 'menu.php'; ?>

        <div class="contenedor">
            <!-- Contenedor de los detalles del producto -->
            <div class="detalle-contenedor">
                <!-- Imagen más grande del producto -->
                <div class="detalle-imagen">
                    <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="producto-imagen">
                </div>

                <!-- Información detallada del producto -->
                <div class="detalle-info">
                    <h1><?php echo $producto['nombre']; ?></h1>
                    <p><strong>Descripción:</strong> <?php echo nl2br($producto['descripcion']); ?></p>
                    <!--<p class="producto-precio">$<?php echo number_format($producto['precio'], 2); ?></p>-->
                    <button class="producto-status <?php echo $producto['status'] == 1 ? 'disponible' : 'no-disponible'; ?>">
                        <?php echo $producto['status'] == 1 ? 'Disponible' : 'No disponible'; ?>
                    </button>

                    <!-- Enlace para volver a la lista de productos -->
                    <a href="farmacia.php" class="volver">Volver a la lista de productos</a>
                </div>
            </div>
        </div>

    </body>
    
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>