<?php

$consulta = "SELECT * FROM datos_empresa WHERE rfc = 1";

$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosA = array();

while($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
	$rfc=$row['rfc'];
	$nombre=$row['nombre'];
	$direccion=$row['direccion'];
	$telefono=$row['telefono'];
	$colonia=$row['colonia'];
    $cod_postal=$row['cod_postal'];
	
	//Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos 
	$datosA[] = array('rfc'=> $rfc, 
						'nombre'=> $nombre, 
						'direccion'=> $direccion, 
						'telefono'=> $telefono, 
						'colonia'=> $colonia,
                        'cod_postal'=> $cod_postal,
					);

}

?>