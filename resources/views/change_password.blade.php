<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/auth/change_password.css') }}">
    <title>Document</title>
</head>
<body>
    <div id="mainContainer">
        <h3>Change password</h3>
        <div id="profile">
            <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="">
            <p>
                AVOHOU Prince
            </p>
        </div>
        <form action="">
            <label for="old_password">Old password</label>
            <input type="password" name="old_password" id="old_password" placeholder="Enter your old password">
            <label for="new_password">New password</label>
            <input type="password" name="password" id="email" placeholder="Enter your new password">
            <label for="new_password_confirmation">Confirm new password</label>
            <input type="password" name="password_confirmation" id="new_password_confirmation" placeholder="Confirm your new password">
            <div id="buttons">
                <button type="submit" name="cancel" id="cancelButton">Cancel</button>
                <button type="submit" name="change">Change</button>
            </div>
        </form>
        <div id="footer">
            &copy; 2023 Chaton. Crafted with &hearts; by Lorem, ipsum dolor.
        </div>
    </div>
</body>
</html>
