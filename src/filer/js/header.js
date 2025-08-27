/* Header-related client logic: nav highlighting, search form, misc progressive enhancements */
(function(){
  'use strict';

  function highlightActiveNav(){
    const currentPath = location.pathname.replace(/\/$/, '');
    document.querySelectorAll('.navbar-nav .nav-link').forEach(a => {
      const href = a.getAttribute('href');
      if (!href) return;
      const normalized = href.replace(/https?:\/\/[^/]+/,'').replace(/\/$/,'');
      if (normalized && normalized === currentPath) {
        a.setAttribute('aria-current','page');
        a.classList.add('active');
      }
    });
  }

  function wireSearch(){
    const input = document.getElementById('searchValue');
    if(!input) return;
    const form = input.closest('form');
    if(!form) return;
    form.addEventListener('submit', function(e){
      e.preventDefault();
      const searchQuery = input.value.trim();
      if(!searchQuery) return;
      const url = 'https://www.bing.com/search?q=site:rockrullarna.se+' + encodeURIComponent(searchQuery);
      window.open(url, '_blank', 'noopener');
    });
  }

  document.addEventListener('DOMContentLoaded', function(){
    highlightActiveNav();
    wireSearch();
  });
})();
