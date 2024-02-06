<?php
//Se llama a la conexion
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
    <title>Reportes</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.min.js"></script><!-- script para la version jquery usada -->
    <!-- Css Tailwind -->
    <!-- <link href="../css/output.css" rel="stylesheet"> -->

    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body>

    <!-- Navegación -->
    <div class="m-3 md:m-6 px-4 py-3 bg-white shadow-xl rounded-xl flex justify-between items-stretch">
        <a href="../index.php" class="bg-indigo-200 hover:bg-indigo-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div class="self-center font-medium md:text-xl">
            <h2>Venta</h2>
        </div>

        <div class="self-center font-medium md:text-lg">
            <h2>
                Usuario:
            </h2>
            <p>
            <span id="usuario"><?php echo empty($_SESSION['Usuariologin']) ? 'No hay internet' : $_SESSION['Usuariologin']; ?></span>
            </p>
        </div>

    </div>

    <!-- Contenido -->
    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Lado izquierdo para buscar el producto -->
            <div>
                <!-- Buscador -->
                <form class="w-full">
                    <label for="" class="mb-2 text-sm font-medium text-gray-900 sr-only">Buscador</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" id="buscar" name="buscar" class="block w-full p-4 pl-10 text-sm text-gray-900 rounded-xl bg-gray-100" placeholder="Busca un producto" required onkeyup="obtenerDatos()">
                    </div>
                </form>
                <!-- Resultados del buscador -->
                <div id="resultados" style="max-width:700px; max-height:700px; overflow-y:auto;"><!-- Aqui van los resultados de la busqueda hechos por el input id=buscar -->
                    <ul id="lista-resultados">
                        <!-- resultados -->
                    </ul>
                </div>
                <!-- <div class="my-4 px-4 flex justify-between items-stretch w-full border-2 border-indigo-200 rounded-xl ">
                    <img src="https://cms.grupoferrepat.net/assets/img/productos/MK6224_3.jpg" class="w-24 h-auto self-center" alt="">
                    <div class="self-center">
                        <p>Nombre:</p>
                        <p>Motosierra Truper...</p>
                    </div>
                    <div class="self-center">
                        <p>Existencia:</p>
                        <p>125</p>
                    </div>
                    <div class="self-center">
                        <p>Precio:</p>
                        <p>$1000</p>
                    </div>
                    <button class="bg-indigo-200 hover:bg-indigo-100 rounded-xl py-2 px-3 self-center">Agregar</button>
                </div> -->
            </div>
            <!-- Lado derecho, lista de productos -->
            <div class="pt-4">
                <div>
                    <p class="text-center text-3xl font-medium">Lista de venta</p>
                </div>
                <div class="pt-4" id="venta" style="max-width:700px; max-height:320px; overflow-y:auto;">
                    <!-- Productos agregados -->
                    <!-- <div class="my-4 px-4 flex justify-between items-stretch w-full border-2 border-indigo-200 rounded-xl ">
                        <img src="https://cms.grupoferrepat.net/assets/img/productos/MK6224_3.jpg" class="w-24 h-auto self-center" alt="">
                        <div class="self-center">
                            <p>Nombre:</p>
                            <p>Motosierra Truper...</p>
                        </div>
                        <div class="self-center">
                            <p>Precio:</p>
                            <p>$1000</p>
                        </div>
                        <div class="self-center">
                            <p>Cantidad:</p>
                            <p>2</p>
                        </div>
                        <div class="flex">
                            <button title="Agregar 1" class="bg-indigo-200 hover:bg-indigo-100 rounded-full p-2 self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                            </button>
                            <button title="Quitar 1" class="bg-indigo-200 hover:bg-indigo-100 rounded-full p-2 self-center mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                </svg>
                            </button>
                            <button title="Eliminar producto" class="bg-red-200 hover:bg-red-100 rounded-full p-2 self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="my-4 px-4 flex justify-between items-stretch w-full border-2 border-indigo-200 rounded-xl ">
                        <img src="https://www.truper.com/media/product/45b/motosierra-60-cc-a-gasolina-con-barra-de-18-pretul-34f.jpg" class="w-24 h-auto self-center" alt="">
                        <div class="self-center">
                            <p>Nombre:</p>
                            <p>Motosierra Truper...</p>
                        </div>
                        <div class="self-center">
                            <p>Precio:</p>
                            <p>$1000</p>
                        </div>
                        <div class="self-center">
                            <p>Cantidad:</p>
                            <p>2</p>
                        </div>
                        <div class="flex">
                            <button title="Agregar 1" class="bg-indigo-200 hover:bg-indigo-100 rounded-full p-2 self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                            </button>
                            <button title="Quitar 1" class="bg-indigo-200 hover:bg-indigo-100 rounded-full p-2 self-center mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                </svg>
                            </button>
                            <button title="Eliminar producto" class="bg-red-200 hover:bg-red-100 rounded-full p-2 self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div> -->
                    <ul id="listaCorrecta"></ul>
                </div>
                <div id="totalVenta">
                    <hr class="my-2">
                    <!-- Conclusión de la venta -->
                    <div class="flex justify-between items-stretch">
                        <div>
                            <p class="text-2xl font-medium">Total:</p>
                            <p class="text-4xl">$<span id="total">0</span></p>
                        </div>
                        <div class="self-center">
                            <p class="text-xl font-medium">Pago:</p>
                            <span class="text-4xl">$<input onblur="revisarCambio()" id="pago" type="number" class="text-4xl w-48 border-2 border-black text-center"/></span>
                        </div>
                        <div class="self-center">
                            <p class="text-xl font-medium">Cambio:</p>
                            <p class="text-4xl">$<span id="cambio">0</span></p>
                        </div>
                        <button id="vender" class="bg-green-200 hover:bg-green-100 text-xl rounded-xl py-2 px-3 self-end" onclick="vender();">Vender</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="venta.js"></script>

</body>

</html>