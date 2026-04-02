import { test, expect, Page, Locator } from '@playwright/test';

const viewports = [
  { name: 'desktop', width: 1280, height: 720 },
  { name: 'mobil', width: 375, height: 812 },
];

const themes = ['light', 'dark'] as const;

type NavbarScenario = {
  name: string;
  screenshotName: string;
  targetUrl: RegExp;
  openMenus: (page: Page) => Promise<void>;
  clickTarget: (page: Page) => Promise<void>;
};

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

async function openNavbar(page: Page, viewportName: string): Promise<void> {
  if (viewportName === 'mobil') {
    await page.getByRole('button', { name: 'Visa menyn' }).click();
    await expect(page.locator('#navbar-content')).toBeVisible();
  }
}

function topLevelDropdown(page: Page, label: string): Locator {
  return page.locator('#navbar-content .navbar-nav > .nav-item.dropdown > a.nav-link.dropdown-toggle', {
    hasText: label,
  }).first();
}

function nestedDropdown(page: Page, label: string): Locator {
  return page.locator('#navbar-content a.dropdown-item.dropdown-toggle', {
    hasText: label,
  }).first();
}

function dropdownItem(page: Page, href: string): Locator {
  return page.locator(`#navbar-content a.dropdown-item[href="${href}"]`).first();
}

async function openTopLevelMenu(page: Page, label: string, expectedItemHref: string): Promise<void> {
  await topLevelDropdown(page, label).click();
  await expect(dropdownItem(page, expectedItemHref)).toBeVisible();
}

async function openForeningenMenu(page: Page): Promise<void> {
  await openTopLevelMenu(page, 'Föreningen', '/foreningen');
}

async function openKontaktaMenu(page: Page): Promise<void> {
  await openTopLevelMenu(page, 'Kontakta', '/kontakt');
}

async function openNestedMenu(page: Page, label: string, expectedItemHref: string): Promise<void> {
  await nestedDropdown(page, label).click();
  await expect(dropdownItem(page, expectedItemHref)).toBeVisible();
}

const scenarios: NavbarScenario[] = [
  {
    name: 'Danskurser',
    screenshotName: 'navbar-danskurser',
    targetUrl: /\/danskurser\/?$/,
    openMenus: async (page) => {
      await openTopLevelMenu(page, 'Danskurser', '/danskurser');
    },
    clickTarget: async (page) => {
      await dropdownItem(page, '/danskurser').click();
    },
  },
  {
    name: 'Tävlingsdans',
    screenshotName: 'navbar-tavlingsdans',
    targetUrl: /\/tavlingsdans\/?$/,
    openMenus: async (page) => {
      await openTopLevelMenu(page, 'Tävlingsdans', '/tavlingsdans');
    },
    clickTarget: async (page) => {
      await dropdownItem(page, '/tavlingsdans').click();
    },
  },
  {
    name: 'Föreningen -> Styrande dokument',
    screenshotName: 'navbar-foreningen-styrande-dokument',
    targetUrl: /\/foreningen\/styrande-dokument\/?$/,
    openMenus: async (page) => {
      await openForeningenMenu(page);
      await openNestedMenu(page, 'Styrande dokument', '/foreningen/styrande-dokument');
    },
    clickTarget: async (page) => {
      await dropdownItem(page, '/foreningen/styrande-dokument').click();
    },
  },
  {
    name: 'Föreningen -> Möten och protokoll',
    screenshotName: 'navbar-foreningen-moten-och-protokoll',
    targetUrl: /\/foreningen\/moten-och-protokoll\/?$/,
    openMenus: async (page) => {
      await openForeningenMenu(page);
      await openNestedMenu(page, 'Möten och protokoll', '/foreningen/moten-och-protokoll');
    },
    clickTarget: async (page) => {
      await dropdownItem(page, '/foreningen/moten-och-protokoll').click();
    },
  },
  {
    name: 'Föreningen -> Organisation',
    screenshotName: 'navbar-foreningen-organisation',
    targetUrl: /\/foreningen\/organisation\/?$/,
    openMenus: async (page) => {
      await openForeningenMenu(page);
      await openNestedMenu(page, 'Organisation', '/foreningen/organisation');
    },
    clickTarget: async (page) => {
      await dropdownItem(page, '/foreningen/organisation').click();
    },
  },
  {
    name: 'Kontakta -> Frågor och svar',
    screenshotName: 'navbar-kontakta-fragor-och-svar',
    targetUrl: /\/kontakt\/fragor-och-svar\/?$/,
    openMenus: async (page) => {
      await openKontaktaMenu(page);
      await openNestedMenu(page, 'Frågor och Svar', '/kontakt/fragor-och-svar');
    },
    clickTarget: async (page) => {
      await dropdownItem(page, '/kontakt/fragor-och-svar').click();
    },
  },
];

test.describe('Navbar visual navigation', () => {
  for (const scenario of scenarios) {
    for (const theme of themes) {
      for (const viewport of viewports) {
        test(`${scenario.name} - ${theme} - ${viewport.name}`, async ({ page }) => {
          await page.setViewportSize({ width: viewport.width, height: viewport.height });

          const response = await page.goto('/', { waitUntil: 'domcontentloaded' });

          if (response?.status() === 404) {
            test.skip();
            return;
          }

          await page.locator('nav.navbar').waitFor();
          await applyTheme(page, theme);
          await page.evaluate(() => window.scrollTo(0, 0));

          await openNavbar(page, viewport.name);
          await scenario.openMenus(page);

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
            `${scenario.screenshotName}-${theme}-${viewport.name}.png`,
            {
              animations: 'disabled',
            }
          );

          await scenario.clickTarget(page);
          await expect(page).toHaveURL(scenario.targetUrl);
          await expect(page.locator('main')).toBeVisible();
        });
      }
    }
  }
});