<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KARDEX SEMANAL</title>
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
        <a href="kardexs.php" class="bg-orange-200 hover:bg-orange-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div class="self-center font-medium md:text-xl">
            <h2>Kardex - Semanal</h2>
        </div>
        <a href="pdf_sem.php" target="_blank" title="Imprimir" class="bg-orange-200 hover:bg-orange-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
            </svg>
        </a>
    </div>


    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">
        <h2 class="text-3xl font-medium">TOTAL DE REGISTROS:
            <?php include('kardex_sem.php');
            echo $registros_total ?></h2>
        <br>
        <h3 class="text-xl text-center">FECHA:
            <?php
            date_default_timezone_set('America/Mexico_City');
            echo date('d/m/Y');
            ?>, HORA: <?php echo date('h:i A') ?>
        </h3>

        <br>

        <div class="relative overflow-x-auto rounded-xl">
            <table class="w-full text-sm text-left text-gray-500">
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
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?php echo ++$a ?>
                            </th>
                            <td class="px-6 py-4">
                                <?php echo $I['codigo_prod'];
                                ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $I['nombre']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $I['tipo_mov']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $I['fecha_mov']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $I['cantidad_inv']; ?>
                            </td>
                            <td class="px-6 py-4">
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