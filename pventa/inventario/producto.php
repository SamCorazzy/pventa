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
    <title>Producto</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Css Tailwind -->
    <link href="../css/output.css" rel="stylesheet">

    <!-- Script necesario para las alertas de sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
    $url = $_GET['url'];

    $datos = mysqli_query($conexion, "SELECT * FROM inventario WHERE num_producto = $url");

    while ($consulta = mysqli_fetch_array($datos)) {
    ?>
        <!-- Navegación -->
        <div class="m-3 md:m-6 px-4 py-3 bg-white shadow-xl rounded-xl flex justify-between items-stretch">
            <a href="inventario.php" class="bg-slate-200 hover:bg-slate-100 p-2 rounded-xl self-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div class="self-center font-medium md:text-xl">
                <h2>Producto</h2>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <!-- La condición hace que el botón solo se muestre con el usuario que tiene rol(tipo) "Administrador" -->
                <a href="editar_producto.php?url=<?php echo $consulta['num_producto']; ?>" <?php if ($tipo == 'Cajero') { ?> style="display: none;" <?php   } ?> title="Editar producto" class="self-center p-2 bg-slate-200 hover:bg-slate-100 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </a>
                <!-- La condición hace que el botón solo se muestre con el usuario que tiene rol(tipo) "Administrador" -->
                <!-- El onclick llama al script de sweetalert -->
                <button onclick="borrarAlert()" <?php if ($tipo == 'Cajero') { ?> style="display: none;" <?php   } ?> title="Eliminar producto" class="self-center p-2 bg-red-400 hover:bg-red-300 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <script>
            function borrarAlert() {

                swal.fire({
                    title: "Espera!",
                    text: "Seguro de eliminar el producto?",
                    icon: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonColor: "#f87171",
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.assign("eliminar_producto.php?url=<?php echo $consulta['num_producto']; ?>");
                    }
                });
            }
        </script>
    <?php
    }
    ?>
    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">
        <?php
        $url = $_GET['url'];

        $datos = mysqli_query($conexion, "SELECT * FROM inventario WHERE num_producto = $url");

        while ($consulta = mysqli_fetch_array($datos)) {
        ?>

            <div class="grid grid-rows-3 grid-cols-1 lg:grid-cols-4 gap-4">
                <div class="row-span-3 flex justify-center">
                    <img class="w-auto h-38 object-cover rounded-xl" src="data:<?php echo $consulta['tipo_imagen']; ?>;base64,<?php echo base64_encode($consulta['imagen']);  ?>" alt="">
                </div>

                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Código:</h3>
                    <p><?php echo $consulta['codigo_prod']; ?></p>
                </div>
                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Nombre:</h3>
                    <p><?php echo $consulta['nombre']; ?></p>
                </div>
                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Precio de compra</h3>
                    <p>$<?php echo $consulta['precio_compra']; ?></p>
                </div>
                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Precio de venta:</h3>
                    <p>$<?php echo $consulta['precio_venta']; ?></p>
                </div>
                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Stock:</h3>
                    <p><?php echo $consulta['stock']; ?></p>
                </div>
                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Existencia:</h3>
                    <p><?php echo $consulta['existencia']; ?></p>
                </div>
                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Fecha de ingreso:</h3>
                    <p><?php echo $consulta['fecha_ingreso']; ?></p>
                </div>
            <?php
        }
            ?>
            <?php
            $url = $_GET['url'];

            $datosproveedor = mysqli_query($conexion, "SELECT t1.num_producto, t1.proveedor_num, t2.num_proveedor, t2.empresa, t2.numero FROM inventario t1 INNER JOIN proveedores t2 ON t1.proveedor_num = t2.num_proveedor WHERE num_producto = $url");

            while ($consultaproveedor = mysqli_fetch_array($datosproveedor)) {
            ?>

                <div class="bg-slate-200 rounded-xl p-3">
                    <h3 class="font-medium">Proveedor:</h3>
                    <p><?php echo $consultaproveedor['empresa']; ?></p>
                </div>
            <?php
            }
            ?>
            </div>
    </div>
</body>

</html>