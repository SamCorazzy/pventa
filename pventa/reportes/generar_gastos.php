<?php
$fecha = $_POST["fecha1"];
$fecha2 = $_POST["fecha2"];
$consulta = "SELECT t1.num_gasto,
                    t1.fecha,
                    t1.concepto,
                    t1.descripcion,
                    t1.importe,
                    t1.numero_remision,
                    t2.nombre FROM gastos t1 LEFT JOIN usuarios t2 ON t1.usuario = t2.nombre WHERE t1.fecha BETWEEN '$fecha' AND '$fecha2'";

$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosC = array();

while($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
	$num_gasto=$row['num_gasto'];
	$fecha=$row['fecha'];
	$concepto=$row['concepto'];
	$descripcion=$row['descripcion'];
	$importe=$row['importe'];
    $numero_remision=$row['numero_remision'];
    $nombre=$row['nombre'];
	
	//Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos 
	$datosC[] = array('num_gasto'=> $num_gasto, 
						'fecha'=> $fecha, 
						'concepto'=> $concepto, 
						'descripcion'=> $descripcion, 
						'importe'=> $importe,
                        'numero_remision'=> $numero_remision,
                        'nombre'=> $nombre,
					);

}
//cierre de ciclo foreach
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>