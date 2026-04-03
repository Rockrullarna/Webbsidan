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
  await page.route('https://dans.se/api/public/events/**', async (route) => {
    await route.fulfill({
      status: 200,
      contentType: 'application/json',
      body: JSON.stringify(body)
    });
  });
}

test('handles nested calendar API payloads', async ({ page }) => {
  await mockCalendarApi(page, {
    data: {
      'fixture-dates': {
        name: 'Fixture event from dates',
        dates: [
          {
            date: formatDate(5),
            start_time: '18:30',
            end_time: '19:45',
            location: { name: 'Fixture Hall A' }
          }
        ]
      },
      'fixture-sessions': {
        title: 'Fixture event from sessions',
        sessions: [
          {
            startDate: formatDate(6),
            startTime: '19:00',
            endDate: formatDate(6),
            endTime: '20:30',
            locationName: 'Fixture Hall B'
          }
        ]
      },
      'fixture-direct-schedule': {
        name: 'Fixture event with booking link',
        place: 'Fixture Hall C',
        source: 'https://example.test/event/direct-schedule',
        registration: {
          url: 'https://example.test/signup/direct-schedule'
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
      },
      'fixture-recurring': {
        name: 'Fixture recurring event',
        place: 'Fixture Hall D',
        schedule: {
          start: {
            date: formatDate(3),
            time: '18:00:00',
            dayOfWeek: '1'
          },
          numberOfPlannedOccasions: 4,
          dayAndTimeInfo: 'Mån 18.00-20.00'
        }
      }
    }
  });

  await page.goto('/aktivitetskalender/');

  const rows = page.locator('.rr-kal-table tbody tr');

  await expect(page.getByRole('table')).toBeVisible();
  await expect(rows).toHaveCount(7);
  await expect(page.getByText('Fixture event from dates')).toBeVisible();
  await expect(page.getByText('Fixture event from sessions')).toBeVisible();
  await expect(page.getByText('Fixture event with booking link')).toBeVisible();
  await expect(page.getByText('Fixture recurring event')).toHaveCount(4);
  await expect(page.getByText('18:30–19:45')).toBeVisible();
  await expect(page.getByText('19:00–20:30')).toBeVisible();
  await expect(page.getByText('15:00–16:00')).toBeVisible();
  await expect(page.getByText('18:00–20:00')).toHaveCount(4);
  await expect(page.getByRole('link', { name: 'Fixture event with booking link' })).toHaveAttribute('href', 'https://example.test/signup/direct-schedule');
  await expect(page.getByText('Inga kommande aktiviteter hittades för de närmaste dagarna.')).toHaveCount(0);
});

test('renders future dates for recurring series that started earlier', async ({ page }) => {
  const pastMondayOffset = offsetToWeekday(1, -2);

  await mockCalendarApi(page, {
    events: [
      {
        name: 'Fixture ongoing series',
        place: 'Fixture Hall E',
        registration: {
          url: 'https://example.test/signup/ongoing-series'
        },
        schedule: {
          start: {
            date: formatDate(pastMondayOffset),
            time: '18:00:00',
            dayOfWeek: '1'
          },
          end: {
            date: formatDate(offsetToWeekday(1, 1)),
            time: '20:00:00'
          },
          numberOfPlannedOccasions: 4,
          dayAndTimeInfo: 'Mån 18.00-20.00'
        }
      }
    ]
  });

  await page.goto('/aktivitetskalender/');

  await expect(page.locator('.rr-kal-table tbody tr')).toHaveCount(2);
  await expect(page.getByText('Fixture ongoing series')).toHaveCount(2);
  await expect(page.getByText('18:00–20:00')).toHaveCount(2);
  await expect(page.getByText('Fixture Hall E').first()).toBeVisible();
  await expect(page.getByRole('link', { name: 'Fixture ongoing series' }).first()).toHaveAttribute('href', 'https://example.test/signup/ongoing-series');
});
