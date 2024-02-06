<?php 
date_default_timezone_set('America/Mexico_City');
$fecha1 = date('c');//Fecha ISO 8601 (añadido en PHP 5)
function fecha($fecha1){
    $fecha1 = DateTime::createFromFormat('Y-m-d\TH:i:sP', $fecha1);
    $fechaphp = $fecha1->format("Y-m-d H:i:s");
    return $fechaphp;
}

?>