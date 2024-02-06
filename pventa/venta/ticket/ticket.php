<?php
include("../../conexion.php");
$codigo_productos = "";
$fecha = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_productos = $_POST["codigo_productos"];
    $fecha = $_POST["fecha"];
  } else {
    $codigo_productos = $_GET["codigo_productos"];
    $fecha = $_GET["fecha"];
  }


$consulta = "SELECT * FROM ventas WHERE codigo_productos = '$codigo_productos' AND fecha = '$fecha'";

$datos = mysqli_query($conexion, $consulta);

if(!$result = mysqli_query($conexion, $consulta)) die();//si los datos entre la coneccion y 
//la consulta son correctos habra un resultado el cual se guardara en result

$datosV = array();

while ($row = mysqli_fetch_array($datos)) //relleno del array
{ //relleno del array segun los datos que se desean obtener de la consulta hasta que todos los datos se guarden en el
    $num_venta = $row['num_venta'];
    $fecha = $row['fecha'];
    $codigo_productos = $row['codigo_productos'];
    $nombre_productos = $row['nombre_productos'];
    $numero_productos = $row['numero_productos'];
    $total = $row['total'];
    $pago = $row['pago'];
    $cambio = $row['cambio'];
    $usuario = $row['usuario'];
    // $no_caja=$row['no_caja'];


    //Una vez terminado el proceso se guardaran los datos en el array  creado anteriormente para poder usarlos 
    $datosV[] = array(
        'num_venta' => $num_venta,
        'fecha' => $fecha,
        'codigo_productos' => $codigo_productos,
        'nombre_productos' => $nombre_productos,
        'numero_productos' => $numero_productos,
        'total' => $total,
        'pago' => $pago,
        'cambio' => $cambio,
        'usuario' => $usuario,
        // 'no_caja'=> $no_caja,
    );
}


	# Incluyendo librerias necesarias #
    require "./fpdf182/code128.php";
    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(20,20, $pdf->Image('../../img/logo1.png',$pdf->GetX()+2,$pdf->GetY(),70,20),0 ,'C');
include 'datos_empresa.php';//archivo datos_empresa.php necesario para obtener los datos de la empresa
foreach ($datosA as $A) {//recorrer dato a dato del array datosA
    $nombre = $A['nombre'];
    $pdf->MultiCell(0, 5, utf8_decode(strtoupper($nombre)), 0, 'C', false);//NOMBRE DE LA EMPRESA
    $pdf->SetFont('Arial', '', 9);
    $rfc = $A['rfc'];
    $pdf->MultiCell(0, 5, utf8_decode("RUC: " . $rfc), 0, 'C', false);//RFC O RUC???????????
    $direccion = $A['direccion'];
    $pdf->MultiCell(0, 5, utf8_decode("Direccion: " . $direccion), 0, 'C', false);//DIRECIÓN DE LA EMPRESA
    $telefono = $A['telefono'];
    $pdf->MultiCell(0, 5, utf8_decode("Teléfono: " . $telefono), 0, 'C', false);//TELEFONO DE LA EMPRESA
    $cod_postal = $A['cod_postal'];
    $pdf->MultiCell(0, 5, utf8_decode("Codigo Postal: " . $cod_postal), 0, 'C', false);//CODIGO POSTAL DE LA EMPRESA
}
    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);
foreach ($datosV as $V){
    $fecha = $V['fecha'];
    $pdf->MultiCell(0,5,utf8_decode("Fecha: ".date("d/m/Y", strtotime($fecha))." Hora:".date(" h:i A", strtotime($fecha))),0,'C',false);
    // $no_caja = $V['no_caja'];
    // $pdf->MultiCell(0,5,utf8_decode("Caja Nro: ".$no_caja),0,'C',false);
    $usuario = $V['usuario'];
    $pdf->MultiCell(0,5,utf8_decode("Cajero: ".$usuario),0,'C',false);
    $pdf->SetFont('Arial','B',10);
    $num_venta = $V['num_venta'];
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Ticket Nro: ".$num_venta)),0,'C',false);
    $pdf->SetFont('Arial','',9);
}
    $pdf->Ln(1);
    // $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    // $pdf->Ln(5);

    // $pdf->MultiCell(0,5,utf8_decode("Cliente: Carlos Alfaro"),0,'C',false);
    // $pdf->MultiCell(0,5,utf8_decode("Documento: DNI 00000000"),0,'C',false);
    // $pdf->MultiCell(0,5,utf8_decode("Teléfono: 00000000"),0,'C',false);
    // $pdf->MultiCell(0,5,utf8_decode("Dirección: San Salvador, El Salvador, Centro America"),0,'C',false);

    // $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #//en caso de agregar el DESC o descuento se modifican los valores de las demas columnas con lo que se comenta al lado de cada una
    //de igual forma donde se agregan los datos en cada fila se deben modificar los valores de las medidas
    //al que se estan en estas columnas definidas
    $pdf->Cell(20,5,utf8_decode("Cant."),0,0,'C');//$pdf->Cell(10,5,utf8_decode("Cant."),0,0,'C');
    $pdf->Cell(25,5,utf8_decode("Precio"),0,0,'C');//$pdf->Cell(19,5,utf8_decode("Precio"),0,0,'C');
    //$pdf->Cell(15,5,utf8_decode("Desc."),0,0,'C');
    $pdf->Cell(28,5,utf8_decode("Total"),0,0,'C');//$pdf->Cell(28,5,utf8_decode("Total"),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);


foreach ($datosV as $V){
    /*----------  Detalles de la tabla  ----------*/
    /*----------  Detalles de los productos: convertir los valores obtenidos en arrays  ----------*/
    $codigo_productos = $V['codigo_productos'];
    $nombre_productos = $V['nombre_productos'];
    $numero_productos = $V['numero_productos'];
    $array_codigo_productos = explode(", ", $codigo_productos);
    $array_nombre_productos = explode(", ", $nombre_productos);
    $array_numero_productos = explode(", ", $numero_productos);
    /*----------  Fin Detalles de los productos  ----------*/
    /*----------  Detalles de el rellenado de productos  ----------*/
    for ($i = 0; $i < count($array_nombre_productos); $i++) {
        $cod_prod = $array_codigo_productos[$i];//obtener ol codigo del producto a buscar
        $precio_venta = mysqli_query($conexion, "SELECT precio_venta FROM inventario WHERE codigo_prod = '$cod_prod'");//buscando el precio del producto
        $precio = 0;//inicializacion de una variable para guardar el precio de un producto
        foreach($precio_venta as $precio_venta){//metodo para obtener los resultados de la consulta sql
            $precio = $precio_venta['precio_venta'];//se guarda el valor obtenido
        }
        $pdf->MultiCell(0,4,utf8_decode($array_nombre_productos[$i]),0,'C',false);//se muestra el nombre del producto
        $pdf->Cell(20,4,utf8_decode($array_numero_productos[$i]),0,0,'C');//se muestra el total de producto del mismo nombre
        $pdf->Cell(25,4,utf8_decode($precio),0,0,'C');//se muestra el precio del producto
        //$pdf->Cell(19,4,utf8_decode("$0.00 USD"),0,0,'C');
        $total = $precio * $array_numero_productos[$i];//se calcula el total del costo de un producto
        $pdf->Cell(28,4,utf8_decode("$".$total." MXN"),0,0,'C');
        $pdf->Ln(4);
    }
    /*----------  Fin Detalles de el rellenado de productos  ----------*/
    $pdf->MultiCell(0,4,utf8_decode("Garantía de fábrica: 2 Meses"),0,'C',false);
    $pdf->Ln(7);
    
    /*----------  Fin Detalles de la tabla  ----------*/
}


    // $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

    //     $pdf->Ln(5);

    // # Impuestos & totales #
    // $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    // $pdf->Cell(22,5,utf8_decode("SUBTOTAL"),0,0,'C');
    // $pdf->Cell(32,5,utf8_decode("+ $70.00 USD"),0,0,'C');

    // $pdf->Ln(5);

    // $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    // $pdf->Cell(22,5,utf8_decode("IVA (13%)"),0,0,'C');
    // $pdf->Cell(32,5,utf8_decode("+ $0.00 USD"),0,0,'C');

    // $pdf->Ln(5);

    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

    $pdf->Ln(5);
foreach ($datosV as $V){
    $total_pagar = $V['total'];
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("TOTAL A PAGAR"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$".$total_pagar." MXN"),0,0,'C');

    $pdf->Ln(5);
    $total_pagado = $V['pago'];
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("TOTAL PAGADO"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$".$total_pagado." MXN"),0,0,'C');

    $pdf->Ln(5);
    $cambio = $V['cambio'];
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("CAMBIO"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$".$cambio." MXN"),0,0,'C');
}
    // $pdf->Ln(5);

    // $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    // $pdf->Cell(22,5,utf8_decode("USTED AHORRA"),0,0,'C');
    // $pdf->Cell(32,5,utf8_decode("$0.00 USD"),0,0,'C');
	
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

    $pdf->Ln(10);

    $pdf->MultiCell(0,5,utf8_decode("*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,7,utf8_decode("Gracias por su compra"),'',0,'C');

    $pdf->Ln(9);

    # Codigo de barras #
    // $pdf->Code128(5,$pdf->GetY(),"COD000001V0001",70,20);
    // $pdf->SetXY(0,$pdf->GetY()+21);
    // $pdf->SetFont('Arial','',14);
    // $pdf->MultiCell(0,5,utf8_decode("COD000001V0001"),0,'C',false);
    
    # Nombre del archivo PDF #
    
    $pdf->Output("I","Ticket_Nro_1.pdf",true);//"I","Ticket_Nro_1.pdf",true
    