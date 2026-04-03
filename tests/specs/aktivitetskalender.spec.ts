import { test, expect } from '@playwright/test';

function formatDate(offsetDays: number): string {
  const date = new Date();
  date.setHours(0, 0, 0, 0);
  date.setDate(date.getDate() + offsetDays);

  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');

  return `${year}-${month}-${day}`;
}

test('handles nested calendar API payloads', async ({ page }) => {
  await page.route('https://dans.se/api/public/events/**', async (route) => {
    const body = {
      data: {
        'course-1': {
          name: 'Bugg - Steg 1',
          dates: [
            {
              date: formatDate(5),
              start_time: '18:30',
              end_time: '19:45',
              location: { name: 'Haga Centrum' }
            }
          ]
        },
        'course-2': {
          title: 'Fox - Grundkurs',
          sessions: [
            {
              startDate: formatDate(6),
              startTime: '19:00',
              endDate: formatDate(6),
              endTime: '20:30',
              locationName: 'Haga Centrum'
            }
          ]
        },
        'course-3': {
          name: 'Friträning Bugg & Fox',
          place: 'Haga Centrum',
          source: 'https://dans.se/event/266015',
          registration: {
            url: 'https://dans.se/rockrullarna/shop/new?event=266015'
          },
          schedule: {
            start: {
              date: formatDate(7),
              time: '15:00:00'
            },
            end: {
              date: formatDate(7),
              time: '16:00:00'
            }
          }
        }
      }
    };

    await route.fulfill({
      status: 200,
      contentType: 'application/json',
      body: JSON.stringify(body)
    });
  });

  await page.goto('/aktivitetskalender/');

  await expect(page.getByRole('table')).toBeVisible();
  await expect(page.getByText('Bugg - Steg 1')).toBeVisible();
  await expect(page.getByText('Fox - Grundkurs')).toBeVisible();
  await expect(page.getByText('Friträning Bugg & Fox')).toBeVisible();
  await expect(page.getByText('18:30–19:45')).toBeVisible();
  await expect(page.getByText('19:00–20:30')).toBeVisible();
  await expect(page.getByText('15:00–16:00')).toBeVisible();
  await expect(page.getByRole('link', { name: 'Friträning Bugg & Fox' })).toHaveAttribute('href', 'https://dans.se/rockrullarna/shop/new?event=266015');
  await expect(page.getByText('Inga kommande aktiviteter hittades för de närmaste dagarna.')).toHaveCount(0);
});
