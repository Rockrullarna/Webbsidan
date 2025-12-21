<#
.SYNOPSIS
    Stoppar lokal utvecklingsmiljö för RR-Webbsidan.

.DESCRIPTION
    Stoppar och tar bort den körande utvecklingscontainern.

.EXAMPLE
    .\stop.ps1
#>

$ErrorActionPreference = "Stop"
$containerName = "rr-webbsidan-dev"

Write-Host "🛑 Stoppar RR-Webbsidan utvecklingsmiljö..." -ForegroundColor Cyan

# Kontrollera om containern körs
$runningContainer = podman ps --filter "name=$containerName" --format "{{.Names}}" 2>$null

if ($runningContainer -eq $containerName) {
    podman stop $containerName
    podman rm $containerName
    Write-Host "✅ Containern har stoppats och tagits bort." -ForegroundColor Green
} else {
    # Kolla om den finns men är stoppad
    $stoppedContainer = podman ps -a --filter "name=$containerName" --format "{{.Names}}" 2>$null
    if ($stoppedContainer -eq $containerName) {
        podman rm $containerName
        Write-Host "✅ Containern har tagits bort." -ForegroundColor Green
    } else {
        Write-Host "ℹ️ Ingen container '$containerName' hittades." -ForegroundColor Yellow
    }
}
