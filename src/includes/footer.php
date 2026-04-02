  </main>
  <footer class="rr-footer">
    <div class="container">
      <div class="row g-4 rr-footer-main">
        <!-- Brand + beskrivning -->
        <div class="col-12 col-md-4">
          <a href="/" class="rr-footer-brand">Dansklubben Rockrullarna</a>
          <p>en ideell dansförening i Örebro</p>
          <small></small>
        </div>
        <!-- Kurser -->
        <div class="col-12 col-sm-6 col-md-2">
          <h5>Kurser</h5>
          <div class="rr-footer-links">
            <a href="/danskurser/kursoversikt/bugg">Bugg</a>
            <a href="/danskurser/kursoversikt/fox">Fox</a>
            <a href="/danskurser/kursoversikt/west-coast-swing">West Coast Swing</a>
            <a href="/danskurser/anmalan-danskurser">Alla kurser</a>
          </div>
        </div>
        <!-- Föreningen -->
        <div class="col-12 col-sm-6 col-md-2">
          <h5>Föreningen</h5>
          <div class="rr-footer-links">
            <a href="/foreningen">Om oss</a>
            <a href="/foreningen/organisation/styrelsen">Styrelsen</a>
            <a href="/foreningen/styrande-dokument">Dokument</a>
            <a href="https://dans.se/shop/?org=rockrullarna&mship" rel="noopener" target="_blank">Bli medlem</a>
          </div>
        </div>
        <!-- Kontakt -->
        <div class="col-12 col-md-4">
          <h5>Kontakt</h5>
          <p>
            <a href="https://www.google.se/maps/place/Dansklubben+Rockrullarna+i+%C3%96rebro/@59.2756333,15.160794,16.44z/data=!4m6!3m5!1s0x465c14d4a35b37db:0x948d71326b2d8b7c!8m2!3d59.2754194!4d15.1647762!16s%2Fg%2F11c76mt8xm" rel="noopener" target="_blank">Vaktelvägen 2, Haga Centrum<br>70348 Örebro</a>
          </p>
          <a href="mailto:info@rockrullarna.se">info@rockrullarna.se</a>
          <div class="rr-footer-social mt-2">
            <a href="https://fb.me/rockrullarna" rel="noopener" target="_blank" title="Följ oss på Facebook">
              <svg width="22" height="22" fill="currentColor"><use href="#facebook"></use></svg>
            </a>
            <a href="https://www.instagram.com/rockrullarna" rel="noopener" target="_blank" title="Följ oss på Instagram">
              <svg width="22" height="22" fill="currentColor"><use href="#instagram"></use></svg>
            </a>
            <a href="https://www.tiktok.com/@dansklubbrockrullarna" rel="noopener" target="_blank" title="Följ oss på TikTok">
              <svg width="22" height="22" fill="currentColor"><use href="#tiktok"></use></svg>
            </a>
          </div>
        </div>
      </div>
      <hr class="rr-footer-divider">
      <div class="row align-items-center g-2 rr-footer-copyright">
        <div class="col-12 col-sm-auto">
          &copy; 1983–<?php echo date("Y"); ?> Dansklubben Rockrullarna
          &nbsp;|&nbsp;
          <a href="/integritetspolicy">Integritetspolicy</a>
          &nbsp;|&nbsp;
          <a href="/kontakt">Kontakt</a>
          &nbsp;|&nbsp;
          <a title="Visa källkoden via GitHub (öppnas i nytt fönster)"
              href="https://github.com/Rockrullarna/Webbsidan/tree/main/src/<?php if (empty($page_url)) { echo "index.php"; } else { echo "$page_url/index.php"; }?>"
              target="_blank" rel="noopener">
            <?php
              $versionUrl = 'https://rockrullarna.se/version.txt';
              $versionContent = file_get_contents($versionUrl);
              echo ($versionContent !== false) ? "Version: " . $versionContent : "Version: –";
            ?>
          </a>
        </div>
        <div class="col-12 col-sm-auto ms-sm-auto">
          <div class="btn-group dropdown">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <svg class="bi my-1 theme-icon-active"><use href="#circle-half"></use></svg>
              <span class="ms-1">Färgtema</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
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
      </div>
    </div>
    <!-- Bootstrap 5 CDN Links --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </footer>
</body>
</html>
