## cache/ – Temporär mellanlagring

Denna katalog används för automatiskt genererade, kortlivade filer som inte ska versionshanteras.

### Syfte
* Minska antal externa anrop (just nu mot `dans.se`).  
* Snabbare sidladdning och lägre belastning på extern tjänst.  
* Fallback om extern källa tillfälligt är nere.

### Nuvarande användning
| Fil | Beskrivning |
|-----|-------------|
| `aktiviteter.json` | Cachead och tolkad lista över kommande aktiviteter hämtad av `proxy/aktiviteter.php`. |

### Cache‑logik
* TTL (time to live) är 15 minuter (justeras i `proxy/aktiviteter.php`, variabeln `$CACHE_TTL`).  
* Om filen saknas eller är för gammal hämtas data på nytt och filen skrivs om.  
* Format: JSON (UTF‑8) – kan raderas när som helst; återskapas automatiskt.

### Rensa / felsöka
* Det räcker att ta bort filerna i katalogen (webbservern skapar nya).  
* Vid ihållande fel: kontrollera att PHP har skrivrättigheter (typiskt 0775 på katalog, 0644 på filer).

### Ska INTE läggas här
* Permanenta filer (bilder, dokument) – lägg dem i `filer/`.
* Känslig eller manuell data – allt här kan rensas utan förvarning.

### Framtida förbättringar (idéer)
* Query‐parameter `?flush=1` för manuell tömning (endast om enkel behörighetskontroll införs).  
* Etag / Last‑Modified headers för klient‑cache.  
* Mer robust HTML‑parsing (DOMDocument) i stället för regex för aktiviteter.

### Snabb överblick av ändringspunkt
I `proxy/aktiviteter.php`:
```php
$CACHE_TTL = 15 * 60; // 15 minuter – ändra här
```

---
Senast uppdaterad: 2025-08-28
