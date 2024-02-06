<?php
//archivo que sirve para imprimir el segundo reporte que se usa en el archivo reporte.php
ob_start(); //inicia el metodo ob_start() para poder imprimir esta documento

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KARDEX MENSUAL</title>
    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;600;700;800&display=swap" rel="stylesheet"> -->
    <!-- Styles -->
    <!-- <link rel="stylesheet" type="text/css" href="styles/style.css"> -->

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Css Tailwind -->
    <link href="../css/output.css" rel="stylesheet">

</head>
<!--LETRA-->
<!-- <style>
    body {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
    }
</style> -->


<body>

    <!-- Navegación -->
    <div class="m-3 md:m-6 px-4 py-3 bg-white shadow-xl rounded-xl flex justify-between items-stretch">
        <div class="self-center font-medium md:text-xl">
            <h2>Kardex - Mensual</h2>
        </div>
    </div>

    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">
        <h2 class="text-3xl font-medium">TOTAL DE REGISTROS:
            <?php include('kardex_mes.php');
            echo $registros_total ?></h2>
        <h3 class="text-xl text-center">FECHA:
            <?php
            date_default_timezone_set('America/Mexico_City');
            echo date('d/m/Y');
            ?>, HORA: <?php echo date('h:i A') ?>
        </h3>

        <br>

        <div class="relative overflow-x-auto rounded-xl">
            <table class="w-full text-sm text-left text-gray-500" border="1" cellspacing="1" bordercolor="black" style="border-collapse:collapse; border-color: black; margin: 0 auto">
                <thead class="text-xs text-gray-700 uppercase bg-orange-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            NO
                        </th>
                        <th scope="col" class="px-6 py-3">
                            COD. PRODUCTO
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            TIPO MOVIMIENTO
                        </th>
                        <th scope="col" class="px-6 py-3">
                            FECHA MOVIMIENTO
                        </th>
                        <th scope="col" class="px-6 py-3">
                            CANTIDAD EN INVENTARIO
                        </th>
                        <th scope="col" class="px-6 py-3">
                            USUARIO
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $a = 0;
                    foreach ($datosC as $I) { //se hace un ciclo foreach para poder leer los datos
                    ?>
                        <tr class="bg-white border-b">
                            <th scope="row" style="text-align:center;" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?php echo ++$a ?>
                            </th>
                            <td class="px-6 py-4" style="text-align:center;">
                                <?php echo $I['codigo_prod'];
                                ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $I['nombre']; ?>
                            </td>
                            <td class="px-6 py-4" style="text-align:center;">
                                <?php echo $I['tipo_mov']; ?>
                            </td>
                            <td class="px-6 py-4" style="text-align:center;">
                                <?php echo $I['fecha_mov']; ?>
                            </td>
                            <td class="px-6 py-4" style="text-align:center;">
                                <?php echo $I['cantidad_inv']; ?>
                            </td>
                            <td class="px-6 py-4" style="text-align:center;">
                                <?php echo $I['usuario']; ?>
                            </td>
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
