import { test, expect } from '@playwright/test';

/**
 * Test to verify that pages load correctly with query parameters from Facebook links
 * Issue: Bug: Cannot navigate to pages from Facebook links with query-strings (e.g. fbclid)
 */

// Representative Facebook click ID for testing (case-sensitive)
const SAMPLE_FBCLID = 'IwY2xjawO2pa9leHRuA2FlbQIxMABicmlkETFsUnZPMEFFQlN4RmEwU1VVc3J0YwZhcHBfaWQ';

test.describe('Facebook link with query-string', () => {
  test('FAQ page loads correctly with fbclid parameter', async ({ page, baseURL }) => {
    // Simulate a Facebook link with fbclid parameter (case-sensitive)
    const testUrl = `${baseURL}/kontakt/fragor-och-svar/?fbclid=${SAMPLE_FBCLID}`;
    
    const response = await page.goto(testUrl);
    
    // Verify that the page loads correctly (200 OK)
    expect(response?.status()).toBe(200);
    
    // Verify that we are not redirected (fbclid should keep its case)
    const finalUrl = page.url();
    expect(finalUrl).toContain(`fbclid=${SAMPLE_FBCLID}`);
    
    // Verify that page content loads (not a black screen)
    await expect(page.locator('h1')).toContainText('Vanliga frågor och svar');
    
    // Verify title via page.title() instead of locator
    const title = await page.title();
    expect(title).toContain('Frågor och svar');
  });

  test('Homepage loads correctly with fbclid and other parameters', async ({ page, baseURL }) => {
    const testUrl = `${baseURL}/?fbclid=TestValue123&utm_source=facebook&utm_medium=social`;
    
    const response = await page.goto(testUrl);
    expect(response?.status()).toBe(200);
    
    // Verify that query parameters keep their case
    const finalUrl = page.url();
    expect(finalUrl).toContain('fbclid=TestValue123');
    expect(finalUrl).toContain('utm_source=facebook');
    
    // Verify that page content loads
    await expect(page.locator('h1')).toContainText('Dansklubben Rockrullarna');
  });

  test.skip('Uppercase in path redirects but query-string keeps case', async ({ page, baseURL }) => {
    // SKIP: PHP server's filesystem is case-insensitive on this platform
    // This test works in production with Apache on case-sensitive system
    
    // Test with uppercase path but case-sensitive query parameter
    const testUrl = `${baseURL}/Kontakt/Fragor-Och-Svar/?fbclid=TestValue123`;
    
    const response = await page.goto(testUrl);
    expect(response?.status()).toBe(200);
    
    // Path should be lowercase but query should keep its case
    const finalUrl = page.url();
    expect(finalUrl).toContain('/kontakt/fragor-och-svar/');
    expect(finalUrl).toContain('fbclid=TestValue123'); // Case preserved
  });
});
