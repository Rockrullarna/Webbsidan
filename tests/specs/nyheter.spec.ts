import { test, expect } from '@playwright/test';

test.describe('Nyheter', () => {
  test('Startsidan visar senaste nyheter med läs mer-länk', async ({ page }) => {
    const response = await page.goto('/');
    expect(response?.status()).toBeLessThan(400);
    await expect(page.locator('a[href="/nyheter/"]')).toHaveCount(1);
    await expect(page.locator('.rr-event-card--news')).toHaveCount(5);
  });

  test('Nyhetssidan laddar med filter', async ({ page }) => {
    const response = await page.goto('/nyheter/');
    expect(response?.status()).toBeLessThan(400);
    await expect(page.locator('h1')).toContainText('Nyheter');
    await expect(page.locator('form.rr-news-filter-form')).toBeVisible();
  });

  test('API levererar listor, kategori och enskild post', async ({ page }) => {
    const listResponse = await page.request.get('/api/posts');
    expect(listResponse.status()).toBe(200);
    const listPayload = await listResponse.json();
    expect(Array.isArray(listPayload.posts)).toBeTruthy();
    expect(listPayload.posts.length).toBeGreaterThan(0);

    const firstPost = listPayload.posts[0];
    expect(firstPost.slug).toBeTruthy();
    expect(firstPost.category).toBeTruthy();

    const singleResponse = await page.request.get(`/api/posts.php/${firstPost.slug}`);
    expect(singleResponse.status()).toBe(200);
    const singlePayload = await singleResponse.json();
    expect(singlePayload.post.slug).toBe(firstPost.slug);

    const categoryResponse = await page.request.get(`/api/posts.php/category/${encodeURIComponent(firstPost.category)}`);
    expect(categoryResponse.status()).toBe(200);
    const categoryPayload = await categoryResponse.json();
    expect(Array.isArray(categoryPayload.posts)).toBeTruthy();
  });

  test('Enskild nyhetssida visar innehåll och delningslänkar', async ({ page }) => {
    const response = await page.goto('/nyheter/post.php?slug=kursstart-hosttermin');
    expect(response?.status()).toBeLessThan(400);
    await expect(page.locator('.rr-news-post-content')).toBeVisible();
    await expect(page.locator('.rr-news-share-links a')).toHaveCount(3);
  });
});
