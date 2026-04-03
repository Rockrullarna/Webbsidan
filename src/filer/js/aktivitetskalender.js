/**
 * Aktivitetskalender – Hämtar och visar kommande aktiviteter från dans.se API.
 *
 * Användning:
 *   <div id="rr-kalender" data-mode="compact"></div>
 *   <script src="/filer/js/aktivitetskalender.js"></script>
 *
 * Attribut på container-elementet:
 *   data-mode     "compact" (scrollbar tabell, startsida) eller "full" (helsida)
 *   data-days     Antal dagar framåt att visa (standard 180)
 *   data-limit    Max antal poster att hämta från API:t (standard 500)
 */
(function () {
  'use strict';

  /* ------------------------------------------------------------------ */
  /*  Konfigurerbart                                                    */
  /* ------------------------------------------------------------------ */
  var API_BASE = 'https://dans.se/api/public/events/';
  var ORG = 'rockrullarna';
  var DEFAULT_DAYS = 180;
  var DEFAULT_LIMIT = 500;
  var CONTAINER_ID = 'rr-kalender';
  var TIMESTAMP_MILLISECONDS_THRESHOLD = 9999999999;
  var TIME_COMPONENT_PATTERN = /[T ]\d{1,2}:\d{2}/;
  var TIME_RANGE_PATTERN = /(\d{1,2})[:.](\d{2})\s*[-–]\s*(\d{1,2})[:.](\d{2})/;

  /* Svenska månadsnamn (kort) */
  var MONTHS_SHORT = [
    'jan', 'feb', 'mar', 'apr', 'maj', 'jun',
    'jul', 'aug', 'sep', 'okt', 'nov', 'dec'
  ];

  /* Svenska veckodagar (kort) */
  var DAYS_SHORT = ['sön', 'mån', 'tis', 'ons', 'tor', 'fre', 'lör'];

  /* ------------------------------------------------------------------ */
  /*  Hjälpfunktioner                                                   */
  /* ------------------------------------------------------------------ */

  /**
   * Formatera ett Date-objekt till "d mon" (t.ex. "25 mar").
   */
  function formatDateShort(date) {
    return date.getDate() + ' ' + MONTHS_SHORT[date.getMonth()];
  }

  /**
   * Formatera ett Date-objekt till "YYYY-MM-DD".
   */
  function formatDateISO(date) {
    var y = date.getFullYear();
    var m = String(date.getMonth() + 1).padStart(2, '0');
    var d = String(date.getDate()).padStart(2, '0');
    return y + '-' + m + '-' + d;
  }

  /**
   * Formatera tid "HH:MM" från ett Date-objekt.
   */
  function formatTime(date) {
    return String(date.getHours()).padStart(2, '0') + ':' +
           String(date.getMinutes()).padStart(2, '0');
  }

  /**
   * Formatera veckodag (kort) från Date.
   */
  function formatWeekday(date) {
    return DAYS_SHORT[date.getDay()];
  }

  /**
   * Skapa ett HTML-element med valfria attribut och innehåll.
   */
  function el(tag, attrs, children) {
    var elem = document.createElement(tag);
    if (attrs) {
      for (var key in attrs) {
        if (Object.prototype.hasOwnProperty.call(attrs, key)) {
          elem.setAttribute(key, attrs[key]);
        }
      }
    }
    if (typeof children === 'string') {
      elem.textContent = children;
    } else if (Array.isArray(children)) {
      children.forEach(function (child) {
        if (typeof child === 'string') {
          elem.appendChild(document.createTextNode(child));
        } else if (child) {
          elem.appendChild(child);
        }
      });
    }
    return elem;
  }

  function isPlainObject(value) {
    return Object.prototype.toString.call(value) === '[object Object]';
  }

  function firstNonEmpty(obj, keys) {
    var i;
    var value;
    for (i = 0; i < keys.length; i += 1) {
      value = obj && obj[keys[i]];
      if (value !== undefined && value !== null && value !== '') {
        return value;
      }
    }
    return null;
  }

  function textValue(value) {
    if (value === undefined || value === null) {
      return '';
    }
    if (typeof value === 'string' || typeof value === 'number') {
      return String(value).trim();
    }
    if (isPlainObject(value)) {
      return textValue(firstNonEmpty(value, ['name', 'title', 'label', 'text', 'value', 'address']));
    }
    return '';
  }

  /**
   * Skapa ett lokalt Date-objekt efter fältvalidering.
   * Returnerar null om datum/tid är utanför tillåtna intervall
   * eller om kombinationen inte bildar ett giltigt kalenderdatum.
   */
  function createValidatedDate(year, month, day, hours, minutes, seconds) {
    var date;

    if (
      month < 0 || month > 11 ||
      day < 1 || day > 31 ||
      hours < 0 || hours > 23 ||
      minutes < 0 || minutes > 59 ||
      seconds < 0 || seconds > 59
    ) {
      return null;
    }

    date = new Date(year, month, day, hours, minutes, seconds);

    if (
      date.getFullYear() !== year ||
      date.getMonth() !== month ||
      date.getDate() !== day
    ) {
      return null;
    }

    return date;
  }

  function parseDateValue(value, extraTime) {
    var match;
    var date;
    var year;
    var month;
    var day;
    var hours;
    var minutes;
    var seconds;
    var str = '';

    if (value === undefined || value === null || value === '') {
      return null;
    }

    if (value instanceof Date) {
      return isNaN(value.getTime()) ? null : value;
    }

    if (typeof value === 'number') {
      date = new Date(value > TIMESTAMP_MILLISECONDS_THRESHOLD ? value : value * 1000);
      return isNaN(date.getTime()) ? null : date;
    }

    if (isPlainObject(value)) {
      return parseDateValue(
        firstNonEmpty(value, ['start', 'startDate', 'start_date', 'date', 'day', 'value']),
        extraTime || firstNonEmpty(value, ['startTime', 'start_time', 'time'])
      );
    }

    str = String(value).trim();
    if (!str) {
      return null;
    }

    if (extraTime && !TIME_COMPONENT_PATTERN.test(str)) {
      str += ' ' + String(extraTime).trim();
    }

    if (/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}(?::\d{2})?$/.test(str)) {
      str = str.replace(' ', 'T');
    }

    match = str.match(/^(\d{2})\/(\d{2})\/(\d{4})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?$/);
    if (match) {
      day = parseInt(match[1], 10);
      month = parseInt(match[2], 10) - 1;
      year = parseInt(match[3], 10);
      hours = parseInt(match[4] || '0', 10);
      minutes = parseInt(match[5] || '0', 10);
      seconds = parseInt(match[6] || '0', 10);
      return createValidatedDate(year, month, day, hours, minutes, seconds);
    }

    match = str.match(/^(\d{2})\.(\d{2})\.(\d{4})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?$/);
    if (match) {
      day = parseInt(match[1], 10);
      month = parseInt(match[2], 10) - 1;
      year = parseInt(match[3], 10);
      hours = parseInt(match[4] || '0', 10);
      minutes = parseInt(match[5] || '0', 10);
      seconds = parseInt(match[6] || '0', 10);
      return createValidatedDate(year, month, day, hours, minutes, seconds);
    }

    match = str.match(/^(\d{4})-(\d{2})-(\d{2})$/);
    if (match) {
      year = parseInt(match[1], 10);
      month = parseInt(match[2], 10) - 1;
      day = parseInt(match[3], 10);
      return createValidatedDate(year, month, day, 0, 0, 0);
    }

    date = new Date(str);
    return isNaN(date.getTime()) ? null : date;
  }

  function parseDateFromObject(obj, prefix) {
    var baseKey = prefix ? prefix + '_' : '';
    var camelPrefix = prefix ? prefix : '';
    var datePart = firstNonEmpty(obj, [
      baseKey + 'date',
      camelPrefix ? camelPrefix + 'Date' : 'date',
      baseKey + 'day',
      'date'
    ]);
    var timePart = firstNonEmpty(obj, [
      baseKey + 'time',
      camelPrefix ? camelPrefix + 'Time' : 'time',
      baseKey + 'clock',
      'time'
    ]);
    var directValue = firstNonEmpty(obj, [
      prefix,
      camelPrefix,
      baseKey + 'datetime',
      camelPrefix ? camelPrefix + 'DateTime' : 'dateTime'
    ]);

    return parseDateValue(directValue || datePart, timePart);
  }

  /**
   * Försöker hitta en array av event-liknande objekt genom att packa upp
   * vanliga wrappers (t.ex. data/results/events) rekursivt.
   * depth begränsar hur djupt vi går för att undvika att tolka helt
   * orelaterade nästlade strukturer som kalenderdata.
   */
  function extractArrayCandidate(value, depth) {
    var preferredKeys = ['results', 'data', 'events', 'items', 'rows', 'entries'];
    var i;
    var nested;
    var values;

    if (!value || depth < 0) {
      return null;
    }

    if (Array.isArray(value)) {
      return value;
    }

    if (!isPlainObject(value)) {
      return null;
    }

    for (i = 0; i < preferredKeys.length; i += 1) {
      nested = extractArrayCandidate(value[preferredKeys[i]], depth - 1);
      if (nested && nested.length) {
        return nested;
      }
    }

    values = Object.keys(value).map(function (key) { return value[key]; });
    if (values.length > 0 && values.every(isPlainObject)) {
      return values;
    }

    for (i = 0; i < values.length; i += 1) {
      nested = extractArrayCandidate(values[i], depth - 1);
      if (nested && nested.length) {
        return nested;
      }
    }

    return null;
  }

  function extractOccasions(eventItem) {
    var occasionKeys = [
      'occasions', 'sessions', 'occurrences', 'dates', 'schedule',
      'times', 'instances', 'eventDates', 'event_dates', 'meetings'
    ];
    var i;
    var candidate;

    for (i = 0; i < occasionKeys.length; i += 1) {
      candidate = extractArrayCandidate(eventItem[occasionKeys[i]], 1);
      if (candidate && candidate.length) {
        return candidate;
      }
    }

    return [];
  }

  /**
   * Hämtar startdatum från ett tillfälle i första hand och faller annars
   * tillbaka till event-nivån. Stöd finns för både kombinerade och separata
   * datum/tid-fält samt flera vanliga nyckelnamn från API-varianter.
   */
  function extractStartDate(occ, ev) {
    var startValue = firstNonEmpty(occ, [
      'start', 'startDateTime', 'start_datetime', 'datetime',
      'dateTime', 'from', 'fromDateTime'
    ]);
    var startTime = firstNonEmpty(occ, ['startTime', 'start_time', 'time', 'fromTime', 'from_time']);

    return parseDateValue(startValue, startTime) ||
      parseDateFromObject(occ, 'start') ||
      parseDateFromObject(occ, 'from') ||
      parseDateValue(firstNonEmpty(occ, ['date', 'day']), firstNonEmpty(occ, ['time', 'startTime', 'start_time'])) ||
      parseDateFromObject(ev, 'start') ||
      parseDateFromObject(ev && ev.schedule, 'start') ||
      parseDateValue(firstNonEmpty(ev, ['date', 'day']), firstNonEmpty(ev, ['time', 'startTime', 'start_time']));
  }

  /**
   * Hämtar slutdatum från ett tillfälle om sådana fält finns.
   * Returnerar null när inget slutdatum kan tolkas.
   */
  function extractEndDate(occ, ev) {
    var endValue = firstNonEmpty(occ, [
      'end', 'endDateTime', 'end_datetime', 'to', 'toDateTime'
    ]);
    var endTime = firstNonEmpty(occ, ['endTime', 'end_time', 'toTime', 'to_time']);

    return parseDateValue(endValue, endTime) ||
      parseDateFromObject(occ, 'end') ||
      parseDateFromObject(occ, 'to') ||
      parseDateFromObject(ev && ev.schedule, 'end');
  }

  function getScheduleDayOfWeek(ev, fallbackDate) {
    var scheduleStart = ev && ev.schedule && ev.schedule.start;
    var dayOfWeek = firstNonEmpty(scheduleStart, ['dayOfWeek', 'day_of_week']);
    var parsedDay;

    if (dayOfWeek !== null && dayOfWeek !== undefined && dayOfWeek !== '') {
      parsedDay = parseInt(dayOfWeek, 10);
      if (!isNaN(parsedDay)) {
        return parsedDay === 7 ? 0 : parsedDay;
      }
    }

    return fallbackDate ? fallbackDate.getDay() : null;
  }

  function resolveDisplayStartDate(startDate, endDate, ev, today) {
    var dayOfWeek;
    var nextDate;
    var daysUntilNext;

    if (!startDate || startDate >= today || !endDate || endDate < today) {
      return startDate;
    }

    dayOfWeek = getScheduleDayOfWeek(ev, startDate);
    if (dayOfWeek === null) {
      return startDate;
    }

    nextDate = new Date(today.getTime());
    nextDate.setHours(startDate.getHours(), startDate.getMinutes(), startDate.getSeconds(), 0);

    daysUntilNext = (dayOfWeek - nextDate.getDay() + 7) % 7;
    nextDate.setDate(nextDate.getDate() + daysUntilNext);

    if (nextDate < today) {
      nextDate.setDate(nextDate.getDate() + 7);
    }

    if (nextDate > endDate) {
      return startDate;
    }

    return nextDate;
  }

  function cloneDate(date) {
    return new Date(date.getTime());
  }

  function setTimeParts(date, hours, minutes, seconds) {
    var nextDate = cloneDate(date);
    nextDate.setHours(hours, minutes, seconds || 0, 0);
    return nextDate;
  }

  function addDays(date, days) {
    var nextDate = cloneDate(date);
    nextDate.setDate(nextDate.getDate() + days);
    return nextDate;
  }

  function parseScheduleTimeRange(ev) {
    var info = textValue(ev && ev.schedule && ev.schedule.dayAndTimeInfo);
    var match;

    if (!info) {
      return null;
    }

    match = info.match(TIME_RANGE_PATTERN);
    if (!match) {
      return null;
    }

    return {
      startHours: parseInt(match[1], 10),
      startMinutes: parseInt(match[2], 10),
      endHours: parseInt(match[3], 10),
      endMinutes: parseInt(match[4], 10)
    };
  }

  function buildOccurrenceEndDate(startDate, ev, fallbackEndDate) {
    var timeRange = parseScheduleTimeRange(ev);
    var endDate = fallbackEndDate ? cloneDate(fallbackEndDate) : null;

    if (timeRange) {
      endDate = setTimeParts(startDate, timeRange.endHours, timeRange.endMinutes, 0);
      if (endDate < startDate) {
        endDate = addDays(endDate, 1);
      }
      return endDate;
    }

    if (endDate) {
      endDate = setTimeParts(startDate, endDate.getHours(), endDate.getMinutes(), endDate.getSeconds());
      if (endDate < startDate) {
        endDate = addDays(endDate, 1);
      }
    }

    return endDate;
  }

  function getPlannedOccasionsCount(ev) {
    var count = parseInt(firstNonEmpty(ev && ev.schedule, ['numberOfPlannedOccasions']), 10);
    return isNaN(count) ? 0 : count;
  }

  function isDateWithinRange(date, startDate, endDate) {
    return !!date && date >= startDate && date <= endDate;
  }

  function getEventName(ev, occ, fallbackName) {
    return textValue(firstNonEmpty(occ, ['name', 'title'])) || fallbackName ||
      textValue(firstNonEmpty(ev, [
        'name', 'title', 'eventName', 'event_name', 'productName',
        'product_name', 'activity', 'activityName', 'headline'
      ])) || 'Okänd aktivitet';
  }

  function getEventLocation(ev, occ) {
    return textValue(firstNonEmpty(occ, [
      'location', 'venue', 'room', 'place', 'locationName', 'location_name'
    ])) || textValue(firstNonEmpty(ev, [
      'location', 'venue', 'room', 'place', 'locationName', 'location_name'
    ]));
  }

  function getEventUrl(ev) {
    return textValue(firstNonEmpty(ev && ev.registration, ['url'])) ||
      textValue(firstNonEmpty(ev, ['url', 'link', 'publicUrl', 'public_url', 'signupUrl', 'signup_url', 'source']));
  }

  function getOccurrenceDates(startDate, endDate, occ, ev, now, cutoff) {
    var displayStartDate;
    var occurrenceDates;

    occurrenceDates = occ.syntheticRecurring ?
      expandRecurringOccurrences(startDate, endDate, ev, now, cutoff) : [];

    if (occurrenceDates.length > 0) {
      return occurrenceDates;
    }

    displayStartDate = resolveDisplayStartDate(startDate, endDate, ev, now);
    return [{
      start: displayStartDate,
      end: buildOccurrenceEndDate(displayStartDate, ev, endDate)
    }];
  }

  function expandRecurringOccurrences(startDate, endDate, ev, now, cutoff) {
    var occurrences = [];
    var plannedCount = getPlannedOccasionsCount(ev);
    var occurrenceDate;
    var occurrenceEndDate;
    var index;

    if (!startDate || plannedCount <= 1) {
      return occurrences;
    }

    for (index = 0; index < plannedCount; index += 1) {
      occurrenceDate = addDays(startDate, index * 7);
      occurrenceEndDate = buildOccurrenceEndDate(occurrenceDate, ev, endDate);

      if (occurrenceDate > cutoff) {
        break;
      }

      if (occurrenceEndDate && occurrenceEndDate < now) {
        continue;
      }

      if (occurrenceDate < now) {
        continue;
      }

      occurrences.push({
        start: occurrenceDate,
        end: occurrenceEndDate
      });
    }

    return occurrences;
  }

  /* ------------------------------------------------------------------ */
  /*  Data-hantering                                                    */
  /* ------------------------------------------------------------------ */

  /**
   * Normalisera API-svaret till en flat lista av visningsbara rader.
   *
   * API:t (dans.se/api/public/events/) kan returnera:
   *   - En array av event-objekt
   *   - Ett objekt med "results" som array
   *   - Ett objekt med "data" som array
   *
   * Varje event kan ha fälten:
   *   name/title, occasions/sessions/occurrences (array med start/end + location)
   *   eller start/end/location direkt på event-nivå.
   */
  function normalizeEvents(raw, maxDays) {
    var events = [];
    var list = extractArrayCandidate(raw, 4);

    if (!list || !list.length) {
      return events;
    }

    var now = new Date();
    now.setHours(0, 0, 0, 0);
    var cutoff = new Date(now.getTime() + maxDays * 24 * 60 * 60 * 1000);

    list.forEach(function (ev) {
      var eventName = getEventName(ev, null, null);

      /* Hämta tillfällen (occasions, sessions, occurrences) */
      var occasions = extractOccasions(ev);

      if (occasions.length === 0) {
        /* Eventet har start/slut direkt */
        occasions = [{
          syntheticRecurring: true,
          start: firstNonEmpty(ev, [
            'start', 'startDateTime', 'start_datetime', 'startDate',
            'start_date', 'start_time', 'startTime', 'date', 'day'
          ]),
          startDate: firstNonEmpty(ev, ['startDate', 'start_date', 'date', 'day']),
          startTime: firstNonEmpty(ev, ['startTime', 'start_time', 'time']),
          end: firstNonEmpty(ev, [
            'end', 'endDateTime', 'end_datetime', 'endDate',
            'end_date', 'end_time', 'endTime'
          ]),
          endDate: firstNonEmpty(ev, ['endDate', 'end_date']),
          endTime: firstNonEmpty(ev, ['endTime', 'end_time']),
          location: firstNonEmpty(ev, ['location', 'venue', 'room', 'place', 'locationName', 'location_name'])
        }];
      }

      occasions.forEach(function (occ) {
        var startDate = extractStartDate(occ, ev);
        var occurrenceDates;
        var location;
        var eventUrl;

        if (!startDate || isNaN(startDate.getTime())) {
          return;
        }

        var endDate = extractEndDate(occ, ev);

        if (endDate && isNaN(endDate.getTime())) {
          endDate = null;
        }

        location = getEventLocation(ev, occ);
        eventUrl = getEventUrl(ev);
        occurrenceDates = getOccurrenceDates(startDate, endDate, occ, ev, now, cutoff);

        occurrenceDates.forEach(function (occurrence) {
          if (!isDateWithinRange(occurrence.start, now, cutoff)) {
            return;
          }

          events.push({
            name: getEventName(ev, occ, eventName),
            start: occurrence.start,
            end: occurrence.end,
            location: location,
            url: eventUrl
          });
        });
      });
    });

    /* Sortera kronologiskt */
    events.sort(function (a, b) {
      return a.start.getTime() - b.start.getTime();
    });

    return events;
  }

  /* ------------------------------------------------------------------ */
  /*  Rendering                                                         */
  /* ------------------------------------------------------------------ */

  /**
   * Visa laddningsindikator.
   */
  function renderLoading(container) {
    container.innerHTML = '';
    var wrapper = el('div', { 'class': 'rr-kal-loading text-center py-4', 'role': 'status' });
    var spinner = el('div', { 'class': 'spinner-border text-primary', 'role': 'status' });
    spinner.appendChild(el('span', { 'class': 'visually-hidden' }, 'Laddar aktiviteter...'));
    wrapper.appendChild(spinner);
    wrapper.appendChild(el('p', { 'class': 'mt-2' }, 'Hämtar aktiviteter från dans.se…'));
    container.appendChild(wrapper);
  }

  /**
   * Visa felmeddelande.
   */
  function renderError(container, message) {
    container.innerHTML = '';
    var alert = el('div', {
      'class': 'alert alert-warning',
      'role': 'alert'
    });
    alert.appendChild(el('strong', {}, 'Kunde inte hämta aktiviteter. '));
    alert.appendChild(document.createTextNode(message || ''));
    alert.appendChild(el('br'));
    var link = el('a', {
      'href': 'https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1',
      'target': '_blank',
      'rel': 'noopener'
    }, 'Visa kalendern direkt på dans.se');
    alert.appendChild(link);
    container.appendChild(alert);
  }

  /**
   * Visa "inga händelser".
   */
  function renderEmpty(container) {
    container.innerHTML = '';
    container.appendChild(
      el('p', { 'class': 'text-muted text-center py-3' },
         'Inga kommande aktiviteter hittades för de närmaste dagarna.')
    );
  }

  /**
   * Rendera kalendertabell.
   *  mode = "compact": begränsad höjd, scrollbar
   *  mode = "full":    visa alla utan höjdbegränsning
   */
  function renderTable(container, events, mode) {
    container.innerHTML = '';

    if (events.length === 0) {
      renderEmpty(container);
      return;
    }

    var isCompact = (mode === 'compact');

    /* Wrapper */
    var wrapper = el('div', {
      'class': 'rr-kal-wrapper' + (isCompact ? ' rr-kal-compact' : ' rr-kal-full')
    });

    /* Tabell */
    var table = el('table', {
      'class': 'table table-striped table-hover rr-kal-table'
    });

    /* Thead */
    var thead = el('thead');
    var headRow = el('tr');
    headRow.appendChild(el('th', { 'scope': 'col' }, 'Datum'));
    headRow.appendChild(el('th', { 'scope': 'col' }, 'Tid'));
    headRow.appendChild(el('th', { 'scope': 'col' }, 'Aktivitet'));
    if (!isCompact) {
      headRow.appendChild(el('th', { 'scope': 'col' }, 'Plats'));
    }
    thead.appendChild(headRow);
    table.appendChild(thead);

    /* Tbody */
    var tbody = el('tbody');
    var prevDateStr = '';

    events.forEach(function (ev) {
      var row = el('tr');

      /* Datum */
      var dateStr = formatDateShort(ev.start);
      var weekday = formatWeekday(ev.start);
      var isoDate = formatDateISO(ev.start);

      var dateCell = el('td', { 'class': 'rr-kal-date text-nowrap' });
      if (dateStr !== prevDateStr) {
        dateCell.appendChild(el('time', { 'datetime': isoDate }, dateStr));
        dateCell.appendChild(document.createTextNode(' '));
        dateCell.appendChild(el('small', { 'class': 'text-body-secondary' }, '(' + weekday + ')'));
        prevDateStr = dateStr;
      }
      row.appendChild(dateCell);

      /* Tid */
      var timeStr = formatTime(ev.start);
      if (ev.end) {
        timeStr += '–' + formatTime(ev.end);
      }
      row.appendChild(el('td', { 'class': 'rr-kal-time text-nowrap' }, timeStr));

      /* Aktivitet */
      var nameCell = el('td', { 'class': 'rr-kal-name' });
      if (ev.url) {
        nameCell.appendChild(el('a', {
          'href': ev.url,
          'target': '_blank',
          'rel': 'noopener'
        }, ev.name));
      } else {
        nameCell.textContent = ev.name;
      }
      /* Visa plats i compact-läge som liten text under namnet */
      if (isCompact && ev.location) {
        nameCell.appendChild(el('br'));
        nameCell.appendChild(el('small', { 'class': 'text-body-secondary' }, ev.location));
      }
      row.appendChild(nameCell);

      /* Plats (bara i full-läge) */
      if (!isCompact) {
        row.appendChild(el('td', { 'class': 'rr-kal-location' }, ev.location));
      }

      tbody.appendChild(row);
    });

    table.appendChild(tbody);
    wrapper.appendChild(table);
    container.appendChild(wrapper);
  }

  /* ------------------------------------------------------------------ */
  /*  Huvudlogik                                                        */
  /* ------------------------------------------------------------------ */

  function init() {
    var container = document.getElementById(CONTAINER_ID);
    if (!container) return;

    var mode = container.getAttribute('data-mode') || 'compact';
    var days = parseInt(container.getAttribute('data-days'), 10) || DEFAULT_DAYS;
    var limit = parseInt(container.getAttribute('data-limit'), 10) || DEFAULT_LIMIT;

    /* Bygg API-URL */
    var url = API_BASE + '?org=' + encodeURIComponent(ORG) +
              '&limit=' + limit;

    /* Visa laddning */
    renderLoading(container);

    /* Hämta data */
    fetch(url)
      .then(function (response) {
        if (!response.ok) {
          throw new Error('HTTP ' + response.status);
        }
        return response.json();
      })
      .then(function (data) {
        var events = normalizeEvents(data, days);
        renderTable(container, events, mode);
      })
      .catch(function (err) {
        console.error('Aktivitetskalender: Kunde inte hämta data:', err);
        renderError(container, err.message || '');
      });
  }

  /* Starta efter DOM-laddning */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
