@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4"> Nuevo Codigo Contable</h3></div>
                <div class="card-body">

<form class = "form-control" method="post" action ="/codcont/crear">
    @csrf
    <div class="form-group row">
        <label for="staticText" class="col-sm-2 col-form-label">Codigo Contable</label>
        <div class="col-sm-10">
            <input type="number" class="form-control  mb-3" required name="codcont">
        </div>
    </div>
    <div class="form-group row">
        <label for="staticText" class="col-sm-2 col-form-label">Nombre</label>
        <div class="col-sm-10">
            <input type="text" class="form-control  mb-3" required name="nombre">
        </div>
    </div>
    <div class="form-group row">
        <label for="staticText" class="col-sm-2 col-form-label">Vida Util</label>
        <div class="col-sm-10">
            <input type="number" class="form-control  mb-3" required name="vidautil">
        </div>
    </div>
    <div class="form-group row">
        <label for="staticText" class="col-sm-2 col-form-label">Observaciones</label>
        <div class="col-sm-10">
            <input type="text" class="form-control  mb-3" required name="observ">
        </div>
    </div>
    <div class="form-group row">
        <label for="staticText" class="col-sm-2 col-form-label">Fecha</label>
        <div class="col-sm-3">
            <input type="date" class="form-control  mb-3" required name="feult">
        </div>
        <div class="col-sm-3">
            <div class="form-check form-check-inline">
            <input class="form-check-input  mb-3" type="checkbox" id="inlineCheckbox1" value="1" name="depreciar">
            <label class="form-check-label" for="inlineCheckbox1">Depreciar</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-check form-check-inline">
            <input class="form-check-input  mb-3" type="checkbox" id="inlineCheckbox2" value="1" name="actualizar">
            <label class="form-check-label" for="inlineCheckbox2">Actualizar</label>
        </div>
    </div>
    <div class="form-group row">
        <label for="staticText" class="col-sm-2 col-form-label">Usuario</label>
        <div class="col-sm-10">
            <input type="text" class="form-control  mb-3" required name="usuar">
        </div>
    </div>
        <button type="submit" class="btn btn-primary mb-3">Guardar</button>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection