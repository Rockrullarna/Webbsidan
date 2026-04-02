import { test, expect, Page, Locator } from '@playwright/test';

const viewports = [
  { name: 'desktop', width: 1280, height: 720 },
  { name: 'mobil', width: 375, height: 812 },
];

const themes = ['light', 'dark'] as const;

async function applyTheme(page: Page, theme: 'light' | 'dark'): Promise<void> {
  await page.evaluate((selectedTheme) => {
    localStorage.setItem('theme', selectedTheme);
    document.documentElement.setAttribute('data-bs-theme', selectedTheme);
  }, theme);
}

async function expectHorizontalFit(locator: Locator, viewportWidth: number): Promise<void> {
  const box = await locator.boundingBox();

  expect(box).not.toBeNull();
  expect(box!.x).toBeGreaterThanOrEqual(0);
  expect(box!.x + box!.width).toBeLessThanOrEqual(viewportWidth + 1);
}

async function openForeningenMenu(page: Page, viewportName: string): Promise<void> {
  if (viewportName === 'mobil') {
    await page.getByRole('button', { name: 'Visa menyn' }).click();
    await expect(page.locator('#navbar-content')).toBeVisible();
  }

  await page.getByRole('link', { name: 'Föreningen' }).click();
  await expect(page.locator('li.nav-item.dropdown >> ul.dropdown-menu').filter({ has: page.getByRole('link', { name: 'Föreningen' }) }).first()).toBeVisible();
}

async function openStyrandeDokumentSubmenu(page: Page): Promise<void> {
  await page.locator('a.dropdown-item.dropdown-toggle', { hasText: 'Styrande dokument' }).click();
  await expect(page.getByRole('link', { name: 'Våra styrande dokument' })).toBeVisible();
}

test.describe('Navbar visual navigation', () => {
  for (const theme of themes) {
    for (const viewport of viewports) {
      test(`Föreningen -> Styrande dokument - ${theme} - ${viewport.name}`, async ({ page }) => {
        await page.setViewportSize({ width: viewport.width, height: viewport.height });

        const response = await page.goto('/foreningen/', { waitUntil: 'domcontentloaded' });

        if (response?.status() === 404) {
          test.skip();
          return;
        }

        await page.locator('nav.navbar').waitFor();
        await applyTheme(page, theme);
        await page.evaluate(() => window.scrollTo(0, 0));

        await openForeningenMenu(page, viewport.name);
        await openStyrandeDokumentSubmenu(page);

        const navRoot = page.locator('#navbar-content');
        const dropdownMenus = page.locator('#navbar-content ul.dropdown-menu:visible');

        await expect(navRoot).toBeVisible();
        await expectHorizontalFit(navRoot, viewport.width);

        const visibleMenuCount = await dropdownMenus.count();
        for (let index = 0; index < visibleMenuCount; index += 1) {
          await expectHorizontalFit(dropdownMenus.nth(index), viewport.width);
        }

        const pageScrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
        expect(pageScrollWidth).toBeLessThanOrEqual(viewport.width + 1);

        await expect(page).toHaveScreenshot(
          `navbar-foreningen-styrande-dokument-${theme}-${viewport.name}.png`,
          {
            animations: 'disabled',
          }
        );

        await page.getByRole('link', { name: 'Våra styrande dokument' }).click();
        await expect(page).toHaveURL(/\/foreningen\/styrande-dokument\/?$/);
        await expect(page.locator('main')).toBeVisible();
      });
    }
  }
});