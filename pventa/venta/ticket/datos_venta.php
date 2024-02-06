<?php

$cod_prods = $_POST["cod_prods"];
$fecha = $_POST["fecha"];
$consulta = "SELECT * FROM ventas WHERE codigo_productos = '$cod_prods' AND fecha = '$fecha'";

$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosV = array();

while($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
	$num_venta=$row['num_venta'];
	$fecha=$row['fecha'];
	$codigo_productos=$row['codigo_productos'];
	$nombre_productos=$row['nombre_productos'];
	$numero_productos=$row['numero_productos'];
    $total=$row['total'];
	$pago=$row['pago'];
	$cambio=$row['cambio'];
	$usuario=$row['usuario'];
    // $no_caja=$row['no_caja'];


	//Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos 
	$datosV[] = array('num_venta'=> $num_venta, 
						'fecha'=> $fecha, 
						'codigo_productos'=> $codigo_productos, 
						'nombre_productos'=> $nombre_productos, 
						'numero_productos'=> $numero_productos,
                        'total'=> $total,
						'pago'=> $pago,
						'cambio'=> $cambio,
                        'usuario'=> $usuario,
                        // 'no_caja'=> $no_caja,
					);

}

?>