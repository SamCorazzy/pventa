<?php
// Se llama a la conexion
require("conexion.php");

// Para quitar el aviso de error de Usuariologin indefinido, esto pasa porque no hay un usaurio logueado aun.
error_reporting(0);

// Llamado de sesion
session_start();

// Verifica si el usuario esta logueado, si es asi lo regresa a index, porque si ya esta logueado no es necesario entrar a login
$verificarlogueo = $_SESSION['Usuariologin'];
if ($verificarlogueo != "") {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- CSS Tailwind -->
    <link href="css/output.css" rel="stylesheet">

    <style>
        body {
            background-color: #e5e5f7;
            background-size: 20px 20px;
            background-image: repeating-linear-gradient(0deg, #047857, #047857 1px, #e5e5f7 1px, #e5e5f7);
        }
    </style>
</head>

<body class="flex h-screen justify-center items-center">

    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-2 lg:mx-0">
        <div class="p-6 lg:p-10 lg:px-8">

            <div class="flex justify-center">
                <img src="img/logo.webp" class="h-52 mb-4" alt="Margarita La flor de Usila" />
            </div>
            <!-- <h3 class="text-2xl font-bold text-center mb-6">Ferretería fiero</h3> -->

            <!-- <h1 class="text-lg mb-4 font-bold text-gray-700 lg:text-xl">
                Inicia sesión
            </h1> -->

            <!-- Validación de usuario y contraseña para el inicio de sesión -->
            <?php
            if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
                $usuario = $_POST['usuario'];
                $contrasena = $_POST['contrasena'];
                $contrasena_decodificada = base64_encode($contrasena);

                // Consulta la informacion con la base de datos en la tabla usuarios
                $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre = '$usuario' AND contrasena = '$contrasena_decodificada'");

                $resultado = mysqli_num_rows($consulta);

                if ($resultado) {
                    // Si los datos son correctos, llama a la sesion del usuario y lo redirecciona al index.php
                    session_start();
                    $_SESSION['Usuariologin'] = $usuario;
                    echo '<script type="text/javascript">
                                window.location.assign("index.php");
                                </script>';
                    die();
                    // Si los datos son incorrectos sale una alerta
                } else {
                    echo '<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-xl dark:bg-red-200 dark:text-red-800" role="alert">
                            <span class="font-medium">Lo siento!</span><br/> El usuario y contraseña son incorrectos.
                            </div>';
                }
                mysqli_free_result($consulta);
                mysqli_close($conexion);
            }
            ?>

            <!-- No envia a otro archivo, el proceso se hace en este mismo archivo. -->
            <form class="space-y-4 md:space-y-6" action="login.php" method="POST">
                <div>
                    <label for="" class="block mb-2 text-md font-medium text-gray-900 ">Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="bg-gray-100/80 text-gray-900 sm:text-sm rounded-xl focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Escribe tu usuario" required="required" />
                </div>
                <div>
                    <label for="" class="block mb-2 text-md font-medium text-gray-900">Contraseña</label>
                    <input autocomplete="off" type="password" name="contrasena" id="contrasena" placeholder="••••••••" class="bg-gray-100/80 text-gray-900 sm:text-sm rounded-xl focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="required" />
                </div>
                <button type="submit" class="w-full text-white/80 bg-teal-700 hover:bg-teal-600 font-bold rounded-xl text-sm px-5 py-2.5 text-center">Entrar</button>
            </form>
        </div>
    </div>

</body>

</html>