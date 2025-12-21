#!/bin/bash

#
# RR-Webbsidan - Playwright Test Runner
# Används i Codespaces eller Linux/macOS miljöer
#

set -e

# Färger för output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Standardvärden
BASE_URL="${BASE_URL:-http://localhost:8080}"
TEST_TYPE="all"

# Hjälpfunktion
show_help() {
    echo ""
    echo -e "${CYAN}RR-Webbsidan - Playwright Test Runner${NC}"
    echo "======================================"
    echo ""
    echo "Användning: ./run-tests.sh [KOMMANDO] [ALTERNATIV]"
    echo ""
    echo "Kommandon:"
    echo "  install       Installera dependencies och Playwright"
    echo "  local         Kör tester mot localhost:8080"
    echo "  prod          Kör tester mot rockrullarna.se"
    echo "  links         Kör endast länkvalidering"
    echo "  crawl         Kör full webbplatscrawl"
    echo "  report        Visa HTML-rapport"
    echo "  help          Visa denna hjälp"
    echo ""
    echo "Alternativ:"
    echo "  --url URL     Ange egen bas-URL"
    echo ""
    echo "Exempel:"
    echo "  ./run-tests.sh install          # Installera först"
    echo "  ./run-tests.sh local            # Testa mot localhost"
    echo "  ./run-tests.sh prod             # Testa mot produktion"
    echo "  ./run-tests.sh links --url https://example.com"
    echo ""
}

# Installera dependencies
install_deps() {
    echo -e "${CYAN}📦 Installerar dependencies...${NC}"
    
    # Kontrollera att vi är i rätt mapp
    SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
    cd "$SCRIPT_DIR"
    
    # Installera npm-paket
    npm install
    
    # Installera Playwright browsers
    echo -e "${CYAN}🌐 Installerar Playwright browsers...${NC}"
    npx playwright install chromium
    
    echo -e "${GREEN}✅ Installation klar!${NC}"
}

# Kör tester
run_tests() {
    local test_file="$1"
    
    SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
    cd "$SCRIPT_DIR"
    
    echo ""
    echo -e "${CYAN}🧪 Kör tester mot: ${YELLOW}$BASE_URL${NC}"
    echo ""
    
    if [ -n "$test_file" ]; then
        BASE_URL="$BASE_URL" npx playwright test "$test_file"
    else
        BASE_URL="$BASE_URL" npx playwright test
    fi
}

# Visa rapport
show_report() {
    SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
    cd "$SCRIPT_DIR"
    
    echo -e "${CYAN}📊 Öppnar testrapport...${NC}"
    npx playwright show-report
}

# Hantera argument
while [[ $# -gt 0 ]]; do
    case $1 in
        install)
            install_deps
            exit 0
            ;;
        local)
            BASE_URL="http://localhost:8080"
            shift
            ;;
        prod)
            BASE_URL="https://rockrullarna.se"
            shift
            ;;
        links)
            TEST_TYPE="links"
            shift
            ;;
        crawl)
            TEST_TYPE="crawl"
            shift
            ;;
        report)
            show_report
            exit 0
            ;;
        help|--help|-h)
            show_help
            exit 0
            ;;
        --url)
            BASE_URL="$2"
            shift 2
            ;;
        *)
            echo -e "${RED}❌ Okänt kommando: $1${NC}"
            show_help
            exit 1
            ;;
    esac
done

# Kontrollera att dependencies är installerade
if [ ! -d "node_modules" ]; then
    echo -e "${YELLOW}⚠️  Dependencies saknas. Kör './run-tests.sh install' först.${NC}"
    exit 1
fi

# Kör rätt testsvit
case $TEST_TYPE in
    links)
        run_tests "link-checker"
        ;;
    crawl)
        run_tests "full-crawl"
        ;;
    all)
        run_tests
        ;;
esac

echo ""
echo -e "${GREEN}✅ Tester klara!${NC}"
echo -e "${CYAN}💡 Kör './run-tests.sh report' för att se detaljerad rapport${NC}"
