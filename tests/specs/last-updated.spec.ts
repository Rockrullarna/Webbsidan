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
      const footerAfterMain = page.locator('main + footer');

      await expect(lastUpdated).toBeVisible();
      await expect(footerAfterMain).toBeVisible();
      await expect(lastUpdated).toContainText(/^Senast uppdaterad: \d{4}-\d{2}-\d{2} \d{2}:\d{2}$|^Senast uppdaterad: datum saknas$/);
    });
  }
});
