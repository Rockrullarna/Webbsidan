  </main>
  <footer class="container-md">
    <hr />
    <div class="row mb-5">
      <div id="footer-page-updated" class="col-6">
        UPPDATERAD: 
        <?php if (isset($page_updated)) { 
          echo "$page_updated";
        } else {
          echo "Datum saknas";
        }?>
      </div>
      <div id="footer-page-contact" class="col-6 text-end">
        <?php if (empty($page_contact_email)) { 
          echo "<a href=\"mailto:info@rockrullarna.se\" title=\"Mejla till: info@rockrullarna.se\">Info, Rockrullarna</a>";
        } else {
          echo "<a href=\"mailto:$page_contact_email\" title=\"Mejla till: $page_contact_email\">$page_contact_name, Rockrullarna</a>";
        }?>
      </div>
    </div>
    <div class="row mt-5">
      <div id="footer-adress" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-center p-0 mt-3">
        BESÖKSADRESS:<br />
        Vaktelvägen 2, Haga Centrum<br />
        70348 Örebro
      </div>
      <div id="footer-mail" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-center p-0 mt-3">
        KONTAKT:<br />
        E-post: <a href="mailto:info@rockrullarna.se" title="Mejla till: info@rockrullarna.se">info@rockrullarna.se</a><br />
        Messenger: <a href="https://m.me/rockrullarna">m.me/rockrullarna</a>
      </div>
      <div id="footer-contact" class="col-lg-4 col-xl-3 text-center align-self-end p-0 mt-3">
        <a href="/Kontakt">Se all kontaktinformation</a>
      </div>
      <div id="footer-social" class="col-12 col-lg-4 col-xl-3 text-center align-self-end p-0 mt-3">
        <a href="/Kontakt">Se all kontaktinformation</a>
      </div>
    </div>
    <!-- Bootstrap 5 CDN Links --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </footer>
</body>
</html>