const SVG_ICONS = {
    'users': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>`,
    'brain': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18ZM12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18ZM12 5v14M12 9h4a2 2 0 0 0 0-4h-4M12 13h3a2 2 0 0 0 0-4h-3M12 17h2a2 2 0 0 0 0-4h-2M12 9H8a2 2 0 0 1 0-4h4M12 13H9a2 2 0 0 1 0-4h3M12 17H10a2 2 0 0 1 0-4h2"/>`,
    'bulb': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>`,
    'spaces': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>`,
    'airport': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>`,
    'calendar': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>`,
    'board': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>`,
    'ticket': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>`,
    'links': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>`,
    'phone': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>`,
    'arrow-back': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>`,
    'mixer': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>`,
    'database': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>`,
    'training': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>`,
    'equipment': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>`,
    'forms': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>`,
    'guides': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>`,
    'mail': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>`,
    'blackout': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>`,
    'access': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>`,
    'bolt': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>`,
    'check-circle': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>`,
    'rank-samar': `<g transform="skewX(-20) translate(15, 6)" fill="currentColor"><rect x="0" y="0" width="32" height="5" rx="1"/><rect x="0" y="9" width="32" height="5" rx="1"/><rect x="0" y="18" width="32" height="5" rx="1"/></g><circle cx="25" cy="17" r="4.5" fill="white" stroke="currentColor" stroke-width="2"/>`,
    'rank-aatz': `<circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21v-1a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 16l2 3 2-3"/>`,
    'rank-rabat': `<g transform="skewX(-20) translate(15, 10)" fill="currentColor"><rect x="0" y="0" width="32" height="5" rx="1"/><rect x="0" y="9" width="32" height="5" rx="1"/></g>`,
    'rank-samal': `<g transform="skewX(-20) translate(15, 6)" fill="currentColor"><rect x="0" y="0" width="32" height="5" rx="1"/><rect x="0" y="9" width="32" height="5" rx="1"/><rect x="0" y="18" width="32" height="5" rx="1"/></g>`,
    'rank-sagam': `<g fill="currentColor"><rect x="21" y="8" width="8" height="24" rx="1.5"/></g>`,
    'rank-segen': `<g fill="currentColor"><rect x="15" y="8" width="8" height="24" rx="1.5"/><rect x="27" y="8" width="8" height="24" rx="1.5"/></g>`,
    'rank-seren': `<g fill="currentColor"><rect x="9" y="8" width="8" height="24" rx="1.5"/><rect x="21" y="8" width="8" height="24" rx="1.5"/><rect x="33" y="8" width="8" height="24" rx="1.5"/></g>`,
    'rank-rasan': `<g transform="translate(25, 20) scale(0.85) translate(-25, -20)"><path d="M 25 6 L 29 16 L 40 14 L 33 22 L 38 30 L 26 27 L 26 34 L 24 34 L 24 27 L 12 30 L 17 22 L 10 14 L 21 16 Z" fill="currentColor" stroke="currentColor" stroke-width="3" stroke-linejoin="round" /></g>`,
    'rank-saal': `<g transform="translate(14, 20) scale(0.65) translate(-25, -20)"><path d="M 25 6 L 29 16 L 40 14 L 33 22 L 38 30 L 26 27 L 26 34 L 24 34 L 24 27 L 12 30 L 17 22 L 10 14 L 21 16 Z" fill="currentColor" stroke="currentColor" stroke-width="3" stroke-linejoin="round" /></g><g transform="translate(36, 20) scale(0.65) translate(-25, -20)"><path d="M 25 6 L 29 16 L 40 14 L 33 22 L 38 30 L 26 27 L 26 34 L 24 34 L 24 27 L 12 30 L 17 22 L 10 14 L 21 16 Z" fill="currentColor" stroke="currentColor" stroke-width="3" stroke-linejoin="round" /></g>`,
    'x': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>`,
    'moon': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>`,
    'sun': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>`,
    'user': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>`,
    'arrow-back': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>`,
    'check': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>`,
    'map-pin': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0L6.343 16.657a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3" stroke-width="2"/>`,
    'alert-triangle': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>`,
    'info': `<circle cx="12" cy="12" r="10" stroke-width="2"/><line x1="12" y1="16" x2="12" y2="12" stroke-width="2"/><line x1="12" y1="8" x2="12.01" y2="8" stroke-width="2.5"/>`,
    'home': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>`,
    'edit-2': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>`,
    'trash-2': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>`,
    'chevron-down': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>`,
    'tool': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>`,
    'file-text': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>`,
    'printer': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>`,
    'help-circle': `<circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3m0 4h.01"/>`,
    'search': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>`,
    'save': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-8H7v8M7 3v5h8"/>`,
    'check': `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>`
};

class UiIcon extends HTMLElement {
    static get observedAttributes() { return ['name', 'class', 'viewbox']; }
    attributeChangedCallback() { this.render(); }
    connectedCallback() { this.render(); }
    render() {
        const name = this.getAttribute('name');
        const cls = this.getAttribute('class') || '';
        let vb = this.getAttribute('viewbox');
        if (!vb || vb === '0 0 50 40' || vb === '0 0 24 24') {
            if (name && name.startsWith('rank-') && name !== 'rank-aatz') {
                vb = '0 0 50 40';
            } else {
                vb = '0 0 24 24';
            }
        }
        const rawSvg = SVG_ICONS[name];
        if (rawSvg) {
            this.innerHTML = `<svg class="${cls}" fill="none" viewBox="${vb}" stroke="currentColor">${rawSvg}</svg>`;
        }
    }
}

if (!customElements.get('ui-icon')) {
    customElements.define('ui-icon', UiIcon);
}

// Dark Mode Management
function toggleDarkMode() {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('mch_theme', isDark ? 'dark' : 'light');
    updateThemeIcon(isDark);
}

function updateThemeIcon(isDark) {
    const icons = document.querySelectorAll('button[onclick="toggleDarkMode()"] ui-icon, button[title="מצב חשוך"] ui-icon, button[title="שינוי ערכת נושא"] ui-icon, button[title="חזרה לאתר מחשוב"] ui-icon');
    icons.forEach(icon => {
        icon.setAttribute('name', isDark ? 'sun' : 'moon');
        const cls = icon.getAttribute('class') || '';
        const vb = icon.getAttribute('viewbox') || '0 0 24 24';
        const rawSvg = SVG_ICONS[isDark ? 'sun' : 'moon'];
        if (rawSvg) {
            icon.innerHTML = `<svg class="${cls}" fill="none" viewBox="${vb}" stroke="currentColor">${rawSvg}</svg>`;
        }
    });
}

// Load dark mode preference automatically
if (localStorage.getItem('mch_theme') === 'dark') {
    document.documentElement.classList.add('dark');
    document.addEventListener('DOMContentLoaded', () => updateThemeIcon(true));
}

// Sync dark mode state between multiple tabs/windows
window.addEventListener('storage', (e) => {
    if (e.key === 'mch_theme') {
        const isDark = e.newValue === 'dark';
        document.documentElement.classList.toggle('dark', isDark);
        updateThemeIcon(isDark);
    }
});

// Google Chrome browser compatibility check
function checkBrowserChrome() {
    const ua = navigator.userAgent;
    const isEdge = /Edg\/|Edge\//i.test(ua);
    const isOpera = /OPR\//i.test(ua);
    const isFirefox = /Firefox\//i.test(ua);
    const isChrome = /Chrome\//i.test(ua) && !isEdge && !isOpera && !isFirefox;

    if (!isChrome) {
        const banner = document.createElement('div');
        banner.id = 'browser-compatibility-banner';
        banner.style.cssText = 'width:100%; background-color:#f59e0b; color:#0f172a; padding:12px 16px; font-weight:800; text-align:center; display:flex; align-items:center; justify-content:center; gap:12px; position:fixed; top:0; left:0; right:0; z-index:99999; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1); border-bottom:3px solid #d97706; direction:rtl;';
        banner.innerHTML = `
            <div style="display:flex; align-items:center; gap:8px; margin:0 auto;">
                <svg style="width:20px; height:20px; flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>שים לב: מערכת זו מותאמת בצורה מיטבית לדפדפן Google Chrome בלבד. מומלץ לפתוח אותה ב-Chrome לחוויית שימוש תקינה.</span>
            </div>
            <button onclick="document.getElementById('browser-compatibility-banner').style.display='none'" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); background:none; border:none; color:#0f172a; font-size:20px; font-weight:800; cursor:pointer; padding:4px; line-height:1;">✕</button>
        `;
        document.body.insertBefore(banner, document.body.firstChild);
    }
}

document.addEventListener('DOMContentLoaded', checkBrowserChrome);

// נרמול טקסט עברי: הורדת רישיות, ניקוד, גרש/גרשיים/מרכאות, איחוד אותיות סופיות, וסימני פיסוק
function normHeb(s) {
    if (s === null || s === undefined) return '';
    return String(s)
        .toLowerCase()
        .replace(/[֑-ׇ]/g, '')            // ניקוד וטעמים
        .replace(/[׳״'"׳״`]/g, '')        // גרש / גרשיים / מרכאות
        .replace(/ם/g, 'מ').replace(/ן/g, 'נ').replace(/ף/g, 'פ').replace(/ץ/g, 'צ').replace(/ך/g, 'כ')
        .replace(/[^א-ת0-9a-z\s]/g, ' ')  // כל שאר סימני הפיסוק -> רווח
        .replace(/\s+/g, ' ')
        .trim();
}
window.normHeb = normHeb;

// פונקציות דיאלוג והתראות מותאמות גלובליות
if (typeof window.showCustomAlert === 'undefined') {
    window.showCustomAlert = function(msg) {
        let modal = document.getElementById('custom-alert-modal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'custom-alert-modal';
            modal.className = 'fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[10000] flex items-center justify-center';
            modal.dir = 'rtl';
            modal.innerHTML = `
                <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-2xl p-6 w-full max-w-sm mx-4 transform transition-all text-center">
                    <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-950/30 flex items-center justify-center mx-auto mb-4 text-rose-600 dark:text-rose-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white mb-2">הודעת מערכת</h3>
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-6" id="custom-alert-msg"></p>
                    <button onclick="document.getElementById('custom-alert-modal').remove()" class="w-full py-3 bg-slate-900 hover:bg-slate-800 dark:bg-white dark:hover:bg-slate-100 text-white dark:text-slate-950 rounded-xl font-extrabold text-sm transition-colors shadow-sm">הבנתי</button>
                </div>
            `;
            document.body.appendChild(modal);
        }
        document.getElementById('custom-alert-msg').textContent = msg;
        modal.classList.remove('hidden');
    };
}

if (typeof window.showCustomConfirm === 'undefined') {
    window.showCustomConfirm = function(msg, onConfirm) {
        let modal = document.getElementById('custom-confirm-modal');
        if (modal) modal.remove();
        
        modal = document.createElement('div');
        modal.id = 'custom-confirm-modal';
        modal.className = 'fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[10001] flex items-center justify-center';
        modal.dir = 'rtl';
        modal.innerHTML = `
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-2xl p-6 w-full max-w-sm mx-4 transform transition-all text-center text-gray-800 dark:text-white">
                <div class="w-12 h-12 rounded-full bg-[#3776AB]/10 dark:bg-[#38bdf8]/10 flex items-center justify-center mx-auto mb-4 text-[#3776AB] dark:text-[#38bdf8]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-white mb-2">אישור פעולה</h3>
                <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-6" id="custom-confirm-msg"></p>
                <div class="flex gap-3">
                    <button id="custom-confirm-btn" class="flex-1 py-3 bg-[#3776AB] hover:bg-[#2b5d87] text-white rounded-xl font-extrabold text-sm transition-colors shadow-sm">אשר</button>
                    <button onclick="document.getElementById('custom-confirm-modal').remove()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 dark:text-slate-300 rounded-xl font-extrabold text-sm border border-slate-200 dark:border-slate-700 transition-colors">ביטול</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        document.getElementById('custom-confirm-msg').textContent = msg;
        document.getElementById('custom-confirm-btn').onclick = () => {
            modal.remove();
            onConfirm();
        };
    };
}

if (typeof window.showSuccessAlert === 'undefined') {
    window.showSuccessAlert = function(msg) {
        let toast = document.getElementById('custom-success-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'custom-success-toast';
            toast.className = 'fixed bottom-5 right-5 bg-emerald-600 text-white px-4 py-3 rounded-2xl shadow-xl flex items-center gap-2.5 z-[10000] transition-all duration-300 transform translate-y-10 opacity-0 font-bold text-sm';
            toast.dir = 'rtl';
            toast.innerHTML = `
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="width:20px;height:20px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                <span id="custom-success-msg"></span>
            `;
            document.body.appendChild(toast);
        }
        document.getElementById('custom-success-msg').textContent = msg;
        
        setTimeout(() => {
            toast.className = 'fixed bottom-5 right-5 bg-emerald-600 text-white px-4 py-3 rounded-2xl shadow-xl flex items-center gap-2.5 z-[10000] transition-all duration-300 transform translate-y-0 opacity-100 font-bold text-sm';
        }, 50);
        
        setTimeout(() => {
            toast.className = 'fixed bottom-5 right-5 bg-emerald-600 text-white px-4 py-3 rounded-2xl shadow-xl flex items-center gap-2.5 z-[10000] transition-all duration-300 transform translate-y-10 opacity-0 font-bold text-sm';
        }, 3000);
    };
}
