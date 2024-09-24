<!DOCTYPE html>
<html>
<head>
    <title>New Admin Registration</title>
</head>
<body>
<div style="border: 1px solid #ddd;margin: auto;width: 70%;padding: 20px;line-height: 1.2;">
    Hi {{ $name }} <br>,
    <p>Welcome to Thomas Cook</p>
    <p>Your login Credential:</p>
    <p>Username : {{ $username }}</p>
    <p>Password : {{ $password }}</p>
    <p>Please click here to login : <a href="{{ $login_link }}">Login</a></p>

    Warm regards,<br>
    BPC Partner by Thomas Cook
</div>

</body>
</html>
