// Navigation functionality
document.addEventListener('DOMContentLoaded', function() {
    // Navigation dropdown functionality
    const navItems = document.querySelectorAll('.unifiednav__item_has-sub-nav');
    navItems.forEach(item => {
        const submenu = item.querySelector('ul');
        if (submenu) {
            item.addEventListener('mouseenter', function() {
                submenu.style.display = 'block';
            });
            item.addEventListener('mouseleave', function() {
                submenu.style.display = 'none';
            });
        }
    });
    
    // Form submission
    const contactForms = document.querySelectorAll('.contact-form');
    contactForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Gracias por contactarnos. Un miembro de nuestro equipo se pondr&aacute; en contacto lo antes posible.');
            this.reset();
        });
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    
});

