@extends('layouts.app')

@section('content')
<div class="card container">
  <div class="card-header text-center">
    <p><b>UNIDAD:&nbsp;&nbsp;</b>{{$unidad->unidad}}&nbsp;&nbsp;--&nbsp;&nbsp;{{$unidad->descrip}}</p>
    <h2>OFICINA</h2>
  </div>
  <div class="card-body">

    <div class="row">
      <div class="col-sm-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="">Oficina</span>
          </div>
          <input type="text" class="form-control" id="_oficina" disabled>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="_codofic">Nombre</label>
          </div>
          <select class="form-select" id="_codofic">
            @foreach ($oficinas as $oficina)
              <option value="{{$oficina->codofic}}">{{$oficina->nomofic}}</option>
            @endforeach
          </select>
        </div>
      </div> 
      <div class="col-sm-2">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="_estado" disabled>
        </div>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-primary">Nuevo</button>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="input-group mb-3">
            <span class="input-group-text">Observaciones</span>
            <textarea class="form-control" aria-label="With textarea" id="_observaciones" disabled></textarea>
        </div>
      </div>
    </div>

    <div class="row">
      <table class="table table-responsive ">
        <thead class="table-dark">
          <th>CODIGO</th>
          <th>RESPONSABLE</th>
          <th>CARGO</th>
          <th>C.I.</th>
          <th>EXPEDIDO</th>
          <th>ESTADO</th>
          <th>SELLECIONAR</th>
        </thead>
        <tbody id="_tablaresp">
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
      document.getElementById('_codofic').addEventListener('change',(e)=>{
        fetch('responsables',{
          method : 'POST',
          body : JSON.stringify({id : e.target.value}),
          headers : {
            'Content-Type' : 'application/json',
            "X-CSRF-Token" : csrfToken
          }
        }).then(response =>{
          return response.json()
        }).then(data=>{
          var filas ="";
          for (let i in data.responsables){
            if(data.responsables[i].api_estado==1){
              filas += '<tr><td>'+data.responsables[i].codresp
              +'</td><td>'+data.responsables[i].nomresp
              +'</td><td>'+data.responsables[i].cargo
              +'</td><td>'+data.responsables[i].ci
              +'</td><td>'+data.responsables[i].cod_exp
              +'</td><td>'+'ACTIVO'+'</td>'
              +'<td><div class="form-check"><input class="form-check-input" type="radio" name="_idresponsable" id="_idresponsable" value="'+data.responsables[i].id+'"></div></td></tr>';
            }else{
              filas += '<tr><td>'+data.responsables[i].codresp
              +'</td><td>'+data.responsables[i].nomresp
              +'</td><td>'+data.responsables[i].cargo
              +'</td><td>'+data.responsables[i].ci
              +'</td><td>'+data.responsables[i].cod_exp
              +'</td><td>'+'INACTIVO'+'</td>'
              +'</td><td><div class="form-check"><input class="form-check-input" type="radio" name="_idresponsable" id="_idresponsable" value="'+data.responsables[i].id+'"></div></td></tr>';
            }
          }
          document.getElementById("_tablaresp").innerHTML = filas;
          document.getElementById("_oficina").value = data.oficinas.codofic;
          document.getElementById("_observaciones").value = data.oficinas.observ;
          if(data.oficinas.api_estado==1){
            document.getElementById("_estado").value="ACTIVO";
          }
          else{
            document.getElementById("_estado").value="INACTIVO";
          }
        }).catch(error => console.log(error));
      });
      let checkbox = document.querySelector('input[name="_idresponsable"]');
          checkbox.addEventListener('change', (e) =>{
          if (e.checked) {
            console.log('si');
          } else {
            console.log('no');
          }
        });
    </script>
@stop