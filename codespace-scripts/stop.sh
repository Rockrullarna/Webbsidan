#!/bin/bash

#
# RR-Webbsidan - Codespaces Development Environment Stopper
# Använd denna för att stoppa den lokala utvecklingsmiljön
#

# Färger för output
CYAN='\033[0;36m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

CONTAINER_NAME="rr-webbsidan-dev"
PORT="${1:-8080}"

echo -e "${CYAN}🛑 Stoppar RR-Webbsidan utvecklingsmiljö...${NC}"
echo ""

# Funktion för att stoppa process på en specifik port
stop_port_process() {
    local port=$1
    local pid=""
    
    # Försök hitta PID med olika metoder (prioritera fuser då det är mest tillförlitligt)
    if command -v fuser &> /dev/null; then
        pid=$(fuser $port/tcp 2>/dev/null || true)
    elif command -v lsof &> /dev/null; then
        pid=$(lsof -ti :$port 2>/dev/null || true)
    elif command -v ss &> /dev/null; then
        pid=$(ss -tlnp 2>/dev/null | grep ":$port " | awk '{print $NF}' | cut -d',' -f2 | cut -d'=' -f2 || true)
    elif command -v netstat &> /dev/null; then
        pid=$(netstat -tlnp 2>/dev/null | grep ":$port " | awk '{print $NF}' | cut -d'/' -f1 || true)
    fi
    
    if [ -n "$pid" ] && [ "$pid" != "-" ]; then
        echo -e "${YELLOW}🧹 Stoppar process (PID: $pid) på port $port...${NC}"
        if kill -9 $pid 2>/dev/null; then
            sleep 1
            echo -e "${GREEN}✅ Process på port $port har stoppats.${NC}"
            return 0
        else
            echo -e "${RED}❌ Kunde inte stoppa process på port $port${NC}"
            return 1
        fi
    else
        echo -e "${CYAN}ℹ️  Ingen process hittades på port $port${NC}"
        return 1
    fi
}

# Försök stoppa process på angiven port
if [ -n "$PORT" ]; then
    echo -e "${CYAN}Kontrollerar port $PORT...${NC}"
    stop_port_process "$PORT"
    echo ""
fi

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
