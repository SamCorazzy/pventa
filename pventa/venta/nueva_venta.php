<?php
global $conexion;
global $fecha;
global $cod_prods;
global $nombre_prods;
global $cantidades_vend_str;
global $total;
global $pago;
global $cambio;
global $usuario;
function nuevaVenta($conexion, $fecha, $cod_prods, $nombre_prods, $cantidades_vend_str, $total, $pago, $cambio, $usuario){
    $venta = mysqli_query($conexion, "INSERT INTO ventas (fecha, codigo_productos, nombre_productos, numero_productos, total, pago, cambio, usuario) VALUES ('$fecha', '$cod_prods', '$nombre_prods', '$cantidades_vend_str', $total, '$pago', '$cambio', '$usuario')");
    echo $venta;
}
nuevaVenta($conexion, $fecha, $cod_prods, $nombre_prods, $cantidades_vend_str, $total, $pago, $cambio, $usuario);

?>