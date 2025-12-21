# RR-Webbsidan Tester

Playwright-tester för att validera länkar och sidor på RR-Webbsidan.

## Installation

### Windows (PowerShell)

```sh
cd tests
npm install
npx playwright install chromium
```

### Linux/macOS/Codespaces (Bash)

```sh
cd tests
chmod +x run-tests.sh
./run-tests.sh install
```

## Köra tester

### Windows (PowerShell)

```sh
# Mot lokal utvecklingsmiljö (starta först dev-scripts/start.ps1)
cd tests
npm run test:local

# Mot produktion
npm run test:prod
```

### Linux/macOS/Codespaces (Bash)

```sh
cd tests

# Mot lokal utvecklingsmiljö
./run-tests.sh local

# Mot produktion
./run-tests.sh prod

# Endast länkvalidering
./run-tests.sh links

# Full webbplatscrawl
./run-tests.sh crawl

# Mot egen URL
./run-tests.sh local --url https://example.com

# Visa rapport
./run-tests.sh report
```

## Tillgängliga kommandon

### NPM Scripts (Windows)

| Kommando | Beskrivning |
|----------|-------------|
| `npm run test:local` | Kör alla tester mot localhost:8080 |
| `npm run test:prod` | Kör alla tester mot rockrullarna.se |
| `npm run test:links:local` | Kör endast länkvalidering mot localhost |
| `npm run test:links:prod` | Kör endast länkvalidering mot produktion |
| `npm run report` | Visa HTML-rapport från senaste testkörning |

### Shell Script (Linux/Codespaces)

| Kommando | Beskrivning |
|----------|-------------|
| `./run-tests.sh install` | Installera dependencies och Playwright |
| `./run-tests.sh local` | Kör alla tester mot localhost:8080 |
| `./run-tests.sh prod` | Kör alla tester mot rockrullarna.se |
| `./run-tests.sh links` | Kör endast länkvalidering |
| `./run-tests.sh crawl` | Kör full webbplatscrawl |
| `./run-tests.sh report` | Visa HTML-rapport |
| `./run-tests.sh help` | Visa hjälp |

## Testfiler

| Fil | Beskrivning |
|-----|-------------|
| `specs/link-checker.spec.ts` | Validerar interna länkar på huvudsidorna |
| `specs/full-crawl.spec.ts` | Crawlar hela webbplatsen och hittar trasiga sidor |
| `specs/external-links.spec.ts` | Validerar viktiga externa länkar (skipped by default) |

## Exempel på output

```
🔍 Startar crawl av http://localhost:8080...

📊 Crawl-resultat:
   ✅ Fungerande sidor: 45
   ❌ Trasiga sidor: 2
   📄 Totalt crawlade: 47

❌ Trasiga sidor:
   - /gammal-sida/ (HTTP 404)
   - /bruten-lank/ (HTTP 404)
```

## Codespaces

I GitHub Codespaces kan du köra testerna direkt:

```sh
# Första gången
cd tests
./run-tests.sh install

# Starta lokal PHP-server (i en annan terminal)
cd ../src
php -S 0.0.0.0:8080

# Kör testerna
cd ../tests
./run-tests.sh local
```

## Tips

- Kör `./run-tests.sh report` eller `npm run report` efter testerna för att se en detaljerad HTML-rapport
- Testerna tar screenshots vid fel, dessa sparas i `test-results/`
- Full crawl kan ta några minuter beroende på antal sidor
