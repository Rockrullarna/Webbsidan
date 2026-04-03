# Aktivitetskalender

Aktivitetskalendern använder en lokal backend-proxy i stället för att låta webbläsaren tolka dans.se direkt.

## Översikt

Backend-endpointen finns i [data.php](c:/GitHub/RR-Webbsidan/src/aktivitetskalender/data.php).

Den ansvarar för att:

1. hämta `schedule`-sidan från dans.se
2. hämta `api/public/events` från dans.se
3. slå ihop båda källorna
4. deduplicera poster
5. cacha resultatet lokalt i 15 minuter
6. returnera färdiga poster till frontend

Frontend i [../filer/js/aktivitetskalender.js](c:/GitHub/RR-Webbsidan/src/filer/js/aktivitetskalender.js) renderar bara färdiga poster som redan normaliserats av backend.

## Varför två datakällor?

`api/public/events` innehåller inte alltid alla aktiviteter som syns i dans.se:s schedule-vy.

Exempel:

1. vissa aktiviteter i `Lilla salen` finns i schedule-vyn
2. samma aktiviteter kan saknas i `api/public/events`

Därför används:

1. schedule-vyn som primär källa för faktiska tillfällen
2. public events-API:t som kompletterande källa för länkar och poster som annars saknas

## Svarformat

Normal användning:

```json
[
  {
    "name": "Exempelaktivitet",
    "start": "2026-04-13 18:00:00",
    "end": "2026-04-13 20:00:00",
    "location": "Lilla salen",
    "url": null
  }
]
```

Debug-läge:

```json
{
  "events": [
    {
      "name": "Exempelaktivitet",
      "start": "2026-04-13 18:00:00",
      "end": "2026-04-13 20:00:00",
      "location": "Lilla salen",
      "url": null
    }
  ],
  "debug": {
    "org": "rockrullarna",
    "days": 180,
    "sources": {
      "scheduleCount": 63,
      "apiCount": 18,
      "mergedCount": 76
    },
    "cache": {
      "status": "fresh",
      "ttlSeconds": 900,
      "file": "calendar-rockrullarna-180.json"
    }
  }
}
```

## Query-parametrar

Stödda parametrar för `data.php`:

1. `days`
   1. antal dagar framåt att hämta
   2. standardvärde: `180`
   3. intervall: `1` till `365`
2. `debug`
   1. använd `1` eller `true` för att få debuginformation
   2. exempel: `/aktivitetskalender/data.php?days=30&debug=1`

## Cache

Cachefiler skrivs till:

1. [cache](c:/GitHub/RR-Webbsidan/src/aktivitetskalender/cache)

Nuvarande cachepolicy:

1. TTL: 15 minuter
2. om cache är färsk returneras den direkt
3. om livehämtning misslyckas används stale cache om sådan finns

För lokal utveckling kan du rensa cache med:

```powershell
.\dev-scripts\clear-cache.ps1
```

Och både rensa och bygga upp den igen med:

```powershell
.\dev-scripts\clear-cache.ps1 -Rebuild
```

## Driftflöde

1. klienten anropar `/aktivitetskalender/data.php?days=180`
2. backend läser cache om den är färsk
3. annars hämtas schedule + public events
4. backend bygger en sammanslagen lista
5. backend skriver cache
6. klienten renderar tabellen

## Filer

1. [index.php](c:/GitHub/RR-Webbsidan/src/aktivitetskalender/index.php)
   1. kalenderns sida
2. [data.php](c:/GitHub/RR-Webbsidan/src/aktivitetskalender/data.php)
   1. backend-proxy, merge, cache, debug
3. [../filer/js/aktivitetskalender.js](c:/GitHub/RR-Webbsidan/src/filer/js/aktivitetskalender.js)
   1. frontend-rendering av färdig backenddata

## Testning

Kalenderns Playwright-tester finns i [../../tests/specs/aktivitetskalender.spec.ts](c:/GitHub/RR-Webbsidan/tests/specs/aktivitetskalender.spec.ts).

De använder syntetiska fixtures och är inte bundna till en specifik termin.