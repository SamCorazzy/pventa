<?php
require_once "../conexion.php";
$sql="SELECT fecha,importe
from gastos order by fecha";
$result=mysqli_query($conexion,$sql);
$valoresY=array();//montos
$valoresX=array();//fechas

while ($ver=mysqli_fetch_row($result)) {
    $valoresY[]=$ver[1];
    $valoresX[]=$ver[0];
}
$datosX=json_encode($valoresX);
$datosY=json_encode($valoresY);
?>

<div id="graficaBarras"></div>
<script type="text/javascript">
function crearCadenaBarras(json) {
    var parsed = JSON.parse(json);
    var arr = [];
    for (var x in parsed) {
        arr.push(parsed[x]);
    }
    return arr;
}
</script>

<script type="text/javascript">
    datosX=crearCadenaBarras('<?php echo $datosX ?>');
    datosY=crearCadenaBarras('<?php echo $datosY ?>');
var data = [{
    x: datosX,
    y: datosY,
    type: 'bar'
}];

var layout = {
    title: 'Grafica Barras',
    font:{
        family: 'Releway, sans-serif'
    },
    xaxis:{
        tickangle: -47,
        title: 'Fechas'
    },
    yaxis: {
        title: '$Importe'
    },
    bargap: 0.05
};

Plotly.newPlot('graficaBarras', data, layout);
</script>