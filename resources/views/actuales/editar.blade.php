@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-align-justify"></i> Editar Activo</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4"> <strong>Código:&nbsp;&nbsp;{{$actual->codigo}}</strong> </h3></div>
                    <div class="card-body">
                        <form class = "form-control" method="post" action ="/codcont/crear">
                            @csrf
                            <div class="form-group row">
                                <label for="staticText" class="col-sm-2 col-form-label">Código Secundario</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control  mb-3" required name="codsec" value="{{$actual->codigosec}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="staticText" class="col-form-label">Grupo Contable</label>
                                    <div class="row form-group">
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" required name="codcont" disabled value="{{$actual->codcont}}">
                                        </div>
                                        <div class="col-sm-6">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#codcont">Abrir Modal</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                <label for="staticText" class="col-form-label">Auxiliar</label>
                                <div class="row form-group">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" required name="codaux" disabled value="{{$actual->codaux}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="" class="btn btn-primary" role="button" aria-pressed="true"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i>&nbsp;&nbsp;Buscar</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label for="staticText" class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control  mb-3" required name="descripcion" >{{$actual->descripcion}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticText" class="col-sm-2 col-form-label">Observaciones</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control  mb-3" required name="observ" >{{$actual->obser}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticText" class="col-sm-2 col-form-label">Fecha</label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control  mb-3" required name="feult" value="{{$actual->feult}}">
                                </div>
                            </div>
                                <button type="submit" class="btn btn-primary mb-3">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--Inicio del modal agregar/actualizar-->
<div class="modal fade" id="codcont" tabindex="-1" aria-labelledby="codcont" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="codcont">Código Contable</h5>
      </div>
      <div class="modal-body">
    <input type="text" id = "buscar">
<div class="card mb-4 container">
  <div class="card-body">
    <table class="table table-striped table-hover table-sm" id="datatablesSimple">
        <thead>
          <tr>
            <th>#</th>
            <th>CÓDIGO</th>
            <th>GRUPO CONTABLE</th>
        </tr>
      </thead>
      <tbody>
    @foreach ($codigocontable as $codigo)
        <tr>
            <td scope="row"><input class="form-control" type="checkbox" id="cbox1" value="first_checkbox" /></td>
            <td scope="row">{{$codigo->codcont}}</td>
            <td scope="row">{{$codigo->nombre }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Seleccionar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin del modal-->
</main>
@endsection
@section('scripts')
<script>
    var codigo_contable = document.getElementById('codcont');
    var codigo_auxiliar = document.getElementById('codaux');
    var buscar = document.getElementById('buscar')

codigo_contable.addEventListener('shown.bs.modal', ()=>{buscar.focus()})
</script>
@endsection