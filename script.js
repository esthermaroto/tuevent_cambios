document.addEventListener('DOMContentLoaded', () => {
    /* --- Hero Text Animation --- */
    const dynamicText = document.querySelector('.dynamic-text');
    const phrases = ["_tu sueño", "_tu inspiración", "_tu realidad"];
    let phraseIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typeSpeed = 100;

    function typeEffect() {
        const currentPhrase = phrases[phraseIndex];

        if (isDeleting) {
            dynamicText.textContent = currentPhrase.substring(0, charIndex--);
            typeSpeed = 50; // Faster deleting
        } else {
            dynamicText.textContent = currentPhrase.substring(0, charIndex++);
            typeSpeed = 150; // Normal typing
        }

        if (!isDeleting && charIndex === currentPhrase.length + 1) {
            isDeleting = true;
            typeSpeed = 2000; // Pause at end
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            phraseIndex = (phraseIndex + 1) % phrases.length;
            typeSpeed = 500; // Pause before new word
        }

        setTimeout(typeEffect, typeSpeed);
    }

    // Start effect
    if (dynamicText) {
        typeEffect();
    }

    /* --- Sticky Header --- */
    const header = document.getElementById('main-header');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    /* --- Mobile Menu Toggle --- */
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.getElementById('main-nav');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', () => {
            // Simple toggle for now, would typically toggle a class like .active
            const ul = nav.querySelector('ul');
            if (ul.style.display === 'flex') {
                ul.style.display = 'none';
            } else {
                ul.style.display = 'flex';
                ul.style.flexDirection = 'column';
                ul.style.position = 'absolute';
                ul.style.top = '100%';
                ul.style.left = '0';
                ul.style.width = '100%';
                ul.style.backgroundColor = '#000';
                ul.style.padding = '20px';
            }
        });
    }
});
