  </main>
  <footer class="container-md">
    <hr />
    <div class="row">
      <div id="footer-page-updated" class="col-6">
        UPPDATERAD: 
        <?php if (empty($page_updated)) { 
          echo "Datum saknas";
        } else {
          echo "$page_updated";
        }?>
      </div>
      <div id="footer-page-contact" class="col-6 mb-2 text-end">
        <?php if (empty($page_contact_email)) { 
          echo "<a href=\"mailto:info@rockrullarna.se\" title=\"Mejla till: info@rockrullarna.se\">Info, Rockrullarna</a>";
        } else {
          echo "<a href=\"mailto:$page_contact_email\" title=\"Mejla till: $page_contact_email\">$page_contact_name, Rockrullarna</a>";
        }?>
      </div>
    </div>
    <div class="row justify-content-end">
      <div class="col-auto btn-group dropdown">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <svg class="bi my-1 theme-icon-active"><use href="#circle-half"></use></svg>
            <span class="ms-2">Växla färgtema</span>
        </button>
        <ul class="dropdown-menu">
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
              <svg class="bi me-2 theme-icon"><use href="#moon-stars-fill"></use></svg>
              Mörkt (standard)
              <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">
              <svg class="bi me-2 theme-icon"><use href="#sun-fill"></use></svg>
              Ljust
              <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
            </button>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center mb-0 active" data-bs-theme-value="auto">
              <svg class="bi me-2 theme-icon"><use href="#circle-half"></use></svg>
              Systeminställning 
              <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
            </button>
          </li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div id="footer-adress" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-center p-0 mt-4">
        BESÖKSADRESS<br />
        Vaktelvägen 2, Haga Centrum<br />
        70348 Örebro
      </div>
      <div id="footer-mail" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-center p-0 mt-4">
        KONTAKT<br />
        Messenger: <a href="https://m.me/rockrullarna" title="Chatta med oss på Messenger" target="_blank" rel="noopener">m.me/rockrullarna</a><br />
        E-post: <a href="mailto:info@rockrullarna.se" title="Mejla till: info@rockrullarna.se">info@rockrullarna.se</a>
      </div>
      <div id="footer-social" class="col-12 col-lg-4 col-xl-3 text-center align-self-end p-0 mt-4 mb-3">
          SOCIALT<br />
          <a href="https://m.me/rockrullarna" rel="noopener" alt="Messenger" title="Chatta med oss på Messenger" target="_blank"><svg width="32" height="32" fill="currentColor" class="bi bi-messenger"><use href="#messenger"></use></svg></a>
          <a href="https://fb.me/rockrullarna" rel="noopener" alt="Facebook" title="Följ oss på Facebook" target="_blank"><svg width="32" height="32" fill="currentColor" class="bi bi-facebook"><use href="#facebook"></use></svg></a>
          <a href="https://www.instagram.com/rockrullarna" rel="noopener" alt="Instagram" title="Följ oss på Instagram" target="_blank"><svg width="32" height="32" fill="currentColor" class="bi bi-instagram"><use href="#instagram"></use></svg></a>
          <a href="https://www.tiktok.com/@dansklubbrockrullarna" rel="noopener" alt="TikTok" title="Följ oss på TikTok" target="_blank"><svg width="32" height="32" fill="currentColor" class="bi bi-tiktok"><use href="#tiktok"></use></svg></a>
        </div>
      <div id="footer-contact" class="col-12 col-xl-3 text-center align-self-end p-0 mt-4 mb-3">
        &copy; <?php echo date("Y"); ?> - Dansklubben Rockrullarna, 
        <a title="Visa källkoden via GitHub" href="https://github.com/Rockrullarna/Webbsidan/tree/v12.5.20230314" target="_blank" rel="noopener">
          v12.5.20230314
        </a><br />
        <a href="/Kontakt" title="Visa sidan med kontaktinformation">Se all kontaktinformation</a>
      </div>
    </div>
    <!-- Bootstrap 5 CDN Links --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </footer>
</body>
</html>