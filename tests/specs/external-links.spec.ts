import { test, expect } from '@playwright/test';

/**
 * Kontrollerar att externa länkar returnerar OK status
 * OBS: Kör inte detta för ofta - kan trigga rate limiting
 */

const externalLinksToCheck = [
  'https://www.facebook.com/dansklubbenrockrullarna',
  'https://www.instagram.com/rockrullansen/',
  'https://www.tiktok.com/@dansklubben_rockrullarna',
  'https://www.youtube.com/@dansklubbenrockrullarna',
  'https://dans.se/',
  'https://www.epassi.se/',
];

test.describe('Externa länkar', () => {
  
  test.skip('Verifiera att viktiga externa länkar fungerar', async ({ page }) => {
    const brokenLinks: { url: string; status: number }[] = [];
    
    for (const url of externalLinksToCheck) {
      try {
        const response = await page.request.get(url, { timeout: 10000 });
        if (response.status() >= 400) {
          brokenLinks.push({ url, status: response.status() });
        } else {
          console.log(`✅ ${url} - OK (${response.status()})`);
        }
      } catch (error) {
        brokenLinks.push({ url, status: 0 });
        console.log(`❌ ${url} - Fel`);
      }
    }
    
    expect(brokenLinks).toHaveLength(0);
  });
});
