<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chargement - DataCenter Management</title>
     <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a237e 0%, #311b92 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .loading-container {
            text-align: center;
            max-width: 500px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }
        
        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid rgba(255, 255, 255, 0.3);
            border-top: 6px solid #00e5ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 30px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        h1 {
            margin-bottom: 20px;
            font-weight: 300;
        }
        
        p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }
        
        .countdown {
            font-size: 1.2em;
            margin-top: 20px;
            color: #00e5ff;
        }
    </style>
</head>
<body>

<div class="background-image"></div>

<div class="loading-container">
  <div class="loading-content">
    <h2>Connexion en cours</h2>
    
    <!-- Animated server racks -->
    <div class="server-loader">
      <div class="server-rack">
        <div class="server server-1"></div>
        <div class="server server-2"></div>
        <div class="server server-3"></div>
      </div>
    </div>

    <!-- Loading bars -->
    <div class="loading-bars">
      <div class="bar bar-1"></div>
      <div class="bar bar-2"></div>
      <div class="bar bar-3"></div>
    </div>

    <!-- Loading text -->
    <div class="loading-text">
      <span>Authentification</span>
      <div class="dots">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </div>

    <p class="loading-message">Veuillez patienter...</p>
  </div>
</div>

</body>
</html>