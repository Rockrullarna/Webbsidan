<#
.SYNOPSIS
    Visar live-loggar från utvecklingscontainern.

.DESCRIPTION
    Följer loggarna från PHP-servern i realtid.
    Avsluta med Ctrl+C.

.EXAMPLE
    .\logs.ps1
#>

$containerName = "rr-webbsidan-dev"

Write-Host "📜 Visar loggar från $containerName (Ctrl+C för att avsluta)..." -ForegroundColor Cyan
Write-Host ""

# Kontrollera om containern körs
$runningContainer = podman ps --filter "name=$containerName" --format "{{.Names}}" 2>$null

if ($runningContainer -eq $containerName) {
    podman logs -f $containerName
} else {
    Write-Host "❌ Containern '$containerName' körs inte." -ForegroundColor Red
    Write-Host "   Starta med: .\dev-scripts\start.ps1" -ForegroundColor Yellow
}
