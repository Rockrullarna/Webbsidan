# Rockrullarna / Webbsidan
Kod-biblioteket [GitHub.com/Rockrullarna/Webbsidan](https://github.com/Rockrullarna/Webbsidan) för vår webbsida v13.x

## Vart finns källkoden?
Källkoden finns under [mappen src (SouRce Code, eller källkod på svenska)](https://github.com/Rockrullarna/Webbsidan/tree/main/src)

## Hur ser webbsidan ut?
Webbsidan finns uppladdad på vår domän: [rockrullarna.se](https://rockrullarna.se/)

## Utvecklingsmiljö

### Starta med GitHub Codespaces
Den enklaste vägen att komma igång med utveckling:

1. Öppna repot på GitHub
2. Klicka på **Code** > **Codespaces** > **Create codespace on main**
3. Vänta tills miljön är klar
4. Kör kommandot i terminalen:
   ```bash
   php -S 0.0.0.0:8080 -t src
   ```
5. Öppna webbsidan via **Ports**-fliken (port 8080) eller klicka på popup-notifikationen

### Starta med Docker eller Podman Desktop (lokalt)

**Alternativ 1: Docker Compose (rekommenderas)**
```bash
docker-compose up
```
eller med Podman:
```bash
podman-compose up
```

**Alternativ 2: Endast Docker**
```bash
docker build -t rockrullarna-web .
docker run -p 8080:8080 -v $(pwd)/src:/var/www/html rockrullarna-web
```
eller med Podman:
```bash
podman build -t rockrullarna-web .
podman run -p 8080:8080 -v $(pwd)/src:/var/www/html rockrullarna-web
```

Öppna sedan webbläsaren på: [http://localhost:8080](http://localhost:8080)

### Lokal utveckling utan container
Om du har PHP installerat lokalt kan du köra:
```bash
cd src
php -S localhost:8080
```

## Hur laddas hemsidan upp?
Som standard nu så laddas källkoden upp via SFTP via en GitHub-action när man gör en merge till main.  
Se filen ```.github\workflows\deploy.yml```.  
  
De som har access till GitHub-organisationen Rockrullarna, kan se en guide för uppladdning till vår domän via repot: 
[GitHub.com/Rockrullarna/Webbsidan-privat](https://github.com/Rockrullarna/Webbsidan-privat)
  
<br />
  
## Versionshistorik
Detta är generation/version 13 av hemsidan och hur den har sett ut genom åren.  
Historik kan hittas via exempelvis: Wayback machine. De som har tillgång till den privata koden under Rockrullarnas GitHub-organisation: https://github.com/orgs/Rockrullarna/repositories , kan hitta historiken för de olika sidorna via: https://github.com/Rockrullarna/Webbsidan-backup  

### Nya versioner eller kod-brancher
Strukturen för nya versioner/branch är följande:  
v`[huvudversion]`.`[byggdatum]`-`[funktion-som-utvecklats]`  
  
### Exempel på versioner:  
`v12.6.20230502-bootstrap-v5.3`  
`v12.7.20230713-klickbar-logga-samt-github-lankning`  
`v12.8.20230730-tar-bort-messenger-och-lagger-till-sok-funktion`   
`v12.9.20231230-ePassi-guide`  
--- Mönster bytt från version 13 ---
`v13.20250330-versionsnummer-via-automatisk-release`
  