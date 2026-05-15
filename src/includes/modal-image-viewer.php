<?php
// Image viewer modal include - place this where you want the modal available
?>
<!-- Image Viewer Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content rr-image-modal-content">
      <button type="button" class="btn-close btn-close-white position-absolute" data-bs-dismiss="modal" aria-label="Stäng" style="z-index: 1050; top: 1rem; right: 1rem;"></button>
      <div class="modal-body rr-image-modal-body">
        <img id="modalImage" src="" alt="Förstorad bild" class="rr-modal-image" />
      </div>
    </div>
  </div>
</div>

<script>
  // Modular image viewer JS - safe to include before or after bootstrap bundle
  document.querySelectorAll('.rr-courses-media-thumb-btn').forEach(button => {
    button.addEventListener('click', function() {
      const imageUrl = this.getAttribute('data-image-url');
      const img = document.getElementById('modalImage');
      if (img) {
        if (imageUrl) img.src = imageUrl; else img.removeAttribute('src');
      }
    });
  });

  const imageModalEl = document.getElementById('imageModal');
  if (imageModalEl) {
    imageModalEl.addEventListener('hidden.bs.modal', function () {
      const img = document.getElementById('modalImage');
      if (img) img.removeAttribute('src');
    });

    const dismissBtn = document.querySelector('#imageModal [data-bs-dismiss="modal"]');
    const modalImage = document.getElementById('modalImage');
    if (modalImage) {
      modalImage.addEventListener('click', function(e) {
        e.stopPropagation();
        if (dismissBtn) dismissBtn.click();
      });
    }

    const modalBody = document.querySelector('.rr-image-modal-body');
    if (modalBody) {
      modalBody.addEventListener('click', function() {
        if (dismissBtn) dismissBtn.click();
      });
    }
  }
</script>
