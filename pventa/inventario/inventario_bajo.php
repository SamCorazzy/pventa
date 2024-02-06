<?php
// Se llama a la conexion
include("../conexion.php");

// Llama a la sesion del usuario
session_start();

// Verifica si el usuario esta logueado
$verificarlogueo = $_SESSION['Usuariologin'];

// Busca los datos del usuario logueado
$datosusuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre = '$verificarlogueo'");

// Para obtener el rol del usuario logueado
while ($consultarol = mysqli_fetch_array($datosusuario)) {
    $tipo = $consultarol['tipo'];
}

// Si no lo esta lo regresa a login, porque si no esta logueado no dejara que entre a dashboard
if ($verificarlogueo == null || $verificarlogueo = "") {
    header("location: login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Css Tailwind -->
    <link href="../css/output.css" rel="stylesheet">

</head>

<body>

    <!-- Navegación -->
    <div class="m-3 md:m-6 px-4 py-3 bg-white shadow-xl rounded-xl flex justify-between items-stretch">
        <a href="inventario.php" class="bg-slate-200 hover:bg-slate-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div class="self-center font-medium md:text-xl">
            <h2>Inventario</h2>
        </div>
        <div class="self-center flex">
            <a href="agregar_producto.php" <?php if ($tipo == 'Cajero') { ?> style="display: none;" <?php   } ?> title="Agregar producto" class="p-2 bg-slate-200 hover:bg-slate-100 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Contenido -->
    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">
        <div class="mb-6 flex flex-wrap justify-between items-stretch">
            <?php

            $obtenerdatosc = mysqli_query($conexion, "SELECT count(existencia) AS total FROM inventario WHERE existencia <= 5");

            while ($consultac = mysqli_fetch_array($obtenerdatosc)) {
            ?>
                <h2 class="text-4xl font-medium self-center"><?php echo $consultac['total']; ?> PRODUCTOS CON SURTIDO BAJO</h2>
            <?php
            }
            ?>
            
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <!-- Mostrar datos de la tabla inventario -->
            <?php
            $obtenerdatos = mysqli_query($conexion, "SELECT * FROM inventario WHERE existencia <= 5");

            while ($consulta = mysqli_fetch_array($obtenerdatos)) {
            ?>
                <a href="producto.php?url=<?php echo $consulta['num_producto']; ?>" class="bg-gray-200 hover:bg-gray-100 rounded-xl p-4">
                    <img class="w-full h-60 object-cover rounded-xl" src="data:<?php echo $consulta['tipo_imagen']; ?>;base64,<?php echo base64_encode($consulta['imagen']); ?>" />

                    <h3 class="text-lg my-4 font-medium text-gray-700 truncate">
                        <?php echo $consulta['nombre']; ?>
                    </h3>
                    <div class="flex justify-between w-full">
                        <div class="bg-white px-3 py-2 rounded-xl">
                        <?php echo $consulta['precio_venta']; ?>
                        </div>
                        <div class="bg-white px-3 py-2 rounded-xl">
                        <?php echo $consulta['existencia']; ?> E.
                        </div>
                        <div class="bg-white px-3 py-2 rounded-xl">
                        <?php echo $consulta['codigo_prod']; ?>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>

        </div>
    </div>
</body>


</html>