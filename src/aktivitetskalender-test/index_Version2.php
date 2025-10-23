<!doctype html>
<html lang="sv">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
    <title>Rockrullarna – Aktivitetskalender</title>
    <meta name="description" content="Visualisera evenemang och tillfällen (occasions) från dans.se XML API via PHP-proxy." />
    <style>
      :root{
        --bg: #0b0d10; --panel: #12151a; --panel-2: #191e25; --text: #e8eef6;
        --muted: #aab6c6; --accent: #7cc7ff; --accent-2:#42d392; --danger:#ff6b6b;
        --ring: #2a3542; --chip: #223449; --warn:#ffd166;
      }
      *{ box-sizing: border-box }
      html,body{ height:100% }
      body{
        margin:0; font: 14px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
        color: var(--text);
        background: radial-gradient(1200px 800px at 80% -10%, #132234, transparent 70%), var(--bg);
      }

      header{ position: sticky; top:0; z-index: 10; backdrop-filter: blur(8px);
        background: color-mix(in srgb, var(--bg) 70%, transparent); border-bottom: 1px solid var(--ring); }
      .wrap{ max-width: 1100px; margin: 0 auto; padding: 16px; }
      h1{ font-size: 22px; margin: 0 0 6px 0; display:flex; align-items:center; gap: 10px; }
      h1 .dot{ width:10px; height:10px; border-radius:50%; background: var(--accent); box-shadow: 0 0 20px var(--accent) }
      .subtitle{ color: var(--muted); margin-bottom: 8px }

      .controls{ display:grid; grid-template-columns: 1fr 1fr 1fr auto; gap:10px; align-items:end }
      .field{ display:flex; flex-direction:column; gap:6px }
      label{ color: var(--muted); font-size: 12px }
      input[type="text"], input[type="date"]{
        appearance: none; border: 1px solid var(--ring); background: var(--panel); color: var(--text);
        padding: 10px 12px; border-radius: 10px; outline: none; transition: border-color .2s, box-shadow .2s, background .2s;
      }
      input[type="text"]:focus, input[type="date"]:focus{
        border-color: var(--accent);
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 25%, transparent);
      }

      .view-toggle{
        background: var(--panel); border:1px solid var(--ring); border-radius: 10px; padding: 4px; display:inline-flex; gap:4px;
      }
      .view-toggle button{
        cursor:pointer; padding:8px 10px; border-radius: 8px; border:none; background: transparent; color: var(--muted);
      }
      .view-toggle button[aria-pressed="true"]{
        background: color-mix(in srgb, var(--accent) 16%, transparent); color: var(--text);
      }

      main{ padding-top: 10px }
      .summary{ display:flex; align-items:center; justify-content: space-between; color: var(--muted); margin:10px 0 6px; font-size:13px; }

      /* Events card grid (as before) */
      .grid{ display:grid; grid-template-columns: 1fr 1fr; gap: 12px; }
      @media (max-width: 900px){ .controls{ grid-template-columns: 1fr 1fr; } .grid{ grid-template-columns: 1fr; } }
      .card{
        display:grid; grid-template-columns: 100px 1fr; gap:12px;
        background: linear-gradient(0deg, color-mix(in srgb, var(--panel) 88%, transparent), color-mix(in srgb, var(--panel) 88%, transparent)),
                    radial-gradient(600px 200px at 110% 10%, color-mix(in srgb, var(--accent) 8%, transparent), transparent),
                    var(--panel);
        border: 1px solid var(--ring); border-radius: 14px; overflow: clip;
        transition: border-color .25s, transform .15s ease;
      }
      .card:hover{ border-color: color-mix(in srgb, var(--accent) 45%, var(--ring)); transform: translateY(-1px) }
      .datebox{ background: linear-gradient(180deg, var(--panel-2), var(--panel));
        border-right: 1px solid var(--ring); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px; padding:14px; }
      .dow{ font-weight: 600; letter-spacing: .3px; color: var(--accent) }
      .day{ font-size: 32px; font-weight: 800; line-height: 1 }
      .month{ text-transform: uppercase; font-size: 12px; letter-spacing: 1.2px; color: var(--muted) }
      .body{ padding: 12px 12px 12px 0; display:flex; flex-direction:column; gap: 8px }
      .title{ margin:0; font-size: 18px; line-height: 1.25; font-weight: 700; display:flex; gap:8px; align-items:center; flex-wrap: wrap; }
      .title a{ color: var(--text); text-decoration: none } .title a:hover{ color: var(--accent) }
      .meta{ display:flex; flex-wrap: wrap; gap: 8px }
      .chip{ background: var(--chip); color: #d7e6f7; border: 1px solid color-mix(in srgb, var(--chip) 85%, var(--ring)); padding: 6px 8px;
             border-radius: 999px; font-size: 12px; display:inline-flex; align-items:center; gap: 6px; }
      .chip .dot{ width:8px; height:8px; border-radius:50%; background: var(--accent-2); box-shadow: 0 0 10px color-mix(in srgb, var(--accent-2) 50%, transparent) }
      .desc{ color: var(--muted); max-height: 0; overflow: hidden; transition: max-height .25s ease; }
      .desc.open{ max-height: 300px } .toggle{ color: var(--accent); font-size: 12px; cursor: pointer; user-select: none; }

      .empty, .error{ background: color-mix(in srgb, var(--danger) 12%, transparent); border: 1px solid color-mix(in srgb, var(--danger) 30%, var(--ring));
        color: #ffdede; padding: 12px 14px; border-radius: 12px; }

      .loader{ display:inline-flex; align-items:center; gap: 8px; color: var(--muted); }
      .spinner{ width: 14px; height: 14px; border-radius: 50%; border: 2px solid var(--ring); border-top-color: var(--accent); animation: spin 1s linear infinite; }
      @keyframes spin{ to{ transform: rotate(360deg) } }

      footer{ color: var(--muted); font-size: 12px; text-align: center; padding: 28px 16px 40px; }
      footer a{ color: var(--accent) }

      /* Schedule (occasions) list */
      .schedule{ display:block }
      .day-group{ margin: 16px 0 12px; border: 1px solid var(--ring); border-radius: 12px; overflow: clip; background: var(--panel); }
      .day-title{
        padding: 10px 12px; background: var(--panel-2); color: var(--text);
        display:flex; align-items:center; gap:10px; border-bottom: 1px solid var(--ring);
      }
      .day-title .date{
        font-weight: 700;
      }
      .rows{ display:flex; flex-direction: column }
      .row{
        display:grid; grid-template-columns: 100px 1fr auto; gap: 10px; align-items:center;
        padding: 10px 12px; border-top: 1px solid var(--ring);
      }
      .row:first-child{ border-top: none }
      .time{ color: var(--text); font-variant-numeric: tabular-nums; white-space: nowrap }
      .name{ font-weight: 600 }
      .name a{ color: var(--text); text-decoration:none } .name a:hover{ color: var(--accent) }
      .loc{ color: var(--muted); text-align:right; }
      @media (max-width: 700px){
        .row{ grid-template-columns: 1fr; align-items:flex-start }
        .loc{ text-align:left }
        .time{ opacity:.9 }
      }
    </style>
  </head>
  <body>
    <header>
      <div class="wrap">
        <h1><span class="dot" aria-hidden="true"></span> Rockrullarna – Aktivitetskalender</h1>
        <div class="subtitle">Data från dans.se XML API (via PHP-proxy). Visa evenemang eller tillfällen (schema).</div>
        <div class="controls">
          <div class="field">
            <label for="q">Sök (titel, plats, ort)</label>
            <input id="q" type="text" placeholder="Ex: kurs, socialdans, Västerås ..." />
          </div>
          <div class="field">
            <label for="from">Från datum</label>
            <input id="from" type="date" />
          </div>
          <div class="field">
            <label for="to">Till datum</label>
            <input id="to" type="date" />
          </div>
          <div class="field">
            <label>Visa</label>
            <div class="view-toggle" role="group" aria-label="Välj vy">
              <button id="btnOcc" aria-pressed="true">Tillfällen</button>
              <button id="btnEvt" aria-pressed="false">Evenemang</button>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main class="wrap">
      <div class="summary">
        <div id="count" class="loader"><span class="spinner" aria-hidden="true"></span> Läser in…</div>
        <div id="status"></div>
      </div>

      <!-- Occasions schedule -->
      <section id="schedule" class="schedule" hidden></section>

      <!-- Events cards -->
      <section id="cards" class="grid" role="list" hidden></section>

      <div id="fallback" style="margin-top:12px"></div>
    </main>

    <footer>
      Serveras via egen PHP-proxy (proxy-events.php) för att undvika CORS-problem.
    </footer>

    <script>
      // Fetch through your same-origin PHP proxy
      const API_URL = 'proxy-events.php';

      const els = {
        q: document.getElementById('q'),
        from: document.getElementById('from'),
        to: document.getElementById('to'),
        btnOcc: document.getElementById('btnOcc'),
        btnEvt: document.getElementById('btnEvt'),
        cards: document.getElementById('cards'),
        schedule: document.getElementById('schedule'),
        count: document.getElementById('count'),
        status: document.getElementById('status'),
        fallback: document.getElementById('fallback'),
      };

      const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'Europe/Stockholm';

      let RAW_EVENTS = [];
      let EVENTS_VIEW = [];
      let OCCASIONS_ALL = []; // flattened
      let OCCASIONS_VIEW = [];
      let currentView = 'occasions'; // default to schedule-like view

      function setView(v){
        currentView = v;
        els.btnOcc.setAttribute('aria-pressed', v === 'occasions' ? 'true' : 'false');
        els.btnEvt.setAttribute('aria-pressed', v === 'events' ? 'true' : 'false');
        els.schedule.hidden = v !== 'occasions';
        els.cards.hidden = v !== 'events';
        applyFilters(); // rerender
      }

      els.btnOcc.addEventListener('click', () => setView('occasions'));
      els.btnEvt.addEventListener('click', () => setView('events'));

      // Utilities
      function parseMaybeDate(input){
        if (!input) return null;
        const s = String(input).trim();
        // Common cases: "YYYY-MM-DD", "YYYY-MM-DD HH:mm", ISO, etc.
        const isoLike = s.includes('T') ? s : s.replace(' ', 'T');
        let d = new Date(isoLike);
        if (!isNaN(d)) return d;

        const m = s.match(/\d{4}-\d{2}-\d{2}/);
        if (m){
          const datePart = m[0];
          const timeMatch = s.match(/\d{2}:\d{2}(:\d{2})?/);
          const dt = timeMatch ? `${datePart}T${timeMatch[0]}` : `${datePart}T00:00:00`;
          d = new Date(dt);
          if (!isNaN(d)) return d;
        }
        return null;
      }
      function fmtDate(d, opts){ try{ return new Intl.DateTimeFormat('sv-SE', { timeZone: tz, ...opts }).format(d); } catch{ return '' } }
      function fmtTime(d){ return fmtDate(d, { hour:'2-digit', minute:'2-digit' }); }
      function normalizeText(s){ return (s||'').toString().trim(); }

      function childText(node, names){
        for (const n of names){
          const el = node.querySelector(n);
          if (el && el.textContent) return normalizeText(el.textContent);
        }
        return '';
      }
      function attrOrChild(node, attrs, childs){
        for (const a of (attrs||[])){
          if (node.hasAttribute && node.hasAttribute(a)) return normalizeText(node.getAttribute(a));
        }
        return childText(node, childs||[]);
      }

      function xmlToEventsAndOccasions(xml){
        const doc = typeof xml === 'string'
          ? new DOMParser().parseFromString(xml, 'application/xml')
          : xml;

        // Collect event nodes
        let eventNodes = Array.from(doc.querySelectorAll('event, evenemang, item, evenemangspost'));
        if (eventNodes.length === 0){
          // Some feeds might wrap in <events> with custom child name
          const root = doc.documentElement;
          eventNodes = Array.from(root ? root.children : []).filter(n => n.children && n.children.length);
        }

        const events = [];
        const occasions = [];

        eventNodes.forEach((node, idx) => {
          // Basic bag of children
          const bag = {};
          Array.from(node.children || []).forEach(ch => {
            const key = (ch.tagName || '').toLowerCase();
            if (!key) return;
            const v = normalizeText(ch.textContent || '');
            if (bag[key] === undefined) bag[key] = v;
            else if (Array.isArray(bag[key])) bag[key].push(v);
            else bag[key] = [bag[key], v];
          });

          const id = attrOrChild(node, ['id'], ['id','guid']) || `ev-${idx}`;
          const title = attrOrChild(node, ['title','name'], ['title','name','rubrik','sammanfattning']) || bag.title || bag.name || bag.rubrik || 'Evenemang';
          const startRaw = attrOrChild(node, ['start','starttime'], ['start','starttime','startdatum','datum','date','from']) || bag.start || bag.startdatum || bag.datum || bag.date || bag.from || '';
          const endRaw   = attrOrChild(node, ['end','endtime'],   ['end','endtime','slutdatum','slut','till','to']) || bag.end || bag.slutdatum || bag.slut || bag.till || bag.to || '';
          const place = attrOrChild(node, ['place','venue','location'], ['place','venue','location','plats','lokal']) || bag.place || bag.venue || bag.location || bag.plats || bag.lokal || '';
          const city  = attrOrChild(node, ['city','town'], ['city','town','stad','ort']) || bag.city || bag.stad || bag.ort || '';
          const link  = attrOrChild(node, ['url','link'], ['url','link','lank','länk']) || bag.url || bag.link || '';
          const price = attrOrChild(node, ['price'], ['price','pris','avgift']) || bag.price || bag.pris || '';
          const desc  = attrOrChild(node, [], ['description','desc','beskrivning','info','content']) || bag.description || bag.desc || bag.beskrivning || bag.info || '';

          const start = parseMaybeDate(startRaw);
          const end   = parseMaybeDate(endRaw);

          const ev = { id, title, startRaw, endRaw, start, end, place, city, link, price, desc, raw: bag, _node: node };
          events.push(ev);

          // Extract nested occasions inside this event
          // Try common containers/nodes: <occasions><occasion>...</occasion></occasions> or <tillfallen><tillfalle>...</tillfalle>
          let occNodes = [];
          const container = node.querySelector('occasions, tillfallen, tillfällen');
          if (container) {
            occNodes = Array.from(container.children || []);
          } else {
            // Sometimes occasions are direct children with these names
            occNodes = Array.from(node.querySelectorAll('occasion, tillfalle, tillfälle'));
          }

          occNodes.forEach((occ, j) => {
            // Occasion-specific overrides
            const oDate = attrOrChild(occ, ['date','datum'], ['date','datum','dag','day']);
            const oStart = attrOrChild(occ, ['start','starttime','from','fromtime','starttid'], ['start','starttime','from','fromtime','starttid']);
            const oEnd = attrOrChild(occ, ['end','endtime','to','totime','sluttid'], ['end','endtime','to','totime','sluttid']);
            const oPlace = attrOrChild(occ, ['place','venue','location'], ['place','venue','location','plats','lokal']) || place;
            const oCity  = attrOrChild(occ, ['city','town'], ['city','town','stad','ort']) || city;
            const oLink  = attrOrChild(occ, ['url','link'], ['url','link']) || link;
            const oPrice = attrOrChild(occ, ['price'], ['price','pris','avgift']) || price;

            // Build datetime: prefer explicit date + time, else parse start field if it includes date
            let startOcc = null, endOcc = null;

            if (oDate) {
              const sStr = oStart ? `${oDate} ${oStart}` : `${oDate} 00:00`;
              startOcc = parseMaybeDate(sStr);
              if (oEnd) endOcc = parseMaybeDate(`${oDate} ${oEnd}`);
            } else {
              // Try parse oStart as full datetime
              startOcc = parseMaybeDate(oStart) || parseMaybeDate(startRaw);
              endOcc = parseMaybeDate(oEnd) || parseMaybeDate(endRaw);
            }

            const occItem = {
              id: `${id}#${j+1}`,
              parentId: id,
              title,
              start: startOcc,
              end: endOcc,
              dateRaw: oDate,
              startRaw: oStart || startRaw,
              endRaw: oEnd || endRaw,
              place: oPlace,
              city: oCity,
              link: oLink,
              price: oPrice,
            };
            occasions.push(occItem);
          });
        });

        // Sort base events by start then title
        events.sort((a,b) => {
          const ad = a.start ? a.start.getTime() : Infinity;
          const bd = b.start ? b.start.getTime() : Infinity;
          if (ad !== bd) return ad - bd;
          return a.title.localeCompare(b.title, 'sv');
        });

        // Sort occasions by datetime then title
        occasions.sort((a,b) => {
          const ad = a.start ? a.start.getTime() : Infinity;
          const bd = b.start ? b.start.getTime() : Infinity;
          if (ad !== bd) return ad - bd;
          return a.title.localeCompare(b.title, 'sv');
        });

        return { events, occasions };
      }

      // Events view (cards) — same as before
      function createEventCard(ev){
        const d = ev.start || parseMaybeDate(ev.startRaw);
        const parts = d ? new Intl.DateTimeFormat('sv-SE', { weekday:'short', day:'2-digit', month:'short', year:'numeric', timeZone: tz }).formatToParts(d).reduce((a,p)=> (a[p.type]=p.value, a), {}) : {};
        const dow = (parts.weekday||'').replace('.',''), day=(parts.day||''), month=(parts.month||'').replace('.',''), year=(parts.year||'');

        const card = document.createElement('article');
        card.className = 'card';
        card.setAttribute('role','listitem');

        const date = document.createElement('div');
        date.className = 'datebox';
        date.innerHTML = `
          <div class="dow">${dow}</div>
          <div class="day">${day || '--'}</div>
          <div class="month">${month} ${year}</div>
        `;

        const body = document.createElement('div');
        body.className = 'body';

        const h = document.createElement('h2');
        h.className = 'title';
        const titleLink = document.createElement(ev.link ? 'a' : 'span');
        titleLink.textContent = ev.title || 'Evenemang';
        if (ev.link){ titleLink.href = ev.link; titleLink.target = '_blank'; titleLink.rel = 'noopener noreferrer'; }
        h.appendChild(titleLink);

        const meta = document.createElement('div');
        meta.className = 'meta';

        if (d){
          const timeChip = document.createElement('span');
          timeChip.className = 'chip';
          const timeTxt = ev.end ? `${fmtTime(d)}–${fmtTime(ev.end)}` : fmtTime(d);
          timeChip.innerHTML = `<span class="dot" aria-hidden="true" style="background:var(--accent)"></span>${timeTxt || 'Tid okänd'}`;
          meta.appendChild(timeChip);
        } else if (ev.startRaw){
          const timeChip = document.createElement('span');
          timeChip.className = 'chip';
          timeChip.innerHTML = `<span class="dot" aria-hidden="true" style="background:var(--accent)"></span>${ev.startRaw}`;
          meta.appendChild(timeChip);
        }

        if (ev.place || ev.city){
          const locChip = document.createElement('span');
          locChip.className = 'chip';
          locChip.innerHTML = `<span class="dot" aria-hidden="true" style="background:var(--accent-2)"></span>${[ev.place, ev.city].filter(Boolean).join(', ')}`;
          meta.appendChild(locChip);
        }

        if (ev.price){
          const priceChip = document.createElement('span');
          priceChip.className = 'chip';
          priceChip.innerHTML = `<span class="dot" aria-hidden="true" style="background:var(--warn)"></span>${ev.price}`;
          meta.appendChild(priceChip);
        }

        const hasDesc = !!ev.desc && ev.desc.length > 0;
        const desc = document.createElement('div');
        desc.className = 'desc';
        if (hasDesc){
          const p = document.createElement('p');
          p.style.margin = '6px 0 0';
          p.style.whiteSpace = 'pre-wrap';
          p.textContent = ev.desc;
          desc.appendChild(p);
        }

        if (hasDesc){
          const toggle = document.createElement('span');
          toggle.className = 'toggle';
          toggle.textContent = 'Visa mer';
          toggle.addEventListener('click', () => {
            const open = desc.classList.toggle('open');
            toggle.textContent = open ? 'Visa mindre' : 'Visa mer';
          });
          body.appendChild(toggle);
        }

        body.appendChild(h);
        body.appendChild(meta);
        if (hasDesc) body.appendChild(desc);

        card.appendChild(date);
        card.appendChild(body);
        return card;
      }

      function renderEvents(list){
        els.cards.innerHTML = '';
        if (!list || list.length === 0){
          els.cards.insertAdjacentHTML('beforeend', `<div class="empty" role="status">Inga evenemang matchar dina filter.</div>`);
          return;
        }
        const frag = document.createDocumentFragment();
        for (const ev of list) frag.appendChild(createEventCard(ev));
        els.cards.appendChild(frag);
      }

      // Occasions schedule (group by calendar day)
      function renderSchedule(occList){
        els.schedule.innerHTML = '';
        if (!occList || occList.length === 0){
          els.schedule.insertAdjacentHTML('beforeend', `<div class="empty" role="status">Inga tillfällen matchar dina filter.</div>`);
          return;
        }

        // Group by YYYY-MM-DD
        const groups = new Map();
        for (const o of occList){
          const d = o.start || parseMaybeDate(o.startRaw);
          if (!d) continue;
          const key = fmtDate(d, { year:'numeric', month:'2-digit', day:'2-digit' }).split('-').join('-'); // YYYY-MM-DD
          if (!groups.has(key)) groups.set(key, []);
          groups.get(key).push(o);
        }

        // Sort groups by date
        const keys = Array.from(groups.keys()).sort((a,b) => a.localeCompare(b));

        const frag = document.createDocumentFragment();

        keys.forEach(key => {
          const dayOcc = groups.get(key);
          // Sort within day by start time
          dayOcc.sort((a,b) => {
            const at = (a.start || parseMaybeDate(a.startRaw) || new Date(8640000000000000)).getTime();
            const bt = (b.start || parseMaybeDate(b.startRaw) || new Date(8640000000000000)).getTime();
            return at - bt;
          });

          const d = parseMaybeDate(key);
          const dateLabel = d ? fmtDate(d, { weekday:'long', day:'2-digit', month:'long', year:'numeric' }) : key;

          const wrap = document.createElement('div');
          wrap.className = 'day-group';

          const title = document.createElement('div');
          title.className = 'day-title';
          title.innerHTML = `<span class="date">${dateLabel}</span><span style="opacity:.7">(${dayOcc.length} st)</span>`;

          const rows = document.createElement('div');
          rows.className = 'rows';

          dayOcc.forEach(o => {
            const row = document.createElement('div');
            row.className = 'row';

            const tStart = o.start ? fmtTime(o.start) : (o.startRaw || '');
            const tEnd = o.end ? fmtTime(o.end) : (o.endRaw || '');
            const timeTxt = tEnd ? `${tStart}–${tEnd}` : tStart || 'Tid okänd';

            const time = document.createElement('div');
            time.className = 'time';
            time.textContent = timeTxt;

            const name = document.createElement('div');
            name.className = 'name';
            if (o.link){
              const a = document.createElement('a');
              a.href = o.link; a.target = '_blank'; a.rel = 'noopener noreferrer';
              a.textContent = o.title || 'Tillfälle';
              name.appendChild(a);
            } else {
              name.textContent = o.title || 'Tillfälle';
            }

            const loc = document.createElement('div');
            loc.className = 'loc';
            const locTxt = [o.place, o.city].filter(Boolean).join(', ');
            loc.textContent = locTxt;

            row.appendChild(time);
            row.appendChild(name);
            row.appendChild(loc);
            rows.appendChild(row);
          });

          wrap.appendChild(title);
          wrap.appendChild(rows);
          frag.appendChild(wrap);
        });

        els.schedule.appendChild(frag);
      }

      function applyFilters(){
        const q = els.q.value.trim().toLowerCase();
        const from = els.from.value ? new Date(els.from.value) : null;
        const to = els.to.value ? new Date(els.to.value) : null;
        const toInclusive = to ? new Date(to.getTime() + 24*3600*1000 - 1) : null;

        // Text predicate
        const textMatch = (title, place, city, price, desc) => {
          const hay = [title, place, city, price, desc].filter(Boolean).join(' ').toLowerCase();
          return !q || hay.includes(q);
        };

        if (currentView === 'events'){
          EVENTS_VIEW = RAW_EVENTS.filter(ev => {
            const d = ev.start || parseMaybeDate(ev.startRaw);
            if (!textMatch(ev.title, ev.place, ev.city, ev.price, ev.desc)) return false;
            if (from && d && d < from) return false;
            if (toInclusive && d && d > toInclusive) return false;
            return true;
          });
          renderEvents(EVENTS_VIEW);
          updateSummary(EVENTS_VIEW);
        } else {
          OCCASIONS_VIEW = OCCASIONS_ALL.filter(o => {
            const d = o.start || parseMaybeDate(o.startRaw);
            if (!textMatch(o.title, o.place, o.city, o.price, '')) return false;
            if (from && d && d < from) return false;
            if (toInclusive && d && d > toInclusive) return false;
            return true;
          });
          renderSchedule(OCCASIONS_VIEW);
          updateSummary(OCCASIONS_VIEW);
        }
      }

      function updateSummary(list){
        const n = list.length;
        els.count.textContent = `${n} ${currentView === 'events' ? 'evenemang' : 'tillfällen'}`;
        if (!n){ els.status.textContent = ''; return; }
        const first = list[0], last = list[list.length-1];
        const ds = first?.start ? fmtDate(first.start, { dateStyle:'medium' }) : '';
        const de = last?.start ? fmtDate(last.start, { dateStyle:'medium' }) : '';
        els.status.textContent = [ds, de].filter(Boolean).join(' – ');
      }

      async function fetchData(){
        els.count.innerHTML = '<span class="spinner" aria-hidden="true"></span> Läser in…';
        els.status.textContent = '';
        els.fallback.innerHTML = '';
        els.cards.innerHTML = '';
        els.schedule.innerHTML = '';

        try{
          const res = await fetch(API_URL, { mode: 'same-origin', cache: 'no-store' });
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          const xmlText = await res.text();

          const parsed = new DOMParser().parseFromString(xmlText, 'application/xml');
          const parseErr = parsed.querySelector('parsererror');
          if (parseErr) throw new Error('XML kunde inte tolkas');

          const { events, occasions } = xmlToEventsAndOccasions(parsed);
          RAW_EVENTS = events;
          OCCASIONS_ALL = occasions;

          // Default view: occasions schedule
          setView(currentView);
        } catch (err){
          console.error(err);
          els.count.textContent = 'Fel vid hämtning';
          els.status.textContent = '';
          els.fallback.innerHTML = `<div class="error">Kunde inte hämta data från proxy/API.<br><small>${(err && err.message) ? err.message : 'Okänt fel'}</small></div>`;
        }
      }

      function debounce(fn, ms){ let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn.apply(null, args), ms); }; }

      // Wire up
      els.q.addEventListener('input', debounce(applyFilters, 120));
      els.from.addEventListener('change', applyFilters);
      els.to.addEventListener('change', applyFilters);

      // Init view from URL ?view=events|occasions and date range
      const params = new URLSearchParams(location.search);
      const v = params.get('view');
      if (v === 'events' || v === 'occasions') currentView = v;
      if (params.get('from')) els.from.value = params.get('from');
      if (params.get('to')) els.to.value = params.get('to');

      // Show the correct section visibility before data arrives
      els.schedule.hidden = currentView !== 'occasions';
      els.cards.hidden = currentView !== 'events';
      els.btnOcc.setAttribute('aria-pressed', currentView === 'occasions' ? 'true' : 'false');
      els.btnEvt.setAttribute('aria-pressed', currentView === 'events' ? 'true' : 'false');

      fetchData();
    </script>
  </body>
</html>