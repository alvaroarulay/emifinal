@extends('layouts.app')

@section('content')
<div class="card container">
  <div class="card-header text-center">
    <p><b>UNIDAD:&nbsp;&nbsp;</b>{{$unidad->unidad}}&nbsp;&nbsp;--&nbsp;&nbsp;{{$unidad->descrip}}</p>
    <h2>Grupo Contable</h2>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-4">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="">Grupo</span>
          </div>
          <input type="text" class="form-control" id="_grupo" disabled>
        </div>
      </div>
      <div class="col-sm-8">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="_codigocontable">Nombre</label>
          </div>
          <select class="form-select" id="_codigocontable">
            @foreach ($codconts as $codcont)
              <option value="{{$codcont->codcont}}">{{$codcont->nombre}}</option>
            @endforeach
          </select>
        </div>
      </div>      
    </div>
    <div class="row">
      <div class="col-sm-4">
      <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" >Vida Util</span>
          </div>
          <input type="text" class="form-control" id="_vidautil" disabled>
        </div>
      </div>
      <div class="col-sm-8">
      <div class="input-group mb-3">
            <span class="input-group-text">Observaciones</span>
            <textarea class="form-control" aria-label="With textarea" id="_observaciones" disabled></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="depreciar" id="_depreciar" disabled>
          <label class="form-check-label" for="_depreciar">
            Depreciar
          </label>
        </div>
      </div>
      <div class="col-sm-6">
      <div class="form-check">
          <input class="form-check-input" type="radio" name="actualizar" id="_actualizar" disabled>
          <label class="form-check-label" for="_actualizar">
            Actualizar
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <table class="table table-responsive ">
        <thead class="table-dark">
          <th>CODIGO CONTABLE</th>
          <th>NOMBRE AUXILIAR</th>
        </thead>
        <tbody id="_tablaaux">
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer text-muted">
   <button class="btn btn-secondary">Nuevo</button>
  </div>
</div>


@endsection
@section('js')
    <script>
      const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
      document.getElementById('_codigocontable').addEventListener('change',(e)=>{
        fetch('auxiliar',{
          method : 'POST',
          body : JSON.stringify({id : e.target.value}),
          headers : {
            'Content-Type' : 'application/json',
            "X-CSRF-Token" : csrfToken
          }
        }).then(response =>{
          return response.json()
        }).then(data=>{
          var opciones ="";
          for (let i in data.auxiliares){
            opciones += '<tr><td>'+data.auxiliares[i].codaux+'</td><td>'+data.auxiliares[i].nomaux+'</td></tr>';
          }
          console.log(data);
          document.getElementById("_tablaaux").innerHTML = opciones;
          document.getElementById("_grupo").value = data.codconts.codcont;
          document.getElementById("_vidautil").value = data.codconts.vidautil;
          document.getElementById("_observaciones").value = data.codconts.observ;
          if(data.codconts.actualizar==1){
            document.getElementById("_actualizar").checked=true;
          }
          else{
            document.getElementById("_actualizar").checked=false;
          }
          if(data.codconts.depreciar == 1){
            document.getElementById("_depreciar").checked=true;
          }
          else{
            document.getElementById("_depreciar").checked=false;
          }
        }).catch(error => console.log(error));
      })
    </script>
@stop