<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - Datacenter Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="background-image"></div>

<div class="login-container">
    <form class="login-form" method="POST" action="{{ route('login.post') }}">
        @csrf

        <h2>Bienvenue !</h2>
        <p>Veuillez vous connecter à votre compte !</p>

        <div class="input-group">
            <input type="email" id="email" name="email" required>
            <label for="email">Email</label>
        </div>

        <div class="input-group">
            <input type="password" id="password" name="password" required>
            <label for="password">Mot de passe</label>
        </div>

        <div class="options">
            <label>
                <input type="checkbox" name="remember">
                Se Sevenir de moi 
            </label>
            <a href="#">Mot de passe oublié ?</a>
        </div>

        <button type="submit" class="btn-login">S'identifier</button>

        <div class="footer-links">
            <span>
                Pas encore membre ?
                <a href="{{ route('register') }}">Créer un compte</a>
            </span>
        </div>
    </form>
</div>

</body>
</html>
