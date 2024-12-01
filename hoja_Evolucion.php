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
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/hojaEvolucionMedica.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <title>Hoja EVO</title>

    </head>

    <body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Hoja de Evolución Médica</h1>
            <form action="procesar_evolucion.php" method="POST">
                <div class="form-group">
                    <label for="fecha"><i class="fas fa-calendar-day"></i>Fecha</label>
                    <input type="date" id="fecha" name="fecha" placeholder="Seleccione la fecha" required>
                </div>
                <div class="form-group">
                    <label for="id_cliente"><i class="fas fa-users"></i>ID del Cliente</label>
                    <input type="number" id="id_cliente" name="id_cliente" placeholder="Ingrese el ID del cliente" required>
                </div>
                <input type="hidden" id="id_medico" name="id_medico" value="<?php echo $_SESSION['idUser']; ?>">
                <div class="form-group">
                    <label for="diagnostico"><i class="fas fa-stethoscope"></i>Diagnóstico</label>
                    <textarea id="diagnostico" name="diagnostico" rows="3" placeholder="Ingrese el diagnóstico del paciente" required></textarea>
                </div>
                <div class="form-group">
                    <label for="tratamiento"><i class="fas fa-pills"></i>Tratamiento</label>
                    <textarea id="tratamiento" name="tratamiento" rows="3" placeholder="Ingrese el tratamiento prescrito" required></textarea>
                </div>
                <div class="form-group">
                    <label for="observacion"><i class="fas fa-comments"></i>Observaciones</label>
                    <textarea id="observacion" name="observacion" rows="3" placeholder="Notas adicionales u observaciones"></textarea>
                </div>
                <div class="form-group">
                    <label for="signos_vitales"><i class="fas fa-heartbeat"></i>Signos Vitales</label>
                    <textarea id="signos_vitales" name="signos_vitales" rows="3" placeholder="Registre los signos vitales del paciente"></textarea>
                </div>
                <div class="form-group">
                    <label for="sintomas"><i class="fas fa-symptoms"></i>Síntomas</label>
                    <textarea id="sintomas" name="sintomas" rows="3"  placeholder="Describa los síntomas observados"></textarea>
                </div>
                <div class="form-group">
                    <label for="recomendaciones"><i class="fas fa-lightbulb"></i>Recomendaciones</label>
                    <textarea id="recomendaciones" name="recomendaciones" rows="3" placeholder="Escriba las recomendaciones para el paciente"></textarea>
                </div>
                <div class="form-group">
                    <label for="nivel_glucosa"><i class="fas fa-tint"></i>Nivel de Glucosa</label>
                    <input type="number" step="0.1" id="nivel_glucosa" name="nivel_glucosa" placeholder="Nivel de glucosa en sangre">
                </div>
                <div class="form-group">
                    <label for="hemoglobina_glicosilada"><i class="fas fa-blood-type"></i>Hemoglobina Glicosilada</label>
                    <input type="number" step="0.1" id="hemoglobina_glicosilada" name="hemoglobina_glicosilada" placeholder="Valor de hemoglobina glicosilada">
                </div>
                <div class="form-group">
                    <label for="antecedentes_familiares"><i class="fas fa-users-cog"></i>Antecedentes Familiares</label>
                    <textarea id="antecedentes_familiares" name="antecedentes_familiares" rows="3" placeholder="Describa los antecedentes familiares del paciente"></textarea>
                </div>
                <div class="form-group">
                    <label for="peso"><i class="fas fa-weight"></i>Peso (kg)</label>
                    <input type="number" step="0.1" id="peso" name="peso" placeholder="Peso del paciente en kg">
                </div>
                <div class="form-group">
                    <label for="altura"><i class="fas fa-ruler"></i>Altura (cm)</label>
                    <input type="number" step="0.1" id="altura" name="altura" placeholder="Altura del paciente en cm">
                </div>
                <div class="form-group">
                    <label for="circunferencia_cintura"><i class="fas fa-tape"></i>Circunferencia de la Cintura (cm)</label>
                    <input type="number" step="0.1" id="circunferencia_cintura" name="circunferencia_cintura" placeholder="Circunferencia de la cintura en cm">
                </div>
                <div class="form-group">
                    <label for="actividad_fisica"><i class="fas fa-running"></i>Actividad Física</label>
                    <textarea id="actividad_fisica" name="actividad_fisica" rows="3" placeholder="Describa la actividad física del paciente"></textarea>
                </div>
                <div class="form-group">
                    <label for="alimentacion"><i class="fas fa-apple-alt"></i>Alimentación</label>
                    <textarea id="alimentacion" name="alimentacion" rows="3"  placeholder="Registre la dieta o hábitos alimenticios del paciente"></textarea>
                </div>
                <button type="submit" class="btn-submit">Guardar</button>
            </form>
           
        </div>    

    </body>

</html>