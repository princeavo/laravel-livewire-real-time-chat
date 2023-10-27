@extends('authentication.layout')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/auth/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="wrapper" style="background-image: url({{ asset('images/auth/bg-registration-form-3.jpg') }});">
    <div class="inner">
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Registration Form</h3>
            <div class="form-group">
                <div class="form-wrapper">
                    <label for="nom">Nom:</label>
                    <div class="form-holder">
                        <i class="zmdi zmdi-account-o"></i>
                        <input type="text" class="form-control  @error('lastname') is-invalid @enderror " id="nom" name="lastname" required value="{{ old('lastname') }}">
                        @error('lastname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-wrapper">
                    <label for="prenom">Prenom:</label>
                    <div class="form-holder">
                        <i class="zmdi zmdi-account-o"></i>
                        <input type="text" class="form-control  @error('firstname') is-invalid @enderror  " id="prenom" name="firstname" required value="{{ old('firstname') }}">
                        @error('firstname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-wrapper">
                    <label for="contact">Contact(optional):</label>
                    <div class="form-holder">
                        <i class="zmdi zmdi-account-o"></i>
                        <input type="tel" class="form-control  @error('tel') is-invalid @enderror  " id="contact" name="contact" value="{{ old('contact') }}">
                        @error('contact')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-wrapper">
                    <label for="email">Email:</label>
                    <div class="form-holder">
                        <i style="font-style: normal; font-size: 15px;">@</i>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror  " id="email" name="email" required  value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-wrapper" style="position:relative">
                    <label for="password">Password:</label>
                    <div class="form-holder">
                        <i class="zmdi zmdi-lock-outline"></i>
                        <input type="password" class="form-control  @error('password') is-invalid @enderror  "   placeholder="********" id="password" name="password" required >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-wrapper">
                    <label for="password_confirmation">Repeat Password:</label>
                    <div class="form-holder">
                        <i class="zmdi zmdi-lock-outline"></i>
                        <input type="password" class="form-control  @error('password') is-invalid @enderror" placeholder="********" id="password_confirmation" name="password_confirmation" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-wrapper">
                    <label for="country">Country:</label>
                    <div class="form-holder select">
                        <select name="pays_id" id="" class="form-control js-example-basic-single" required value="{{ old('pays_id') }}">
                            @foreach ($pays as $pay)

                            <option value="{{ $pay->id }}">{{ $pay->name }}</option>

                            @endforeach
                        </select>
                        <i class="zmdi zmdi-pin"></i>
                    </div>
                </div>
                <div class="form-wrapper">
                    <label for="gender">Gender:</label>
                    <div class="form-holder select">
                        <select name="genre" id="gender" class="form-control" required  value="{{ old('genre') }}">
                            <option value="man">Male</option>
                            <option value="woman">Female</option>
                        </select>
                        <i class="zmdi zmdi-face"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-wrapper">
                    <label for="date">Date de naissance:</label>
                    <div class="form-holder">
                        <i class="zmdi zmdi-account-o"></i>
                        <input type="date" class="form-control @error('date') is-invalid @enderror " name="date_de_naissance" id="date" required  value="{{ old('date_de_naissance') }}">
                        @error('date_de_naissance')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Default file input example</label>
                        <input class="form-control  @error('profile_photo') is-invalid @enderror" type="file" id="formFile" name="profile_photo" accept="image/*">
                        @error('profile_photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                      </div>
                </div>
            <div class="form-end">
                <div class="checkbox">
                    <label>
                        <input type="checkbox">J'accepte les termes et conditions du site
                        <span class="checkmark"></span>
                    </label>
                    <a href="{{ route('login') }}" class="m-2 btn btn-secondary">Login</a>
                </div>
                <div class="button-holder">
                    <button>Register Now</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/passwordConfirmationRegistration.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
