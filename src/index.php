<?php
  $header_title = "";
  $header_description = "";

  $page_updated = "2022-12-30 02:10";
  $page_url = "";
  $page_contact_name = "";
  $page_contact_email = "";

  include_once 'includes/header.php'
?>
    <h1>Dansklubben Rockrullarna</h1>
    <p>Välkommen till dansglädjen hos vår ideella dansförening i Örebro! Våra primära dansstilar är Bugg, Fox och West Coast Swing.</p>
    <p>Klubben är för dig som medlem. Vi som dansar här ställer upp ideellt och lär varandra.</p>
    <div class="row">
    <section id="start-activity" class="col-12 col-lg-6">
        <h2 class="text-center">Kommande aktiviteter</h2>
        <p>
          Här hittar du våra kommande aktiviteter från <a href="/Aktivitetskalender">Aktivitetskalendern</a>. 
        </p>
        <p>
          Vill du anmäla dig till någon av våra aktiviteter eller kurser, kan du göra detta via sidan: 
          <strong>
            <a href="/Danskurser/Anmalan-danskurser" title="Anmälan till Rockrullarnas danskurser och aktiviteter">Anmälan till danskurser</a>
          </strong>
        </p>
        <p>
          <iframe frameborder="0" height="500" scrolling="yes" src="https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1" style="border-width: 0; width: 98%; min-width: 320px;"></iframe>
        </p>
      </section>
      <section id="start-news" class="col-12 col-lg-6 text-center">
        <h2>Nyheter</h2>
        <p class="mb-5">
          Senaste nytt hittar du på <a href="/Sociala-media">Sociala media-sidan</a>.
        </p>
        <h3>Facebook</h3>
        <p>
          <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Frockrullarna&tabs=timeline&width=450&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=702771861196793" width="450" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
        </p>
      </section>
    </div>
<?php
  include_once 'includes/footer.php'
?>