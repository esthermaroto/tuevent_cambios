// Cargar header y footer comunes en todas las páginas
document.addEventListener('DOMContentLoaded', function () {
    // Función para cargar un archivo HTML (compatible con file:// y http://)
    function loadHTML(elementId, filePath) {
        // Intentar primero con fetch (funciona con http/https)
        fetch(filePath)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(html => {
                const element = document.getElementById(elementId);
                if (element) {
                    element.innerHTML = html;
                    console.log(`✓ Loaded ${elementId} from ${filePath}`);

                    // Reinicializar navegación después de cargar el header
                    if (elementId === 'common-header') {
                        initNavigation();
                    }
                }
            })
            .catch(error => {
                console.warn(`Fetch failed for ${filePath}, trying XMLHttpRequest...`, error);
                // Fallback: usar XMLHttpRequest (funciona mejor con file://)
                const xhr = new XMLHttpRequest();
                xhr.open('GET', filePath, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 0 || xhr.status === 200) {
                            const element = document.getElementById(elementId);
                            if (element) {
                                element.innerHTML = xhr.responseText;
                                console.log(`✓ Loaded ${elementId} from ${filePath} (via XMLHttpRequest)`);

                                if (elementId === 'common-header') {
                                    initNavigation();
                                }
                            }
                        } else {
                            console.error(`Error loading ${filePath}: HTTP ${xhr.status}`);
                        }
                    }
                };
                xhr.send();
            });
    }

    // Función para inicializar la navegación
    function initNavigation() {
        // Mobile menu toggle
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mainNav = document.querySelector('.main-navigation');

        if (mobileToggle && mainNav) {
            mobileToggle.addEventListener('click', function () {
                this.classList.toggle('active');
                mainNav.classList.toggle('active');
            });
        }

        // Submenu toggle en móvil
        const hasSubmenu = document.querySelectorAll('.has-submenu');
        hasSubmenu.forEach(item => {
            const link = item.querySelector('a');
            if (link && window.innerWidth <= 768) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    item.classList.toggle('active');
                });
            }
        });

        // Marcar el elemento activo del menú según la página actual
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        const navLinks = document.querySelectorAll('.nav-menu a');
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'index.html')) {
                link.classList.add('active');
            }
        });

        // Cerrar menú móvil al hacer clic en un enlace
        const navMenuLinks = document.querySelectorAll('.nav-menu a');
        navMenuLinks.forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 768 && !this.parentElement.classList.contains('has-submenu')) {
                    if (mobileToggle) mobileToggle.classList.remove('active');
                    if (mainNav) mainNav.classList.remove('active');
                }
            });
        });
    }

    // Usar rutas relativas simples - se resuelven desde la ubicación del archivo HTML actual
    const headerPath = 'includes/header.html';
    const footerPath = 'includes/footer.html';

    // Verificar que los elementos existen antes de cargar
    const headerElement = document.getElementById('common-header');
    const footerElement = document.getElementById('common-footer');

    if (headerElement) {
        loadHTML('common-header', headerPath);
    } else {
        console.error('Element #common-header not found in DOM');
    }

    if (footerElement) {
        loadHTML('common-footer', footerPath);
    } else {
        console.error('Element #common-footer not found in DOM');
    }
});
