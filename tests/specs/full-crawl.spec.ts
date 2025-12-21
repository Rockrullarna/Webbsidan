import { test, expect, Page } from '@playwright/test';

/**
 * Crawlar hela webbplatsen och samlar alla unika interna länkar
 */
async function crawlSite(page: Page, baseURL: string, maxPages: number = 100): Promise<Map<string, number>> {
  const visited = new Map<string, number>();
  const toVisit = new Set<string>(['/']);
  
  while (toVisit.size > 0 && visited.size < maxPages) {
    const url = toVisit.values().next().value;
    toVisit.delete(url);
    
    if (visited.has(url)) continue;
    
    const fullUrl = `${baseURL}${url}`;
    
    try {
      const response = await page.goto(fullUrl, { waitUntil: 'domcontentloaded', timeout: 30000 });
      const status = response?.status() || 0;
      visited.set(url, status);
      
      if (status >= 400) continue;
      
      // Samla nya länkar från sidan
      const links = await page.locator('a[href]').all();
      
      for (const link of links) {
        const href = await link.getAttribute('href');
        if (!href) continue;
        
        // Skippa vissa typer
        if (href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
          continue;
        }
        
        let normalizedHref = href;
        
        // Konvertera till relativ URL
        if (href.startsWith('/') && !href.startsWith('//')) {
          normalizedHref = href;
        } else if (href.includes('rockrullarna.se')) {
          try {
            const urlObj = new URL(href);
            normalizedHref = urlObj.pathname;
          } catch {
            continue;
          }
        } else if (href.startsWith('http')) {
          continue; // Extern länk
        } else {
          continue;
        }
        
        // Normalisera sökvägen
        if (!normalizedHref.endsWith('/') && !normalizedHref.includes('.')) {
          normalizedHref += '/';
        }
        
        if (!visited.has(normalizedHref) && !toVisit.has(normalizedHref)) {
          toVisit.add(normalizedHref);
        }
      }
    } catch (error) {
      visited.set(url, 0);
    }
  }
  
  return visited;
}

test.describe('Full webbplatscrawl', () => {
  
  test('Crawla hela webbplatsen och rapportera trasiga länkar', async ({ page, baseURL }) => {
    test.setTimeout(300000); // 5 minuter timeout
    
    console.log(`\n🔍 Startar crawl av ${baseURL}...\n`);
    
    const results = await crawlSite(page, baseURL!, 200);
    
    const workingPages: string[] = [];
    const brokenPages: { url: string; status: number }[] = [];
    
    results.forEach((status, url) => {
      if (status >= 400 || status === 0) {
        brokenPages.push({ url, status });
      } else {
        workingPages.push(url);
      }
    });
    
    console.log(`\n📊 Crawl-resultat:`);
    console.log(`   ✅ Fungerande sidor: ${workingPages.length}`);
    console.log(`   ❌ Trasiga sidor: ${brokenPages.length}`);
    console.log(`   📄 Totalt crawlade: ${results.size}\n`);
    
    if (brokenPages.length > 0) {
      console.log('❌ Trasiga sidor:');
      brokenPages.forEach(({ url, status }) => {
        console.log(`   - ${url} (HTTP ${status})`);
      });
      console.log('');
    }
    
    if (workingPages.length > 0) {
      console.log('✅ Fungerande sidor:');
      workingPages.slice(0, 20).forEach(url => {
        console.log(`   - ${url}`);
      });
      if (workingPages.length > 20) {
        console.log(`   ... och ${workingPages.length - 20} fler`);
      }
      console.log('');
    }
    
    expect(brokenPages, `Hittade ${brokenPages.length} trasiga sidor`).toHaveLength(0);
  });
});
