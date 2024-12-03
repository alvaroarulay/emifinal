@extends('layouts.error')
<div class="page-error">
    <h1 class="text-danger"><i class="bi bi-exclamation-circle"></i> Error 419: Sesión Terminada</h1>
    <p>La Página no se abrirá, sino inicias sesión.</p>
    <p><a class="btn btn-primary" href="{{route('login.show')}}">Iniciar Sesión</a></p>
</div>