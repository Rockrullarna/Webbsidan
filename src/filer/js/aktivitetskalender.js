/**
 * Aktivitetskalender – renderar färdignormaliserade aktiviteter från backend.
 *
 * Backend-proxyn i /aktivitetskalender/data.php ansvarar för att:
 * - hämta data från dans.se
 * - slå ihop schedule-sidan och public events-API:t
 * - deduplicera poster
 * - cacha resultatet
 *
 * Klienten här renderar bara färdiga poster.
 */
(function () {
  'use strict';

  var API_BASE = '/aktivitetskalender/data.php';
  var DEFAULT_DAYS = 180;
  var DEFAULT_LIMIT = 500;
  var CONTAINER_ID = 'rr-kalender';
  var MONTHS_SHORT = [
    'jan', 'feb', 'mar', 'apr', 'maj', 'jun',
    'jul', 'aug', 'sep', 'okt', 'nov', 'dec'
  ];
  var DAYS_SHORT = ['sön', 'mån', 'tis', 'ons', 'tor', 'fre', 'lör'];

  function formatDateShort(date) {
    return date.getDate() + ' ' + MONTHS_SHORT[date.getMonth()];
  }

  function formatDateISO(date) {
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var day = String(date.getDate()).padStart(2, '0');
    return year + '-' + month + '-' + day;
  }

  function formatTime(date) {
    return String(date.getHours()).padStart(2, '0') + ':' +
      String(date.getMinutes()).padStart(2, '0');
  }

  function formatWeekday(date) {
    return DAYS_SHORT[date.getDay()];
  }

  function el(tag, attrs, children) {
    var elem = document.createElement(tag);
    var key;

    if (attrs) {
      for (key in attrs) {
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

  function parseDateValue(value) {
    var date;

    if (value === undefined || value === null || value === '') {
      return null;
    }

    if (value instanceof Date) {
      return isNaN(value.getTime()) ? null : value;
    }

    if (typeof value === 'number') {
      date = new Date(value);
      return isNaN(date.getTime()) ? null : date;
    }

    date = new Date(String(value).trim().replace(' ', 'T'));
    return isNaN(date.getTime()) ? null : date;
  }

  function extractEvents(raw) {
    if (Array.isArray(raw)) {
      return raw;
    }

    if (raw && Array.isArray(raw.events)) {
      return raw.events;
    }

    return [];
  }

  function normalizeEvents(raw, maxDays) {
    var events = [];
    var list = extractEvents(raw);
    var now = new Date();
    var cutoff;

    now.setHours(0, 0, 0, 0);
    cutoff = new Date(now.getTime() + maxDays * 24 * 60 * 60 * 1000);

    list.forEach(function (item) {
      var startDate = parseDateValue(item && item.start);
      var endDate = parseDateValue(item && item.end);

      if (!startDate || startDate < now || startDate > cutoff) {
        return;
      }

      events.push({
        name: item && item.name ? String(item.name).trim() : 'Okänd aktivitet',
        start: startDate,
        end: endDate,
        location: item && item.location ? String(item.location).trim() : '',
        url: item && item.url ? String(item.url).trim() : ''
      });
    });

    events.sort(function (left, right) {
      return left.start.getTime() - right.start.getTime();
    });

    return events;
  }

  function renderLoading(container) {
    container.innerHTML = '';
    var wrapper = el('div', { 'class': 'rr-kal-loading text-center py-4', 'role': 'status' });
    var spinner = el('div', { 'class': 'spinner-border text-primary', 'role': 'status' });
    spinner.appendChild(el('span', { 'class': 'visually-hidden' }, 'Laddar aktiviteter...'));
    wrapper.appendChild(spinner);
    wrapper.appendChild(el('p', { 'class': 'mt-2' }, 'Hämtar aktiviteter från dans.se…'));
    container.appendChild(wrapper);
  }

  function renderError(container, message) {
    container.innerHTML = '';
    var alert = el('div', {
      'class': 'alert alert-warning',
      'role': 'alert'
    });
    var link = el('a', {
      'href': 'https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1',
      'target': '_blank',
      'rel': 'noopener'
    }, 'Visa kalendern direkt på dans.se');

    alert.appendChild(el('strong', {}, 'Kunde inte hämta aktiviteter. '));
    alert.appendChild(document.createTextNode(message || ''));
    alert.appendChild(el('br'));
    alert.appendChild(link);
    container.appendChild(alert);
  }

  function renderEmpty(container) {
    container.innerHTML = '';
    container.appendChild(
      el('p', { 'class': 'text-muted text-center py-3' },
        'Inga kommande aktiviteter hittades för de närmaste dagarna.')
    );
  }

  function renderTable(container, events, mode) {
    var isCompact = mode === 'compact';
    var wrapper;
    var table;
    var thead;
    var headRow;
    var tbody;
    var previousDate = '';

    container.innerHTML = '';

    if (events.length === 0) {
      renderEmpty(container);
      return;
    }

    wrapper = el('div', {
      'class': 'rr-kal-wrapper' + (isCompact ? ' rr-kal-compact' : ' rr-kal-full')
    });

    table = el('table', {
      'class': 'table table-striped table-hover rr-kal-table'
    });

    thead = el('thead');
    headRow = el('tr');
    headRow.appendChild(el('th', { 'scope': 'col' }, 'Datum'));
    headRow.appendChild(el('th', { 'scope': 'col' }, 'Tid'));
    headRow.appendChild(el('th', { 'scope': 'col' }, 'Aktivitet'));
    if (!isCompact) {
      headRow.appendChild(el('th', { 'scope': 'col' }, 'Plats'));
    }
    thead.appendChild(headRow);
    table.appendChild(thead);

    tbody = el('tbody');

    events.forEach(function (eventItem) {
      var row = el('tr');
      var dateStr = formatDateShort(eventItem.start);
      var dateCell = el('td', { 'class': 'rr-kal-date text-nowrap' });
      var nameCell = el('td', { 'class': 'rr-kal-name' });
      var timeStr = formatTime(eventItem.start);

      if (dateStr !== previousDate) {
        dateCell.appendChild(el('time', { 'datetime': formatDateISO(eventItem.start) }, dateStr));
        dateCell.appendChild(document.createTextNode(' '));
        dateCell.appendChild(el('small', { 'class': 'text-body-secondary' }, '(' + formatWeekday(eventItem.start) + ')'));
        previousDate = dateStr;
      }
      row.appendChild(dateCell);

      if (eventItem.end) {
        timeStr += '–' + formatTime(eventItem.end);
      }
      row.appendChild(el('td', { 'class': 'rr-kal-time text-nowrap' }, timeStr));

      if (eventItem.url) {
        nameCell.appendChild(el('a', {
          'href': eventItem.url,
          'target': '_blank',
          'rel': 'noopener'
        }, eventItem.name));
      } else {
        nameCell.textContent = eventItem.name;
      }

      if (isCompact && eventItem.location) {
        nameCell.appendChild(el('br'));
        nameCell.appendChild(el('small', { 'class': 'text-body-secondary' }, eventItem.location));
      }
      row.appendChild(nameCell);

      if (!isCompact) {
        row.appendChild(el('td', { 'class': 'rr-kal-location' }, eventItem.location));
      }

      tbody.appendChild(row);
    });

    table.appendChild(tbody);
    wrapper.appendChild(table);
    container.appendChild(wrapper);
  }

  function init() {
    var container = document.getElementById(CONTAINER_ID);
    var mode;
    var days;
    var limit;
    var url;

    if (!container) {
      return;
    }

    mode = container.getAttribute('data-mode') || 'compact';
    days = parseInt(container.getAttribute('data-days'), 10) || DEFAULT_DAYS;
    limit = parseInt(container.getAttribute('data-limit'), 10) || DEFAULT_LIMIT;
    url = API_BASE + '?days=' + encodeURIComponent(days) + '&limit=' + encodeURIComponent(limit);

    renderLoading(container);

    fetch(url)
      .then(function (response) {
        if (!response.ok) {
          throw new Error('HTTP ' + response.status);
        }
        return response.json();
      })
      .then(function (data) {
        renderTable(container, normalizeEvents(data, days), mode);
      })
      .catch(function (error) {
        console.error('Aktivitetskalender: Kunde inte hämta data:', error);
        renderError(container, error.message || '');
      });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
