<?php
  $header_title = "Utvärdering";
  $header_description = "Utvärderingar för kurser du gått hos Dansklubben Rockrullarna i Örebro";

  $page_updated = "2024-06-02 12:33";
  $page_url = "/utvardering";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";

  include_once '../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../">Rockrullarna.se</a> / <span>Utvärdering</span>
    </div>

    <h1>Utvärdering</h1>
    <p>Här kan du fylla i våra utvärderingar inom olika områden.</p>
    
    <h2>Danskurser</h2>
    <p>Här kan du fylla i kursutvärderingen för våra dansstilar:</p>
    <ul>
      <li><a href="barndans" title="Kursutvärdering Barndans">Kursutvärdering Barndans</a></li>
      <li><a href="fox" title="Kursutvärdering Fox">Kursutvärdering Fox</a></li>
      <li><a href="bugg" title="Kursutvärdering Bugg">Kursutvärdering Bugg</a></li>
      <li><a href="wcs" title="Kursutvärdering West Coast Swing">Kursutvärdering West Coast Swing</a></li>
    </ul>

    <h2>Utbildningar</h2>
    <ul>
      <li><a href="utbildning" title="Utvärdering för utbildning">Utvärdering för utbildningar</a></li>
    </ul>

    <h2>Socialdanser</h2>
    <ul>
      <li><a href="socialdans" title="Utvärdering Socialdanser">Utvärdering för socialdanser</a></li>
    </ul>

    <br />

    <style>
      ul > li {
        margin-bottom: 1rem;
      }
    </style>

<?php
  include_once '../includes/footer.php'
?>