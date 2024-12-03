@extends('layouts.app')

@section('content')
<main class="app-content">
<blockquote class="blockquote app-title">
  <div>
    <p><b>UNIDAD:&nbsp;&nbsp;</b>{{$unidad->unidad}}&nbsp;&nbsp;--&nbsp;&nbsp;{{$unidad->descrip}}</p>
    <h1>ACTIVOS FIJOS</h1>
  </div>
</blockquote>
<div class="card">
  <div class="card-header">
      
      <a href="{{route('codconts.crear')}}" class="btn btn-secondary" role="button" aria-pressed="true"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i>&nbsp;&nbsp;Agregar</a>
      
      <a href="{{route('actualizar')}}" class="btn btn-success" role="button" aria-pressed="true"><i class="fa-solid fa-rotate" style="color: #ffffff;"></i>&nbsp;&nbsp;Actualizar</a>
  </div>
  <div class="card-body">
    <table class="table table-striped table-hover table-sm" id="datatablesSimple">
        <thead>
          <tr>
            <th>UNIDAD</th>
            <th>CÓDIGO</th>
            <th>GRUPO CONTABLE</th>
            <th>AUXILIAR</th>
            <th>VIDA ÚTIL</th>
            <th>OFICINA</th>
            <th>RESPONSABLE</th>
            <th>DESCRIPCIÓN</th>
            <th>VER</th>
            <th>PDF</th>
            <th>EDITAR</th>
        </tr>
      </thead>
      <tbody>
    @foreach ($actuales as $actual)
        <tr>
            <td scope="row">{{$actual->unidad }}</td>
            <td scope="row">{{$actual->codigo}}</td>
            <td scope="row">{{$actual->nombre }}</td>
            <td scope="row">{{$actual->nomaux}}</td>
            <td scope="row">{{$actual->vidautil }}</td>
            <td scope="row">{{$actual->nomofic}}</td>
            <td scope="row">{{$actual->nomresp }}</td>
            <td scope="row">{{$actual->descripcion}}</td>
            <td scope="row"><a href="/actuales/ver/{{$actual->id}}" class="text-center btn btn-success"><i class="fa fa-eye" ></i></a></td>
            <td scope="row"><a href="/actuales/imprimir/{{$actual->id}}" class="text-center btn btn-danger"><i class="fa fa-file-pdf-o"></i></a></td>
            <td scope="row"><a href="/actuales/editar/{{$actual->id}}" class="text-center btn btn-warning"><i class="fa fa-pencil-square-o"></i></a></td>
    </tr>
    @endforeach
    </tbody>
    </table>
</div>
</div>
</main>
@endsection