<?php
session_start(); // Iniciar sesión aquí
require 'funciones/conecta.php';
$con = conecta();

// Obtener los datos del formulario
$fecha = $_POST['fecha'];
$id_cliente = $_POST['id_cliente'];
$id_medico = $_SESSION['idUser'];  // Este valor se obtiene de la sesión
$diagnostico = $_POST['diagnostico'];
$tratamiento = $_POST['tratamiento'];
$observacion = $_POST['observacion'];
$signos_vitales = $_POST['signos_vitales'];
$sintomas = $_POST['sintomas'];
$recomendaciones = $_POST['recomendaciones'];
$nivel_glucosa = $_POST['nivel_glucosa'];
$hemoglobina_glicosilada = $_POST['hemoglobina_glicosilada'];
$antecedentes_familiares = $_POST['antecedentes_familiares'];
$peso = $_POST['peso'];
$altura = $_POST['altura'];
$circunferencia_cintura = $_POST['circunferencia_cintura'];
$actividad_fisica = $_POST['actividad_fisica'];
$alimentacion = $_POST['alimentacion'];

// Consulta SQL para insertar los datos
$sql = "INSERT INTO hoja_evolucion (
    fecha, id_usuario, id_medico, diagnostico, tratamiento, observaciones, 
    signosVitales, sintomas, recomendaciones, nivelGlucosa, 
    hemoglobinaGlicosilada, antecedentesFamiliares, peso, altura, 
    circunferenciaCintura, actividadFisica, alimentacion
) VALUES (
    '$fecha', '$id_cliente', '$id_medico', '$diagnostico', '$tratamiento', '$observacion', 
    '$signos_vitales', '$sintomas', '$recomendaciones', '$nivel_glucosa', 
    '$hemoglobina_glicosilada', '$antecedentes_familiares', '$peso', '$altura', 
    '$circunferencia_cintura', '$actividad_fisica', '$alimentacion'
)";

// Ejecutar la consulta y verificar si fue exitosa
if ($con->query($sql) === TRUE) {
    // Redirigir si la consulta fue exitosa
    header("Location: ingreso_anos.php");
} else {
    // Si hay un error en la consulta, mostrar el mensaje
    echo "Error: " . $sql . "<br>" . $con->error;
}

// Cerrar la conexión al final
$con->close();
?>