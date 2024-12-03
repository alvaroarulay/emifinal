@extends('layouts.app')

@section('content')
<main class="app-content">
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
</main>
@endsection