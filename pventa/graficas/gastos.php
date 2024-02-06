<!DOCTYPE html>
<html>

<head>
    <title>Mi Tienda</title>
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <script src="librerias/jquery-3.6.3.min.js"></script>
    <script src="librerias/plotly-2.18.2.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel panel-heading">LA FLOR DE USILA "MARGARITA"</div>
                    <div class="panel panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="cargalineal"></div>
                            </div>
                            <div class="col-sm-6">
                                <div id="cargabarras"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script type="text/javascript">
    $(document).ready(function(){
    $('#cargalineal').load('gastoslineal.php');
    $('#cargabarras').load('gastosbarras.php');
});
</script>
</div>

        <h1></h1>
            <center>
        <div class="align-content-center mx-auto d-grid gap-2 col-6">
                <a href="graficas.php" type="button" class="btn btn-outline-info my-3 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-backspace" viewBox="0 0 16 16">
                    <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
                    <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-7.08z"/>
                  </svg>  REGRESAR</a>
                </div>
                </center>
        </div>
        </div>