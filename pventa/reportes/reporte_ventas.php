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
    // Si esta logueado dependiendo el tipo se mantiene en la pagina
} elseif ($tipo == "Cajero") {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de ventas</title>

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
        <a href="reportes.php" class="bg-orange-200 hover:bg-orange-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div class="self-center font-medium md:text-xl">
            <h2>Reporte de ventas</h2>
        </div>
        <div></div>
    </div>

    <!-- Contenido -->
    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">

        <form class="space-y-6" method="POST" action="pdf_ventas.php" target="_blank">
            <h3 class="text-3xl md:text-4xl mb-6">Escoge el rango de fecha</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">De</label>
                    <input type="date" name="fecha1" id="fecha1" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Hasta</label>
                    <input type="date" name="fecha2" id="fecha2" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
            </div>
            <button type="submit" class="w-full text-gray-900 bg-orange-200 hover:bg-orange-100 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Generar reporte</button>
        </form>

    </div>
</body>

</html>