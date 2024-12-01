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

// Determinar la página actual
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$productos_por_pagina = 9;  // Número de productos por página
$inicio = ($pagina - 1) * $productos_por_pagina;

// Consulta para obtener los productos con paginación, sin importar el estatus, pero filtrando por elimina = 0
$sql = "SELECT * FROM medicamentos WHERE elimina = 0 LIMIT $inicio, $productos_por_pagina";
$result = $conn->query($sql);

// Consulta para obtener el número total de productos disponibles
$sql_total = "SELECT COUNT(*) AS total FROM medicamentos WHERE elimina = 0";
$result_total = $conn->query($sql_total);
$total_productos = $result_total->fetch_assoc()['total'];

// Calcular el total de páginas
$total_paginas = ceil($total_productos / $productos_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Farmacia</title>
        <link rel="stylesheet" href="css/farmacia.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <script src="js/notificaciones.js"></script>
    </head>

    <body>

        <?php include 'menu.php'; ?>
        <div class="contenedor">
            <!-- Banner con fondo azul -->
            <div class="banner">
                <img src="src/banner-image1.png" alt="Medicamentos">
                <h1 class="titulo">Medicamentos</h1>
            </div>

            <!-- Contenedor de los productos -->
            <div class="medicamentos">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($producto = $result->fetch_assoc()): ?>
                        <div class="producto">
                            <div class="medicamento-imagen">
                                <a href="detalle_medicamento.php?id=<?php echo $producto['id']; ?>">
                                    <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="producto-imagen">
                                </a>
                            </div>
                            <h2 class="producto-nombre">
                                <a href="detalle_medicamento.php?id=<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></a>
                            </h2>
                            <!-- <p class="producto-precio">$<?php echo number_format($producto['precio'], 2); ?></p>-->
                            <button class="producto-status <?php echo $producto['status'] == 1 ? 'disponible' : 'no-disponible'; ?>">
                                <?php echo $producto['status'] == 1 ? 'Disponible' : 'No disponible'; ?>
                            </button>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay productos disponibles.</p>
                <?php endif; ?>
            </div>

            <!-- Paginación -->
            <div class="paginacion">
                <?php if ($pagina > 1): ?>
                    <div class="pagina"><a href="?pagina=1">&laquo;&laquo; 1</a></div>
                    <div class="pagina"><a href="?pagina=<?php echo $pagina - 1; ?>">&lt; Anterior</a></div>
                <?php endif; ?>

                <!-- Mostrar los números de página -->
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <div class="pagina <?php echo $i == $pagina ? 'active' : ''; ?>">
                        <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </div>
                <?php endfor; ?>

                <?php if ($pagina < $total_paginas): ?>
                    <div class="pagina"><a href="?pagina=<?php echo $pagina + 1; ?>">Siguiente &gt;</a></div>
                    <div class="pagina"><a href="?pagina=<?php echo $total_paginas; ?>">Última &raquo;&raquo;</a></div>
                <?php endif; ?>

                <!-- Mostrar la página actual -->
                <div class="pagina-actual">Estás en la página <?php echo $pagina; ?> de <?php echo $total_paginas; ?></div>
            </div>
        </div>
    </body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>