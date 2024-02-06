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
    <title>Agregar producto</title>

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
            <a href="inventario.php" class="bg-slate-200 hover:bg-slate-100 lg:p-2 lg:px-4 p-3 px-4  rounded-xl flex cursor-pointer justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h3 class="ml-5 self-center text-xl font-medium text-gray-900">Agrega un producto</h3>
        </div>


        <?php
        if (isset($_POST['codigoproducto'])) {
            $codigoproducto = $_POST['codigoproducto'];
            $nombreproducto = $_POST['nombreproducto'];
            $imagennombre = $_FILES['imagen']['name'];
            $imagentipo = $_FILES['imagen']['type'];
            $permitido = array("image/png", "image/jpeg", "image/webp");
            if (in_array($imagentipo, $permitido) == false) {
                die('<script>
                    swal.fire({
                        title: "Espera!",
                        text: "No es valido ese formato de imagen, usa png, jpeg, webp.",
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 3000,
                        backdrop: "#e5e7eb"
                      });
                    function saludos(){
                        window.history.go(-1);
                            }
                    setTimeout(saludos, 3000);
                   
                </script>');
            }
            $imagentamano = $_FILES['imagen']['size'];
            $imagensubida = fopen($_FILES['imagen']['tmp_name'], 'r');
            $binariosimagen = fread($imagensubida, $imagentamano);
            $binariosimagen = mysqli_escape_string($conexion, $binariosimagen);

            $preciocompra = $_POST['preciocompra'];
            $precioventa = $_POST['precioventa'];
            $stockproducto = $_POST['stockproducto'];
            $existenciaproducto = $_POST['existenciaproducto'];
            $proveedorproducto = $_POST['proveedorproducto'];
            $fechaingreso = $_POST['fechaingreso'];

            // Verificación de si ya existe un producto con el mismo código
            $verificacion = mysqli_query($conexion, "SELECT * FROM inventario WHERE codigo_prod = '$codigoproducto'");
            $r = mysqli_num_rows($verificacion);
            if ($r > 0) {
                echo '<script>
                swal.fire({
                    title: "Espera!",
                    text: "Ya existe un producto con ese código",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 2600,
                    backdrop: "#e5e7eb"
                  });
                function saludos(){
                    window.history.go(-1);
                        }
                setTimeout(saludos, 2600);
               
            </script>';
                die();
            }

            $sql = "INSERT INTO inventario(codigo_prod, nombre, nombre_imagen, imagen, tipo_imagen, precio_compra, precio_venta, stock, existencia, fecha_ingreso, proveedor_num) VALUES ('$codigoproducto', '$nombreproducto', '$imagennombre', '$binariosimagen', '$imagentipo', '$preciocompra', '$precioventa', '$stockproducto', '$existenciaproducto', '$fechaingreso', '$proveedorproducto')";

            if ($conexion->query($sql) === true) {
                echo '<script>
                            swal.fire({
                                title: "Éxito!",
                                text: "Se agregó el producto",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2600,
                                backdrop: "#e5e7eb"
                            });
                            
                        </script>';
            } else {
                echo '<script>
                            swal.fire({
                                title: "Error!",
                                text: "No se pudo agregar el producto",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 2600,
                                backdrop: "#e5e7eb"
                            });

                        </script>';
            }
        }
        ?>

        <form class="space-y-6" method="POST" action="" enctype="multipart/form-data">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Código de producto</label>
                    <input type="text" name="codigoproducto" id="codigoproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                    <input type="text" name="nombreproducto" id="nombreproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Precio de compra</label>
                    <input type="number" name="preciocompra" id="preciocompra" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Precio de venta</label>
                    <input type="number" name="precioventa" id="precioventa" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Stock</label>
                    <input type="number" name="stockproducto" id="stockproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Existencia</label>
                    <input type="number" name="existenciaproducto" id="existenciaproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Proveedor</label>
                    <select type="text" name="proveedorproducto" id="proveedorproducto" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                    <option hidden>Seleciona el proveedor</option>
                    <option value="Sin proveedor">Sin proveedor</option>
                    <?php
                    // Muestra datos de la tabla proveedores, esto para mostrar en el select los proveedores que hay
                    $datos = mysqli_query($conexion, "SELECT * FROM proveedores WHERE 1");

                    while ($consulta = mysqli_fetch_array($datos)) {
                    ?>
                        <option value="<?php echo $consulta['num_proveedor']; ?>">- <?php echo $consulta['empresa']; ?></option>
                    <?php
                    }
                    ?>
                    </select>
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Fecha de ingreso</label>
                    <input type="date" value="<?php date_default_timezone_set('America/Mexico_City');
                                                echo date('Y-m-d'); ?>" name="fechaingreso" id="fechaingreso" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="block w-full text-sm rounded-xl p-2 bg-gray-50 text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-xl file:border-0
                            file:text-sm file:font-medium
                            cursor-pointer
                            file:bg-[#e2e8f0] file:text-gray-900
                            hover:file:bg-[#f1f5f9]" required="required" />
                </div>
            </div>
            <button type="submit" class="w-full text-gray-900 bg-slate-200 hover:bg-slate-100 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Agregar</button>
        </form>
        <!-- Fin de formulario -->
    </div>

</body>

</html>