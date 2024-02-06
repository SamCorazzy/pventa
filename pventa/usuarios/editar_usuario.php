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
    <title>Edita un usuario</title>

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
                <a href="usuarios.php" class="bg-green-200/80 hover:bg-green-100/80 lg:p-2 lg:px-4 p-3 px-4  rounded-xl flex cursor-pointer justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <h3 class="ml-5 self-center text-xl font-medium text-gray-900">Edita un usuario</h3>
            </div>

            <?php
            if (isset($_POST['editarusuario'])) {
                $editarusuario = $_POST['editarusuario'];
                $editarcontrasena = base64_encode($_POST['editarcontrasena']);
                $editartipo = $_POST['editartipo'];
                $url = $_GET["url"];

                $actualizardatos = "UPDATE usuarios SET nombre='$editarusuario', contrasena='$editarcontrasena', tipo='$editartipo' WHERE num_usuario = '$url'";

                // Alertas de sweetalert2
                if ($conexion->query($actualizardatos) === true) {
                    echo '<script>
                    swal.fire({
                        title: "Éxito!",
                        text: "Se editó el usuario",
                        icon: "success",
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
                } else {
                    echo '<script>
                    swal.fire({
                        title: "Error!",
                        text: "No se editó el usuario",
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
            ?>


            <!-- Mostrar datos de la tabla usuarios-->
            <?php
            $url = $_GET["url"];

            $obtenerdatos = mysqli_query($conexion, "SELECT * FROM usuarios WHERE num_usuario = '$url'");

            while ($consulta = mysqli_fetch_array($obtenerdatos)) {
            ?>
                <!-- Formulario -->
                <!-- Se envia al archivo editar_usuario_proceso.php con el id del usuario -->
                <form class="space-y-6" method="POST" action="editar_usuario.php?url=<?php echo $consulta['num_usuario']; ?>">
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Nombre del usuario</label>
                        <input value="<?php echo $consulta['nombre']; ?>" type="text" name="editarusuario" id="editarusuario" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
                        <input value="<?php echo base64_decode($consulta['contrasena']); ?>" type="text" name="editarcontrasena" id="editarcontrasena" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" required="required" />
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Rol del usuario</label>
                        <select type="text" name="editartipo" id="editartipo" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5">
                            <option hidden selected><?php echo $consulta['tipo']; ?></option>
                            <option>Administrador</option>
                            <option>Cajero</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full text-gray-900 bg-green-200/80 hover:bg-green-100/80 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Editar</button>
                </form>
            <?php
            }
            ?>
            <!-- Fin de formulario -->

        </div>
    </div>

</body>

</html>