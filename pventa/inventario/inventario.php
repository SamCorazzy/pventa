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
        <a href="../index.php" class="bg-slate-200 hover:bg-slate-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div class="self-center font-medium md:text-xl">
            <h2>Inventario</h2>
        </div>
        <div class="self-center flex">
            <a href="agregar_producto.php" <?php if ($tipo == 'Cajero'){ ?> style="display: none;" <?php   } ?> title="Agregar producto" class="p-2 bg-slate-200 hover:bg-slate-100 rounded-xl">
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

            $obtenerdatosc = mysqli_query($conexion, "SELECT count(codigo_prod) AS total FROM inventario");

            while ($consultac = mysqli_fetch_array($obtenerdatosc)) {
            ?>
                <h2 class="text-4xl font-medium self-center"><?php echo $consultac['total']; ?> PRODUCTOS</h2>
            <?php
            }
            ?>

            <a href="inventario_bajo.php" class="bg-slate-200 hover:bg-slate-100 rounded-xl self-center px-3 py-2 w-full md:w-fit mt-2 md:mt-0 text-center">Surtido bajo</a>

            <form action="" method="post" class="w-full md:w-fit mt-2 md:mt-0">
                <div class="flex w-full bg-slate-200 p-2 rounded-xl">
                    <label for="campo" class="self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </label>
                    <input autocomplete="off" type="text" placeholder="Buscador" name="campo" id="campo" class="ml-2 bg-slate-200">
                </div>
            </form>
        </div>

        <div id="content" class="grid grid-cols-1 lg:grid-cols-4 gap-4">



        </div>
    </div>
</body>
<script>
    /* Llamando a la función getData() */
    getData()
    /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
    document.getElementById("campo").addEventListener("keyup", getData)
    /* Peticion AJAX */
    function getData() {
        let input = document.getElementById("campo").value
        let content = document.getElementById("content")
        let url = "buscador.php"
        let formaData = new FormData()
        formaData.append('campo', input)
        fetch(url, {
                method: "POST",
                body: formaData
            }).then(response => response.json())
            .then(data => {
                content.innerHTML = data
            }).catch(err => console.log(err))
    }
</script>

</html>