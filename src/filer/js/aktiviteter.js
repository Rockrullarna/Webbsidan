// Hämtar aktiviteter server-renderade (embedding via data-endpoint) eller via AJAX fallback
(async function() {
  const container = document.getElementById('aktiviteter-lista');
  if (!container) return;
  if (container.dataset.loaded === '1') return;

  // Om servern redan renderat innehåll (SSR) så hoppa
  if (container.children.length > 0 && container.children[0].classList && !container.children[0].classList.contains('loading')) {
    container.dataset.loaded = '1';
    return;
  }

  try {
    const resp = await fetch('/proxy/aktiviteter.php');
    if (!resp.ok) throw new Error('Status ' + resp.status);
    const html = await resp.text();
    container.innerHTML = html;
    container.dataset.loaded = '1';
  } catch (e) {
    container.innerHTML = '<div class="alert alert-warning" role="status">Kunde inte hämta aktiviteter just nu. Försök igen senare eller se <a href="https://dans.se/rockrullarna">dans.se</a>.</div>';
  }
})();
