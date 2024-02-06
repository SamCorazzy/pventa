<?php
//archivo que sirve para imprimir el segundo reporte que se usa en el archivo reporte.php
ob_start(); //inicia el metodo ob_start() para poder imprimir esta documento

include("../conexion.php"); //utiliza el archivo para poder interacturar con la base de datos

?>

<!-- se abre un documento HTML para poder modificar como se vera el aspecto del documento a imprimir -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="styles/style.css">

</head>
<!--LETRA-->
<style>
    body {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
    }
</style>


<body>
    <div>

        <div>
        <h4 style="text-align: center; vertical-align: middle;">
            <img src="img/logo.png" width="150" height="60"/>
            REPORTE DE GASTOS. FECHA: 
                <?php 
                    date_default_timezone_set('America/Mexico_City');
                    echo date('d/m/Y');
                ?>, HORA: <?php echo date('h:i A')?>
            </h4>      
        </div><br>

        <div>
            <table class="content-table" border="1" cellspacing="1" bordercolor="black" style="border-collapse:collapse; border-color: black; margin: 0 auto">
                <thead>
                <tr>
                        <th>NUM GASTO</th>
                        <th>FECHA</th>
                        <th>CONCEPTO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>IMPORTE</th>
                        <th>NÚMERO DE REMISIÓN</th>
                        <th>NOMBRE DEL REALIZADOR</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    include('generar_gastos.php');
                    $a = 0;
                    foreach ($datosC as $I) { //se hace un ciclo foreach para poder leer los datos
                    ?>
                        <tr>
                            <th><?php echo $I['num_gasto']; //datos php obtenidos ?></th>
                            <th><?php echo $I['fecha']; ?></th>
                            <th><?php echo $I['concepto']; ?></th>
                            <th><?php echo $I['descripcion']; ?></th>
                            <th><?php echo $I['importe'];?></th>
                            <th><?php echo $I['numero_remision']; ?></th>
                            <th><?php echo $I['nombre']; ?></th>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>

<?php
//El siguiente metodo no permite que el documento html se muestre en cambio muostrara la vista de impresión
$html = ob_get_clean();
//echo $html;

//requiere el uso de la libreria Dompdf
require_once 'dompdf\autoload.inc.php';  //..libreria\dompdf\autoload.inc.php
use Dompdf\Dompdf;
//inicializa una nueva función Dompdf
$dompdf = new Dompdf();
//obtiene las funciones que requiere en caso de usarlas
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnable' => true, 'tempDir' => '/tmp', 'chroot' => __DIR__)); //para imagenes

$dompdf->setOptions($options);

$dompdf->loadHtml($html); //guarda el archivo html o un mensaje

//$dompdf->setPaper('letter');
$dompdf->setPaper('letter', 'landscape'); //medidas del documento pdf que generara

$dompdf->render();

$dompdf->stream("archivo.pdf", array("Attachment" => false)); //si es true lo descarga automaticamente

?>
