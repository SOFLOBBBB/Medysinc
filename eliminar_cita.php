<?php
session_start();
require 'funciones/conecta.php';
$con = conecta();

// Verificar si el usuario está logueado
if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID de la cita a eliminar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Primero eliminar las notificaciones asociadas a la cita
    $stmt_notificaciones = $con->prepare("DELETE FROM notificaciones WHERE cita_id = ? AND usuario_id = ?");
    $stmt_notificaciones->bind_param('ii', $id, $_SESSION['idUser']);
    $stmt_notificaciones->execute();

    // Luego eliminar la cita de la base de datos
    $stmt_cita = $con->prepare("DELETE FROM citas WHERE id = ? AND usuario_id = ?");
    $stmt_cita->bind_param('ii', $id, $_SESSION['idUser']);
    $stmt_cita->execute();
}

// Redirigir de vuelta a la agenda
header("Location: agenda.php");
exit;
?>