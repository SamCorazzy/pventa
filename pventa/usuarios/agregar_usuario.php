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
                <a href="usuarios.php" class="bg-green-200/80 hover:bg-green-100 lg:p-2 lg:px-4 p-3 px-4  rounded-xl flex cursor-pointer justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <h3 class="ml-5 self-center text-xl font-medium text-gray-900">Agrega un usuario</h3>
            </div>

            <!-- Formulario -->
            <?php
            // Proceso de php para insetar registros en la tabla usuarios
            if (isset($_POST['nombreusuario'])) {
                $nombreusuario = $_POST['nombreusuario'];
                $contrasenausuario = $_POST['contrasenausuario'];
                $tipousuario = $_POST['tipousuario'];
                $contrasenausuario_codificado = base64_encode($contrasenausuario);

                // Verificación de si ya existe el usuario con el mismo nombre
                $verificacion = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre = '$nombreusuario'");
                $r = mysqli_num_rows($verificacion);
                if ($r > 0) {
                    echo '<script>
                    swal.fire({
                        title: "Lo siento!",
                        text: "Ya existe un usuario con ese nombre",
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
                $sql = "INSERT INTO usuarios(nombre, contrasena, tipo) VALUES ('$nombreusuario', '$contrasenausuario_codificado', '$tipousuario')";

                // Alertas
                if ($conexion->query($sql) === true) {
                    echo '<script>
                            swal.fire({
                                title: "Éxito!",
                                text: "Se agregó el usuario",
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
                                text: "No se pudo agregar el usuario",
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
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Nombre del usuario</label>
                    <input type="text" name="nombreusuario" id="nombreusuario" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" placeholder="Usuario" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
                    <input type="text" name="contrasenausuario" id="contrasenausuario" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5" placeholder="Contraseña" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900">Tipo de usuario</label>
                    <select type="text" name="tipousuario" id="tipousuario" class="bg-gray-100 text-gray-900 text-sm rounded-xl  block w-full p-2.5">
                        <option hidden selected>Selecciona un tipo</option>
                        <option>Administrador</option>
                        <option>Cajero</option>
                    </select>
                </div>
                <button type="submit" class="w-full text-gray-900 bg-green-200/80 hover:bg-green-100/80 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Agregar</button>
            </form>
            <!-- Fin de formulario -->

        </div>
    </div>

</body>

</html>