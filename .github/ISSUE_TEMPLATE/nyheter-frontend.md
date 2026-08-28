---
name: Nyhetssida - Frontend
about: Implementera publika nyhetssidor med API-integration från admin-systemet
title: "📰 Implementera nyhetssida med API-integration från admin-systemet"
labels: ["frontend", "feature", "database"]
---

## 📰 Issue: Implementera nyhetssida med API-integration från admin-systemet

**Titel:** Skapa publika nyhetssidor med JSON-data från admin-system

### Syfte
Implementera publika sidor där besökare kan se nyheter, bloggposter och aktiviteter som skapas av superanvändare via ett dolt admin-gränssnitt. Denna issue hanterar **visningsdelen** (frontend).

**Motsvarande issue för admin-delen finns i:** [Webbsidan-privat](https://github.com/Rockrullarna/Webbsidan-privat/issues)

### Krav

#### 1. **Nyhetssida/Blogg-sida**
- [ ] Skapa en ny sida `/nyheter/` eller `/blogg/` som visar alla publiceräde poster
- [ ] Implementera listvy med:
  - Titel
  - Ingress/kort beskrivning
  - Miniatyrbild
  - Datum och författare
  - Länk till fullständig post
- [ ] Implementera pagination (10-20 poster per sida)
- [ ] Lägg till möjlighet att filtrera efter kategori (Nyheter, Evenemang, Kursstart, Årsmöte osv.)
- [ ] Implementera sökning i nyheter

#### 2. **Enskild nyhet/post-sida**
- [ ] Skapa sida som visar fullständig post med:
  - Titel
  - Författare och publiceringsdatum
  - Featured image (om tillgänglig)
  - Innehål (HTML/Markdown renderad)
  - Relaterade poster (förslag)
  - Möjlighet att dela på sociala medier
- [ ] Implementera kommentarssystem (valfritt, kan vänta)

#### 3. **Startsida-integration**
- [ ] Uppdatera startsidan för att visa de **5-10 senaste nyheterna** dynamiskt
- [ ] Implementera "Läs mer"-länk till full nyhetssida
- [ ] Möjlighet att visa destacerad nyheter/featured posts

#### 4. **API-integration**
- [ ] Skapa PHP-endpoints som hämtar nyhetsdata från databasen:
  - `GET /api/posts` - Hämta alla publiceräde poster
  - `GET /api/posts/{id}` - Hämta enskild post
  - `GET /api/posts/category/{category}` - Filtrera på kategori
- [ ] Implementera caching för bättre prestanda
- [ ] Hantera felfall och felresponser

#### 5. **Design & Responsivitet**
- [ ] Designa sida som passar Rockrullarna visuell profil
- [ ] Säkerställ responsivitet för mobil, tablet och desktop
- [ ] Implementera mörkläge (om önskvärt)
- [ ] Optimera för snabb laddning

#### 6. **SEO & Tillgänglighet**
- [ ] Implementera SEO-vänliga URLs (slugs)
- [ ] Lägg till meta-tags för sociala medier (Open Graph)
- [ ] Säkerställ WCAG-efterlevnad för tillgänglighet
- [ ] Implementera structured data (JSON-LD) för nyheter

#### 7. **RSS-feed (valfritt)**
- [ ] Skapa RSS-feed för nyheter `/api/posts/feed`

### Tekniska specifikationer

**Mapp-struktur förslag:**
```
src/
├── nyheter/
│   ├── index.php (nyhetslista)
│   ├── post.php (enskild post)
│   └── README.md
├── api/
│   ├── posts.php (REST-endpoints)
│   └── posts-cache.php (cachning)
└── filer/
    └── js/
        └── nyheter.js (frontend-logik)
```

**Databaskoppling:**
- Hämtar data från tabell `posts` i MariaDB
- Posts-data lagras i JSON-format (se admin-issue för detaljer)
- Anslutningen och config hämtas från delad konfigurationsfil

### Acceptanskriterier
- ✅ Nyhetssida visar alla publiceräde poster
- ✅ Enskild post-sida fungerar korrekt
- ✅ Startsidan visar senaste nyheter dynamiskt
- ✅ API-endpoints returnerar korrekt formaterad data
- ✅ Sidan är responsiv och tillgänglig
- ✅ Prestanda är acceptabel (< 2s laddningstid)

### Relaterade issues
- [Webbsidan-privat: Admin-panel för nyhetshanterings](https://github.com/Rockrullarna/Webbsidan-privat/issues)
- #131 (Uppdatera startsidan)

**Labels:** `frontend`, `feature`, `database`
