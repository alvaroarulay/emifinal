
@extends('layouts.app')

@section('content')


    <div class="row">
      
        <div class="col-md-6">
            <section class="login-content">
             <div class="card mx-6 login-box">
                <div class="card-body p-4">
                    <form class="login-form" method="POST" action="{{ route('login.perform') }}">
                        @csrf
                        <h3 class="login-head"><i class="bi bi-person me-2"></i>Ingreso al Sistema</h3>
                        <div class="mb-3 input-group" >
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="bi bi-person-square"></i></span>
                            </div>
                            <input id="name" 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    name="username" 
                                    value="{{ old('name') }}" 
                                    required 
                                    autocomplete="name" 
                                    autofocus 
                                    placeholder="Nombre">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 input-group" >
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="bi bi-pass"></i>
                                </span>
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 btn-container d-grid">
                            <button class="btn btn-primary btn-block" type="submit"><i class="bi bi-box-arrow-in-right me-2 fs-5"></i>Acceder</button>
                        </div>
                    </form>
                    
            </div> 
            </div>
           </section> 
        </div>    
        <div class="col-md-6 bg-success position-relative align-items-center">
            <div class="logo position-absolute top-50 start-50 translate-middle">
                <img src="/img/logo.png" alt="" style="width: 300px; ">
                <h2  class="text-center text-white">Escuela Militar de Ingeniería</h2>
                <h3  class="text-center text-white">Módulo de Activos Fijos</h3>
            </div>
        </div>
    </div>
    
   
   

@endsection
