<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://rockrullarna.se/filer/bilder/Rockrullarna-favicon.png?w=32" rel="shortcut icon" type="image/x-icon">
  <!-- Bootstrap Theme switcher --><script src="https://rockrullarna.se/filer/js/bootstrap-theme-switcher.js"></script>
  <!-- Bootstrap 5 CDN Links --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://rockrullarna.se/filer/css/rockrullarna.css" /> 
  <title><?php if (empty($header_title)) {
    echo "Dansklubben Rockrullarna | Välkommen till vår ideella dansförening i Örebro!";
  } else {
    echo "$header_title | Rockrullarna";
  }?></title>
  <meta name="TITLE" content="<?php if (empty($header_title)) {
    echo "Dansklubben Rockrullarna | Välkommen till vår ideella dansförening i Örebro!";
  } else {
    echo "$header_title | Dansklubben Rockrullarna";
  }?>" />
  <meta name="DESCRIPTION" content="<?php if (empty($header_description)) {
    echo "Dansklubben Rockrullarna, en ideell dansförening i Örebro.";
  } else {
    echo "$header_description | Rockrullarna.se";
  }?>" />
  <meta name="KEYWORDS" content="<?php if (empty($header_keywords)) {
    echo "Dansklubben Rockrullarna, Ideell dansförening i Örebro";
  } else {
    echo "$header_keywords";
  }?>" />
  <meta name="RATING" content="General" />
  <meta property="og:url" content="<?php if (empty($page_url)) {
    echo "https://rockrullarna.se/";
  } else {
    echo "https://rockrullarna.se" . $page_url . "";
  }?>" />
  <meta property="og:title" content="<?php if (empty($header_title)) {
    echo "Dansklubben Rockrullarna | Välkommen till vår ideella dansförening i Örebro!";
  } else {
      echo "$header_title | Dansklubben Rockrullarna";
  }?>" />
  <meta property="og:description" content="<?php if (empty($header_description)) {
    echo "Dansklubben Rockrullarna, en ideell dansförening i Örebro.";
  } else {
    echo "$header_description | Rockrullarna.se";
  }?>" />
  <meta property="og:image" content="<?php if (empty($page_image)) {
    echo "https://rockrullarna.se/filer/bilder/social-startsida-lar-dig-dansa.jpg";
  } else {
    echo "$page_image";
  }?>" />
  <meta property="og:site_name" content="Dansklubben Rockrullarna" />
  <meta property="og:type" content="website" />
  <meta name="creation_date" content="Thu, 29 Dec 2022 21:29:00 GMT" />
  <meta name="LAST-MODIFIED" content="<?php if (empty($page_updated)) {
    echo "Datum saknas";
  } else {
    echo "$page_updated";
  }?>" />
  <meta name="REVISED" content="<?php if (empty($page_updated)) {
    echo "Datum saknas";
  } else {
    echo "$page_updated";
  }?>" />
</head>
<body>
  <a class="SkipToContentLink" href="#ContentStart" accesskey="s">
    Hoppa till sidans innehåll
  </a>
  <header>
    <!-- Bootstrap Icons symbols, from: https://icons.getbootstrap.com/ -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <!-- /*** Theme-switcher icons ***/ -->
      <!-- https://icons.getbootstrap.com/icons/check2 -->
      <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
      </symbol>
      <!-- https://icons.getbootstrap.com/icons/circle-half -->
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
      </symbol>
      <!-- https://icons.getbootstrap.com/icons/moon-stars-fill -->
      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
      </symbol>
      <!-- https://icons.getbootstrap.com/icons/sun-fill -->
      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
      </symbol>
      <!-- /*** Social icons ***/ -->
      <!-- https://icons.getbootstrap.com/icons/facebook -->
      <symbol id="facebook" viewBox="0 0 16 16">
        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
      </symbol>
      <!-- https://icons.getbootstrap.com/icons/instagram -->
      <symbol id="instagram" viewBox="0 0 16 16">
        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
      </symbol>
      <!-- https://icons.getbootstrap.com/icons/tiktok -->
      <symbol id="tiktok" viewBox="0 0 16 16">
        <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
      </symbol>
      <symbol id="envelope-at" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
        <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
      </symbol>
    </svg><!-- ENDING: Bootstrap Icons symbols -->
    <div class="m-5 text-center">
      <a href="https://rockrullarna.se/">
        <picture>
          <source type="image/webp" srcset="https://rockrullarna.se/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.webp" />
          <source type="image/jpeg" srcset="https://rockrullarna.se/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.jpg" />
          <img src="https://rockrullarna.se/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.jpg" alt="Logga för Dansklubben Rockrullarna" class="logo" />
        </picture>
      </a>
    </div>
    <nav class="navbar fixed-top navbar-expand-lg p-0">
      <div class="container-fluid dkrr-navbar-bg">
        <a class="navbar-brand dkrr-logo-link" href="https://rockrullarna.se/">
          <img class="dkrr-logo" alt="Dansklubben Rockrullarna" src="https://rockrullarna.se/filer/bilder/Rockrullarna-SVG-logga.svg" />
        </a>
        <button class="navbar-toggler collapsed" title="Visa menyn" aria-label="Visa menyn" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content">
          <span class="navButton-Line" aria-hidden="true"></span>
          <span class="navButton-Line" aria-hidden="true"></span>
          <span class="navButton-Line" aria-hidden="true"></span>
          Meny
        </button>
        <div class="collapse navbar-collapse" id="navbar-content">
          <ul class="navbar-nav navbar-nav-scroll mx-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="https://rockrullarna.se/Sociala-media">Sociala media</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Danskurser</a>
              <ul class="dropdown-menu shadow">
                <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser">Våra danskurser</a></li>
                <li><hr class="dropdown-divider"></li>
                <li class="dropend">
                  <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Kursöversikt</a>
                  <ul class="dropdown-menu shadow">
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt">Kursöversikten</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Dans-barn-och-ungdom">Barn och ungdom</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Bugg">Bugg</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Fox">Fox</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/West-Coast-Swing">West Coast Swing</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Fritraning">Friträning</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Evenemang">Evenemang</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Privatlektioner">Privatlektioner</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Trivselkvallar">Trivselkvällar</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Kursoversikt/Utbildningar">Utbildningar</a></li>
                  </ul>
                </li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Anmalan-danskurser">Anmälan danskurser</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Avanmalan">Avanmälan</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Danskurser/Betalning">Betalning</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Tävlingsdans</a>
              <ul class="dropdown-menu shadow">
                <li><a class="dropdown-item" href="https://rockrullarna.se/Tavlingsdans">Tävlingsdans</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Tavlingsdans/Kalender">Kalender</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Tavlingsdans/Vilka-tavlar-vart">Vilka tävlar vart?</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Tavlingsdans/Resultat">Resultat</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Tavlingsdans/Dans.se">Dans.se</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Tavlingsdans/Vote4Dance">Vote 4 Dance</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="https://www.danssport.se/taevling/taevlingskalender" title="DSF Tävlingskalender (Öppnas i nytt fönster)" target="_blank" rel="noopener">DSF Tävlingskalender (danssport.se)</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="https://rockrullarna.se/Aktivitetskalender">Aktivitetskalender</a></li>
            <li class="nav-item"><a class="nav-link" href="https://rockrullarna.se/Boka-lilla-salen">Boka lilla salen</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Föreningen</a>
              <ul class="dropdown-menu shadow">
                <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen">Föreningen</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Historia">Historia</a></li>
                <li class="dropstart">
                  <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Styrande dokument</a>
                  <ul class="dropdown-menu shadow">
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Styrande-dokument">Våra styrande dokument</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Styrande-dokument/Verksamhetsbeskrivning">Verksamhetsbeskrivning</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Styrande-dokument/Stadgar">Stadgar</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Styrande-dokument/Blanketter">Blanketter</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Styrande-dokument/Integritetspolicy">Integritetspolicy</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Styrande-dokument/Policy-mot-diskriminering">Policy mot diskriminering</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Styrande-dokument/Arshjul">Årshjul</a></li>
                  </ul>
                </li>
                <li class="dropstart">
                  <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Möten och protokoll</a>
                  <ul class="dropdown-menu shadow">
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Moten-och-protokoll">Möten och protokoll</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Moten-och-protokoll/Arsmote">Årsmöte</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Moten-och-protokoll/Medlemsmote">Medlemsmöte</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Moten-och-protokoll/Styrelsemote">Styrelsemöte</a></li>
                  </ul>
                </li>
                <li class="dropstart">
                  <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Organisation</a>
                  <ul class="dropdown-menu shadow">
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Organisation">Vår organisation</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Organisation/Styrelsen">Styrelsen</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Organisation/Tidigare-styrelser">Tidigare styrelser</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Organisation/Valberedningen">Valberedningen</a></li>
                  </ul>
                </li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Foreningen/Medlemsrabatter">Medlemsrabatter</a></li>
                <li><a class="dropdown-item" href="https://dans.se/shop/?org=rockrullarna&mship" title="Bli medlem hos oss (Öppnas i nytt fönster)" target="_blank" rel="noopener">Bli medlem hos oss (dans.se)</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Kontakta</a>
              <ul class="dropdown-menu shadow">
                <li><a class="dropdown-item" href="https://rockrullarna.se/Kontakt">Kontaktinformation</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="https://www.google.se/maps/place/Rockrullarna+i+%C3%96rebro/@59.2747154,15.1734813,14.12z/data=!4m5!3m4!1s0x465c14d4a35b37db:0x948d71326b2d8b7c!8m2!3d59.2754033!4d15.1647323" title="Hitta till oss (Google maps öppnas i nytt fönster)" target="_blank" rel="noopener">Hitta till oss (Google maps)</a></li>
                <li><hr class="dropdown-divider"></li>
                <li class="dropstart">
                  <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Frågor och Svar</a>
                  <ul class="dropdown-menu shadow">
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Kontakt/Fragor-och-svar">Frågor och Svar</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Kontakt/Fragor-och-svar/Dans.se">Dans.se</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Kontakt/Fragor-och-svar/Teams-mote">Teams-möten</a></li>
                    <li><a class="dropdown-item" href="https://rockrullarna.se/Kontakt/Fragor-och-svar/Zoom-mote">Zoom-möte</a></li>
                  </ul>
                </li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Kontakt/Skicka-arende-eller-fraga">Skicka ärende/fråga</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Webbkarta">Webbkarta</a></li>
                <li><a class="dropdown-item" href="https://rockrullarna.se/Kontakt/Hjalp">Hjälp</a></li>
              </ul>
            </li>
          </ul>
          <form class="d-flex ms-auto">
            <div class="input-group">
              <input id="searchValue" class="form-control border-0 mr-2" type="search" placeholder="Sök på sidan" aria-label="Sök på sidan">
              <button class="btn border-0" type="submit" onclick="searchFunc()">Sök</button>
            </div>
          </form>
          <script>
            function searchFunc() {
              var searchQuery = document.getElementById("searchValue").value;
              var searchUrl = "https://www.bing.com/search?q=site:rockrullarna.se+" + encodeURIComponent(searchQuery);
              window.open(searchUrl, '_blank').focus();
            }
          </script>
        </div>
      </div>
    </nav>
  </header>
  <main id="ContentStart" class="container-md">
