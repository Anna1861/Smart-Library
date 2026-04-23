@extends('welcome')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Mono:wght@300;400;500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
:root {
    --bg:           #0b0c10;
    --bg-elevated:  #111318;
--bg-card:      #1e2230;     /* основной серый */
--bg-card-alt:  #262b3a;     /* чуть светлее */
--bg-hover:     #2c3142;     /* ховер тоже светлее */

    --border:       rgba(255,255,255,0.07);
    --border-light: rgba(255,255,255,0.04);

    --text:         #ede8da;
    --text-muted:   #5f6278;
    --text-soft:    #9a96a6;

    --gold:         #d4923a;
    --gold-bright:  #f0ac4e;
    --gold-dim:     rgba(212,146,58,0.12);
    --teal:         #3dcfb0;
    --teal-dim:     rgba(61,207,176,0.1);
    --rose:         #e0605a;
    --rose-dim:     rgba(224,96,90,0.1);
    --violet:       #9b7de8;
    --sky:          #4fa8d4;

    --shadow-card:  0 4px 32px rgba(0,0,0,0.45);
    --shadow-glow:  0 0 40px rgba(212,146,58,0.08);

    --r-sm:  8px;
    --r-md:  14px;
    --r-lg:  20px;

    --ease: cubic-bezier(0.22, 1, 0.36, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    color: var(--text);
    font-size: 14px;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    min-height: 100vh;

    background-image:
        radial-gradient(ellipse 80% 50% at 50% -10%, rgba(212,146,58,0.06), transparent),
        url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
}

.dash-wrap {
    max-width: 100%;
    width: 100%;
    margin: 0;
    padding: 40px 56px 80px;
}

.dash-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 44px;
    padding-bottom: 28px;
    border-bottom: 1px solid var(--border);
    gap: 16px;
    flex-wrap: wrap;
}

.dash-header-left {}

.dash-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 10px;
}

.dash-eyebrow::before {
    content: '';
    display: inline-block;
    width: 16px;
    height: 1px;
    background: var(--gold);
    opacity: 0.6;
}

.dash-title {
    font-size: 36px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: var(--text);
    line-height: 1.15;
}

.dash-title span {
    color: var(--gold-bright);
}

.dash-date {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 6px;
}

.dash-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 100px;
    border: 1px solid var(--border);
    background: var(--bg-card);
    font-size: 11px;
    color: var(--text-soft);
    letter-spacing: 0.5px;
    transition: border-color 0.25s var(--ease), color 0.25s var(--ease);
    cursor: default;
    white-space: nowrap;
}

html, body {
    width: 100%;
    height: 100%;
    overflow-x: hidden;
}

.dash-badge:hover {
    border-color: var(--gold);
    color: var(--gold-bright);
}

.dash-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--teal);
    box-shadow: 0 0 6px var(--teal);
    animation: pulse 2.5s ease infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.35; }
}

.stat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}

.stat-card {
    position: relative;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 24px 26px 22px;
    overflow: hidden;
    transition: border-color 0.3s var(--ease), transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
    cursor: default;
}

.stat-card::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.3s var(--ease);
    border-radius: inherit;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-card);
}

.stat-card--total { border-top: 2px solid var(--gold); }
.stat-card--total::before { background: var(--gold-dim); }
.stat-card--total:hover { border-color: var(--gold-bright); }
.stat-card--total:hover::before { opacity: 1; }

.stat-card--available { border-top: 2px solid var(--teal); }
.stat-card--available::before { background: var(--teal-dim); }
.stat-card--available:hover { border-color: var(--teal); border-left-color: var(--border); border-right-color: var(--border); border-bottom-color: var(--border); }
.stat-card--available:hover::before { opacity: 1; }

.stat-card--borrowed { border-top: 2px solid var(--rose); }
.stat-card--borrowed::before { background: var(--rose-dim); }
.stat-card--borrowed:hover { border-color: var(--rose); border-left-color: var(--border); border-right-color: var(--border); border-bottom-color: var(--border); }
.stat-card--borrowed:hover::before { opacity: 1; }

.stat-card-inner { position: relative; z-index: 1; }

.stat-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--r-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    font-size: 16px;
}

.stat-icon--total    { background: var(--gold-dim); color: var(--gold-bright); }
.stat-icon--available { background: var(--teal-dim); color: var(--teal); }
.stat-icon--borrowed  { background: var(--rose-dim); color: var(--rose); }

.stat-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    margin-bottom: 4px;
}

.stat-value {
    font-size: 42px;
    font-weight: 700;
    line-height: 1;
    letter-spacing: -1px;
}

.stat-value--total    { color: var(--text); }
.stat-value--available { color: var(--teal); }
.stat-value--borrowed  { color: var(--rose); }

.stat-footer {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid var(--border-light);
    font-size: 11px;
    color: var(--text-muted);
}

.stat-pill {
    display: inline-block;
    padding: 2px 7px;
    border-radius: 100px;
    font-size: 10px;
    margin-right: 4px;
}

.stat-pill--pos { background: rgba(61,207,176,0.12); color: var(--teal); }
.stat-pill--neg { background: rgba(224,96,90,0.12);  color: var(--rose); }

.panel-grid {
    display: grid;
    grid-template-columns: 1.45fr 1fr;
    gap: 14px;
}

.card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px 0;
}

.card-title-wrap {}

.card-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--text);
}

.card-subtitle {
    font-size: 10px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 2px;
}

.card-action {
    font-size: 10px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 5px 10px;
    border-radius: 6px;
    border: 1px solid var(--border);
    cursor: pointer;
    background: transparent;
    transition: color 0.2s, border-color 0.2s;
}

.card-action:hover { color: var(--gold-bright); border-color: var(--gold); }

.card-body {
    padding: 20px 24px 24px;
    flex: 1;
}

.chart-container {
    position: relative;
    width: 100%;
}

.chart-legend-custom {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 20px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--border-light);
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 11px;
    color: var(--text-soft);
    cursor: default;
    transition: color 0.2s;
}

.legend-item:hover { color: var(--text); }

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.borrow-list { list-style: none; }

.borrow-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 13px 0;
    border-bottom: 1px solid var(--border-light);
    transition: background 0.2s var(--ease);
    margin: 0 -4px;
    padding-left: 4px;
    padding-right: 4px;
    border-radius: var(--r-sm);
    cursor: default;
}

.borrow-item:last-child { border-bottom: none; }
.borrow-item:hover { background: var(--bg-hover); }

.borrow-index {
    font-size: 10px;
    color: var(--text-muted);
    width: 16px;
    padding-top: 2px;
    flex-shrink: 0;
    text-align: right;
}

.borrow-avatar {
    width: 32px;
    height: 32px;
    border-radius: var(--r-sm);
    background: var(--bg-card-alt);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    color: var(--gold-bright);
    flex-shrink: 0;
    letter-spacing: -0.5px;
    transition: background 0.2s;
}

.borrow-item:hover .borrow-avatar {
    background: var(--gold-dim);
}

.borrow-info { flex: 1; min-width: 0; }

.borrow-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}

.borrow-meta {
    font-size: 10px;
    color: var(--text-muted);
    margin-top: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.borrow-status {
    flex-shrink: 0;
    padding: 3px 9px;
    border-radius: 100px;
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--rose-dim);
    color: var(--rose);
    margin-top: 1px;
}

.section-divider {
    height: 1px;
    background: var(--border);
    margin: 24px 0;
    position: relative;
}

.section-divider::after {
    content: attr(data-label);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--text-muted);
    background: var(--bg);
    padding: 0 12px;
}

::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }

@media (max-width: 900px) {
    .panel-grid { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .dash-wrap { padding: 24px 16px 60px; }
    .dash-title { font-size: 26px; }
    .stat-grid { grid-template-columns: 1fr; gap: 10px; }
    .stat-value { font-size: 34px; }
    .dash-header { flex-direction: column; align-items: flex-start; }
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

.dash-header        { animation: fadeUp 0.5s var(--ease) both; }
.stat-grid          { animation: fadeUp 0.5s var(--ease) 0.08s both; }
.panel-grid         { animation: fadeUp 0.5s var(--ease) 0.16s both; }


.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 18px;
}

.book-card {
    background: var(--bg-card-alt);
    border-radius: var(--r-md);
    overflow: hidden;
    border: 1px solid var(--border);
    transition: all 0.3s var(--ease);
    cursor: pointer;
}

.book-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 10px 40px rgba(0,0,0,0.6);
    border-color: var(--gold);
}

.book-cover {
    width: 100%;
    height: 220px;
    overflow: hidden;
}

.book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-info {
    padding: 12px;
}

.book-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.3;
}

.book-author {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 3px;
}

.book-status {
    margin-top: 8px;
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 100px;
    display: inline-block;
}

.book-status.available {
    background: var(--teal-dim);
    color: var(--teal);
}

.book-status.borrowed {
    background: var(--rose-dim);
    color: var(--rose);
}

.stat-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}

.stat-icon {
    margin-bottom: 0;
}

.stat-label {
    margin-bottom: 0;
}
.dash-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    border-radius: 16px;

    background: linear-gradient(135deg, #0f172a, #1e293b);
    border: 1px solid rgba(255,255,255,0.05);
}

/* ЛЕВО */
.dash-left {
    display: flex;
    flex-direction: column;
}

.dash-title {
    color: #fff;
    margin: 0;
}

.dash-eyebrow {
    font-size: 12px;
    opacity: 0.7;
    color: #ffd002;
}
.dash-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}

/* LIVE */
.live-row {
    display: flex;
    align-items: center;
    gap: 6px;
}

.live-text {
    font-size: 12px;
    letter-spacing: 1px;
    color: #22c55e;
}

.dot {
    width: 8px;
    height: 8px;
    background: #22c55e;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}

/* дата */
.dash-date {
    font-size: 12px;
    color: #94a3b8;
}

/* сенсоры */
.sensor-inline {
    display: flex;
    gap: 16px;
    margin-top: 4px;
}

.sensor-box {
    display: flex;
    align-items: center;
    gap: 6px;

    font-size: 16px;
    font-weight: 500;
    color: #e2e8f0;
}

.sensor-box .value {
    font-size: 18px;
    font-weight: 600;
}

.sensor-box .unit {
    font-size: 13px;
    opacity: 0.7;
}
</style>


<div class="dash-wrap">

<header class="dash-header">
    <div class="dash-left">
        <div class="dash-eyebrow">Smart Library</div>
        <h1 class="dash-title">Bestandsübersicht</h1>
    </div>

<div class="dash-right">
    <div class="live-row">
        <span class="dot"></span>
        <span class="live-text">LIVE</span>
    </div>

    <div class="dash-date" id="js-date"></div>

    <div class="sensor-inline">
        <div class="sensor-box">
            <span class="icon">🌡</span>
            <span class="value" id="temp">--</span>
            <span class="unit">°C</span>
        </div>

        <div class="sensor-box">
            <span class="icon">💧</span>
            <span class="value" id="hum">--</span>
            <span class="unit">%</span>
        </div>
    </div>
</div>
</header>

    <div class="stat-grid">

<div class="stat-card stat-card--total">
    <div class="stat-card-inner">
            <div class="stat-head">
                <div class="stat-icon stat-icon--total">&#9776;</div>
                <div class="stat-label">Gesamtanzahl Bücher</div>
            </div>
            <div class="stat-value stat-value--total">{{ $totalBooks }}</div>
        <div class="stat-footer">Gesamter Katalog</div>
 </div>
 </div>

        <div class="stat-card stat-card--available">
            <div class="stat-card-inner">
         <div class="stat-head">
    <div class="stat-icon stat-icon--available">&#10003;</div>
    <div class="stat-label">Verfügbar</div>
</div>
                <div class="stat-value stat-value--available">{{ $availableBooks }}</div>
                <div class="stat-footer">
                    <span class="stat-pill stat-pill--pos">
                        @php $pct = $totalBooks > 0 ? round(($availableBooks / $totalBooks) * 100) : 0; @endphp
                        {{ $pct }}%
                    </span>
                    vom gesamten Katalog
                </div>
            </div>
        </div>

        <div class="stat-card stat-card--borrowed">
            <div class="stat-card-inner">
           <div class="stat-head">
    <div class="stat-icon stat-icon--borrowed">&#8593;</div>
    <div class="stat-label">Ausgeliehen</div>
</div>
                <div class="stat-value stat-value--borrowed">{{ $borrowedBooks }}</div>
                <div class="stat-footer">
                    <span class="stat-pill stat-pill--neg">
                        @php $bpct = $totalBooks > 0 ? round(($borrowedBooks / $totalBooks) * 100) : 0; @endphp
                        {{ $bpct }}%
                    </span>
                    derzeit ausgeliehen
                </div>
            </div>
        </div>

    </div>

    <div class="panel-grid">

        <div class="card">
            <div class="card-header">
                <div class="card-title-wrap">
                    <div class="card-title">Ausgeliehen nach Genre</div>
                    <div class="card-subtitle">Verteilung · insgesamt</div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <canvas id="genreChart" height="210"></canvas>
                </div>

                <div class="chart-legend-custom" id="chartLegend"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title-wrap">
                    <div class="card-title">Zuletzt ausgeliehen</div>
                    <div class="card-subtitle">Neueste · in Echtzeit</div>
                </div>
            </div>

            <div class="card-body" style="padding-top:10px;">
                <ul class="borrow-list">
                    @foreach($lastBorrowed as $index => $borrow)
                        <li class="borrow-item">
                            <span class="borrow-index">{{ $index + 1 }}</span>

                            <div class="borrow-avatar">
                                {{ strtoupper(substr($borrow->book->title, 0, 1)) }}
                            </div>

                            <div class="borrow-info">
                                <div class="borrow-title">{{ $borrow->book->title }}</div>
                                <div class="borrow-meta">
                                    {{ $borrow->book->author }}
                                    &nbsp;·&nbsp;
                                    {{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('M d, Y') }}
                                </div>
                            </div>

                            <span class="borrow-status">Ausgeliehen</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dateEl = document.getElementById('js-date');
    if (dateEl) {
        const now = new Date();
        dateEl.textContent = now.toLocaleDateString('en-GB', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }

    const PALETTE = ['#d4923a', '#3dcfb0', '#e0605a', '#9b7de8', '#4fa8d4', '#e8c94f'];

    const labels = {!! json_encode($genreStats->pluck('name')) !!};
    const values = {!! json_encode($genreStats->pluck('borrowed_count')) !!};

    const legendEl = document.getElementById('chartLegend');
    if (legendEl) {
        labels.forEach((label, i) => {
            const item = document.createElement('div');
            item.className = 'legend-item';
            item.innerHTML = `
                <span class="legend-dot" style="background:${PALETTE[i % PALETTE.length]}"></span>
                ${label}
            `;
            legendEl.appendChild(item);
        });
    }

    new Chart(document.getElementById('genreChart'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: PALETTE.map(c => c + 'cc'),
                hoverBackgroundColor: PALETTE,
                borderWidth: 2,
                borderColor: '#13151c',
                hoverBorderColor: '#1c1f2a',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#181b24',
                    borderColor: 'rgba(255,255,255,0.07)',
                    borderWidth: 1,
                    titleColor: '#ede8da',
                    bodyColor: '#9a96a6',
                    titleFont: { family: "'DM Sans', sans-serif", size: 13, weight: '600' },
                    bodyFont: { family: "'DM Mono', monospace", size: 11 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => `  ${ctx.formattedValue} borrowed`
                    }
                }
            },
            animation: {
                animateRotate: true,
                duration: 900,
                easing: 'easeInOutQuart'
            }
        }
    });

});
</script>

@endsection
