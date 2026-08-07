#!/bin/bash

#
# RR-Webbsidan - Codespaces Development Environment Starter
# Använd denna för att starta den lokala utvecklingsmiljön
#

set -e

# Färger för output
CYAN='\033[0;36m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
CONTAINER_NAME="rr-webbsidan-dev"
PORT="8080"

echo -e "${CYAN}🚀 Startar RR-Webbsidan utvecklingsmiljö...${NC}"
echo ""

# Kontrollera om Docker/Podman är tillgängligt
if command -v docker &> /dev/null; then
    DOCKER_CMD="docker"
    USE_DOCKER=true
elif command -v podman &> /dev/null; then
    DOCKER_CMD="podman"
    USE_DOCKER=true
else
    USE_DOCKER=false
fi

if [ "$USE_DOCKER" = true ]; then
    echo -e "${CYAN}Använder: $DOCKER_CMD${NC}"
    echo ""

    # Stoppa befintlig container om den körs
    RUNNING=$($DOCKER_CMD ps --filter "name=$CONTAINER_NAME" --format "{{.Names}}" 2>/dev/null || true)
    if [ "$RUNNING" = "$CONTAINER_NAME" ]; then
        echo -e "${YELLOW}🛑 Stoppar befintlig container...${NC}"
        $DOCKER_CMD stop $CONTAINER_NAME > /dev/null 2>&1 || true
    fi

    # Ta bort befintlig container
    EXISTING=$($DOCKER_CMD ps -a --filter "name=$CONTAINER_NAME" --format "{{.Names}}" 2>/dev/null || true)
    if [ "$EXISTING" = "$CONTAINER_NAME" ]; then
        echo -e "${YELLOW}🗑️  Tar bort befintlig container...${NC}"
        $DOCKER_CMD rm $CONTAINER_NAME > /dev/null 2>&1 || true
    fi

    # Bygg imagen
    echo -e "${CYAN}🔨 Bygger Docker-imagen...${NC}"
    if $DOCKER_CMD build -t rr-webbsidan "$PROJECT_ROOT" > /dev/null 2>&1; then
        echo -e "${GREEN}✅ Imagen byggd framgångsrikt${NC}"
    else
        echo -e "${RED}❌ Byggfel! Kontrollera Dockerfile.${NC}"
        exit 1
    fi

    # Starta containern
    echo -e "${CYAN}🐳 Startar container...${NC}"
    $DOCKER_CMD run -d \
        --name $CONTAINER_NAME \
        -p $PORT:8080 \
        -v "$PROJECT_ROOT/src:/var/www/html" \
        -e PHP_CLI_SERVER_WORKERS=4 \
        rr-webbsidan \
        php -S 0.0.0.0:8080 -t /var/www/html > /dev/null

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ Container startad framgångsrikt!${NC}"
        echo ""
        echo -e "${CYAN}📍 Webbplatsen är tillgänglig på:${NC}"
        echo -e "${YELLOW}   http://localhost:$PORT${NC}"
        echo ""
        echo -e "${CYAN}💡 Kör tester med:${NC}"
        echo -e "${YELLOW}   cd tests && ./run-tests.sh local${NC}"
        echo ""
        echo -e "${CYAN}🛑 Stoppa miljön med:${NC}"
        echo -e "${YELLOW}   ./codespace-scripts/stop.sh${NC}"
    else
        echo -e "${RED}❌ Kunde inte starta container!${NC}"
        exit 1
    fi
else
    # Fallback: Använd PHP built-in server direkt
    echo -e "${YELLOW}⚠️  Docker/Podman inte tillgängligt. Använder PHP built-in server...${NC}"
    echo ""
    
    # Kontrollera om PHP är installerat
    if ! command -v php &> /dev/null; then
        echo -e "${RED}❌ PHP hittades inte!${NC}"
        echo "   Installera PHP eller använd Docker/Podman."
        exit 1
    fi
    
    # Kontrollera om det redan finns en process på porten och stoppa den
    if command -v fuser &> /dev/null && fuser $PORT/tcp &> /dev/null 2>&1; then
        echo -e "${YELLOW}⚠️  En process körs redan på port $PORT${NC}"
        echo -e "${YELLOW}🧹 Stoppar befintlig process...${NC}"
        
        pid=$(fuser $PORT/tcp 2>/dev/null || true)
        if [ -n "$pid" ]; then
            kill -9 $pid 2>/dev/null || true
            sleep 1
            echo -e "${GREEN}✅ Befintlig process stoppades${NC}"
        fi
    fi
    
    echo -e "${CYAN}🐘 Startar PHP server på port $PORT...${NC}"
    cd "$PROJECT_ROOT/src"
    
    echo -e "${GREEN}✅ PHP server startad!${NC}"
    echo ""
    echo -e "${CYAN}📍 Webbplatsen är tillgänglig på:${NC}"
    echo -e "${YELLOW}   http://localhost:$PORT${NC}"
    echo ""
    echo -e "${CYAN}💡 Kör tester med (i annat terminalfönster):${NC}"
    echo -e "${YELLOW}   cd tests && ./run-tests.sh local${NC}"
    echo ""
    echo -e "${CYAN}🛑 Stoppa servern i ett annat terminalfönster med:${NC}"
    echo -e "${YELLOW}   bash ./codespace-scripts/stop.sh $PORT${NC}"
    echo ""
    echo -e "${CYAN}Eller: Ctrl+C här${NC}"
    echo ""
    
    php -S 0.0.0.0:$PORT
fi
