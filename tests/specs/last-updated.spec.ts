import { test, expect } from '@playwright/test';

const pages = [
  '/',
  '/kontakt/',
  '/foreningen/'
];

test.describe('Senast uppdaterad', () => {
  for (const path of pages) {
    test(`visas längst ned i main före footer på ${path}`, async ({ page }) => {
      await page.goto(path, { waitUntil: 'domcontentloaded' });

      const lastUpdated = page.locator('main > .rr-last-updated');

      await expect(lastUpdated).toBeVisible();
      await expect(lastUpdated).toContainText(/^Senast uppdaterad: \d{4}-\d{2}-\d{2} \d{2}:\d{2}$|^Senast uppdaterad: datum saknas$/);

      const isPlacedInsideMainBeforeFooter = await page.evaluate(() => {
        const main = document.querySelector('main');
        const footer = document.querySelector('footer');
        const lastUpdatedElement = main?.querySelector('.rr-last-updated');

        return Boolean(
          main &&
          footer &&
          lastUpdatedElement &&
          main.contains(lastUpdatedElement) &&
          (main.compareDocumentPosition(footer) & Node.DOCUMENT_POSITION_FOLLOWING) !== 0
        );
      });

      expect(isPlacedInsideMainBeforeFooter).toBe(true);
    });
  }
});
