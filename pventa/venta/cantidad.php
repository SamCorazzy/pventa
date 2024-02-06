<?php
global $conexion;
global $nombre;
$valores = json_decode(file_get_contents('php://input'), true);
function cantidad($conexion, $nombre){
    $cantidadEnInventario = mysqli_query($conexion, "SELECT codigo_prod, existencia FROM inventario WHERE nombre = '$nombre'");
    $row = mysqli_fetch_assoc($cantidadEnInventario);
    $codigo_prod = $row['codigo_prod'];
    $cantidadEnInventario = $row['existencia'];
    return array('codigo_prod' => $codigo_prod, 'existencia' => $cantidadEnInventario);
}

?>