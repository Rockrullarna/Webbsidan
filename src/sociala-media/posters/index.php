<?php
  $header_title = "Sociala media - posters";
  $header_description = "Här finner du posters och bilder som du kan använda i sociala media för att sprida information om våra kurser! Välkommen med din anmälan";

  $page_updated = "2026-05-26 23:20";
  $page_url = "/sociala-media/posters";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";

  include_once '../../includes/header.php'
?>
  <style>
    /* Själva rutnätet */
    .posters-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 24px;
      padding: 20px 0;
    }

    /* Design av varje enskilt kort (länk) */
    .posters-grid a {
      display: flex;
      flex-direction: column;
      background-color: #0b131a; /* Mörk bakgrund som matchar er hemsida */
      border: 1px solid #1a2633;
      border-radius: 8px;
      padding: 20px;
      text-decoration: none;
      color: #ffffff;
      transition: all 0.2s ease-in-out;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    /* Hover-effekt när man för muspekaren över ett kort */
    .posters-grid a:hover {
      transform: translateY(-4px);
      border-color: #00ABD6; /* Rockrullarna-blå lyser upp vid hover */
      box-shadow: 0 8px 16px rgba(0, 171, 214, 0.2);
    }

    /* Rubriken i kortet (Första p-taggen) */
    .posters-grid a p:first-of-type {
      font-weight: bold;
      font-size: 16px;
      color: #00ABD6; /* Blå rubrik för att sticka ut */
      margin: 0 0 10px 0;
      line-height: 1.4;
    }

    /* Beskrivningen i kortet (Andra p-taggen) */
    .posters-grid a p:last-of-type {
      font-size: 14px;
      color: #b3c0cc; /* Lite mer dämpad text för brödtexten */
      margin: 0;
      line-height: 1.5;
      flex-grow: 1; /* Gör att texten fyller ut så alla knappar/kort blir lika höga */
    }
  </style>


  <div class="rr-page-shell rr-courses-page">
    <div id="BreadCrumbsDiv">
      <a href="../../">Rockrullarna.se</a> / <a href="../">Sociala media</a> / <span>Posters</span>
    </div>
    <h1>Sociala media - posters</h1>
    <p>Här hittar du posters och bilder som du kan använda i sociala media för att sprida information om våra kurser. Klicka på bilden för att ladda ner den i högupplöst format.</p>
    <div class="posters-grid">
      <a href="./poster-mall-1.html" target="_blank">
        <h2>HTML - Poster mall 1 - 🎨 Förslag på digital plansch</h2>
        <p>Här är en skiss på hur ni kan bygga planschen. Den Rockrullare-blå färgen (#00ABD6) används som en stark, kontrasterande bakgrund för att dra blicken till sig.</p>
      </a>
      <a href="./poster-mall-2.html" target="_blank">
        <h2>HTML - Poster mall 2 - Dansmara / Socialdans (Sommarfest / Fika & Dans)</h2>
        <p>Den här är perfekt för era vanliga socialdanskvällar, sommaravslutningar eller trivseldanser.</p>
      </a>
      <a href="./poster-mall-3.html" target="_blank">
        <h2>HTML - Poster mall 3 - Kursstart (Höstterminen / Prova-på)</h2>
        <p>Den här är mer säljande och fokuserar på att locka nya deltagare till kurserna, med en tydlig uppmaning att boka sin plats.</p>
      </a>
      <a href="./poster-mall-4.html" target="_blank">
        <h2>HTML - Poster mall 4 - "Inverterad" Stil (För t.ex. Medlemsmöte eller Årsmöte)</h2>
        <p>Den här använder vit bakgrund med cyanblå text och detaljer istället. Det ger ett lite mer formellt men fortfarande modernt intryck – bra om ni vill att just denna poster ska sticka ut från de vanliga danseventen.</p>
      </a>
      <a href="./poster-mall-5.html" target="_blank">
        <h2>HTML - Poster mall 5 - Nygammal (Modern Neon) – Allmänt event/Marknadsafton</h2>
        <p>Detta förslag tar din ursprungliga idé för Marknadsafton men uppdaterar den till ett mörkare, mer neon-inspirerat tema med en bild som sätter stämningen direkt.</p>
      </a>
      <a href="./poster-mall-6.html" target="_blank">
        <h2>HTML - Poster mall 6 - "Danspuls" – Socialdans/Klubbkväll</h2>
        <p>Här används loggan som en central punkt och bilden integreras med en tonad övergång för en mer dynamisk och "klubbig" känsla. Perfekt för fredagsdanser eller liknande.</p>
      </a>
      <a href="./poster-mall-7.html" target="_blank">
        <h2>HTML - Poster mall 7 - "Upptäck" – Kursstart/Höstterminen</h2>
        <p>En renare och mer informativ design som använder en ljusare bild av en dansare för att skapa kontrast mot den svarta bakgrunden. Perfekt för att fånga uppmärksamheten och tydligt kommunicera information.</p>
      </a>
      <a href="./poster-mall-8.html" target="_blank">
        <h2>HTML - Poster mall 8 - "Foxkväll" – Socialdans/Klubbkväll</h2>
        <p>Här används loggan som en central punkt och bilden integreras med en tonad övergång för en mer dynamisk och "klubbig" känsla. Perfekt för fredagsdanser eller liknande.</p>
      </a>
      <a href="./poster-mall-9.html" target="_blank">
        <h2>HTML - Poster mall 9 - "Neon Pulse" – För en modern och kaxig klubbkänsla</h2>
        <p>Här flyttar vi loggan till mitten, lägger en mjukare toning över bilden och använder en textskugga som ger en svag neoneffekt i Rockrullarnas blå färg. Det ger ett mer "klubbigt" och modernt intryck.</p>
      </a>
      <a href="./poster-mall-10.html" target="_blank">
        <h2>HTML - Poster mall 10 - "Rhythm Split" – För kursstarter och tydlig information</h2>
        <p>Den här varianten delar upp postern i en bilddel och en informationsdel med en diagonal skärning. Loggan placeras i informationsdelen. Detta är perfekt när man vill ha mycket och tydlig information (som t.ex. en hel kursstart) utan att den krockar med bilden.</p>
      </a>
    </div>
  </div>
<?php
  include_once '../../includes/footer.php'
?>