# RR-Webbsidan Tester

Playwright-tester för att validera länkar och sidor på RR-Webbsidan.

## Installation

### Windows (PowerShell)

Om `npm` inte finns installerat på datorn behöver du först installera Node.js LTS, eftersom `npm` normalt följer med Node.js.

```powershell
# Installera Node.js LTS med winget
winget install OpenJS.NodeJS.LTS

# Stäng och öppna terminalen igen, kontrollera sedan att allt finns
node --version
npm --version
```

Om `winget` inte finns kan du installera Node.js LTS manuellt från nodejs.org.

När `node` och `npm` fungerar:

```sh
cd tests
npm install
npx playwright install chromium
```

Om `npm install` fortfarande misslyckas trots att `npm --version` fungerar, betyder det oftast att `npm` finns men att något annat i installationen gick fel. Börja då med att köra kommandot igen i `tests/` och läs det faktiska felmeddelandet.

#### Felsökning: `node` känns inte igen i PowerShell

Om du får felet:

```text
node: The term 'node' is not recognized as a name of a cmdlet, function, script file, or executable program.
```

så betyder det att Node.js antingen inte är installerat ännu, eller att installationen inte har lagts till i `PATH`.

Gör då så här:

```powershell
# 1. Installera Node.js LTS
winget install OpenJS.NodeJS.LTS

# 2. Stäng alla terminalfönster och starta om VS Code

# 3. Kontrollera att node och npm nu finns
node --version
npm --version
Get-Command node
Get-Command npm
```

Om det fortfarande inte fungerar, kontrollera om Node faktiskt finns installerat:

```powershell
Test-Path "C:\Program Files\nodejs\node.exe"
Test-Path "C:\Program Files\nodejs\npm.cmd"
```

Om filerna finns men kommandona ändå inte känns igen behöver du lägga till denna sökväg i Windows `Path`:

```text
C:\Program Files\nodejs\
```

Det gör du inte genom att köra själva sökvägen som ett kommando i PowerShell. Lägg i stället till den i `Path`.

Tillfälligt, bara i den terminal du har öppen just nu:

```powershell
$env:Path += ";C:\Program Files\nodejs\"

node --version
npm --version
```

Permanent för ditt Windows-användarkonto:

```powershell
$nodePath = 'C:\Program Files\nodejs\'
$currentUserPath = [Environment]::GetEnvironmentVariable('Path', 'User')

if ($currentUserPath -notlike "*$nodePath*") {
   [Environment]::SetEnvironmentVariable('Path', "$currentUserPath;$nodePath", 'User')
}
```

Stäng sedan terminalen och öppna en ny, och kontrollera igen:

```powershell
node --version
npm --version
Get-Command node
Get-Command npm
```

Du kan också lägga till sökvägen via Windows gränssnitt:

1. Öppna Start-menyn och sök efter `Miljövariabler`
2. Välj `Redigera systemets miljövariabler`
3. Klicka på `Miljövariabler...`
4. Markera `Path` under användarvariabler
5. Klicka på `Redigera`
6. Lägg till `C:\Program Files\nodejs\`
7. Spara och öppna en ny terminal

Därefter öppnar du en ny terminal och testar igen:

```powershell
node --version
npm --version
```

### Linux/macOS/Codespaces (Bash)

```sh
cd tests
chmod +x run-tests.sh
./run-tests.sh install
```

## Köra tester

### Windows (PowerShell)

NPM-skripten i `package.json` är anpassade för Windows. Om du tidigare sett felet:

```text
'BASE_URL' is not recognized as an internal or external command
```

så beror det på att Windows inte använder Unix-syntaxen `BASE_URL=... kommando` i `npm run`. Skripten är nu skrivna med Windows-kompatibel syntax.

```sh
# Mot lokal utvecklingsmiljö (starta först dev-scripts/start.ps1)
cd tests
npm run test:local

# Mot produktion
npm run test:prod

# Endast visuella regression-tester
npm run test:visual:local

# Uppdatera referens-screenshots mot produktion
npm run test:visual:update:prod

# Uppdatera referens-screenshots mot localhost
npm run test:visual:update:local
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

# Visuella regression-tester
./run-tests.sh screenshots

# Uppdatera referens-screenshots (se nedan)
./run-tests.sh update-screenshots

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
| `npm run test:external:links` | Kör och validerar externa webblänkar |
| `npm run test:visual:local` | Kör visuella regression-tester mot localhost |
| `npm run test:visual:prod` | Kör visuella regression-tester mot produktion |
| `npm run test:visual:update:local` | Uppdatera referens-screenshots mot localhost |
| `npm run test:visual:update:prod` | Uppdatera referens-screenshots mot produktion |
| `npm run test:navbar:local` | Kör navbar regression-tester mot localhost |
| `npm run test:navbar:prod` | Kör navbar regression-tester mot produktion |
| `npm run test:navbar:update:local` | Uppdatera navbar referens-screenshots mot localhost |
| `npm run test:navbar:update:prod` | Uppdatera navbar referens-screenshots mot produktion |
| `npm run report` | Visa HTML-rapport från senaste testkörning |

### Shell Script (Linux/Codespaces)

| Kommando | Beskrivning |
|----------|-------------|
| `./run-tests.sh install` | Installera dependencies och Playwright |
| `./run-tests.sh local` | Kör alla tester mot localhost:8080 |
| `./run-tests.sh prod` | Kör alla tester mot rockrullarna.se |
| `./run-tests.sh links` | Kör endast länkvalidering |
| `./run-tests.sh crawl` | Kör full webbplatscrawl |
| `./run-tests.sh screenshots` | Kör visuella regression-tester |
| `./run-tests.sh update-screenshots` | Uppdatera referens-screenshots |
| `./run-tests.sh report` | Visa HTML-rapport |
| `./run-tests.sh help` | Visa hjälp |

## Testfiler

| Fil | Beskrivning |
|-----|-------------|
| `specs/external-links.spec.ts` | Validerar viktiga externa länkar (skipped by default) |
| `specs/fbclid-query-string.spec.ts` | Validerar så att facebook clid länkar fungerar som de ska |
| `specs/full-crawl.spec.ts` | Crawlar hela webbplatsen och hittar trasiga sidor |
| `specs/link-checker.spec.ts` | Validerar interna länkar på huvudsidorna |
| `specs/navbar-visual.spec.ts` | Visuella regression-tester med screenshots för navbar menyn |
| `specs/visual-regression.spec.ts` | Visuella regression-tester med screenshots på olika specificerade sidor |

## Visuella regression-tester (screenshot-tester)

Testerna i `specs/visual-regression.spec.ts` tar fullständiga skärmdumpar av viktiga sidor och
jämför dem mot referens-screenshots (sparade i `snapshots/`). Om en sida ser annorlunda ut –
t.ex. efter en CSS- eller kodändring – failar testet och visar en diff-bild.

### Vad testas

| Sidor | Teman | Viewports |
|-------|-------|-----------|
| Startsida, Danskurser, Kursöversikt, Föreningen, Kontakt, Aktivitetskalender | Ljust (light), Mörkt (dark) | Desktop (1280×720), Mobil (375×812) |

Totalt: **24 kombinationer** per testkörning.

### Uppdatera referens-screenshots

När du gjort en **avsiktlig** design- eller CSS-ändring behöver du uppdatera referens-bilderna
i `snapshots/` och committa dem till repot:

```sh
# Starta PHP-servern om den inte redan är igång
cd ../src && php -S 0.0.0.0:8080 &

# Uppdatera referens-screenshots (kör i tests/-mappen)
cd ../tests
./run-tests.sh update-screenshots
# eller med npm:
npm run test:visual:update:local

# Granska ändringarna och committa bilderna
git add snapshots/
git commit -m "Uppdatera referens-screenshots"
```

### Lägga till en ny sida i testet

Öppna `specs/visual-regression.spec.ts` och lägg till ett objekt i `pages`-arrayen:

```typescript
const pages = [
  { name: 'startsida',          path: '/' },
  { name: 'danskurser',         path: '/danskurser/' },
  // ... befintliga sidor ...

  // Ny sida:
  { name: 'min-nya-sida',       path: '/min-nya-sida/' },
];
```

Kör sedan `update-screenshots` för att skapa referens-bilder för den nya sidan.

### När nya snapshots skapas automatiskt

När du lägger till en ny sida i `specs/visual-regression.spec.ts` finns det ännu inga referens-bilder
för den sidan i alla kombinationer av tema och viewport. Då kan Playwright skriva meddelanden som:

```text
A snapshot doesn't exist at tests/snapshots/visual-regression.spec.ts/...
writing actual.
```

Det betyder normalt inte att testet är trasigt. Det betyder bara att en referensbild saknades och att
Playwright skapade en ny snapshot under körningen med `--update-snapshots`.

Arbetsflödet är då:

1. Lägg till den nya sidan i `pages`-arrayen i `specs/visual-regression.spec.ts`
2. Kör `npm run test:visual:update:local` eller `npm run test:visual:update:prod`
3. Granska de nya bilderna i `tests/snapshots/visual-regression.spec.ts/`
4. Om bilderna ser korrekta ut, lägg till dem i git och committa dem
5. Kör sedan testet igen utan update-läge för att verifiera att allt matchar

Det är först om de nya bilderna ser fel ut, eller om vanliga testkörningar fortsätter att klaga på saknade snapshots,
som det är ett problem som behöver felsökas.

### Konfiguration

Snapshot-inställningar hittas i `playwright.config.ts`:

- **`snapshotDir`** – mapp för referens-screenshots (`tests/snapshots/`)
- **`maxDiffPixelRatio`** – tillåten pixelskillnad (standard 2 %) för att undvika flaky tester

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

# Kör visuella regression-tester
./run-tests.sh screenshots
```

## Tips

- Kör `./run-tests.sh report` eller `npm run report` efter testerna för att se en detaljerad HTML-rapport
- Testerna tar screenshots vid fel, dessa sparas i `test-results/`
- Full crawl kan ta några minuter beroende på antal sidor
- Referens-screenshots (`snapshots/`) är incheckade i repot och ska uppdateras vid avsiktliga designändringar
