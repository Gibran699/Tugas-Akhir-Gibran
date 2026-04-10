// Neon Button Splash Effect
document.addEventListener('DOMContentLoaded', function() {
    const neonButtons = document.querySelectorAll('.neon-btn');
    
    neonButtons.forEach(button => {
        button.addEventListener('mouseenter', function(e) {
            createSplash(e, this);
        });
    });
    
    function createSplash(e, button) {
        const splash = document.createElement('span');
        splash.classList.add('splash');
        
        const rect = button.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        splash.style.left = x + 'px';
        splash.style.top = y + 'px';
        
        button.appendChild(splash);
        
        setTimeout(() => {
            splash.remove();
        }, 600);
    }
});
