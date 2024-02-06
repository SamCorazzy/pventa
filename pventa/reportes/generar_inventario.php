<?php
$fecha = $_POST["fecha1"];
$fecha2 = $_POST["fecha2"];
$proveedor = $_POST["proveedor"];
$cantidad = $_POST["cantidad"];
$consulta = "SELECT t1.num_producto,
                    t1.codigo_prod,
                    t1.nombre,
                    t1.nombre_imagen,
                    t1.imagen,
                    t1.tipo_imagen,
                    t1.precio_compra,
                    t1.precio_venta,
                    t1.stock,
                    t1.existencia,
                    t1.fecha_ingreso,
                    t2.empresa FROM inventario t1 LEFT JOIN proveedores t2 ON t1.proveedor_num = t2.num_proveedor WHERE t1.fecha_ingreso BETWEEN '$fecha' AND '$fecha2'";
if($proveedor == "Todos" && $cantidad == "No"){
    $consulta = $consulta." AND t1.existencia >= 10";//muestra los productos que tenga una existencia mayor a 10
} elseif($proveedor != "Todos"){
    $consulta = $consulta." AND t2.empresa = '" . $proveedor . "'";
    if($cantidad == "No"){
        $consulta = $consulta." AND t1.existencia >= 10";
    }
}


$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosC = array();

while($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
	$num_producto=$row['num_producto'];
	$codigo_prod=$row['codigo_prod'];
	$nombre=$row['nombre'];
	$nombre_imagen=$row['nombre_imagen'];
	$imagen=$row['imagen'];
    $tipo_imagen=$row['tipo_imagen'];
    $precio_compra=$row['precio_compra'];
    $precio_venta=$row['precio_venta'];
    $stock=$row['stock'];
    $existencia=$row['existencia'];
    $fecha_ingreso=$row['fecha_ingreso'];
    $empresa=$row['empresa'];
	
	//Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos 
	$datosC[] = array('num_producto'=> $num_producto, 
						'codigo_prod'=> $codigo_prod, 
						'nombre'=> $nombre, 
						'nombre_imagen'=> $nombre_imagen, 
						'imagen'=> $imagen,
                        'tipo_imagen'=> $tipo_imagen,
                        'precio_compra'=> $precio_compra,
                        'precio_venta'=> $precio_venta,
                        'stock'=> $stock,
                        'existencia'=> $existencia,
                        'fecha_ingreso'=> $fecha_ingreso,
                        'empresa'=> $empresa,
					);

}
//cierre de ciclo foreach
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>