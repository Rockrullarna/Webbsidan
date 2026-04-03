<#
.SYNOPSIS
    Rensar och kan återskapa aktivitetskalenderns cache.

.DESCRIPTION
    Tar bort lokala cachefiler i src\aktivitetskalender\cache.
    Med -Rebuild byggs cachen upp igen genom att anropa backend-endpointen.

.EXAMPLE
    .\clear-cache.ps1

.EXAMPLE
    .\clear-cache.ps1 -Rebuild

.EXAMPLE
    .\clear-cache.ps1 -Rebuild -Days 30
#>

param(
    [switch]$Rebuild,
    [int]$Days = 180
)

$ErrorActionPreference = 'Stop'
$containerName = 'rr-webbsidan-dev'
$preferredImageNames = @('rr-webbsidan', 'rockrullarna-web')
$projectRoot = Split-Path -Parent $PSScriptRoot
$cacheDir = Join-Path $projectRoot 'src\aktivitetskalender\cache'
$cacheFiles = Join-Path $cacheDir '*.json'
$endpointUrl = "http://localhost:8080/aktivitetskalender/data.php?days=$Days&debug=1"

Write-Host "🧹 Rensar aktivitetskalenderns cache..." -ForegroundColor Cyan

if (-not (Test-Path $cacheDir)) {
    Write-Host "ℹ️ Cache-katalogen finns inte ännu: $cacheDir" -ForegroundColor Yellow
} else {
    $existingCacheFiles = Get-ChildItem -Path $cacheFiles -ErrorAction SilentlyContinue

    if ($null -eq $existingCacheFiles -or $existingCacheFiles.Count -eq 0) {
        Write-Host "ℹ️ Inga cachefiler hittades." -ForegroundColor Yellow
    } else {
        Remove-Item -Path $cacheFiles -Force
        Write-Host "✅ Tog bort $($existingCacheFiles.Count) cachefil(er)." -ForegroundColor Green
    }
}

if (-not $Rebuild) {
    Write-Host "ℹ️ Klar. Använd -Rebuild om du vill bygga upp cachen direkt igen." -ForegroundColor Yellow
    exit 0
}

Write-Host "🔄 Återskapar kalendercache..." -ForegroundColor Cyan

$runningContainer = ''
if (Get-Command podman -ErrorAction SilentlyContinue) {
    $runningContainer = podman ps --filter "name=$containerName" --format "{{.Names}}" 2>$null
}

if ($runningContainer -eq $containerName) {
    try {
        Invoke-WebRequest -Uri $endpointUrl -UseBasicParsing | Out-Null
        Write-Host "✅ Cachen byggdes upp via körande utvecklingscontainer." -ForegroundColor Green
        Write-Host "   🌐 $endpointUrl" -ForegroundColor Gray
        exit 0
    } catch {
        Write-Host "⚠️ Kunde inte återskapa cache via lokal container. Försöker engångskörning..." -ForegroundColor Yellow
    }
}

if (-not (Get-Command podman -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Podman hittades inte, så cachen kunde inte återskapas automatiskt." -ForegroundColor Red
    Write-Host "   Starta sidan och anropa: $endpointUrl" -ForegroundColor Yellow
    exit 1
}

$imageName = $null
foreach ($candidateImageName in $preferredImageNames) {
    podman image exists $candidateImageName 2>$null
    if ($LASTEXITCODE -eq 0) {
        $imageName = $candidateImageName
        break
    }
}

if ($null -eq $imageName) {
    Write-Host "❌ Ingen känd image hittades. Förväntade något av: $($preferredImageNames -join ', ')" -ForegroundColor Red
    Write-Host "   Bygg först med .\dev-scripts\start.ps1 eller podman build -t rr-webbsidan ." -ForegroundColor Yellow
    exit 1
}

$bootstrapCode = "parse_str('days=$Days&debug=1', `$_GET); `$_SERVER['REQUEST_METHOD'] = 'GET'; include '/var/www/html/aktivitetskalender/data.php';"

podman run --rm `
    -v "${projectRoot}\src:/var/www/html" `
    -w /var/www/html `
    $imageName `
    php -r $bootstrapCode | Out-Null

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Cachen byggdes upp via engångskörning i container." -ForegroundColor Green
} else {
    Write-Host "❌ Kunde inte återskapa kalendercachen." -ForegroundColor Red
    exit 1
}