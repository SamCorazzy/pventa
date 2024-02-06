<?php
include("../conexion.php");
$caja = array();
$proveedores = mysqli_query($conexion, "SELECT no_caja,usuario,fecha_ent,fecha_sal,cant_caja FROM caja");
while ($row = mysqli_fetch_array($proveedores)) {
    $no_caja = $row['no_caja'];
    $usuario = $row['usuario'];
    $fecha_ent = $row['fecha_ent'];
    $fecha_sal = $row['fecha_sal'];
    $cant_caja = $row['cant_caja'];
    $caja[] = array('no_caja'=> $no_caja, 'usuario'=>$usuario, 'fecha_ent'=>$fecha_ent, 'fecha_sal'=>$fecha_sal, 'cant_caja'=>$cant_caja,);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cortes de caja</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Css Tailwind -->
    <link href="../css/output.css" rel="stylesheet">

    <!-- Css Flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/flowbite.min.css" rel="stylesheet" />
</head>

<body>

    <!-- Navegación -->
    <div class="m-3 md:m-6 px-4 py-3 bg-white shadow-xl rounded-xl flex justify-between items-stretch">
        <a href="../index.php" class="bg-yellow-200 hover:bg-yellow-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div class="self-center font-medium md:text-xl">
            <h2>Cortes de caja</h2>
        </div>
        <div></div>
    </div>

    <!-- Contenido -->
    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">
        <h2 class="mb-3 text-lg">Cortes de caja recientes</h2>
        <?php foreach ($caja as $C) { //se hace un ciclo foreach para poder leer los datos?>
            <div class="p-4 rounded-xl bg-yellow-200 mb-4 grid grid-cols-5 md:grid-cols-5 md:place-items-center gap-3">
                <!--  grid-template-columns: repeat(3, 1fr); -->
                <div>
                    <h3 class="font-medium">
                        Inicio de caja:
                    </h3>
                    <p>
                        <?php echo $C['fecha_ent']; ?>
                    </p>
                </div>
                <div>
                    <h3 class="font-medium">
                        Final de caja:
                    </h3>
                    <p>
                        <?php echo $C['fecha_sal']; ?>
                    </p>
                </div>
                <div>
                    <h3 class="font-medium">
                        No. de caja:
                    </h3>
                    <p>
                        <?php echo $C['no_caja']; ?>
                    </p>
                </div>
                <div>
                    <h3 class="font-medium">
                        Total en caja:
                    </h3>
                    <p>
                        <?php echo $C['cant_caja']; ?>
                    </p>
                </div>
                <div>
                    <h3 class="font-medium">
                        Usuario:
                    </h3>
                    <p>
                        <?php echo $C['usuario']; ?>
                    </p>
                </div>
            </div>
        <?php $close = mysqli_close($conexion);}?>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/flowbite.min.js"></script>

</html>