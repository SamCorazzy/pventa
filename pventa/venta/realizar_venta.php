<?php
include("../conexion.php");
date_default_timezone_set('America/Mexico_City');
$fecha = date('c');//Fecha ISO 8601 (añadido en PHP 5)
$valores = json_decode(file_get_contents('php://input'), true);
// guardar los valores en la base de datos...
$cod_prods = "";
$nombre_prods = "";
$codigo_prod;
$total = 0;
$cantidades_vend = array();
$usuario = "";
$pago = 0;
$cambio = 0;
$nombre = "";
$fechaphp = array();
$nuevaCantEnInventario = 0;
$row = array();
foreach($valores as $valores){
    $nombre = $valores['nombre'];
    $precio = $valores['precio'];
    $cantidadVendida = $valores['cantidad'];
    $usuario = $valores['usuario'];
    $cod_prods = $valores['cod_prods'];
    $nombre_prods = $valores['nomb_prods'];
    $total = $valores['total'];
    $pago = $valores['pago'];
    $cambio = $valores['cambio'];

    require ("cantidad.php");
    $row = cantidad($conexion, $nombre);
    $codigo_prod = $row['codigo_prod'];
    $cantidadEnInventario = $row['existencia'];
    $nuevaCantEnInventario = $cantidadEnInventario - $cantidadVendida;//Nueva cantidad en el inventario una vez vendido un producto
    $cantidades_vend[] = $cantidadVendida;

    require ("nuevo_mov.php");
    require ("actualizar_inv.php");
    
}
$cantidades_vend_str = implode(", ", $cantidades_vend);
require ("nueva_venta.php");
require ("fecha.php");
$fechaphp = fecha($conexion, $fecha);
var_dump($fechaphp);//sirve con la variable $valores para obtener respuestas del servidor, tambien para recibir algun dato como esta actualmente la variable $fechaphp se regresa la fecha que se obtiene en este archivo
?>