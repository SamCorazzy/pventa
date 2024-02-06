<?php
include("../conexion.php");
$semana_actual = date("W");
$registros_total = "SELECT COUNT(*)  AS Total FROM movimientos LEFT JOIN inventario ON movimientos.codigo_prod = inventario.codigo_prod WHERE WEEK(movimientos.fecha_mov) = $semana_actual AND YEAR(movimientos.fecha_mov) = YEAR(NOW()) ORDER BY movimientos.fecha_mov DESC;";//el valor despues de AS da el nombre dal resultado obtenido
$resultado = mysqli_query($conexion, $registros_total);
$datosResultado = mysqli_fetch_assoc($resultado);
$registros_total = $datosResultado['Total'];//el nombre del resultado obtenido
$consulta = "SELECT movimientos.codigo_prod, movimientos.nombre, movimientos.tipo_mov, movimientos.fecha_mov, movimientos.cantidad_inv, movimientos.usuario FROM movimientos LEFT JOIN inventario ON movimientos.codigo_prod = inventario.codigo_prod WHERE WEEK(movimientos.fecha_mov) = $semana_actual AND YEAR(movimientos.fecha_mov) = YEAR(NOW()) ORDER BY movimientos.fecha_mov DESC;";

$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosC = array();

while($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
	$codigo_prod=$row['codigo_prod'];
	$nombre=$row['nombre'];
	$tipo_mov=$row['tipo_mov'];
	$fecha_mov=$row['fecha_mov'];
	$cantidad_inv=$row['cantidad_inv'];
	$usuario=$row['usuario'];

	//Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos 
	$datosC[] = array('codigo_prod'=> $codigo_prod, 
						'nombre'=> $nombre, 
						'tipo_mov'=> $tipo_mov, 
						'fecha_mov'=> $fecha_mov, 
						'cantidad_inv'=> $cantidad_inv,
                        'usuario'=> $usuario,
					);

}
//cierre de ciclo foreach
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>