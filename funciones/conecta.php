<?php
// funciones/ conecta.php
define("HOST", 'localhost'); //constante y su valor
define("BD", 'medisync');
define("USER_BD", 'root');
define("PASS_BD",'');

function conecta() {
    $con = new mysqli (HOST, USER_BD, PASS_BD, BD);
    return $con;
}
?>