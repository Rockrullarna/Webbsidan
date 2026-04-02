import { test, expect } from '@playwright/test';

/**
 * Kontrollerar att externa länkar returnerar OK status
 * OBS: Kör inte detta för ofta - kan trigga rate limiting
 */

const externalLinksToCheck = [
  'https://www.facebook.com/rockrullarna',
  'https://www.instagram.com/rockrullarna/',
  'https://www.tiktok.com/@dansklubbrockrullarna',
  'https://www.youtube.com/@dansklubbenrockrullarna',
  'https://dans.se/',
  'https://www.epassi.se/',
];

async function getExternalLinkStatus(url: string): Promise<number> {
  const response = await fetch(url, {
    redirect: 'follow',
  });

  return response.status;
}

test.describe('Externa länkar', () => {

  test('Verifiera att viktiga externa länkar fungerar', async () => {
    const brokenLinks: { url: string; status: number }[] = [];

    for (const url of externalLinksToCheck) {
      try {
        const status = await getExternalLinkStatus(url);
        if (status >= 400) {
          brokenLinks.push({ url, status });
        } else {
          console.log(`✅ ${url} - OK (${status})`);
        }
      } catch (error) {
        brokenLinks.push({ url, status: 0 });
        console.log(`❌ ${url} - Fel`);
      }
    }

    expect(brokenLinks).toHaveLength(0);
  });
});
