<?php
// Llama a la sesion del usuario
session_start();
// Destruye la sesion del usuario
session_destroy();
// Redirecciona a la página de login.php
header("location: login.php");
?>