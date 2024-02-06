<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    // Se llama a la conexion
    include("../conexion.php");

    // Proceso de PHP para eliminar registros de la tabla clientes
    $url = $_GET["url"];
    $eliminardatos = "DELETE FROM clientes WHERE num_cliente = '$url'";

    $resultado = mysqli_query($conexion, $eliminardatos);
    // Alertas de sweetalert2
    if ($resultado) {
        echo '<script>
        swal.fire({
            title: "Éxito!",
            text: "Se eliminó el cliente",
            icon: "success",
            showConfirmButton: false,
            timer: 2600
          });
        function saludos(){
            window.location.assign("clientes.php");
                }
        setTimeout(saludos, 2600);
       
    </script>';
        die();
    } else {
        echo '<script>
        swal.fire({
            title: "Error!",
            text: "No se eliminó el cliente",
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
    ?>
</body>

</html>