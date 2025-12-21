import { test, expect, Page } from '@playwright/test';

/**
 * Samlar alla unika länkar från en sida
 */
async function collectLinks(page: Page): Promise<Set<string>> {
  const links = await page.locator('a[href]').all();
  const hrefs = new Set<string>();
  
  for (const link of links) {
    const href = await link.getAttribute('href');
    if (href) {
      hrefs.add(href);
    }
  }
  
  return hrefs;
}

/**
 * Kontrollerar om en länk är intern (samma domän)
 */
function isInternalLink(href: string, baseURL: string): boolean {
  if (href.startsWith('/') && !href.startsWith('//')) {
    return true;
  }
  if (href.startsWith('#')) {
    return false; // Ankare, skippa
  }
  if (href.startsWith('mailto:') || href.startsWith('tel:')) {
    return false;
  }
  try {
    const url = new URL(href);
    const base = new URL(baseURL);
    return url.hostname === base.hostname || url.hostname === 'rockrullarna.se' || url.hostname === 'www.rockrullarna.se';
  } catch {
    return false;
  }
}

/**
 * Normaliserar en länk till en full URL
 */
function normalizeLink(href: string, baseURL: string): string {
  if (href.startsWith('/')) {
    return `${baseURL}${href}`;
  }
  if (href.startsWith('http')) {
    // Ersätt produktions-URL med test-URL om vi kör lokalt
    if (baseURL.includes('localhost')) {
      return href
        .replace('https://rockrullarna.se', baseURL)
        .replace('https://www.rockrullarna.se', baseURL)
        .replace('http://rockrullarna.se', baseURL)
        .replace('http://www.rockrullarna.se', baseURL);
    }
  }
  return href;
}

// Sidor att börja crawla från
const startPages = [
  '/',
  '/danskurser/',
  '/foreningen/',
  '/kontakt/',
  '/bli-medlem/',
  '/aktivitetskalender/',
];

test.describe('Länkvalidering', () => {
  
  test('Startsidan laddas korrekt', async ({ page, baseURL }) => {
    const response = await page.goto('/');
    expect(response?.status()).toBeLessThan(400);
    await expect(page.locator('body')).toBeVisible();
  });

  test('Alla navigeringslänkar i menyn fungerar', async ({ page, baseURL }) => {
    await page.goto('/');
    
    // Hämta alla länkar i navigeringsmenyn
    const navLinks = await page.locator('nav a[href]').all();
    const checkedLinks = new Set<string>();
    const brokenLinks: { href: string; status: number; text: string }[] = [];
    
    for (const link of navLinks) {
      const href = await link.getAttribute('href');
      const text = await link.textContent();
      
      if (!href || checkedLinks.has(href)) continue;
      if (href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) continue;
      
      checkedLinks.add(href);
      
      const normalizedHref = normalizeLink(href, baseURL!);
      
      try {
        const response = await page.request.get(normalizedHref);
        if (response.status() >= 400) {
          brokenLinks.push({ href, status: response.status(), text: text || '' });
        }
      } catch (error) {
        brokenLinks.push({ href, status: 0, text: text || '' });
      }
    }
    
    if (brokenLinks.length > 0) {
      console.log('Trasiga navigeringslänkar:');
      brokenLinks.forEach(link => {
        console.log(`  - ${link.href} (${link.status}) - "${link.text}"`);
      });
    }
    
    expect(brokenLinks, `Hittade ${brokenLinks.length} trasiga navigeringslänkar`).toHaveLength(0);
  });

  for (const startPage of startPages) {
    test(`Alla länkar på ${startPage} fungerar`, async ({ page, baseURL }) => {
      const response = await page.goto(startPage);
      
      // Skippa om sidan inte finns
      if (response?.status() === 404) {
        test.skip();
        return;
      }
      
      const links = await collectLinks(page);
      const brokenLinks: { href: string; status: number }[] = [];
      const checkedLinks = new Set<string>();
      
      for (const href of links) {
        // Skippa vissa typer av länkar
        if (href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
          continue;
        }
        
        // Skippa externa länkar (inte rockrullarna.se)
        if (!isInternalLink(href, baseURL!)) {
          continue;
        }
        
        const normalizedHref = normalizeLink(href, baseURL!);
        
        if (checkedLinks.has(normalizedHref)) continue;
        checkedLinks.add(normalizedHref);
        
        try {
          const response = await page.request.get(normalizedHref);
          if (response.status() >= 400) {
            brokenLinks.push({ href: normalizedHref, status: response.status() });
          }
        } catch (error) {
          brokenLinks.push({ href: normalizedHref, status: 0 });
        }
      }
      
      if (brokenLinks.length > 0) {
        console.log(`Trasiga länkar på ${startPage}:`);
        brokenLinks.forEach(link => {
          console.log(`  - ${link.href} (${link.status})`);
        });
      }
      
      expect(brokenLinks, `Hittade ${brokenLinks.length} trasiga länkar på ${startPage}`).toHaveLength(0);
    });
  }
});
