  </main>
  <footer class="container-md">
    <hr />
    <div class="row mb-5">
      <div id="footer-page-updated" class="col-6">
        UPPDATERAD: 
        <?php if (empty($page_updated)) { 
          echo "Datum saknas";
        } else {
          echo "$page_updated";
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
      <div id="footer-adress" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-center p-0 mt-4">
        BESÖKSADRESS<br />
        Vaktelvägen 2, Haga Centrum<br />
        70348 Örebro
      </div>
      <div id="footer-mail" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-center p-0 mt-4">
        KONTAKT<br />
        Messenger: <a href="https://m.me/rockrullarna" title="Chatta med oss på Messenger" target="_blank">m.me/rockrullarna</a><br />
        E-post: <a href="mailto:info@rockrullarna.se" title="Mejla till: info@rockrullarna.se">info@rockrullarna.se</a>
      </div>
      <div id="footer-social" class="col-12 col-lg-4 col-xl-3 text-center align-self-end p-0 mt-4 mb-3">
        SOCIALT<br />
        <a href="https://m.me/rockrullarna" alt="Messenger" title="Chatta med oss på Messenger" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-messenger" viewBox="0 0 16 16">
            <path d="M0 7.76C0 3.301 3.493 0 8 0s8 3.301 8 7.76-3.493 7.76-8 7.76c-.81 0-1.586-.107-2.316-.307a.639.639 0 0 0-.427.03l-1.588.702a.64.64 0 0 1-.898-.566l-.044-1.423a.639.639 0 0 0-.215-.456C.956 12.108 0 10.092 0 7.76zm5.546-1.459-2.35 3.728c-.225.358.214.761.551.506l2.525-1.916a.48.48 0 0 1 .578-.002l1.869 1.402a1.2 1.2 0 0 0 1.735-.32l2.35-3.728c.226-.358-.214-.761-.551-.506L9.728 7.381a.48.48 0 0 1-.578.002L7.281 5.98a1.2 1.2 0 0 0-1.735.32z"/>
          </svg></a>
        <a href="https://fb.me/rockrullarna" alt="Facebook" title="Följ oss på Facebook" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
        </svg></a>
        <a href="https://www.instagram.com/rockrullarna" alt="Instagram" title="Följ oss på Instagram" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
          </svg></a>
        <a href="https://www.tiktok.com/@dansklubbrockrullarna" alt="TikTok" title="Följ oss på TikTok" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
            <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
          </svg></a>
      </div>
      <div id="footer-contact" class="col-12 col-xl-3 text-center align-self-end p-0 mt-4 mb-3">
        &copy; <?php echo date("Y"); ?> - Dansklubben Rockrullarna, v12.2.230118<br />
        <a href="/Kontakt" title="Visa sidan med kontaktinformation">Se all kontaktinformation</a>
      </div>
    </div>
    <!-- Bootstrap 5 CDN Links --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </footer>
</body>
</html>