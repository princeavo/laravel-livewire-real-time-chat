<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/auth/logout.css') }}">
    <title>Logout</title>
</head>
<body>
    <div id="mainContainer">
        <div id="top">
            @if(session()->get('profile_photo'))
                <img src="{{ asset('storage/'.session()->get('profile_photo')) }}" alt="" id="userProfileImage">
            @else
                <img src="{{ asset('images/man.png') }}" alt="" id="userProfileImage">
            @endif
            <h3>You are logged out</h3>
            <p id="thanks">Thanks for using </p>
            <p id="nom">Our Chat App.</p>
            <a href="{{ route('login') }}" id="loginLink">Sign in</a>
        </div>
        <div id="footer">
            &copy; 2023 Chat App. We hope you to come back &hearts;.
        </div>
    </div>
</body>
</html>
