<!DOCTYPE html>
<html lang="sv" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/filer/bilder/Rockrullarna-favicon.png?w=32" rel="shortcut icon" type="image/x-icon">
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
    echo "https://rockrullarna.se/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.jpg";
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
              <li><a class="dropdown-item" href="https://www.danssport.se/taevling/taevlingskalender" title="DSF Tävlingskalender (Öppnas i nytt fönster)" target="_blank">DSF Tävlingskalender (danssport.se)</a></li>
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
              <li><a class="dropdown-item" href="https://dans.se/shop/?org=rockrullarna&mship" title="Bli medlem hos oss (Öppnas i nytt fönster)" target="_blank">Bli medlem hos oss (dans.se)</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Kontakta</a>
            <ul class="dropdown-menu shadow">
              <li><a class="dropdown-item" href="/Kontakt">Kontaktinformation</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="https://www.google.se/maps/place/Rockrullarna+i+%C3%96rebro/@59.2747154,15.1734813,14.12z/data=!4m5!3m4!1s0x465c14d4a35b37db:0x948d71326b2d8b7c!8m2!3d59.2754033!4d15.1647323" title="Hitta till oss (Google maps öppnas i nytt fönster)" target="_blank">Hitta till oss (Google maps)</a></li>
              <li><a class="dropdown-item" href="https://m.me/Rockrullarna" title="Chatta med oss (Messenger öppnas i nytt fönster)" target="_blank">Chatta med oss (Messenger)</a></li>
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
