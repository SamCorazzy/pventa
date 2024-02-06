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
    // Si esta logueado dependiendo el rol se mantiene en la pagina
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
    <title>Editar producto</title>

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

    <div class="bg-white rounded-xl shadow-xl m-3 md:m-6 px-4 py-3">
        <div class="flex justify-start items-stretch mb-3">
            <?php
            $url = $_GET["url"];

            $datos = mysqli_query($conexion, "SELECT * FROM inventario WHERE num_producto = '$url'");

            while ($consulta = mysqli_fetch_array($datos)) {
            ?>
                <a href="producto.php?url=<?php echo $consulta['num_producto']; ?>" class="bg-slate-200 hover:bg-slate-100 lg:p-2 lg:px-4 p-3 px-4  rounded-xl flex cursor-pointer justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
            <?php
            }
            ?>
            <h3 class="ml-5 self-center text-xl font-medium text-gray-900">Edita un producto</h3>
        </div>


        <?php
        if (isset($_POST['nombreproducto'])) {
            // $codigoproducto = $_POST['codigoproducto'];
            $nombreproducto = $_POST['nombreproducto'];
            $preciocompra = $_POST['preciocompra'];
            $precioventa = $_POST['precioventa'];
            $stockproducto = $_POST['stockproducto'];
            $existenciaproducto = $_POST['existenciaproducto'];
            $fechaingreso = $_POST['fechaingreso'];
            $proveedorproducto = $_POST['proveedorproducto'];
            $url = $_GET["url"];

            $sql = "UPDATE inventario SET nombre='$nombreproducto', precio_compra='$preciocompra', precio_venta='$precioventa', stock='$stockproducto', existencia='$existenciaproducto', fecha_ingreso='$fechaingreso', proveedor_num='$proveedorproducto' WHERE num_producto = '$url'";

            if ($conexion->query($sql) === true) {
                echo '<script>
                            swal.fire({
                                title: "Éxito!",
                                text: "Se editó el producto",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2600
                            });
                            function saludos(){
                                window.history.go(-2);
                                    }
                            setTimeout(saludos, 2600);
                        </script>';
            } else {
                echo '<script>
                            swal.fire({
                                title: "Error!",
                                text: "No se pudo editar el producto",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 2600
                            });
                            function saludos(){
                                window.history.go(-1);
                                    }
                            setTimeout(saludos, 2600);
                        </script>';
            }
        }
        ?>

        <?php
        $url = $_GET["url"];

        $datos = mysqli_query($conexion, "SELECT * FROM inventario WHERE num_producto = '$url'");

        while ($consulta = mysqli_fetch_array($datos)) {
        ?>
            <form class="space-y-6" method="POST" action="editar_producto.php?url=<?php echo $consulta['num_producto']; ?>" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Código de producto</label>
                        <input disabled type="text" name="codigoproducto" id="codigoproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" value="<?php echo $consulta['codigo_prod']; ?>" />
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                        <input type="text" name="nombreproducto" id="nombreproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" value="<?php echo $consulta['nombre']; ?>" />
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Precio de compra</label>
                        <input type="number" name="preciocompra" id="preciocompra" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" value="<?php echo $consulta['precio_compra']; ?>" />
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Precio de venta</label>
                        <input type="number" name="precioventa" id="precioventa" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" value="<?php echo $consulta['precio_venta']; ?>" />
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Stock</label>
                        <input type="number" name="stockproducto" id="stockproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" value="<?php echo $consulta['stock']; ?>" />
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Existencia</label>
                        <input type="number" name="existenciaproducto" id="existenciaproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" value="<?php echo $consulta['existencia']; ?>" />
                    </div>

                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Proveedor</label>
                        <select type="text" name="proveedorproducto" id="proveedorproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                        <?php
                        // Muestra datos de la tabla proveedores, esto para mostrar en el select los proveedores que hay
                        $datosproveedores = mysqli_query($conexion, "SELECT t1.num_producto, t1.proveedor_num, t2.num_proveedor, t2.empresa, t2.numero FROM inventario t1 INNER JOIN proveedores t2 ON t1.proveedor_num = t2.num_proveedor WHERE num_producto = $url");

                        while ($consultaproveedores = mysqli_fetch_array($datosproveedores)) {
                        ?>
                            <option hidden value="<?php echo $consultaproveedores['num_proveedor']; ?>">- <?php echo $consultaproveedores['empresa']; ?></option>
                        <?php
                        }
                        ?>
                        <option value="0">Sin proveedor</option>
                        <?php
                        // Muestra datos de la tabla proveedores, esto para mostrar en el select los proveedores que hay
                        $datosproveedores = mysqli_query($conexion, "SELECT * FROM proveedores WHERE 1");

                        while ($consultaproveedores = mysqli_fetch_array($datosproveedores)) {
                        ?>
                            <option value="<?php echo $consultaproveedores['num_proveedor']; ?>">- <?php echo $consultaproveedores['empresa']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>

                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Fecha de ingreso</label>
                        <input type="date" value="<?php echo $consulta['fecha_ingreso']; ?>" name="fechaingreso" id="fechaingreso" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                    </div>
                </div>
                <button type="submit" class="w-full text-gray-900 bg-slate-200 hover:bg-slate-100 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Editar</button>
            </form>
            <!-- Fin de formulario -->
        <?php
        }
        ?>
    </div>

</body>

</html>