<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h4>Hey {{ $user->first_name }}</h4>
    <p>Your account has been created successfully</p>
    <p>
        This is your email: {{ $user->email }}
    </p>
    <p>
        This is your password: Please use the password you put during account creation.
    </p>
    <P>Now you can login and explore barta app</P>

    <p>
        Happy Scrolling
    </p>
</body>

</html>