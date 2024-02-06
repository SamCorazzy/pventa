<?php
global $conexion;
global $codigo_prod;
global $nombre;
global $nuevaCantEnInventario;
global $usuario;
global $fecha;
function nuevomov($conexion, $codigo_prod, $nombre, $nuevaCantEnInventario, $usuario, $fecha){
    $nuevoMov = mysqli_query($conexion, "INSERT INTO movimientos (codigo_prod, nombre, tipo_mov, fecha_mov, cantidad_inv, usuario) VALUES ('$codigo_prod', '$nombre', 'Salida', '$fecha', $nuevaCantEnInventario,'$usuario')");//Guarda un registro de la venta del producto y del nuevo total en el inventario del producto
    echo $nuevoMov;
}
nuevomov($conexion, $codigo_prod, $nombre, $nuevaCantEnInventario, $usuario, $fecha);
?>