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

    /* Hitta event-arrayen */
    var list;
    if (Array.isArray(raw)) {
      list = raw;
    } else if (raw && Array.isArray(raw.results)) {
      list = raw.results;
    } else if (raw && Array.isArray(raw.data)) {
      list = raw.data;
    } else {
      return events;
    }

    var now = new Date();
    now.setHours(0, 0, 0, 0);
    var cutoff = new Date(now.getTime() + maxDays * 24 * 60 * 60 * 1000);

    list.forEach(function (ev) {
      var eventName = ev.name || ev.title || 'Okänd aktivitet';

      /* Hämta tillfällen (occasions, sessions, occurrences) */
      var occasions = ev.occasions || ev.sessions || ev.occurrences || [];

      if (occasions.length === 0 && (ev.start || ev.start_time || ev.startTime || ev.date)) {
        /* Eventet har start/slut direkt */
        occasions = [{
          start: ev.start || ev.start_time || ev.startTime || ev.date,
          end: ev.end || ev.end_time || ev.endTime || null,
          location: ev.location || ev.venue || ev.room || ''
        }];
      }

      occasions.forEach(function (occ) {
        var startStr = occ.start || occ.start_time || occ.startTime || occ.date || '';
        if (!startStr) return;

        var startDate = new Date(startStr);
        if (isNaN(startDate.getTime())) return;

        /* Filtrera: visa bara framtida och inom maxDays */
        if (startDate < now || startDate > cutoff) return;

        var endDate = null;
        var endStr = occ.end || occ.end_time || occ.endTime || '';
        if (endStr) {
          endDate = new Date(endStr);
          if (isNaN(endDate.getTime())) endDate = null;
        }

        var location = occ.location || occ.venue || occ.room || ev.location || ev.venue || ev.room || '';

        events.push({
          name: eventName,
          start: startDate,
          end: endDate,
          location: location,
          url: ev.url || ev.link || ''
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
