<?php
// Este archivo es parte del proceso del buscarador.php

// Se llama a la conexion
require '../conexion.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['num_producto', 'codigo_prod', 'nombre', 'nombre_imagen', 'imagen', 'tipo_imagen', 'precio_compra', 'precio_venta', 'stock', 'existencia'];

/* Nombre de la tabla */
$table = "inventario";

$campo = isset($_POST['campo']) ? $conexion->real_escape_string($_POST['campo']) : null;


/* Filtrado */
$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}


/* Consulta */
$sql = "SELECT " . implode(", ", $columns) . "
FROM $table
$where ORDER BY num_producto DESC LIMIT 20";
$resultado = $conexion->query($sql);
$num_rows = $resultado->num_rows;


/* Mostrado resultados */
$html = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<a href="producto.php?url=' . $row['num_producto'] . '" class="bg-gray-200 hover:bg-gray-100 rounded-xl p-4">        
                  <img class="w-full h-60 object-cover rounded-xl" src="data:' . $row['tipo_imagen'] . ';base64,' . base64_encode($row['imagen'])  . '" />

                    <h3 class="text-lg my-4 font-medium text-gray-700 truncate">
                            ' . $row['nombre'] . '
                    </h3>
                    <div class="flex justify-between w-full">
                        <div class="bg-white px-3 py-2 rounded-xl">
                            $' . $row['precio_venta'] . '
                        </div>
                        <div class="bg-white px-3 py-2 rounded-xl">
                            ' . $row['existencia'] . ' E.
                        </div>
                        <div class="bg-white px-3 py-2 rounded-xl">
                            ' . $row['codigo_prod'] . '
                        </div>
                    </div>
                  </a>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">No se encontró el producto</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
