<?php
session_start(); // Iniciar sesión aquí
require 'funciones/conecta.php';
$con = conecta();

// Obtener los datos del formulario
$correo = $_POST['correo'];
$pass = $_POST['pass'];
$pass = md5($pass);

$sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND pass = '$pass' AND eliminado = 0";
$res = $con->query($sql);

// Verificar si el usuario existe y guardar en sesión
if ($res && $res->num_rows == 1) {
    $row = $res->fetch_array();
    $_SESSION['idUser'] = $row["id"];
    $_SESSION['nomUser'] = $row["nombre"] . ' ' . $row["apellidos"];
    $_SESSION['correoUser'] = $row["correo"];
    $_SESSION['rol'] = $row["rol"];
    echo 1; // Autenticación exitosa
} else {
    echo 0; // Error en la autenticación
}
?>