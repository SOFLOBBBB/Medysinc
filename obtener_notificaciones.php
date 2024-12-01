<?php
// Incluir el archivo de conexión
require 'funciones/conecta.php';

// Establecer la conexión
$con = conecta();

// Consulta para obtener las notificaciones con citas futuras
$query = "
    SELECT n.id AS notificacion_id, c.fecha AS fecha_cita, n.mensaje AS mensaje, c.titulo AS titulo
    FROM notificaciones n
    JOIN citas c ON n.cita_id = c.id
    WHERE c.fecha > CURDATE()";
$result = $con->query($query);

// Arreglo para las notificaciones
$notificaciones = [];

while ($row = $result->fetch_assoc()) {
    // Convierte la fecha de la cita en un objeto DateTime
    $fecha_cita = new DateTime($row['fecha_cita']);
    // Obtén la fecha actual, sin hora (sólo la fecha)
    $fecha_actual = new DateTime();
    $fecha_actual->setTime(0, 0);  // Esto elimina la parte de la hora

    // Calcular la diferencia de días
    $intervalo = $fecha_actual->diff($fecha_cita);
    $dias_diferencia = $intervalo->days;

    // Verificar si la cita está dentro de los rangos de notificación
    if ($dias_diferencia == 1) {
        // Si es el día siguiente
        $notificaciones[] = [
            'mensaje' => "Cita programada mañana: " . $row['titulo'],
            'id' => $row['notificacion_id']
        ];
    } elseif ($dias_diferencia == 3) {
        // Si es dentro de 3 días
        $notificaciones[] = [
            'mensaje' => "Cita programada en 3 días: " . $row['titulo'],
            'id' => $row['notificacion_id']
        ];
    } elseif ($dias_diferencia == 7) {
        // Si es dentro de 1 semana
        $notificaciones[] = [
            'mensaje' => "Cita programada en 1 semana: " . $row['titulo'],
            'id' => $row['notificacion_id']
        ];
    }
}

// Encabezado para JSON
header('Content-Type: application/json');

// Retornar las notificaciones como JSON
echo json_encode($notificaciones);
?>