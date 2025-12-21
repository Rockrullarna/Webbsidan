# Lokal utvecklingsmiljö

Denna guide beskriver hur du kör igång projektet lokalt med Podman Desktop eller Docker.

## Förutsättningar

- [Podman Desktop](https://podman-desktop.io/) eller [Docker Desktop](https://www.docker.com/products/docker-desktop/)
  - Se guide: [Installera Podman Desktop i Windows 11](https://blog.pownas.se/2025/12/13/installera-podman)
- Git

## Snabbstart med PowerShell-skript (rekommenderat)

Det enklaste sättet att starta utvecklingsmiljön:

```powershell
# Starta utvecklingsmiljön
.\dev-scripts\start.ps1

# Stoppa utvecklingsmiljön
.\dev-scripts\stop.ps1

# Visa status
.\dev-scripts\status.ps1

# Visa live-loggar
.\dev-scripts\logs.ps1
```

Webbsidan är tillgänglig på: **http://localhost:8080**

## Snabbstart med Podman (manuellt)

### 1. Bygg Docker-imagen

```sh
cd C:\GitHub\RR-Webbsidan
podman build -t rr-webbsidan .
```

### 2. Starta containern

```sh
podman run -d -p 8080:8080 -v C:\GitHub\RR-Webbsidan\src:/var/www/html --name rr-webbsidan-dev rr-webbsidan
```

Webbsidan är nu tillgänglig på: **http://localhost:8080**

### 3. Stoppa containern

```sh
podman stop rr-webbsidan-dev
podman rm rr-webbsidan-dev
```

## Snabbstart med Docker Desktop

```sh
cd C:\GitHub\RR-Webbsidan
docker-compose up --build
```

Webbsidan är nu tillgänglig på: **http://localhost:8080**

## Alternativ: docker-compose (kräver extra installation)

Om du vill använda `podman compose` behöver du installera compose-providern:

```sh
# Med pip (kräver Python)
pip install podman-compose

# Sedan kan du köra
podman-compose up --build
```

## Via Podman Desktop GUI

1. Öppna **Podman Desktop**
2. Kontrollera att Podman-maskinen är startad (grön status)
3. Gå till **Images** → **Build**
4. Välj `C:\GitHub\RR-Webbsidan` som context och `Dockerfile` som fil
5. Klicka **Build**
6. När imagen är byggd, gå till **Containers** → **Create**
7. Välj imagen och konfigurera:
   - **Port mapping:** `8080:8080`
   - **Volume:** `C:\GitHub\RR-Webbsidan\src` → `/var/www/html`
8. Klicka **Start**

## Öppna webbsidan

Surfa till: **http://localhost:8080**

## Stoppa containern

### Med Podman (manuellt)

```sh
podman stop rr-webbsidan-dev
podman rm rr-webbsidan-dev
```

### Med docker-compose

```sh
docker-compose down
```

### Lista körande containers

```sh
podman ps
```

## Felsökning

| Problem | Lösning |
|---------|---------|
| Port 8080 är upptagen | Ändra porten med `-p 8081:8080` |
| Podman-maskinen startar inte | Starta om Podman Desktop eller kör `podman machine start` |
| Ändringar syns inte | Kontrollera att volymen är korrekt monterad |
| `podman` känns inte igen i terminalen | Starta om terminalen efter installation |
| `podman compose` saknar provider | Använd manuell metod (build + run) eller installera `pip install podman-compose` |
| Container med samma namn finns redan | Kör `podman rm rr-webbsidan-dev` först |

## Utveckling

Tack vare volym-monteringen (`./src:/var/www/html`) uppdateras webbsidan automatiskt när du sparar ändringar i `src/`-mappen. Ingen omstart av containern behövs.

## Avancerade inställningar

Du kan anpassa `docker-compose.yml` för att lägga till fler tjänster, miljövariabler eller nätverksinställningar efter behov.

Se [docker-compose dokumentation](https://docs.docker.com/compose/) för mer information.

