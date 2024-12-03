<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content ="{{ csrf_token() }}"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema Activos</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
<body class="sb-nav-fixed">
<div class="container" id="product-section">
  <div class="row">
   <div class="col-md-6">
    <img src="{{ asset('/assets/img/img.png') }}" class="card-img-bottom" alt="imagen de producto">
   </div>
   <div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">CODIGO ACTIVO FIJO: {{$actual->codigo}}</h5>

        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">DETALLE:</h6>
            <p class="card-text">{{$actual->descripcion}}</p>
            <table>
                <tr>
                    <td><b>GRUPO CONTABLE:&nbsp;&nbsp;&nbsp;</b></td>
                    <td>{{$codcont->nombre}}</td>
                </tr>
                <tr><td><b>AUXILIAR:&nbsp;&nbsp;&nbsp;</b></td>
                <td>{{$auxiliar->nomaux}}</td></tr>

                <tr><td><b>COSTO:&nbsp;&nbsp;&nbsp;</b></td>
                <td>{{$actual->costo}}</td></tr>

                <tr><td><b>OFICINA:&nbsp;&nbsp;&nbsp;</b></td>
                <td>{{$oficina->nomofic}}</td></tr>

                <tr><td><b>RESPONSABLE:&nbsp;&nbsp;&nbsp;</b></td>
                <td>{{$responsable->nomresp}}</td></tr>
            </table>
        </div>
        </div>
   </div>
  </div><!-- end row -->
 </div><!-- end container -->
 </body>
</html>