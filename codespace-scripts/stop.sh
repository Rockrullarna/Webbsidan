#!/bin/bash

#
# RR-Webbsidan - Codespaces Development Environment Stopper
# Använd denna för att stoppa den lokala utvecklingsmiljön
#

set -e

# Färger för output
CYAN='\033[0;36m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

CONTAINER_NAME="rr-webbsidan-dev"

echo -e "${CYAN}🛑 Stoppar RR-Webbsidan utvecklingsmiljö...${NC}"
echo ""

# Kontrollera om Docker/Podman är tillgängligt
if command -v docker &> /dev/null; then
    DOCKER_CMD="docker"
elif command -v podman &> /dev/null; then
    DOCKER_CMD="podman"
else
    echo -e "${CYAN}Docker/Podman är inte installerat.${NC}"
    exit 0
fi

# Kontrollera om containern körs
RUNNING=$($DOCKER_CMD ps --filter "name=$CONTAINER_NAME" --format "{{.Names}}" 2>/dev/null || true)

if [ "$RUNNING" = "$CONTAINER_NAME" ]; then
    echo -e "${YELLOW}🛑 Stoppar container...${NC}"
    $DOCKER_CMD stop $CONTAINER_NAME
    echo -e "${YELLOW}🗑️  Tar bort container...${NC}"
    $DOCKER_CMD rm $CONTAINER_NAME
    echo -e "${GREEN}✅ Containern har stoppats och tagits bort.${NC}"
else
    # Kolla om den finns men är stoppad
    STOPPED=$($DOCKER_CMD ps -a --filter "name=$CONTAINER_NAME" --format "{{.Names}}" 2>/dev/null || true)
    if [ "$STOPPED" = "$CONTAINER_NAME" ]; then
        echo -e "${YELLOW}🗑️  Tar bort stoppad container...${NC}"
        $DOCKER_CMD rm $CONTAINER_NAME
        echo -e "${GREEN}✅ Containern har tagits bort.${NC}"
    else
        echo -e "${CYAN}ℹ️  Ingen container '$CONTAINER_NAME' hittades.${NC}"
    fi
fi
