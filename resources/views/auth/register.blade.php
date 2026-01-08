<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - DataCenter Management</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/css/login.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <div class="datacenter-logo">DataHub</div>
        <h1>Créer un Compte</h1>
        <p>Accédez aux Ressources du Data Center</p>
      </div>

      <!-- User Type Selection -->
      <div style="margin-bottom: 30px;">
        <label style="display: block; margin-bottom: 16px;">Type de Compte</label>
        
        <div class="signup-types">
          <!-- Guest Option -->
          <div class="signup-type-card">
            <input type="radio" id="type-guest" name="userType" value="guest" checked>
            <div class="type-icon">👁️</div>
            <label for="type-guest" class="type-label">Invité</label>
            <div class="type-description">
              Accès en lecture seule, consultez les ressources disponibles
            </div>
          </div>

          <!-- Professional Option -->
          <div class="signup-type-card">
            <input type="radio" id="type-professional" name="userType" value="professional">
            <div class="type-icon">💼</div>
            <label for="type-professional" class="type-label">Professionnel / Utilisateur Interne</label>
            <div class="type-description">
              Réservez des ressources, suivez vos demandes et recevez des notifications
            </div>
          </div>

          <!-- Technical Manager Option -->
          <div class="signup-type-card">
            <input type="radio" id="type-manager" name="userType" value="manager">
            <div class="type-icon">🔧</div>
            <label for="type-manager" class="type-label">Responsable Technique</label>
            <div class="type-description">
              Gérez les ressources, approuvez les demandes et supervisez les opérations
            </div>
          </div>
        </div>
      </div>

      <!-- Registration Form -->
      <form id="signupForm">
        <!-- Full Name Input -->
        <div class="form-group">
          <label for="fullname">Nom Complet</label>
          <input 
            type="text" 
            id="fullname" 
            name="fullname" 
            placeholder="Jean Dupont" 
            required
          >
        </div>

        <!-- Email Input -->
        <div class="form-group">
          <label for="signup-email">Adresse Email</label>
          <input 
            type="email" 
            id="signup-email" 
            name="email" 
            placeholder="jean.dupont@entreprise.com" 
            required
          >
        </div>

        <!-- Organization (shown for Professional and Manager) -->
        <div class="form-group" id="organization-group">
          <label for="organization">Organisation</label>
          <input 
            type="text" 
            id="organization" 
            name="organization" 
            placeholder="Nom de votre entreprise/université"
          >
        </div>

        <!-- Department (shown for Professional and Manager) -->
        <div class="form-group" id="department-group">
          <label for="department">Département / Service</label>
          <input 
            type="text" 
            id="department" 
            name="department" 
            placeholder="Ex: IT, Recherche, Développement"
          >
        </div>

        <!-- Manager Specific Field -->
        <div class="form-group" id="resources-group" style="display: none;">
          <label for="resources">Ressources à Superviser</label>
          <select id="resources" name="resources" multiple>
            <option value="servers">Serveurs Physiques</option>
            <option value="vms">Machines Virtuelles</option>
            <option value="storage">Stockage</option>
            <option value="network">Équipements Réseau</option>
            <option value="bandwidth">Bande Passante</option>
          </select>
        </div>

        <!-- Password Input -->
        <div class="form-group">
          <label for="signup-password">Mot de Passe</label>
          <input 
            type="password" 
            id="signup-password" 
            name="password" 
            placeholder="••••••••" 
            required
            minlength="8"
          >
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
          <label for="confirm-password">Confirmer le Mot de Passe</label>
          <input 
            type="password" 
            id="confirm-password" 
            name="confirmPassword" 
            placeholder="••••••••" 
            required
            minlength="8"
          >
        </div>

        <!-- Terms & Conditions -->
        <div class="checkbox-group" style="margin-top: 16px; margin-bottom: 16px;">
          <input type="checkbox" id="terms" name="terms" required>
          <label for="terms" style="margin: 0;">
            J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn">Créer un Compte</button>
      </form>

      <div class="divider">Vous avez déjà un compte ?</div>

      <!-- Login Button -->
      <a href="login.html" class="btn btn-secondary" style="display: block; text-align: center; text-decoration: none;">
        Se Connecter
      </a>

      <div class="auth-footer">
        © 2026 DataHub. Tous droits réservés | 
        <a href="#">Conditions d'utilisation</a> | 
        <a href="#">Politique de confidentialité</a>
      </div>
    </div>
  </div>

  <script>
    // Handle user type selection
    const userTypeRadios = document.querySelectorAll('input[name="userType"]');
    const organizationGroup = document.getElementById('organization-group');
    const departmentGroup = document.getElementById('department-group');
    const resourcesGroup = document.getElementById('resources-group');

    function updateFormVisibility() {
      const selectedType = document.querySelector('input[name="userType"]:checked').value;
      
      // Show/hide organization and department for professional and manager
      if (selectedType === 'guest') {
        organizationGroup.style.display = 'none';
        departmentGroup.style.display = 'none';
        resourcesGroup.style.display = 'none';
      } else if (selectedType === 'professional') {
        organizationGroup.style.display = 'flex';
        departmentGroup.style.display = 'flex';
        resourcesGroup.style.display = 'none';
      } else if (selectedType === 'manager') {
        organizationGroup.style.display = 'flex';
        departmentGroup.style.display = 'flex';
        resourcesGroup.style.display = 'flex';
      }
    }

    userTypeRadios.forEach(radio => {
      radio.addEventListener('change', updateFormVisibility);
    });

    // Initialize form visibility
    updateFormVisibility();

    // Handle form submission
    document.getElementById('signupForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const fullname = document.getElementById('fullname').value;
      const email = document.getElementById('signup-email').value;
      const password = document.getElementById('signup-password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      const userType = document.querySelector('input[name="userType"]:checked').value;

      if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas!');
        return;
      }

      console.log('Signup data:', { fullname, email, userType });
      alert('Inscription en cours... (Demo)');
    });
  </script>
</body>
</html>
