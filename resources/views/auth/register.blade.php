
@extends('layouts.app')

@section('content')
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
    <img src="/img/MiArpro.png" alt="" style="width: 200px; ">
    </div>
    <div class="card mx-4 login-box">
        <div class="card-body p-4">
            <h1>Registrate!</h1>
            <p class="text-muted">Crea tu Cuenta</p>
            <form method="POST" action="{{ route('register.perform') }}">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bi bi-person-square"></i></span>
                    </div>
                    <input id="name" 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            name="name" 
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
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                    </div>
                    <input id="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            placeholder="E-Mail">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-person-plus"></i></span>
                    </div>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Nombre de Usuario">

                    @error('username')
                        <div class="col-lg-4">
                            <div class="bs-component">
                            <p class="text-danger">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
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
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                    <i class="bi bi-pass"></i>
                    </span>
                    </div>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña">
                </div>
                <div class="mb-3 btn-container d-grid">
                    <button class="btn btn-block btn-primary" type="submit">Crear Cuenta</button>
                </div>
            </form>
            <div class="card-footer text-center py-3 mb-3">
                <div class="small"><a href="{{ route('login.perform') }}">Ya tienes una Cuenta? Inicia Sesión</a></div>
            </div>
        </div>
    </div>
</section>
@endsection
