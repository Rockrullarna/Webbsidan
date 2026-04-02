import { defineConfig, devices } from '@playwright/test';

declare const process: {
  env: Record<string, string | undefined>;
};

const baseURL = process.env.BASE_URL || 'http://localhost:8080';

export default defineConfig({
  testDir: './specs',
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 2 : 0,
  workers: process.env.CI ? 1 : undefined,
  reporter: [
    ['html'],
    ['list']
  ],
  use: {
    baseURL: baseURL,
    trace: 'on-first-retry',
    screenshot: 'only-on-failure',
  },

  // ── Konfiguration för visuella regression-tester ────────────────────────────
  snapshotDir: './snapshots',
  snapshotPathTemplate: '{snapshotDir}/{testFileName}/{arg}{ext}',
  expect: {
    toHaveScreenshot: {
      // Tillåt upp till 2 % pixelskillnad för att undvika flaky tester
      // vid t.ex. subtil anti-aliasing-skillnad mellan körningar.
      maxDiffPixelRatio: 0.02,
    },
  },

  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },
  ],
  timeout: 60000,
});
