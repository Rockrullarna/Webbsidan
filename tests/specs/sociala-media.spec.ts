import { test, expect } from '@playwright/test';

test('sociala medier page shows redesigned content and instagram feed hook', async ({ page }) => {
  await page.goto('/sociala-media/', { waitUntil: 'domcontentloaded' });

  await expect(page.getByRole('heading', { level: 1, name: /följ våra senaste uppdateringar/i })).toBeVisible();
  await expect(page.getByRole('heading', { level: 2, name: /det här hittar du här/i })).toBeVisible();
  await expect(page.locator('.rr-social-platform-card')).toHaveCount(3);
  await expect(page.locator('#rr-instagram-feed')).toBeVisible();
  await expect(page.getByRole('link', { name: /instagram\.com\/rockrullarna/i })).toBeVisible();
});
