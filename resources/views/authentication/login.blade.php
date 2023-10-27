@extends('authentication.layout')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/auth/style.css') }}">

@endsection

@section('content')

<div class="wrapper" style="background-image: url({{ asset('images/auth/bg-registration-form-3.jpg') }});">
    <div class="inner">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h3>Login form</h3>
            <div class="form-group">
                <div class="form-wrapper">
                    <label for="email">Email:</label>
                    <div class="form-holder">
                        <i style="font-style: normal; font-size: 15px;">@</i>
                        <input type="email" class="form-control @error("email") is-invalid @enderror" id="email" name="email" required>
                    </div>
                    @error("email")
                    <div class="invalid-feedback" style="display: inline-flex">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-wrapper">
                    <label for="password">Password</label>
                    <div class="form-holder">
                        <i class="zmdi zmdi-account-o"></i>
                        <input type="password" class="form-control @error("password") is-invalid @enderror" id="password" name="password" required>
                    </div>
                    @error("password")
                    <div class="invalid-feedback" style="display: inline-flex">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-end">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" checked name="remember">Se souvenir de moi
                        <span class="checkmark"></span>
                    </label>
                    <div class="mt-2 d-flex" style="align-items: center;justify-content: center;flex-direction: row">
                        <a href="{{ route('password.request') }}" class="p-1 m-2 btn btn-outline-primary">Mot de passe oublié?</a>
                        <a href="{{ route("register") }}" class="m-2 btn btn-secondary">S'inscrire </a>
                    </div>
                </div>
                <div class="button-holder">
                    <button type="submit">Se connecter</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
