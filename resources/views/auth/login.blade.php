<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Connexion - DataCenter Management</title>
  <link rel="stylesheet" href="/css/login.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <div class="datacenter-logo">DataHub</div>
        <h1>Connexion</h1>
        <p>Gestion Intelligente des Ressources</p>
      </div>

      <form id="loginForm">
        <!-- Email Input -->
        <div class="form-group">
          <label for="email">Adresse Email</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="votre.email@entreprise.com" 
            required
          >
        </div>

        <!-- Password Input -->
        <div class="form-group">
          <label for="password">Mot de Passe</label>
          <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="••••••••" 
            required
          >
        </div>

        <!-- Remember Me -->
        <div class="checkbox-group">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember" style="margin: 0;">Se souvenir de moi</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn">Connexion</button>

        <!-- Forgot Password -->
        <div style="text-align: center; margin-top: 12px;">
          <a href="#" style="color: #a0aace; text-decoration: none; font-size: 13px;">
            Mot de passe oublié ?
          </a>
        </div>
      </form>

      <div class="divider">Pas encore membre ?</div>

      <!-- Sign Up Button -->
      <a href="/register" class="btn btn-secondary" style="display: block; text-align: center; text-decoration: none;">
        Créer un Compte
      </a>

      <div class="auth-footer">
        © 2026 DataHub. Tous droits réservés | 
        <a href="#">Conditions d'utilisation</a> | 
        <a href="#">Politique de confidentialité</a>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      console.log('Login attempt:', { email, password });
      alert('Connexion en cours... (Demo)');
    });
  </script>
</body>
</html>
