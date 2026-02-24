/**
 * Lightbox for Tuevent
 * Handles image enlargement for gallery images
 */
document.addEventListener('DOMContentLoaded', function () {
    // 1. Create Modal HTML if it doesn't exist
    if (!document.getElementById('lightbox-modal')) {
        const modal = document.createElement('div');
        modal.id = 'lightbox-modal';
        modal.className = 'lightbox-modal';
        modal.innerHTML = `
            <span class="lightbox-close">&times;</span>
            <img class="lightbox-content" id="lightbox-img">
        `;
        document.body.appendChild(modal);
    }

    const modal = document.getElementById('lightbox-modal');
    const lightboxImg = document.getElementById('lightbox-img');
    const closeBtn = document.querySelector('.lightbox-close');

    // 2. Click event for gallery images (and hero slides if they look like images)
    const galleryItems = document.querySelectorAll('.gallery-images img, .gallery-item-div');

    galleryItems.forEach(item => {
        item.addEventListener('click', function () {
            let src = '';

            if (this.tagName === 'IMG') {
                src = this.src;
            } else {
                // For gallery-item-div, get image from background-image
                const bg = window.getComputedStyle(this).backgroundImage;
                src = bg.replace(/url\(['"]?(.*?)['"]?\)/i, '$1');
            }

            if (src && src !== 'none') {
                lightboxImg.src = src;
                modal.classList.add('active');
                document.body.classList.add('modal-open');
            }
        });
    });

    // 3. Close Modal Events
    const closeModal = () => {
        modal.classList.remove('active');
        document.body.classList.remove('modal-open');
        // Clear src after transition to avoid flicker next time
        setTimeout(() => { if (!modal.classList.contains('active')) lightboxImg.src = ''; }, 300);
    };

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    // ESC key close
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
