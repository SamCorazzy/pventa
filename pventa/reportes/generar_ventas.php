<?php
$fecha = $_POST["fecha1"];
$fecha2 = $_POST["fecha2"];
$consulta = "SELECT t1.num_venta,
                    t1.fecha,
                    t1.codigo_productos,
                    t1.nombre_productos,
                    t1.numero_productos,
                    t1.total,
                    t1.usuario FROM ventas t1 LEFT JOIN usuarios t2 ON t1.usuario = t2.nombre WHERE t1.fecha BETWEEN '$fecha' AND '$fecha2'";

$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosC = array();

while($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
	$num_venta=$row['num_venta'];
	$fecha=$row['fecha'];
	$codigo_productos=$row['codigo_productos'];
	$nombre_productos=$row['nombre_productos'];
	$numero_productos=$row['numero_productos'];
    $total=$row['total'];
    $usuario=$row['usuario'];

	//Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos 
	$datosC[] = array('num_venta'=> $num_venta, 
						'fecha'=> $fecha, 
						'codigo_productos'=> $codigo_productos, 
						'nombre_productos'=> $nombre_productos, 
						'numero_productos'=> $numero_productos,
                        'total'=> $total,
                        'usuario'=> $usuario,
					);

}
//cierre de ciclo foreach
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>