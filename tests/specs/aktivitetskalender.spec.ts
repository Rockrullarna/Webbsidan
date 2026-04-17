import { test, expect, Page } from '@playwright/test';

function formatDate(offsetDays: number): string {
  const date = new Date();
  date.setHours(0, 0, 0, 0);
  date.setDate(date.getDate() + offsetDays);

  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');

  return `${year}-${month}-${day}`;
}

function offsetToWeekday(targetDay: number, weekShift = 0): number {
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const daysUntilWeekday = (targetDay - today.getDay() + 7) % 7;
  return daysUntilWeekday + weekShift * 7;
}

async function mockCalendarApi(page: Page, body: unknown): Promise<void> {
  await page.route('**/aktivitetskalender/data.php**', async (route) => {
    await route.fulfill({
      status: 200,
      contentType: 'application/json',
      body: JSON.stringify(body)
    });
  });
}

test('handles nested calendar API payloads', async ({ page }) => {
  await mockCalendarApi(page, {
    events: [
      {
        name: 'Fixture event from parsed schedule',
        start: `${formatDate(5)} 18:30:00`,
        end: `${formatDate(5)} 19:45:00`,
        location: 'Fixture Hall A',
        url: 'https://example.test/signup/fixture-a'
      },
      {
        name: 'Fixture follow-up event',
        start: `${formatDate(6)} 19:00:00`,
        end: `${formatDate(6)} 20:30:00`,
        location: 'Fixture Hall B',
        url: null
      },
      {
        name: 'Fixture event with booking link',
        start: `${formatDate(7)} 15:00:00`,
        end: `${formatDate(7)} 16:00:00`,
        location: 'Fixture Hall C',
        url: 'https://example.test/signup/direct-schedule'
      },
      {
        name: 'Fixture room split event',
        start: `${formatDate(8)} 18:00:00`,
        end: `${formatDate(8)} 20:00:00`,
        location: 'Lilla salen',
        url: null
      }
    ],
    debug: {
      cache: {
        status: 'fresh'
      }
    }
  });

  await page.goto('/aktivitetskalender/');

  const rows = page.locator('.rr-kal-table tbody tr');

  await expect(page.getByRole('table')).toBeVisible();
  await expect(rows).toHaveCount(4);
  await expect(page.getByText('Fixture event from parsed schedule')).toBeVisible();
  await expect(page.getByText('Fixture follow-up event')).toBeVisible();
  await expect(page.getByText('Fixture event with booking link')).toBeVisible();
  await expect(page.getByText('Fixture room split event')).toBeVisible();
  await expect(page.getByText('18:30–19:45')).toBeVisible();
  await expect(page.getByText('19:00–20:30')).toBeVisible();
  await expect(page.getByText('15:00–16:00')).toBeVisible();
  await expect(page.getByText('18:00–20:00')).toBeVisible();
  await expect(page.locator('.rr-kal-location-pill--lilla')).toBeVisible();
  await expect(page.getByRole('link', { name: 'Fixture event with booking link' })).toHaveAttribute('href', 'https://example.test/signup/direct-schedule');
  await expect(page.getByText('Inga kommande aktiviteter hittades för de närmaste dagarna.')).toHaveCount(0);
});

test('homepage limits calendar to 10 events', async ({ page }) => {
  const events = Array.from({ length: 15 }, (_, i) => ({
    name: `Fixture event ${i + 1}`,
    start: `${formatDate(i + 1)} 18:00:00`,
    end: `${formatDate(i + 1)} 19:00:00`,
    location: 'Fixture Hall',
    url: null
  }));

  await mockCalendarApi(page, { events });

  await page.goto('/');

  const rows = page.locator('.rr-kal-table tbody tr');
  await expect(rows).toHaveCount(10);
  await expect(page.getByRole('cell', { name: 'Fixture event 1 Fixture Hall' })).toBeVisible();
  await expect(page.getByRole('cell', { name: 'Fixture event 10 Fixture Hall' })).toBeVisible();
  await expect(page.getByRole('cell', { name: /Fixture event 11/ })).toHaveCount(0);
});

test('full calendar page shows all events beyond 10', async ({ page }) => {
  const events = Array.from({ length: 15 }, (_, i) => ({
    name: `Fixture event ${i + 1}`,
    start: `${formatDate(i + 1)} 18:00:00`,
    end: `${formatDate(i + 1)} 19:00:00`,
    location: 'Fixture Hall',
    url: null
  }));

  await mockCalendarApi(page, { events });

  await page.goto('/aktivitetskalender/');

  const rows = page.locator('.rr-kal-table tbody tr');
  await expect(rows).toHaveCount(15);
  await expect(page.getByText('Fixture event 15')).toBeVisible();
});

test('renders backend-expanded recurring occurrences', async ({ page }) => {
  await mockCalendarApi(page, [
    {
      name: 'Fixture ongoing series',
      start: `${formatDate(offsetToWeekday(1, 1))} 18:00:00`,
      end: `${formatDate(offsetToWeekday(1, 1))} 20:00:00`,
      location: 'Fixture Hall E',
      url: 'https://example.test/signup/ongoing-series'
    }
  ]);

  await page.goto('/aktivitetskalender/');

  await expect(page.locator('.rr-kal-table tbody tr')).toHaveCount(1);
  await expect(page.getByText('Fixture ongoing series')).toHaveCount(1);
  await expect(page.getByText('18:00–20:00')).toHaveCount(1);
  await expect(page.getByText('Fixture Hall E').first()).toBeVisible();
  await expect(page.getByRole('link', { name: 'Fixture ongoing series' }).first()).toHaveAttribute('href', 'https://example.test/signup/ongoing-series');
});
