<?php
// Llama a la conexion
require("../conexion.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>

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

    <!-- Navegación -->
    <div class="m-3 md:m-6 px-4 py-3 bg-white shadow-xl rounded-xl flex justify-between items-stretch">
        <a href="../index.php" class="bg-blue-200 hover:bg-blue-100 p-2 rounded-xl self-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div class="self-center font-medium md:text-xl">
            <h2>Proveedores</h2>
        </div>
        <a href="agregar_proveedor.php" title="Agregar proveedor" class="self-center p-2 bg-blue-200 hover:bg-blue-100 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

        </a>
    </div>

    <!-- Contenido -->
    <div class="m-3 md:m-6 p-4 bg-white shadow-xl rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Mostrar datos de la tabla proveedores -->
            <?php
            $obtenerdatos = mysqli_query($conexion, "SELECT * FROM proveedores WHERE 1");

            while ($consulta = mysqli_fetch_array($obtenerdatos)) {
            ?>
                <div class="p-3 px-4 bg-blue-200 rounded-xl">
                    <h3 class="font-bold">Datos del proveedor:</h3>
                    <li>Nombre: <?php echo $consulta['empresa']; ?></li>
                    <li>Teléfono: <?php echo $consulta['numero']; ?></li>
                    <li>Se debe: <?php echo $consulta['cuentas_pagar']; ?></li>
                    <hr class="my-3" />
                    <div class="flex">

                        <!-- Manda el id del proveedor al archivo editar_proveedores.php para editar la información -->
                        <a href="editar_proveedor.php?url=<?php echo $consulta['num_proveedor']; ?>" title="Editar proveedor" class="mr-2  bg-white hover:bg-gray-100 rounded-xl p-2" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>

                        <button onclick="<?php echo $consulta['empresa']; ?>()" class="bg-red-400 hover:bg-red-300 rounded-xl p-2" title="Eliminar proveedor">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <script>
                            function <?php echo $consulta['empresa']; ?>() {

                                swal.fire({
                                    title: "Espera!",
                                    text: "Seguro de eliminar el proveedor?",
                                    icon: "warning",
                                    showConfirmButton: true,
                                    showCancelButton: true,
                                    confirmButtonColor: "#f87171",
                                    cancelButtonColor: '#9ca3af',
                                    confirmButtonText: 'Si',
                                    cancelButtonText: 'No'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.assign("eliminar_proveedor.php?url=<?php echo $consulta['num_proveedor']; ?>");
                                    }
                                });
                            }
                        </script>

                    </div>

                </div>

            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>