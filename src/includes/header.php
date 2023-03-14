<!DOCTYPE html>
<html lang="sv" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/filer/bilder/Rockrullarna-favicon.png?w=32" rel="shortcut icon" type="image/x-icon">
  <!-- Bootstrap Theme switcher --><script src="/filer/js/bootstrap-theme-switcher.js"></script>
  <!-- Bootstrap 5 CDN Links --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="/filer/css/rockrullarna.css" /> 
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
  <!-- Icons symbols --><svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
    </symbol>
  </svg><!-- End of Icons symbols -->
  <a class="SkipToContentLink" href="#ContentStart" accesskey="s">
    Hoppa till sidans innehåll
  </a>
  <header>
    <img alt="Logga för Dansklubben Rockrullarna" src="/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.jpg" class="logo" />
    <nav class="navbar navbar-expand-lg ph-3">
      <a class="navbar-brand" href="/" style="width: 4rem;">
        <img alt="Dansklubben Rockrullarna" src="/filer/bilder/Rockrullarna-SVG-logga.svg" />
      </a>
      <button class="navbar-toggler collapsed" title="Visa menyn" aria-label="Visa menyn" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content">
        <span class="navButton-Line" aria-hidden="true"></span>
        <span class="navButton-Line" aria-hidden="true"></span>
        <span class="navButton-Line" aria-hidden="true"></span>
         Meny
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="/Sociala-media">Sociala media</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Danskurser</a>
            <ul class="dropdown-menu shadow">
              <li><a class="dropdown-item" href="/Danskurser">Våra danskurser</a></li>
              <li><hr class="dropdown-divider"></li>
              <li class="dropend">
                <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Kursöversikt</a>
                <ul class="dropdown-menu shadow">
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt">Kursöversikten</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Dans-barn-och-ungdom">Barn och ungdom</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Bugg">Bugg</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Fox">Fox</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/West-Coast-Swing">West Coast Swing</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Fritraning">Friträning</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Evenemang">Evenemang</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Privatlektioner">Privatlektioner</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Trivselkvallar">Trivselkvällar</a></li>
                  <li><a class="dropdown-item" href="/Danskurser/Kursoversikt/Utbildningar">Utbildningar</a></li>
                </ul>
              </li>
              <li><a class="dropdown-item" href="/Danskurser/Anmalan-danskurser">Anmälan danskurser</a></li>
              <li><a class="dropdown-item" href="/Danskurser/Avanmalan">Avanmälan</a></li>
              <li><a class="dropdown-item" href="/Danskurser/Betalning">Betalning</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Tävlingsdans</a>
            <ul class="dropdown-menu shadow">
              <li><a class="dropdown-item" href="/Tavlingsdans">Tävlingsdans</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/Tavlingsdans/Kalender">Kalender</a></li>
              <li><a class="dropdown-item" href="/Tavlingsdans/Vilka-tavlar-vart">Vilka tävlar vart?</a></li>
              <li><a class="dropdown-item" href="/Tavlingsdans/Resultat">Resultat</a></li>
              <li><a class="dropdown-item" href="/Tavlingsdans/Dans.se">Dans.se</a></li>
              <li><a class="dropdown-item" href="/Tavlingsdans/Vote4Dance">Vote 4 Dance</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="https://www.danssport.se/taevling/taevlingskalender" title="DSF Tävlingskalender (Öppnas i nytt fönster)" target="_blank" rel="noopener">DSF Tävlingskalender (danssport.se)</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="/Aktivitetskalender">Aktivitetskalender</a></li>
          <li class="nav-item"><a class="nav-link" href="/Boka-lilla-salen">Boka lilla salen</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Föreningen</a>
            <ul class="dropdown-menu shadow">
              <li><a class="dropdown-item" href="/Foreningen">Föreningen</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/Foreningen/Historia">Historia</a></li>
              <li class="dropstart">
                <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Styrande dokument</a>
                <ul class="dropdown-menu shadow">
                  <li><a class="dropdown-item" href="/Foreningen/Styrande-dokument">Våra styrande dokument</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/Foreningen/Styrande-dokument/Verksamhetsbeskrivning">Verksamhetsbeskrivning</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Styrande-dokument/Stadgar">Stadgar</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Styrande-dokument/Blanketter">Blanketter</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Styrande-dokument/Integritetspolicy">Integritetspolicy</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Styrande-dokument/Policy-mot-diskriminering">Policy mot diskriminering</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Styrande-dokument/Arshjul">Årshjul</a></li>
                </ul>
              </li>
              <li class="dropstart">
                <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Möten och protokoll</a>
                <ul class="dropdown-menu shadow">
                  <li><a class="dropdown-item" href="/Foreningen/Moten-och-protokoll">Möten och protokoll</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/Foreningen/Moten-och-protokoll/Arsmote">Årsmöte</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Moten-och-protokoll/Medlemsmote">Medlemsmöte</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Moten-och-protokoll/Styrelsemote">Styrelsemöte</a></li>
                </ul>
              </li>
              <li class="dropstart">
                <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Organisation</a>
                <ul class="dropdown-menu shadow">
                  <li><a class="dropdown-item" href="/Foreningen/Organisation">Vår organisation</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/Foreningen/Organisation/Styrelsen">Styrelsen</a></li>
                  <li><a class="dropdown-item" href="/Foreningen/Organisation/Tidigare-styrelser">Tidigare styrelser</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/Foreningen/Organisation/Valberedningen">Valberedningen</a></li>
                </ul>
              </li>
              <li><a class="dropdown-item" href="/Foreningen/Medlemsrabatter">Medlemsrabatter</a></li>
              <li><a class="dropdown-item" href="https://dans.se/shop/?org=rockrullarna&mship" title="Bli medlem hos oss (Öppnas i nytt fönster)" target="_blank" rel="noopener">Bli medlem hos oss (dans.se)</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Kontakta</a>
            <ul class="dropdown-menu shadow">
              <li><a class="dropdown-item" href="/Kontakt">Kontaktinformation</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="https://www.google.se/maps/place/Rockrullarna+i+%C3%96rebro/@59.2747154,15.1734813,14.12z/data=!4m5!3m4!1s0x465c14d4a35b37db:0x948d71326b2d8b7c!8m2!3d59.2754033!4d15.1647323" title="Hitta till oss (Google maps öppnas i nytt fönster)" target="_blank" rel="noopener">Hitta till oss (Google maps)</a></li>
              <li><a class="dropdown-item" href="https://m.me/Rockrullarna" title="Chatta med oss (Messenger öppnas i nytt fönster)" target="_blank" rel="noopener">Chatta med oss (Messenger)</a></li>
              <li><hr class="dropdown-divider"></li>
              <li class="dropstart">
                <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Frågor och Svar</a>
                <ul class="dropdown-menu shadow">
                  <li><a class="dropdown-item" href="/Kontakt/Fragor-och-svar">Frågor och Svar</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/Kontakt/Fragor-och-svar/Teams-mote">Teams-möten</a></li>
                  <li><a class="dropdown-item" href="/Kontakt/Fragor-och-svar/Zoom-mote">Zoom-möte</a></li>
                  <li><a class="dropdown-item" href="/Kontakt/Fragor-och-svar/Dans.se">Dans.se</a></li>
                </ul>
              </li>
              <li><a class="dropdown-item" href="/Kontakt/Skicka-arende-eller-fraga">Skicka ärende/fråga</a></li>
              <li><a class="dropdown-item" href="/Webbkarta">Webbkarta</a></li>
              <li><a class="dropdown-item" href="/Kontakt/Hjalp">Hjälp</a></li>
            </ul>
          </li>
        </ul>
        <li class="nav-item dropdown">
          <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
                  id="bd-theme"
                  type="button"
                  aria-expanded="false"
                  data-bs-toggle="dropdown"
                  data-bs-display="static">
            <svg class="bi my-1 theme-icon-active"><use href="#circle-half"></use></svg>
            <span class="d-lg-none ms-2">Växla tema</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme" style="--bs-dropdown-min-width: 8rem;">
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">
                <svg class="bi me-2 opacity-50 theme-icon"><use href="#sun-fill"></use></svg>
                Mörkt
                <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
              </button>
            </li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
                <svg class="bi me-2 opacity-50 theme-icon"><use href="#moon-stars-fill"></use></svg>
                Ljust
                <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
              </button>
            </li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto">
                <svg class="bi me-2 opacity-50 theme-icon"><use href="#circle-half"></use></svg>
                Systeminställning 
                <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
              </button>
            </li>
          </ul>
        </li>
        <!--
        <form class="d-flex ms-auto">
          <div class="input-group">
            <input class="form-control border-0 mr-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn border-0" type="submit">Search</button>
          </div>
        </form>
        -->
      </div>
    </nav>
  </header>
  <main id="ContentStart" class="container-md">
