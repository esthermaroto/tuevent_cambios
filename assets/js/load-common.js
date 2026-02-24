// Cargar header y footer comunes en todas las p&aacute;ginas
document.addEventListener('DOMContentLoaded', function () {
    // Funci&oacute;n para cargar un archivo HTML (compatible con file:// y http://)
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
                    let processedHtml = html;
                    // Ajustar rutas relativas si estamos en un subdirectorio antes de insertar en el DOM
                    if (pathPrefix) {
                        // Reemplazar src y href que no sean absolutos ni ya relativos (../)
                        // Usamos una expresi&oacute;n regular simple para src y href que empiecen por comillas
                        processedHtml = processedHtml.replace(/(src|href)=(["'])(?!(http|mailto|#|\.\.\/))/gi, `$1=$2${pathPrefix}`);
                    }

                    element.innerHTML = processedHtml;
                    console.log(`âœ&ldquo; Loaded ${elementId} from ${filePath}`);

                    // Reinicializar navegaci&oacute;n despu&eacute;s de cargar el header
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
                                console.log(`âœ&ldquo; Loaded ${elementId} from ${filePath} (via XMLHttpRequest)`);

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

    // Funci&oacute;n para inicializar la navegaci&oacute;n
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

        // Submenu toggle en m&oacute;vil
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

        // Marcar el elemento activo del men&uacute; seg&uacute;n la p&aacute;gina actual
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        const navLinks = document.querySelectorAll('.nav-menu a');
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'index.html')) {
                link.classList.add('active');
            }
        });

        // Cerrar men&uacute; m&oacute;vil al hacer clic en un enlace
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

    // Determinar el prefijo de ruta seg&uacute;n la profundidad del directorio actual
    const currentPath = window.location.pathname;
    // Comprobar si estamos en un subdirectorio (admin, portfolio, maintenance o producci&oacute;n)
    const isAdmin = /\/admin\/|\\admin\\/.test(currentPath) || currentPath.includes('admin/');
    const isPortfolio = /\/portfolio\/|\\portfolio\\/.test(currentPath) || currentPath.includes('portfolio/');
    const isMaintenance = /\/maintenance\/|\\maintenance\\/.test(currentPath) || currentPath.includes('maintenance/');
    const isProduccion = /[\\/]producci(\u00f3n|%C3%B3n|on)[\\/]/i.test(currentPath) || /^(producci\u00f3n|produccion)[\\/]/i.test(currentPath);

    const isInSubdir = isAdmin || isPortfolio || isMaintenance || isProduccion;
    const pathPrefix = isInSubdir ? '../' : '';

    const headerPath = pathPrefix + 'includes/header.html';
    const footerPath = pathPrefix + 'includes/footer.html';

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

