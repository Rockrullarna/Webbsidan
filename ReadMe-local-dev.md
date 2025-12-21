# Lokal utvecklingsmiljö

Denna guide beskriver hur du kör igång projektet lokalt med Podman Desktop eller Docker.

## Förutsättningar

- [Podman Desktop](https://podman-desktop.io/) eller [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Git

## Snabbstart med Podman Desktop

```sh
cd C:\GitHub\RR-Webbsidan
podman compose up --build
```

> **OBS:** Om `podman compose` inte fungerar, installera podman-compose:
> - **Windows (winget):** `winget install -e --id RedHat.Podman-Desktop`
> - **Windows (pip):** `pip install podman-compose` (kräver [Python](https://www.python.org/downloads/))
> - **macOS:** `brew install podman-compose`

Webbsidan är nu tillgänglig på: **http://localhost:8080**

## Snabbstart med Docker Desktop

```sh
cd C:\GitHub\RR-Webbsidan
docker-compose up --build
```

Webbsidan är nu tillgänglig på: **http://localhost:8080**

## Alternativ: Bygg och kör manuellt

### 1. Bygg Docker-imagen

```sh
podman build -t rr-webbsidan .
```

### 2. Starta containern

```sh
podman run -d -p 8080:8080 -v ./src:/var/www/html:Z rr-webbsidan
```

> **OBS:** `:Z` behövs på Linux för SELinux-kompatibilitet. På Windows kan du utelämna det.

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

### Med docker-compose

```sh
podman-compose down
```

### Manuellt

Lista körande containers:

```sh
podman ps
```

Stoppa container (ersätt CONTAINER_ID):

```sh
podman stop CONTAINER_ID
```

## Felsökning

| Problem | Lösning |
|---------|---------|
| Port 8080 är upptagen | Ändra porten i `docker-compose.yml` eller använd `-p 8081:8080` |
| Podman-maskinen startar inte | Starta om Podman Desktop eller kör `podman machine start` |
| Ändringar syns inte | Kontrollera att volymen är korrekt monterad |
| `podman` känns inte igen i terminalen | Starta om terminalen efter installation. Om det inte hjälper, använd GUI-metoden eller kör: `& "$env:ProgramFiles\RedHat\Podman\podman.exe" compose up --build` |
| `podman-compose` känns inte igen | Använd `podman compose` (utan bindestreck) eller GUI-metoden |

## Utveckling

Tack vare volym-monteringen (`./src:/var/www/html`) uppdateras webbsidan automatiskt när du sparar ändringar i `src/`-mappen. Ingen omstart av containern behövs.

## Avancerade inställningar

Du kan anpassa `docker-compose.yml` för att lägga till fler tjänster, miljövariabler eller nätverksinställningar efter behov.

Se [docker-compose dokumentation](https://docs.docker.com/compose/) för mer information.

