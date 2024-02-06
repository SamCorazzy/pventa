<?php
// Se hace la conexion a la base de datos
$conexion = new mysqli("localhost", "root", "", "prueba2");
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
// echo $mysqli->host_info . "\n";
