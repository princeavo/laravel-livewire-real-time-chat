<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/auth/lock-screen.css') }}">
    <title>Document</title>
</head>
<body>
    <div id="mainContainer">
        <h3>Screen lock</h3>
        <div id="info">Enter your password to unlock screen</div>
        <div id="profile">
            {{-- <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt=""> --}}
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(Auth()->user()->profile_photo) }}" alt="">
            <p>
                {{ $user->firstname ." " . $user->lastname }}
            </p>
        </div>
        <form action="{{ route('screen_locked') }}" method="POST">
            @csrf
            <label for="code">Your unlock code</label>
            <input type="password" name="code" id="code" placeholder="Enter your code" >
            @if(session()->has('error'))
                <p style="color: rgb(194, 96, 96)">
                    {{ session('error') }}
                </p>
            @endif
            @error('code')
                <p style="color: rgb(194, 96, 96)">
                    {{ $message}}
                </p>
            @enderror
            <button type="submit" name="lock" >Lock</button>
            <p>Not you? return <a href="{{ route('login') }}">login</a></p>
        </form>
        <div id="footer">
            &copy; 2023 Chaton. Crafted with &hearts; by Lorem, ipsum dolor.
        </div>
    </div>
</body>
</html>
