<?php
    session_start();

    session_unset(); // Libera todas las variables de sesión

    session_destroy();
    
    header("Location: index.php");
?>