<#
.SYNOPSIS
    Visar status för utvecklingsmiljön.

.DESCRIPTION
    Visar om containern körs och var webbsidan är tillgänglig.

.EXAMPLE
    .\status.ps1
#>

$containerName = "rr-webbsidan-dev"
$port = 8080

Write-Host ""
Write-Host "📊 RR-Webbsidan Utvecklingsmiljö Status" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Kontrollera Podman
if (-not (Get-Command podman -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Podman: Ej installerat" -ForegroundColor Red
    exit 1
}

# Kontrollera Podman-maskin
$machineStatus = podman machine info 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Podman-maskin: Körs" -ForegroundColor Green
} else {
    Write-Host "❌ Podman-maskin: Stoppad" -ForegroundColor Red
    Write-Host "   Starta med: podman machine start" -ForegroundColor Yellow
    exit 1
}

# Kontrollera container
$runningContainer = podman ps --filter "name=$containerName" --format "{{.Names}}" 2>$null

if ($runningContainer -eq $containerName) {
    Write-Host "✅ Container: Körs" -ForegroundColor Green
    Write-Host ""
    Write-Host "   🌐 Webbsida: http://localhost:$port" -ForegroundColor Cyan
    
    # Visa container-detaljer
    Write-Host ""
    Write-Host "📋 Container-detaljer:" -ForegroundColor Yellow
    podman ps --filter "name=$containerName" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
    
    # Visa loggar
    Write-Host ""
    Write-Host "📜 Senaste loggar:" -ForegroundColor Yellow
    podman logs --tail 5 $containerName
} else {
    Write-Host "⏹️ Container: Stoppad" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "   Starta med: .\dev-scripts\start.ps1" -ForegroundColor Gray
}

Write-Host ""
