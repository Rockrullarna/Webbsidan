import { test, expect, Page } from '@playwright/test';

/**
 * Visual regression-tester för RR-Webbsidan
 *
 * Testar viktiga sidor mot referens-screenshots (sparade i tests/snapshots/).
 * Kombinationer: ljust/mörkt tema × desktop/mobil-viewport.
 *
 * Kör för att uppdatera referens-screenshots (t.ex. efter avsiktliga designändringar):
 *   npx playwright test visual-regression --update-snapshots
 *
 * Lägg till en ny sida i testet:
 *   Lägg till ett nytt objekt i 'pages'-arrayen nedan, med ett unikt 'name' och korrekt 'path'.
 */

// ─── Sidor att testa ─────────────────────────────────────────────────────────
const pages = [
  { name: 'startsida',            path: '/' },
  { name: 'aktivitetskalender',   path: '/aktivitetskalender/' },
  { name: 'danskurser',           path: '/danskurser/' },
  { name: 'avanmalan',            path: '/danskurser/avanmalan/' },
  { name: 'betalning',            path: '/danskurser/betalning/' },
  { name: 'kursoversikt',         path: '/danskurser/kursoversikt/' },
  { name: 'foreningen',           path: '/foreningen/' },
  { name: 'styrande-dokument',    path: '/foreningen/styrande-dokument/' },
  { name: 'organisation',         path: '/foreningen/organisation/' },
  { name: 'moten-och-protokoll',  path: '/foreningen/moten-och-protokoll/' },
  { name: 'kontakt',              path: '/kontakt/' },
];

// ─── Viewports att testa ─────────────────────────────────────────────────────
const viewports = [
  { name: 'desktop', width: 1280, height: 720 },
  { name: 'mobil',   width: 375,  height: 812 },
];

// ─── Teman att testa ─────────────────────────────────────────────────────────
const themes = ['light', 'dark'] as const;

/**
 * Applicerar Bootstrap-tema (ljust eller mörkt) på sidan.
 * Skriver till localStorage och sätter data-bs-theme-attributet direkt
 * så att temabyte sker utan om-laddning.
 */
async function applyTheme(page: Page, theme: 'light' | 'dark'): Promise<void> {
  await page.evaluate((t) => {
    localStorage.setItem('theme', t);
    document.documentElement.setAttribute('data-bs-theme', t);
  }, theme);
}

/**
 * Väntar in att sidan blivit visuellt stabil innan screenshot tas.
 * Fokus ligger på att bilder ska vara laddade och att DOM:en ska ha hunnit sätta sig.
 */
async function waitForVisualReadiness(page: Page): Promise<void> {
  await page.waitForLoadState('load');

  try {
    await page.waitForLoadState('networkidle', { timeout: 10000 });
  } catch {
    // En del sidor kan ha bakgrundsanrop eller tredjepartsskript som aldrig blir helt idle.
  }

  await page.waitForTimeout(500);

  await page.waitForFunction(() => {
    const images = Array.from(document.images);

    if (images.length === 0) {
      return true;
    }

    return images.every((image) => image.complete && image.naturalWidth > 0);
  }, { timeout: 10000 });

  await page.waitForTimeout(250);
}

// ─── Generera tester för alla kombinationer ───────────────────────────────────
test.describe('Visuell regression', () => {
  for (const { name: pageName, path: pagePath } of pages) {
    for (const theme of themes) {
      for (const { name: viewportName, width, height } of viewports) {
        test(`${pageName} – ${theme} – ${viewportName}`, async ({ page }) => {
          await page.setViewportSize({ width, height });

          const response = await page.goto(pagePath, { waitUntil: 'domcontentloaded' });

          // Hoppa över om sidan inte finns (t.ex. i en delmiljö)
          if (response?.status() === 404) {
            test.skip();
            return;
          }

          // Applicera tema efter laddning
          await applyTheme(page, theme);
          await waitForVisualReadiness(page);

          // Jämför mot referens-screenshot (fullPage = hela sidan, inte bara viewport).
          // animations: 'disabled' fryser alla CSS-övergångar i slutläget före skärmdump.
          await expect(page).toHaveScreenshot(
            `${pageName}-${theme}-${viewportName}.png`,
            {
              fullPage: true,
              animations: 'disabled',
            }
          );
        });
      }
    }
  }
});
