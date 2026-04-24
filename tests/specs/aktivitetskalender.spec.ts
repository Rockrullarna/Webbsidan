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

/** Returns an ISO date string that falls in October of the upcoming or current year
 *  within the 180-day window. If October of this year is already within 180 days,
 *  use that; otherwise use next year. We pick Oct 7 (always a few months ahead from
 *  typical spring test runs). */
function octoberDate(day = 7): string {
  const now = new Date();
  now.setHours(0, 0, 0, 0);
  const cutoff = new Date(now.getTime() + 180 * 24 * 60 * 60 * 1000);

  const thisYear = now.getFullYear();
  const candidate = new Date(thisYear, 9, day); // month 9 = October (0-indexed)
  const year = candidate > now && candidate <= cutoff ? thisYear : thisYear + 1;

  return `${year}-10-${String(day).padStart(2, '0')}`;
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

test('renders October events with correct autumn booking links', async ({ page }) => {
  const octDate = octoberDate(7);

  await mockCalendarApi(page, [
    {
      name: 'Fixture hösttermin kurs',
      start: `${octDate} 18:30:00`,
      end: `${octDate} 20:00:00`,
      location: 'Stora salen',
      url: 'https://example.test/signup/autumn-course'
    },
    {
      name: 'Fixture hösttermin utan länk',
      start: `${octDate} 19:00:00`,
      end: `${octDate} 21:00:00`,
      location: 'Lilla salen',
      url: null
    }
  ]);

  await page.goto('/aktivitetskalender/');

  const rows = page.locator('.rr-kal-table tbody tr');

  await expect(page.getByRole('table')).toBeVisible();
  await expect(rows).toHaveCount(2);
  await expect(page.getByText('Fixture hösttermin kurs')).toBeVisible();
  await expect(page.getByText('Fixture hösttermin utan länk')).toBeVisible();
  await expect(page.getByText('18:30–20:00')).toBeVisible();
  await expect(page.getByText('19:00–21:00')).toBeVisible();
  await expect(page.locator('.rr-kal-location-pill--stora')).toBeVisible();
  await expect(page.locator('.rr-kal-location-pill--lilla')).toBeVisible();
  // Autumn booking link must point to the autumn event, not a spring event
  await expect(page.getByRole('link', { name: 'Fixture hösttermin kurs' })).toHaveAttribute(
    'href',
    'https://example.test/signup/autumn-course'
  );
  // Event without URL should be plain text, not a link
  await expect(page.getByRole('link', { name: 'Fixture hösttermin utan länk' })).toHaveCount(0);
  await expect(page.getByText('Inga kommande aktiviteter hittades för de närmaste dagarna.')).toHaveCount(0);
});
