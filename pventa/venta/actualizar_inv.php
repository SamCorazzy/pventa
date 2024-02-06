<?php
global $conexion;
global $nuevaCantEnInventario;
global $codigo_prod;
function actuInv($conexion, $nuevaCantEnInventario, $codigo_prod){
    $actualizarInv = mysqli_query($conexion, "UPDATE inventario SET existencia = '$nuevaCantEnInventario' WHERE codigo_prod = '$codigo_prod'");//Actualiza la cantidad de un producto luego de su venta
    echo $actualizarInv;
}
actuInv($conexion, $nuevaCantEnInventario, $codigo_prod);
    
?>