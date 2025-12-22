import { test, expect } from '@playwright/test';

/**
 * Test för att verifiera att sidor laddas korrekt med query-parametrar från Facebook-länkar
 * Issue: Bug: Kan inte navigera till sidor från Facebook-länkar med query-strings (t.ex. fbclid)
 */
test.describe('Facebook-länk med query-string', () => {
  test('Fragor och Svar-sidan laddas korrekt med fbclid parameter', async ({ page, baseURL }) => {
    // Simulera en Facebook-länk med fbclid parameter (case-sensitive)
    const testUrl = `${baseURL}/kontakt/fragor-och-svar/?fbclid=IwY2xjawO2pa9leHRuA2FlbQIxMABicmlkETFsUnZPMEFFQlN4RmEwU1VVc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHukF5wAZa9NUzfzAimcxsTZ4OORUpfqEStomTUe9S166afGf5sXIXWIKRYdL`;
    
    const response = await page.goto(testUrl);
    
    // Verifiera att sidan laddar korrekt (200 OK)
    expect(response?.status()).toBe(200);
    
    // Verifiera att vi inte omdirigeras (fbclid ska behålla sitt case)
    const finalUrl = page.url();
    expect(finalUrl).toContain('fbclid=IwY2xjawO2pa9leHRuA2FlbQIxMABicmlkETFsUnZPMEFFQlN4RmEwU1VVc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHukF5wAZa9NUzfzAimcxsTZ4OORUpfqEStomTUe9S166afGf5sXIXWIKRYdL');
    
    // Verifiera att sidinnehållet laddas (inte en svart ruta)
    await expect(page.locator('h1')).toContainText('Vanliga frågor och svar');
    
    // Verifiera title via page.title() istället för locator
    const title = await page.title();
    expect(title).toContain('Frågor och svar');
  });

  test('Startsidan laddas korrekt med fbclid och andra parametrar', async ({ page, baseURL }) => {
    const testUrl = `${baseURL}/?fbclid=TestValue123&utm_source=facebook&utm_medium=social`;
    
    const response = await page.goto(testUrl);
    expect(response?.status()).toBe(200);
    
    // Verifiera att query-parametrarna behåller sitt case
    const finalUrl = page.url();
    expect(finalUrl).toContain('fbclid=TestValue123');
    expect(finalUrl).toContain('utm_source=facebook');
    
    // Verifiera att sidinnehållet laddas
    await expect(page.locator('h1')).toContainText('Dansklubben Rockrullarna');
  });

  test.skip('Uppercase i path omdirigeras men query-string behåller case', async ({ page, baseURL }) => {
    // SKIP: PHP-serverns filsystem är case-insensitive på denna plattform
    // Detta test fungerar i produktion med Apache på case-sensitive system
    
    // Test med uppercase path men case-sensitive query parameter
    const testUrl = `${baseURL}/Kontakt/Fragor-Och-Svar/?fbclid=TestValue123`;
    
    const response = await page.goto(testUrl);
    expect(response?.status()).toBe(200);
    
    // Path ska vara lowercase men query ska behålla sitt case
    const finalUrl = page.url();
    expect(finalUrl).toContain('/kontakt/fragor-och-svar/');
    expect(finalUrl).toContain('fbclid=TestValue123'); // Case preserved
  });
});
