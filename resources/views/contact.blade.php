<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | DataCore Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .contact-page { padding: 60px 0; background: #f8fafc; min-height: 80vh; }
        .contact-card { 
            max-width: 900px; margin: 0 auto; background: white; 
            border-radius: 20px; display: grid; grid-template-columns: 1fr 1.5fr; 
            overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        }
        
        .contact-sidebar { background: #0f172a; color: white; padding: 40px; }
        .contact-sidebar h2 { color: #3b82f6; margin-bottom: 20px; font-size: 1.8rem; }
        .contact-sidebar p { color: #94a3b8; line-height: 1.6; margin-bottom: 30px; }
        
        .contact-method { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .contact-method i { color: #3b82f6; font-size: 1.2rem; }

        .contact-form-area { padding: 40px; }
        .contact-form-area h3 { margin-bottom: 25px; color: #0f172a; }

        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #1e293b; }
        .input-group input, .input-group textarea { 
            width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 1rem;
        }
        .input-group input:focus, .input-group textarea:focus { 
            border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); 
        }

        .btn-submit { 
            background: #3b82f6; color: white; border: none; padding: 15px 30px; 
            border-radius: 10px; font-weight: 700; width: 100%; cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { background: #2563eb; transform: translateY(-2px); }

        .success-msg { background: #dcfce7; color: #15803d; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: 500; }
    </style>
</head>
<body>

    @include('partials.header')

    <main class="contact-page">
        <div class="container">
            <div class="contact-card">
                <!-- Sidebar d'information -->
                <div class="contact-sidebar">
                    <h2>Contact IT</h2>
                    <p>Une question sur une ressource ou un problème d'accès ? Notre équipe technique vous assiste.</p>
                    
                    <div class="contact-method">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Data Center A, Zone Tech, Paris</span>
                    </div>
                    <div class="contact-method">
                        <i class="fa-solid fa-phone"></i>
                        <span>+33 1 40 00 00 00</span>
                    </div>
                    <div class="contact-method">
                        <i class="fa-solid fa-envelope"></i>
                        <span>support@datacore.local</span>
                    </div>
                </div>

                <!-- Zone du formulaire -->
                <div class="contact-form-area">
                    @if(session('success'))
                        <div class="success-msg">
                            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    <h3>Envoyer un message</h3>
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        
                        @guest
                        <div class="input-group">
                            <label>Votre Email</label>
                            <input type="email" name="email" placeholder="email@institution.fr" required>
                        </div>
                        @endguest

                        <div class="input-group">
                            <label>Sujet</label>
                            <input type="text" name="subject" placeholder="Ex: Problème de connexion VM" required>
                        </div>

                        <div class="input-group">
                            <label>Message</label>
                            <textarea name="message" rows="5" placeholder="Décrivez votre demande en détail..." required></textarea>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-paper-plane"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

</body>
</html>