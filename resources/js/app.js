// app.js - Ton JavaScript habituel

document.addEventListener('DOMContentLoaded', function() {
    console.log('Data Center Manager chargé !');
    
    // Exemple : Animation simple
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Tu peux ajouter tout ton JS normal ici
});