# rockrullarna.se/beta

Den här README:n beskriver hur beta-miljön på `https://rockrullarna.se/beta` används för att testa ändringar innan de går till ordinarie publicering.

## Syfte

Beta-miljön används för att kunna:

- provköra nya funktioner live
- verifiera layout, länkar och asset-laddning under `/beta/`
- testa ändringar från utvecklingsbrancher utan att påverka produktionen på `https://rockrullarna.se/`

## Hur beta-publiceringen fungerar

Beta-publiceringen är tänkt att ske automatiskt via ett separat GitHub Actions-workflow för brancher som börjar med:

- `dev/`
- `feature/`

Exempel:

- `dev/v14.20260402`
- `feature/ny-funktion-pa-sidan`

Vid push till en sådan branch ska workflowet:

1. checka ut repot
2. skapa en beta-version av `version.txt`
3. skriva om absoluta sökvägar så att sajten fungerar under `/beta/`
4. ladda upp innehållet från `src/` till serverns `/beta/`-katalog via SFTP

## Vad som skrivs om i beta-deployen

För att samma kodbas ska fungera under `https://rockrullarna.se/beta` behöver absoluta referenser justeras vid deploy.

Följande ersättningar görs i relevanta filer:

- `href="/` blir `href="/beta/`
- `src="/` blir `src="/beta/`

Detta gäller för filer som publiceras i beta-flödet, till exempel `.php`, `.html`, `.htm`, `.css` och `.js`.

## Viktigt att känna till

- `/beta/` är en gemensam testmiljö, inte en separat preview per branch
- senaste pushen från en matchande `dev/`- eller `feature/`-branch skriver över tidigare beta-publicering
- beta-miljön är till för verifiering, inte för långsiktig parallell drift
- versionssträngen i beta ska märkas upp som beta, så att det går att skilja den från produktion

## Produktion jämfört med beta

- `main` deployas till ordinarie webbplats via det vanliga deploy-flödet
- `dev/` och `feature/` deployas till `/beta/` via det separata beta-flödet

Det gör att vi kan testa ändringar i en publik men avgränsad miljö innan merge till `main`.

## URL för test

Beta-versionen nås här:

https://rockrullarna.se/beta

## Koppling till utvecklingsarbetet

Det här dokumentet speglar arbetet i:

- Issue `#121`: GitHub Action för deploy av `dev/`- och `feature/`-brancher till SFTP med `/beta/`-rewrite
- PR `#122`: implementation av workflow för beta-deploy via GitHub Actions
