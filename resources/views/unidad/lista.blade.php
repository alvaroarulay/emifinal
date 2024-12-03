@extends('layouts.app')

@section('content')
<div class="card text-center container">
  <div class="card-header">
    <h2>ADMINISTRACIÓN UNIDAD ADMINISTRATIVA</h2>
  </div>
  <div class="card-body">
    <form action="{{route('cambiarunidad')}}" method="POST">
    @csrf
    <div class="row">
      <table class="table">
        <thead class="table-dark">
          <th>UNIDAD</th>
          <th>DESCRIPCIÓN</th>
          <th>CIUDAD</th>
          <th>SELECCIONADO</th>
        </thead>
        <tbody >
            @foreach($unidad as $data)
              <tr>
                <td>{{$data->unidad}}</td>
                <td>{{$data->descrip}}</td>
                <td>{{$data->ciudad}}</td>
                <td>
                  @if($data->estado == 1)
                  <input class="form-check-input" type="radio" name="id" value="{{$data->id}}" checked>
                  @else
                  <input class="form-check-input" type="radio" name="id" value="{{$data->id}}">
                  @endif
              </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>

  </div>
  <div class="card-footer text-muted">
   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Nuevo</button>
   <button class="btn btn-primary" type="submit">Seleccionar</button>
  </form>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h1 class="modal-title fs-5" id="exampleModalLabel">UNIDAD ADMINISTRATIVA</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="">
            <div class="input-group mb-3">
              <span class="input-group-text" id="inputGroup-sizing-default">Unidad Administrativa</span>
              <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="inputGroup-sizing-default">Ciudad</span>
              <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
          <div class="input-group">
            <span class="input-group-text">Descripción</span>
            <textarea class="form-control" aria-label="With textarea"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Grabar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('js')
@stop