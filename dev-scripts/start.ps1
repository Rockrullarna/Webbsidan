<#
.SYNOPSIS
    Startar lokal utvecklingsmiljö för RR-Webbsidan med Podman.

.DESCRIPTION
    Bygger Docker-imagen och startar containern med volym-montering
    för live-uppdateringar under utveckling.

.EXAMPLE
    .\start.ps1
#>

$ErrorActionPreference = "Stop"
$containerName = "rr-webbsidan-dev"
$imageName = "rr-webbsidan"
$port = 8080
$projectRoot = Split-Path -Parent $PSScriptRoot

Write-Host "🚀 Startar RR-Webbsidan utvecklingsmiljö..." -ForegroundColor Cyan

# Kontrollera om Podman är tillgängligt
if (-not (Get-Command podman -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Podman hittades inte. Installera Podman Desktop först." -ForegroundColor Red
    Write-Host "   https://podman-desktop.io/" -ForegroundColor Yellow
    exit 1
}

# Kontrollera om Podman-maskinen körs
$machineStatus = podman machine info 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚙️ Startar Podman-maskinen..." -ForegroundColor Yellow
    podman machine start
}

# Stoppa och ta bort befintlig container om den finns
$existingContainer = podman ps -a --filter "name=$containerName" --format "{{.Names}}" 2>$null
if ($existingContainer -eq $containerName) {
    Write-Host "🛑 Stoppar befintlig container..." -ForegroundColor Yellow
    podman stop $containerName 2>$null
    podman rm $containerName 2>$null
}

# Bygg imagen
Write-Host "🔨 Bygger Docker-imagen..." -ForegroundColor Yellow
podman build -t $imageName $projectRoot

if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Byggfel! Kontrollera Dockerfile." -ForegroundColor Red
    exit 1
}

# Starta containern
Write-Host "▶️ Startar containern..." -ForegroundColor Yellow
podman run -d `
    -p ${port}:8080 `
    -v "${projectRoot}\src:/var/www/html" `
    --name $containerName `
    $imageName

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "✅ Utvecklingsmiljön är igång!" -ForegroundColor Green
    Write-Host ""
    Write-Host "   🌐 Webbsida:  http://localhost:$port" -ForegroundColor Cyan
    Write-Host "   📁 Källa:     $projectRoot\src" -ForegroundColor Gray
    Write-Host ""
    Write-Host "   Stoppa med:  .\dev-scripts\stop.ps1" -ForegroundColor Gray
    Write-Host ""
    
    # Öppna i webbläsaren
    $openBrowser = Read-Host "Öppna i webbläsaren? (J/n)"
    if ($openBrowser -ne "n") {
        Start-Process "http://localhost:$port"
    }
} else {
    Write-Host "❌ Kunde inte starta containern." -ForegroundColor Red
    exit 1
}
