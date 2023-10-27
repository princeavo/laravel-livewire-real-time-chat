<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/auth/recovery.css') }}">
    <title>Document</title>
</head>
<body>
    <div id="mainContainer">
        <h3>Reset password</h3>
        <p id="firstP">Reset password with Lorem, ipsum dolor.</p>
        <form action="">
            <div id="info">
                Enter your Email and instructions will be sent to you!
            </div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email">
            <button type="submit">Reset</button>
        </form>
        <p id="remembered">
            Remember it? <a href="{{ route('login') }}">Login</a>
        </p>
        <div id="footer">
            &copy; 2023 Chaton. Crafted with &hearts; by Lorem, ipsum dolor.
        </div>
    </div>
</body>
</html>
