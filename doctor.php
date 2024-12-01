<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Doctor</title>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        function validarFormulario() {
            var correo = $('#correo').val();
            var pass = $('#pass').val();

            if (correo == '' || pass == '') {
                $('#mensaje').addClass('error').text("Faltan campos por llenar.");
                setTimeout(function() {
                    $('#mensaje').text('').removeClass('error');
                }, 5000);
                return false;
            } else {
                $('#mensaje').removeClass('error').text('');
                $.ajax({
                    url: 'verificar_doctor.php',
                    type: 'POST',
                    data: {
                        correo: correo,
                        pass: pass
                    },
                    success: function(respuesta) {
                        if (respuesta == 1) {
                            window.location.href = 'ingreso_anos.php';
                        } else {
                            $('#mensaje').addClass('error').text('Usuario no existe o contraseña incorrecta.');
                            setTimeout(function() {
                                $('#mensaje').text('').removeClass('error');
                            }, 5000)
                        }
                    }
                });
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Logo del sitio -->
        <div class="logo">
            <img src="src/logo.png" alt="Logo de la tienda" />
        </div>

        <h2>Inicia Sesion Doc</h2><br>
        <form onsubmit="return validarFormulario();">
            <label for="correo">Correo Electrónico:</label><br>
            <input type="email" id="correo" name="correo" required><br>
            <label for="pass">Contraseña:</label><br>
            <input type="password" id="pass" name="pass" required><br><br>

            <input class="boton" type="submit" value="Iniciar Sesión">
        </form>

        <div id="mensaje"></div>
    </div>
</body>
</html>