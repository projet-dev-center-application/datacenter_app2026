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

        {{-- Affichage des erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="input-group">
            <input type="text" id="fullname" name="name" value="{{ old('name') }}" required>
            <label for="fullname">Nom complet</label>
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            <label for="email">Email institutionnel</label>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <input type="text" id="dep" name="departement" value="{{ old('departement') }}" required>
            <label for="dep">Département</label>
            @error('departement')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <input type="password" id="password" name="password" required>
            <label for="password">Mot de passe</label>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
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
