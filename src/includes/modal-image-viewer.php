<?php
// Image viewer modal include - place this where you want the modal available
?>
<!-- Image Viewer Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content rr-image-modal-content">
      <button type="button" class="btn-close btn-close-white position-absolute" data-bs-dismiss="modal" aria-label="Stäng" style="z-index: 1050; top: 1rem; right: 1rem;"></button>
      <button type="button" class="rr-image-modal-nav rr-image-modal-nav--prev" aria-label="Föregående bild">
        <span aria-hidden="true">&larr;</span>
      </button>
      <button type="button" class="rr-image-modal-nav rr-image-modal-nav--next" aria-label="Nästa bild">
        <span aria-hidden="true">&rarr;</span>
      </button>
      <div id="imageModalCounter" class="rr-image-modal-counter" aria-live="polite"></div>
      <div class="modal-body rr-image-modal-body">
        <img id="modalImage" src="" alt="Förstorad bild" class="rr-modal-image" />
      </div>
    </div>
  </div>
</div>

<script>
  // Modular image viewer JS - safe to include before or after bootstrap bundle
  const modalThumbButtons = Array.from(
    document.querySelectorAll('.rr-courses-media-thumb-btn[data-bs-target="#imageModal"]')
  );

  let currentImageIndex = -1;
  const modalImage = document.getElementById('modalImage');
  const modalCounter = document.getElementById('imageModalCounter');

  function updateModalCounter() {
    if (!modalCounter) return;

    const totalImages = modalThumbButtons.length;
    if (totalImages === 0 || currentImageIndex < 0) {
      modalCounter.textContent = '';
      return;
    }

    modalCounter.textContent = 'Bild ' + (currentImageIndex + 1) + ' av ' + totalImages;
  }

  function updateModalNavState() {
    const prevBtn = document.querySelector('#imageModal .rr-image-modal-nav--prev');
    const nextBtn = document.querySelector('#imageModal .rr-image-modal-nav--next');
    const hasMultipleImages = modalThumbButtons.length > 1;

    if (prevBtn) prevBtn.hidden = !hasMultipleImages;
    if (nextBtn) nextBtn.hidden = !hasMultipleImages;
  }

  function setModalImageByIndex(nextIndex) {
    if (!modalImage || modalThumbButtons.length === 0) return;

    let normalizedIndex = nextIndex;
    if (normalizedIndex < 0) normalizedIndex = modalThumbButtons.length - 1;
    if (normalizedIndex >= modalThumbButtons.length) normalizedIndex = 0;

    const button = modalThumbButtons[normalizedIndex];
    const imageUrl = button ? button.getAttribute('data-image-url') : '';

    if (imageUrl) {
      modalImage.src = imageUrl;
      currentImageIndex = normalizedIndex;
      updateModalCounter();
      updateModalNavState();
    }
  }

  modalThumbButtons.forEach((button, index) => {
    button.addEventListener('click', function() {
      setModalImageByIndex(index);
    });
  });

  const imageModalEl = document.getElementById('imageModal');
  if (imageModalEl) {
    const prevBtn = imageModalEl.querySelector('.rr-image-modal-nav--prev');
    const nextBtn = imageModalEl.querySelector('.rr-image-modal-nav--next');

    if (prevBtn) {
      prevBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        setModalImageByIndex(currentImageIndex - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        setModalImageByIndex(currentImageIndex + 1);
      });
    }

    document.addEventListener('keydown', function(e) {
      if (!imageModalEl.classList.contains('show')) return;
      if (modalThumbButtons.length <= 1) return;

      if (e.key === 'ArrowRight') {
        e.preventDefault();
        setModalImageByIndex(currentImageIndex + 1);
      } else if (e.key === 'ArrowLeft') {
        e.preventDefault();
        setModalImageByIndex(currentImageIndex - 1);
      }
    });

    imageModalEl.addEventListener('hidden.bs.modal', function () {
      if (modalImage) modalImage.removeAttribute('src');
      currentImageIndex = -1;
      updateModalCounter();
      updateModalNavState();
    });

    const dismissBtn = document.querySelector('#imageModal [data-bs-dismiss="modal"]');
    if (modalImage) {
      let touchStartX = 0;
      let touchStartY = 0;
      let suppressImageClickClose = false;

      modalImage.addEventListener('click', function(e) {
        e.stopPropagation();
        if (suppressImageClickClose) {
          suppressImageClickClose = false;
          return;
        }
        if (dismissBtn) dismissBtn.click();
      });

      modalImage.addEventListener('touchstart', function(e) {
        const touch = e.changedTouches && e.changedTouches[0];
        if (!touch) return;
        touchStartX = touch.clientX;
        touchStartY = touch.clientY;
      }, { passive: true });

      modalImage.addEventListener('touchend', function(e) {
        const touch = e.changedTouches && e.changedTouches[0];
        if (!touch) return;

        const deltaX = touch.clientX - touchStartX;
        const deltaY = touch.clientY - touchStartY;
        const absX = Math.abs(deltaX);
        const absY = Math.abs(deltaY);

        // Swipe left/right to navigate between all images tied to this modal.
        if (absX >= 60 && absX > absY * 1.2) {
          suppressImageClickClose = true;
          if (deltaX < 0) {
            setModalImageByIndex(currentImageIndex + 1);
          } else {
            setModalImageByIndex(currentImageIndex - 1);
          }
          return;
        }

        // Close on clear vertical swipe (up or down) while ignoring tiny taps/drags.
        if (absY >= 70 && absY > absX * 1.2) {
          suppressImageClickClose = true;
          if (dismissBtn) dismissBtn.click();
        }
      }, { passive: true });
    }

    const modalBody = document.querySelector('.rr-image-modal-body');
    if (modalBody) {
      modalBody.addEventListener('click', function() {
        if (dismissBtn) dismissBtn.click();
      });
    }

    updateModalCounter();
    updateModalNavState();
  }
</script>
