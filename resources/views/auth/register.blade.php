<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - DataCenter Management</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="background-image"></div>

<div class="login-container register-container">
    <form class="login-form" method="POST" action="{{ route('register.post') }}">
        @csrf

        <h2>Créer un compte</h2>

        <div class="input-group">
            <input type="text" id="fullname" name="name" required>
            <label for="fullname">Nom complet</label>
        </div>

        <div class="input-group">
            <input type="email" id="email" name="email" required>
            <label for="email">Email institutionnel</label>
        </div>

        <div class="input-group">
            <input type="text" id="dep" name="department" required>
            <label for="dep">Département</label>
        </div>

        <div class="input-group">
            <input type="password" id="password" name="password" required>
            <label for="password">Mot de passe</label>
        </div>

        <div class="input-group">
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <label for="password_confirmation">Confirmer le mot de passe</label>
        </div>

        <button type="submit" class="btn-login">Envoyer la demande</button>

        <div class="footer-links">
            <span>
                Déjà membre ?
                <a href="{{ route('login') }}">Se connecter</a>
            </span>
        </div>
    </form>
</div>

</body>
</html>
