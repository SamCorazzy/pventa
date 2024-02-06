<?php
include("../conexion.php");
$nombre = $_POST['json'];//obtiene un valor de venta.js

$consulta = "SELECT t1.codigo_prod,
                    t1.nombre,
                    t1.imagen,
                    t1.tipo_imagen,
                    t1.precio_venta,
                    t1.stock,
                    t1.existencia FROM inventario t1 LEFT JOIN proveedores t2 ON t1.proveedor_num = t2.num_proveedor WHERE t1.nombre LIKE '$nombre%';";

$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosp = array();

while($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
	$codigo_prod=$row['codigo_prod'];
	$nombre=$row['nombre'];
	$imagen=base64_encode($row['imagen']);
    $tipo_imagen=$row['tipo_imagen'];
    $precio_venta=$row['precio_venta'];
    $stock=$row['stock'];
    $existencia=$row['existencia'];
	
	//Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos
    $datosp[] = array('codigo_prod'=> $codigo_prod, 
    'nombre'=> $nombre,
    'imagen'=> $imagen,
    'tipo_imagen'=> $tipo_imagen,
    'precio_venta'=> $precio_venta,
    'stock'=> $stock,
    'existencia'=> $existencia,);
    

//echo var_dump(json_encode($datosp));
}

//echo json_encode(count($datosp));
//cierre de ciclo foreach
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");


$datosp = json_encode($datosp);//documento json que se usa para almacenar los datos del array
echo $datosp;

