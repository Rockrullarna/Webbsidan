# Hur man kan sätta och läsa versionsnummer via GitHub-actions

## Lägga till versionsnummer i version.txt via yaml-fil
Läs under action-step: "Add version.txt file", den kommer att ersätta innehållet i version.txt med: "v13.yyyyMMdd.hhmm"

```yml
on:
  push:
    branches:
      - main

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v2

      - name: Add version.txt file
        run: echo "v13.$(date +'%Y%m%d').$(date +'%H%M')" > ./src/version.txt
```



## Läsa versionsnummer
Hur läser man https://rockrullarna.se/version.txt och skriver ut dess innehåll på en PHP sida?

---

För att läsa innehållet från en URL som https://rockrullarna.se/version.txt och skriva ut det på en PHP-sida, kan du använda funktionen file_get_contents() i PHP. Här är ett exempel:
```php
<?php
// Läs innehållet från version.txt
$versionUrl = 'https://rockrullarna.se/version.txt';
$versionContent = file_get_contents($versionUrl);

// Kontrollera om läsningen lyckades
if ($versionContent === false) {
    echo "Kunde inte läsa version.txt.";
} else {
    // Skriv ut innehållet på sidan
    echo "Version: " . htmlspecialchars($versionContent);
}
?>
```

Förklaring:
1. ```file_get_contents()```:

Funktionen används för att läsa innehållet från en fil eller URL. I detta fall läser den innehållet från ```https://rockrullarna.se/version.txt```.


2. Felhantering:

Om ```file_get_contents()``` misslyckas (t.ex. om filen inte finns eller om servern inte är tillgänglig), returnerar den ```false```. Detta hanteras med en ```if```-kontroll.


3. ```htmlspecialchars()```:

Funktionen används för att undvika att potentiellt farliga tecken (som ```<``` och ```>```) tolkas som HTML. Detta är en säkerhetsåtgärd för att förhindra XSS-attacker.


4. Utskrift:

Om läsningen lyckas, skrivs innehållet från ```version.txt``` ut på sidan.


**Viktigt:** 
Kontrollera att ```allow_url_fopen``` är aktiverat i din PHP-konfiguration. Detta krävs för att kunna läsa innehåll från en URL med ```file_get_contents()```. Du kan kontrollera detta genom att köra ```phpinfo();``` och leta efter ```allow_url_fopen```.
Om allow_url_fopen är inaktiverat, kan du istället använda cURL för att läsa innehållet. Här är ett exempel med cURL:

```php
<?php
$ch = curl_init('https://rockrullarna.se/version.txt');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$versionContent = curl_exec($ch);
curl_close($ch);

if ($versionContent === false) {
    echo "Kunde inte läsa version.txt.";
} else {
    echo "Version: " . htmlspecialchars($versionContent);
}
?>
```

Använd det alternativ som passar din serverkonfiguration bäst.