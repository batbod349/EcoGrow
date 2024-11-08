// assets/scroll.js
document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('header');
  
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) { // Déclenchement du changement à 50px de défilement
        header.classList.add('scrolled', 'flex-row');
        header.classList.remove('flex-col');
      } else {
        header.classList.remove('scrolled', 'flex-row');
        header.classList.add('flex-col');
      }
    });
  });
  