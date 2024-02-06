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
    <title>Agrega un usuario</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Css Tailwind -->
    <link href="../css/output.css" rel="stylesheet">

    <!-- Script necesario para las alertas de sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body class="flex h-screen justify-center items-center mx-3 lg:mx-6">

    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="py-6 px-6 lg:px-8">
            <div class="flex justify-start items-stretch mb-3">
                <a href="proveedores.php" class="bg-blue-200 hover:bg-blue-100 lg:p-2 lg:px-4 p-3 px-4  rounded-xl flex cursor-pointer justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <h3 class="ml-5 self-center text-xl font-medium text-gray-900">Agrega un proveedor</h3>
            </div>

            <!-- Formulario -->
            <?php
            // Proceso de php para insetar registros en la tabla proveedores
            if (isset($_POST['empresa'])) {
                $empresa = $_POST['empresa'];
                $numero = $_POST['numero'];

                // Verificación de si ya existe el usuario con el mismo nombre
                $verificacion = mysqli_query($conexion, "SELECT * FROM proveedores WHERE empresa = '$empresa'");
                $r = mysqli_num_rows($verificacion);
                if ($r > 0) {
                    echo '<script>
                    swal.fire({
                        title: "Lo siento!",
                        text: "Ya existe un proveedor con ese nombre",
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

                // Se añade el usuario
                $sql = "INSERT INTO proveedores(empresa, numero) VALUES ('$empresa', '$numero')";

                // Alertas
                if ($conexion->query($sql) === true) {
                    echo '<script>
                            swal.fire({
                                title: "Éxito!",
                                text: "Se agregó el proveedor",
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
                                text: "No se pudo agregar el proveedor",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 2600,
                                backdrop: "#e5e7eb"
                            });
                            function saludos(){
                                window.history.go(-1);
                                    }
                            setTimeout(saludos, 2600);
                        </script>';
                }
            }
            mysqli_close($conexion);
            ?>

            <form class="space-y-6" method="POST" action="">
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la empresa</label>
                    <input type="text" name="empresa" id="empresa" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" placeholder="Truper" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Número de la empresa</label>
                    <input type="number" name="numero" id="numero" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" placeholder="2871234567" required="required" />
                </div>
               
                <button type="submit" class="w-full text-gray-900 bg-blue-200 hover:bg-blue-100/80 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Agregar</button>
            </form>
            <!-- Fin de formulario -->

        </div>
    </div>

</body>

</html>