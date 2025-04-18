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
        <a href="https://www.google.se/maps/place/Dansklubben+Rockrullarna+i+%C3%96rebro/@59.2756333,15.160794,16.44z/data=!4m6!3m5!1s0x465c14d4a35b37db:0x948d71326b2d8b7c!8m2!3d59.2754194!4d15.1647762!16s%2Fg%2F11c76mt8xm" rel="noopener" title="Hitta till: Dansklubben Rockrullarna (Google Maps, öppnas i nytt fönster)" target="_blank">
          Vaktelvägen 2, Haga Centrum<br />
          70348 Örebro
        </a>
      </div>
      <div id="footer-mail" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-center p-0 mt-4">
        KONTAKT<br />
        <svg width="16" height="16" fill="currentColor" class="bi bi-envelope-at"><use href="#envelope-at"></use></svg> 
        E-post: <a href="mailto:info@rockrullarna.se" title="Mejla till: info@rockrullarna.se">info@rockrullarna.se</a>
      </div>
      <div id="footer-social" class="col-12 col-lg-4 col-xl-3 text-center align-self-end p-0 mt-4 mb-3">
        SOCIALT<br />
        <a href="https://fb.me/rockrullarna" rel="noopener" title="Följ oss på Facebook (Facebook, öppnas i nytt fönster)" target="_blank"><svg width="32" height="32" fill="currentColor" class="bi bi-facebook"><use href="#facebook"></use></svg></a>
        <a href="https://www.instagram.com/rockrullarna" rel="noopener" title="Följ oss på Instagram (Instagram, öppnas i nytt fönster)" target="_blank"><svg width="32" height="32" fill="currentColor" class="bi bi-instagram"><use href="#instagram"></use></svg></a>
        <a href="https://www.tiktok.com/@dansklubbrockrullarna" rel="noopener" title="Följ oss på TikTok (TikTok, öppnas i nytt fönster)" target="_blank"><svg width="32" height="32" fill="currentColor" class="bi bi-tiktok"><use href="#tiktok"></use></svg></a>
      </div>
      
      <div id="footer-contact" class="col-12 col-xl-3 text-center align-self-end p-0 mt-4 mb-3">
        &copy; <?php echo date("Y"); ?> - Dansklubben Rockrullarna, 
        <a title="Visa källkoden via GitHub (GitHub öppnas i nytt fönster)" 
            href="https://github.com/Rockrullarna/Webbsidan/tree/main/src/<?php if (empty($page_url)) { echo "/index.php"; } else { echo "$page_url/index.php"; }?>" 
            target="_blank" rel="noopener">
            <?php
              // Läs innehållet från version.txt
              $versionUrl = 'https://rockrullarna.se/version.txt';
              $versionContent = file_get_contents($versionUrl);

              // Kontrollera om läsningen lyckades
              if ($versionContent === false) {
                  echo "Kunde inte utläsa versionsnummer.";
              } else {
                  // Skriv ut innehållet på sidan
                  // echo "Version: " . htmlspecialchars($versionContent);
                  echo "Version: " . $versionContent;
              }
            ?>
        </a><br />
        <a href="https://rockrullarna.se/kontakt" title="Visa sidan med kontaktinformation">Se all kontaktinformation</a>
      </div>
    </div>
    <!-- Bootstrap 5 CDN Links --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </footer>
</body>
</html>
