// Toggle dropstart/dropend on dropdown parents when near viewport edges
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    const EST_MENU_WIDTH = 240; // px - approximate dropdown width to keep in viewport
    const PADDING = 12;

    document.querySelectorAll('.dropdown').forEach(function (dd) {
      if (dd.closest('.rr-footer-copyright')) return;

      const toggle = dd.querySelector('[data-bs-toggle="dropdown"]');
      if (!toggle) return;

      // Before showing, decide if we should open to the left/right
      toggle.addEventListener('show.bs.dropdown', function () {
        dd.classList.remove('dropstart', 'dropend');
        const rect = toggle.getBoundingClientRect();
        const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);

        if (rect.right > vw - (EST_MENU_WIDTH + PADDING)) {
          dd.classList.add('dropstart');
        } else if (rect.left < (EST_MENU_WIDTH + PADDING)) {
          dd.classList.add('dropend');
        }
      });

      // Clean up classes on hide
      dd.addEventListener('hide.bs.dropdown', function () {
        dd.classList.remove('dropstart', 'dropend');
      });
    });
  });
})();
