<?php
    $CI               = &get_instance();
    $isKasirDashboard = $CI->session->userdata('level') == 'Kasir';
    $dashboardMode    = $isKasirDashboard ? 'kasir' : 'main';
    $dashboardKicker  = $isKasirDashboard ? 'Dashboard Kasir' : 'Dashboard Transaksi';
    $dashboardTitle   = $isKasirDashboard
    ? 'Pantau transaksi kasir, dine in, dan takeaway dari satu dashboard yang lebih rapi.'
    : 'Pantau dine in dan takeaway dari satu dashboard yang lebih rapi.';
    $dashboardCopy = $isKasirDashboard
    ? 'Ringkasan ini dirapikan untuk kebutuhan kasir: baca omzet, volume transaksi, kontribusi takeaway, dan pola transaksi harian tanpa perlu pindah halaman.'
    : 'Ringkasan ini menonjolkan omzet, volume transaksi, kontribusi takeaway, dan pola transaksi harian supaya kasir atau owner bisa cepat membaca kondisi operasional.';
    $dashboardFilterTitle = $isKasirDashboard
    ? 'Tarik insight shift kasir sesuai tanggal'
    : 'Tarik insight transaksi sesuai tanggal';
    $dashboardFilterCopy = $isKasirDashboard
    ? 'Semua card, chart, dan data takeaway akan mengikuti range ini agar pembacaan operasional kasir tetap konsisten.'
    : 'Semua card, chart, dan data takeaway akan mengikuti range ini.';
    $dashboardFilterBadge = $isKasirDashboard ? 'Kasir Live' : 'Live';
    $dashboardButtonLabel = $isKasirDashboard ? 'Muat Dashboard Kasir' : 'Muat Dashboard';
?>

<div ng-app="HomeKasirApp" ng-controller="HomeKasirController" data-home-dashboard="<?php echo $dashboardMode ?>">
    <div class="page-wrapper">
        <div class="page-content dashboard-home-page">
            <div class="card border-0 dashboard-hero-card">
                <div class="card-body">
                    <div class="row g-4 align-items-end">
                        <div class="col-lg-7">
                            <span class="dashboard-hero-kicker"><?php echo $dashboardKicker ?></span>
                            <h2 class="dashboard-hero-title"><?php echo $dashboardTitle ?></h2>
                            <p class="dashboard-hero-copy"><?php echo $dashboardCopy ?></p>

                            <div class="dashboard-hero-glance">
                                <div class="dashboard-glance-pill">
                                    <small>Share Takeaway</small>
                                    <strong>{{dashboard.summary.takeaway_share | number:1}}%</strong>
                                </div>
                                <div class="dashboard-glance-pill">
                                    <small>Dine In Aktif</small>
                                    <strong>{{dashboard.summary.dine_in_count_transaksi | number:0}} transaksi</strong>
                                </div>
                                <div class="dashboard-glance-pill">
                                    <small>Periode</small>
                                    <strong>{{dashboard.date_start || '-'}} s/d {{dashboard.date_end || '-'}}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="dashboard-filter-card">
                                <div class="dashboard-filter-head">
                                    <div>
                                        <small>Filter Periode</small>
                                        <h5 class="mb-1"><?php echo $dashboardFilterTitle ?></h5>
                                        <p class="mb-0"><?php echo $dashboardFilterCopy ?></p>
                                    </div>
                                    <span class="dashboard-filter-badge">
                                        <i class="bx bx-calendar-event"></i>
                                        <span><?php echo $dashboardFilterBadge ?></span>
                                    </span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label dashboard-filter-label" for="date_start">From
                                            Date</label>
                                        <input type="date" class="form-control dashboard-filter-input" id="date_start"
                                            value="<?php echo date('Y-m-01') ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label dashboard-filter-label" for="date_end">To Date</label>
                                        <input type="date" class="form-control dashboard-filter-input" id="date_end"
                                            value="<?php echo date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <button type="button" class="btn dashboard-filter-button w-100 mt-3"
                                    ng-click="getSalesReport()">
                                    <i class="bx bx-search-alt"></i>
                                    <span><?php echo $dashboardButtonLabel ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 dashboard-summary-grid">
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 dashboard-stat-card dashboard-stat-card-amount h-100">
                        <div class="card-body">
                            <span class="dashboard-stat-icon">
                                <i class="bx bx-wallet"></i>
                            </span>
                            <small>Omzet Total</small>
                            <h4>Rp {{dashboard.summary.total_revenue | number:0}}</h4>
                            <p>Total omzet seluruh transaksi pada periode aktif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 dashboard-stat-card dashboard-stat-card-visitor h-100">
                        <div class="card-body">
                            <span class="dashboard-stat-icon">
                                <i class="bx bx-group"></i>
                            </span>
                            <small>Total Visitor</small>
                            <h4>{{dashboard.summary.total_visitor | number:0}}</h4>
                            <p>Jumlah order yang masuk pada rentang tanggal yang dipilih.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 dashboard-stat-card dashboard-stat-card-transaction h-100">
                        <div class="card-body">
                            <span class="dashboard-stat-icon">
                                <i class="bx bx-receipt"></i>
                            </span>
                            <small>Total Transaksi</small>
                            <h4>{{dashboard.summary.total_count_transaksi | number:0}}</h4>
                            <p>Invoice yang tercatat dan sudah masuk ke rangkuman dashboard.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 dashboard-stat-card dashboard-stat-card-takeaway h-100">
                        <div class="card-body">
                            <span class="dashboard-stat-icon">
                                <i class="bx bx-shopping-bag"></i>
                            </span>
                            <small>Transaksi Takeaway</small>
                            <h4>{{dashboard.summary.takeaway_count_transaksi | number:0}}</h4>
                            <p>Jumlah invoice takeaway yang teridentifikasi dari order dan service.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 dashboard-stat-card dashboard-stat-card-takeaway-amount h-100">
                        <div class="card-body">
                            <span class="dashboard-stat-icon">
                                <i class="bx bx-store-alt"></i>
                            </span>
                            <small>Omzet Takeaway</small>
                            <h4>Rp {{dashboard.summary.takeaway_revenue | number:0}}</h4>
                            <p>Total kontribusi omzet takeaway terhadap transaksi yang berjalan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 dashboard-stat-card dashboard-stat-card-share h-100">
                        <div class="card-body">
                            <span class="dashboard-stat-icon">
                                <i class="bx bx-pie-chart-alt-2"></i>
                            </span>
                            <small>Share Takeaway</small>
                            <h4>{{dashboard.summary.takeaway_share | number:1}}%</h4>
                            <p>Porsi transaksi takeaway dibanding total transaksi pada periode aktif.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12 col-xl-8">
                    <div class="card border-0 dashboard-panel-card h-100">
                        <div class="card-header dashboard-panel-header">
                            <div>
                                <small>Trend Harian</small>
                                <h5 class="mb-1">Pergerakan transaksi vs takeaway</h5>
                                <p class="mb-0">Garis utama menunjukkan total transaksi, garis hijau menunjukkan
                                    transaksi takeaway.</p>
                            </div>
                            <span class="dashboard-panel-chip">
                                <i class="bx bx-line-chart"></i>
                                <span>Modern Chart</span>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-chart-wrap">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="dashboard-side-stack h-100">
                        <div class="card border-0 dashboard-panel-card dashboard-revenue-insight-card">
                            <div class="card-header dashboard-panel-header">
                                <div>
                                    <small>Insight Omzet</small>
                                    <h5 class="mb-1">Dine In vs Takeaway</h5>
                                    <p class="mb-0">Perbandingan omzet dibuat lebih fokus agar channel dominan dan gap
                                        nominal cepat terbaca.</p>
                                </div>
                                <span class="dashboard-panel-chip dashboard-panel-chip-neutral">
                                    <i class="bx bx-bar-chart-alt-2"></i>
                                    <span>{{getRevenueLeaderLabel()}}</span>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="dashboard-revenue-spotlight">
                                    <div>
                                        <small>Selisih Omzet</small>
                                        <h4>Rp {{getRevenueDiff() | number:0}}</h4>
                                        <p>Gap nilai penjualan antara channel dine in dan takeaway pada periode aktif.
                                        </p>
                                    </div>
                                    <div class="dashboard-revenue-spotlight-total">
                                        <span>Total Omzet</span>
                                        <strong>Rp {{dashboard.summary.total_revenue | number:0}}</strong>
                                    </div>
                                </div>

                                <div class="dashboard-revenue-insight-grid">
                                    <div class="dashboard-revenue-insight-item dashboard-revenue-insight-item-dinein">
                                        <div class="dashboard-revenue-insight-head">
                                            <span class="dashboard-revenue-insight-icon">
                                                <i class="bx bx-restaurant"></i>
                                            </span>
                                            <strong>{{getRevenueShare(dashboard.summary.dine_in_revenue) | number:1}}%</strong>
                                        </div>
                                        <small>Dine In</small>
                                        <h6>Rp {{dashboard.summary.dine_in_revenue | number:0}}</h6>
                                        <p>{{dashboard.summary.dine_in_count_transaksi | number:0}} transaksi</p>
                                        <div class="dashboard-revenue-progress">
                                            <span
                                                ng-style="getRevenueBarStyle(dashboard.summary.dine_in_revenue)"></span>
                                        </div>
                                    </div>

                                    <div class="dashboard-revenue-insight-item dashboard-revenue-insight-item-takeaway">
                                        <div class="dashboard-revenue-insight-head">
                                            <span class="dashboard-revenue-insight-icon">
                                                <i class="bx bx-shopping-bag"></i>
                                            </span>
                                            <strong>{{getRevenueShare(dashboard.summary.takeaway_revenue) | number:1}}%</strong>
                                        </div>
                                        <small>Takeaway</small>
                                        <h6>Rp {{dashboard.summary.takeaway_revenue | number:0}}</h6>
                                        <p>{{dashboard.summary.takeaway_count_transaksi | number:0}} transaksi</p>
                                        <div class="dashboard-revenue-progress">
                                            <span
                                                ng-style="getRevenueBarStyle(dashboard.summary.takeaway_revenue)"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dashboard-revenue-footnote">
                                    <span class="dashboard-revenue-footnote-pill">
                                        <i class="bx bx-line-chart"></i>
                                        {{getRevenueLeaderCopy()}}
                                    </span>
                                    <span class="dashboard-revenue-footnote-copy">Grafik komposisi ditaruh terpisah di
                                        bawah agar area chart tidak bercampur dengan insight omzet.</span>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 dashboard-panel-card dashboard-composition-chart-card">
                            <div class="card-header dashboard-panel-header">
                                <div>
                                    <small>Grafik Komposisi</small>
                                    <h5 class="mb-1">Dine In vs Takeaway</h5>
                                    <p class="mb-0">Background grafik dipisahkan supaya pembacaan chart lebih bersih dan
                                        fokus.</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="dashboard-chart-panel">
                                    <div class="dashboard-donut-wrap">
                                        <canvas id="dashboardMixChart"></canvas>
                                    </div>
                                </div>

                                <div class="dashboard-composition-stat-row">
                                    <div class="dashboard-composition-stat dashboard-composition-stat-dinein">
                                        <span></span>
                                        <div>
                                            <strong>Dine In</strong>
                                            <small>{{dashboard.summary.dine_in_count_transaksi | number:0}}
                                                transaksi</small>
                                        </div>
                                    </div>
                                    <div class="dashboard-composition-stat dashboard-composition-stat-takeaway">
                                        <span></span>
                                        <div>
                                            <strong>Takeaway</strong>
                                            <small>{{dashboard.summary.takeaway_count_transaksi | number:0}}
                                                transaksi</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="dashboard-takeaway-note">
                                    <i class="bx bx-info-circle"></i>
                                    <span>Takeaway dibaca dari `no_meja`, `metode_service`, prefix invoice `TKI`, atau
                                        order `TAK`.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12 col-xl-6">
                    <div class="card border-0 dashboard-panel-card h-100">
                        <div class="card-header dashboard-panel-header">
                            <div>
                                <small>Top Menu</small>
                                <h5 class="mb-1">Menu paling laku</h5>
                                <p class="mb-0">Diurutkan dari jumlah qty tertinggi pada periode yang dipilih.</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-menu-list" ng-if="menu_deskripsi.length > 0">
                                <div class="dashboard-menu-item"
                                    ng-repeat="dt in menu_deskripsi | limitTo:8 track by $index">
                                    <span class="dashboard-menu-rank">{{$index + 1}}</span>
                                    <div class="dashboard-menu-copy">
                                        <div class="dashboard-menu-topline">
                                            <h6 class="mb-1">{{dt.nama}}</h6>
                                            <span class="dashboard-menu-qty">{{dt.jumlah | number:0}} qty</span>
                                        </div>
                                        <div class="dashboard-menu-meta">
                                            <span class="dashboard-menu-pill"
                                                ng-class="{'dashboard-menu-pill-food': dt.jenis == 'Makanan', 'dashboard-menu-pill-drink': dt.jenis == 'Minuman'}">
                                                {{dt.jenis || 'Menu'}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-empty-state" ng-if="menu_deskripsi.length == 0">
                                <i class="bx bx-dish"></i>
                                <h6 class="mb-1">Belum ada data menu</h6>
                                <p class="mb-0">Coba ubah periode lalu muat ulang dashboard.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="card border-0 dashboard-panel-card h-100">
                        <div class="card-header dashboard-panel-header">
                            <div>
                                <small>Pembayaran</small>
                                <h5 class="mb-1">Distribusi metode bayar</h5>
                                <p class="mb-0">Membantu membaca channel pembayaran yang dominan pada periode ini.</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-payment-list" ng-if="dashboard.payment_summary.length > 0">
                                <div class="dashboard-payment-item"
                                    ng-repeat="item in dashboard.payment_summary track by $index">
                                    <div class="dashboard-payment-head">
                                        <div>
                                            <span class="dashboard-payment-pill"
                                                ng-class="'payment-tone-' + getPaymentTone(item.label)">
                                                {{item.label}}
                                            </span>
                                            <small>{{item.count | number:0}} transaksi</small>
                                        </div>
                                        <strong>Rp {{item.amount | number:0}}</strong>
                                    </div>
                                    <div class="dashboard-payment-bar">
                                        <span ng-style="getPaymentBarStyle(item.amount)"
                                            ng-class="'payment-tone-' + getPaymentTone(item.label)"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-empty-state" ng-if="dashboard.payment_summary.length == 0">
                                <i class="bx bx-credit-card-front"></i>
                                <h6 class="mb-1">Belum ada data pembayaran</h6>
                                <p class="mb-0">Transaksi pada periode ini belum memiliki distribusi metode bayar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-home-page {
    --dashboard-ink: #0f172a;
    --dashboard-muted: #64748b;
    --dashboard-border: #dbe3ee;
    --dashboard-surface: #ffffff;
    --dashboard-surface-soft: #f8fafc;
    --dashboard-shadow: 0 24px 45px -34px rgba(15, 23, 42, 0.55);
    background:
        radial-gradient(circle at top left, rgba(14, 165, 233, 0.08), transparent 28%),
        radial-gradient(circle at top right, rgba(16, 185, 129, 0.08), transparent 24%),
        linear-gradient(180deg, #f8fbff 0%, #f8fafc 100%);
    min-height: calc(100vh - 90px);
}

.dashboard-hero-card {
    overflow: hidden;
    border-radius: 28px;
    background:
        radial-gradient(circle at top right, rgba(16, 185, 129, 0.18), transparent 26%),
        radial-gradient(circle at left center, rgba(14, 165, 233, 0.16), transparent 30%),
        linear-gradient(135deg, #0f172a 0%, #112941 52%, #0f766e 100%);
    box-shadow: 0 28px 55px -36px rgba(15, 23, 42, 0.78);
}

.dashboard-hero-card .card-body {
    padding: 32px;
}

.dashboard-hero-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    margin-bottom: 16px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.12);
    color: #dbeafe;
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.dashboard-hero-title {
    color: #f8fafc;
    font-size: 2rem;
    font-weight: 800;
    line-height: 1.18;
    max-width: 760px;
}

.dashboard-hero-copy {
    max-width: 700px;
    margin-top: 12px;
    color: rgba(226, 232, 240, 0.88);
    font-size: 0.96rem;
    line-height: 1.75;
}

.dashboard-hero-glance {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-top: 24px;
}

.dashboard-glance-pill {
    padding: 16px 18px;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
}

.dashboard-glance-pill small {
    display: block;
    margin-bottom: 4px;
    color: rgba(226, 232, 240, 0.75);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.dashboard-glance-pill strong {
    color: #ffffff;
    font-size: 0.94rem;
    font-weight: 700;
}

.dashboard-filter-card {
    padding: 22px;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 24px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(18px);
}

.dashboard-filter-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
}

.dashboard-filter-head small {
    display: block;
    margin-bottom: 6px;
    color: rgba(219, 234, 254, 0.82);
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.dashboard-filter-head h5 {
    color: #f8fafc;
    font-weight: 700;
}

.dashboard-filter-head p {
    color: rgba(226, 232, 240, 0.84);
    font-size: 0.84rem;
    line-height: 1.6;
}

.dashboard-filter-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    background: rgba(236, 253, 245, 0.16);
    color: #dcfce7;
    font-size: 0.76rem;
    font-weight: 700;
}

.dashboard-filter-label {
    color: rgba(226, 232, 240, 0.9);
    font-size: 0.8rem;
    font-weight: 600;
}

.dashboard-filter-input {
    min-height: 46px;
    border-color: rgba(255, 255, 255, 0.18);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.92);
    box-shadow: none;
}

.dashboard-filter-button {
    min-height: 48px;
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, #38bdf8 0%, #10b981 100%);
    color: #ffffff;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.dashboard-filter-button:hover {
    color: #ffffff;
}

.dashboard-summary-grid {
    margin-top: 4px;
}

.dashboard-stat-card,
.dashboard-panel-card {
    border: 1px solid var(--dashboard-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: var(--dashboard-shadow);
}

.dashboard-stat-card .card-body {
    padding: 22px;
}

.dashboard-stat-card small {
    display: block;
    margin-top: 18px;
    margin-bottom: 8px;
    color: var(--dashboard-muted);
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.dashboard-stat-card h4 {
    margin-bottom: 8px;
    color: var(--dashboard-ink);
    font-size: 1.55rem;
    font-weight: 800;
}

.dashboard-stat-card p {
    margin-bottom: 0;
    color: var(--dashboard-muted);
    font-size: 0.86rem;
    line-height: 1.7;
}

.dashboard-stat-icon {
    width: 54px;
    height: 54px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px;
    font-size: 1.45rem;
}

.dashboard-stat-card-amount {
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.dashboard-stat-card-amount .dashboard-stat-icon {
    background: #dbeafe;
    color: #1d4ed8;
}

.dashboard-stat-card-visitor {
    background: linear-gradient(135deg, #ecfeff 0%, #ffffff 100%);
}

.dashboard-stat-card-visitor .dashboard-stat-icon {
    background: #cffafe;
    color: #0f766e;
}

.dashboard-stat-card-transaction {
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
}

.dashboard-stat-card-transaction .dashboard-stat-icon {
    background: #ffedd5;
    color: #c2410c;
}

.dashboard-stat-card-takeaway {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
}

.dashboard-stat-card-takeaway .dashboard-stat-icon {
    background: #dcfce7;
    color: #15803d;
}

.dashboard-stat-card-takeaway-amount {
    background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
}

.dashboard-stat-card-takeaway-amount .dashboard-stat-icon {
    background: #bbf7d0;
    color: #047857;
}

.dashboard-stat-card-share {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}

.dashboard-stat-card-share .dashboard-stat-icon {
    background: #e2e8f0;
    color: #334155;
}

.dashboard-panel-header {
    padding: 22px 24px 0;
    border-bottom: none;
    background: transparent;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
}

.dashboard-panel-header small {
    display: block;
    margin-bottom: 6px;
    color: var(--dashboard-muted);
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.dashboard-panel-header h5 {
    color: var(--dashboard-ink);
    font-weight: 800;
}

.dashboard-panel-header p {
    color: var(--dashboard-muted);
    font-size: 0.84rem;
    line-height: 1.65;
}

.dashboard-panel-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 0.76rem;
    font-weight: 700;
}

.dashboard-panel-card .card-body {
    padding: 22px 24px 24px;
}

.dashboard-chart-wrap {
    height: 360px;
}

.dashboard-composition-card {
    background:
        radial-gradient(circle at top right, rgba(16, 185, 129, 0.1), transparent 26%),
        linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

.dashboard-side-stack {
    display: flex;
    flex-direction: column;
    gap: 14px;
    height: 100%;
}

.dashboard-revenue-insight-card {
    background:
        radial-gradient(circle at top right, rgba(14, 165, 233, 0.08), transparent 28%),
        linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
}

.dashboard-panel-chip-neutral {
    background: #e2e8f0;
    color: #0f172a;
}

.dashboard-revenue-spotlight {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding: 20px;
    border-radius: 24px;
    background:
        radial-gradient(circle at top right, rgba(56, 189, 248, 0.24), transparent 28%),
        radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.22), transparent 32%),
        linear-gradient(135deg, #0f172a 0%, #0f3b5f 55%, #0f766e 100%);
    color: #f8fafc;
}

.dashboard-revenue-spotlight small {
    display: block;
    margin-bottom: 6px;
    color: rgba(226, 232, 240, 0.82);
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.dashboard-revenue-spotlight h4 {
    margin-bottom: 8px;
    color: #ffffff;
    font-size: 1.5rem;
    font-weight: 800;
}

.dashboard-revenue-spotlight p {
    margin-bottom: 0;
    max-width: 320px;
    color: rgba(226, 232, 240, 0.84);
    font-size: 0.84rem;
    line-height: 1.6;
}

.dashboard-revenue-spotlight-total {
    min-width: 150px;
    padding: 14px 16px;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
}

.dashboard-revenue-spotlight-total span {
    display: block;
    margin-bottom: 6px;
    color: rgba(226, 232, 240, 0.78);
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.dashboard-revenue-spotlight-total strong {
    display: block;
    color: #ffffff;
    font-size: 1rem;
    font-weight: 800;
    line-height: 1.5;
}

.dashboard-revenue-insight-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    margin-top: 14px;
}

.dashboard-revenue-insight-item {
    padding: 18px;
    border: 1px solid var(--dashboard-border);
    border-radius: 22px;
}

.dashboard-revenue-insight-item-dinein {
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.dashboard-revenue-insight-item-takeaway {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
}

.dashboard-revenue-insight-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
}

.dashboard-revenue-insight-head strong {
    color: var(--dashboard-ink);
    font-size: 1rem;
    font-weight: 800;
}

.dashboard-revenue-insight-icon {
    width: 46px;
    height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    font-size: 1.2rem;
}

.dashboard-revenue-insight-item-dinein .dashboard-revenue-insight-icon {
    background: #dbeafe;
    color: #1d4ed8;
}

.dashboard-revenue-insight-item-takeaway .dashboard-revenue-insight-icon {
    background: #dcfce7;
    color: #15803d;
}

.dashboard-revenue-insight-item small {
    display: block;
    margin-bottom: 6px;
    color: var(--dashboard-muted);
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.dashboard-revenue-insight-item h6 {
    margin-bottom: 6px;
    color: var(--dashboard-ink);
    font-size: 1.12rem;
    font-weight: 800;
}

.dashboard-revenue-insight-item p {
    margin-bottom: 0;
    color: var(--dashboard-muted);
    font-size: 0.82rem;
}

.dashboard-revenue-progress {
    height: 8px;
    margin-top: 14px;
    border-radius: 999px;
    background: rgba(148, 163, 184, 0.18);
    overflow: hidden;
}

.dashboard-revenue-progress span {
    display: block;
    height: 100%;
    border-radius: inherit;
}

.dashboard-revenue-insight-item-dinein .dashboard-revenue-progress span {
    background: linear-gradient(90deg, #38bdf8 0%, #2563eb 100%);
}

.dashboard-revenue-insight-item-takeaway .dashboard-revenue-progress span {
    background: linear-gradient(90deg, #34d399 0%, #16a34a 100%);
}

.dashboard-revenue-footnote {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-top: 16px;
}

.dashboard-revenue-footnote-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1e3a8a;
    font-size: 0.76rem;
    font-weight: 700;
}

.dashboard-revenue-footnote-copy {
    color: var(--dashboard-muted);
    font-size: 0.82rem;
    line-height: 1.6;
}

.dashboard-composition-chart-card {
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

.dashboard-chart-panel {
    padding: 18px;
    border: 1px solid var(--dashboard-border);
    border-radius: 24px;
    background:
        radial-gradient(circle at top right, rgba(14, 165, 233, 0.08), transparent 28%),
        radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.08), transparent 28%),
        linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
}

.dashboard-donut-wrap {
    height: 240px;
}

.dashboard-composition-stat-row {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    margin-top: 14px;
}

.dashboard-composition-stat {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px;
    border: 1px solid var(--dashboard-border);
    border-radius: 18px;
    background: #ffffff;
}

.dashboard-composition-stat span {
    width: 12px;
    height: 12px;
    flex: 0 0 12px;
    border-radius: 999px;
}

.dashboard-composition-stat strong {
    display: block;
    margin-bottom: 4px;
    color: var(--dashboard-ink);
    font-size: 0.88rem;
    font-weight: 700;
}

.dashboard-composition-stat small {
    display: block;
    color: var(--dashboard-muted);
    font-size: 0.78rem;
}

.dashboard-composition-stat-dinein span {
    background: #0ea5e9;
}

.dashboard-composition-stat-takeaway span {
    background: #10b981;
}

.dashboard-mini-stat {
    padding: 16px;
    border: 1px solid var(--dashboard-border);
    border-radius: 18px;
}

.dashboard-mini-stat small {
    display: block;
    margin-bottom: 6px;
    color: var(--dashboard-muted);
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.dashboard-mini-stat h6 {
    margin-bottom: 4px;
    color: var(--dashboard-ink);
    font-size: 1.15rem;
    font-weight: 800;
}

.dashboard-mini-stat p {
    margin-bottom: 0;
    color: var(--dashboard-muted);
    font-size: 0.82rem;
}

.dashboard-mini-stat-dinein {
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.dashboard-mini-stat-takeaway {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
}

.dashboard-takeaway-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-top: 16px;
    padding: 12px 14px;
    border: 1px dashed var(--dashboard-border);
    border-radius: 16px;
    background: var(--dashboard-surface-soft);
    color: var(--dashboard-muted);
    font-size: 0.8rem;
    line-height: 1.6;
}

.dashboard-takeaway-note i {
    margin-top: 1px;
    color: #0f766e;
    font-size: 1rem;
}

.dashboard-menu-list,
.dashboard-payment-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.dashboard-menu-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px;
    border: 1px solid var(--dashboard-border);
    border-radius: 18px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
}

.dashboard-menu-rank {
    width: 36px;
    height: 36px;
    flex: 0 0 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: #dbeafe;
    color: #1d4ed8;
    font-size: 0.82rem;
    font-weight: 800;
}

.dashboard-menu-copy {
    min-width: 0;
    flex: 1;
}

.dashboard-menu-topline {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.dashboard-menu-topline h6 {
    color: var(--dashboard-ink);
    font-weight: 700;
}

.dashboard-menu-qty {
    white-space: nowrap;
    color: #0f766e;
    font-size: 0.8rem;
    font-weight: 700;
}

.dashboard-menu-meta {
    margin-top: 8px;
}

.dashboard-menu-pill {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
}

.dashboard-menu-pill-food {
    background: #eff6ff;
    color: #1d4ed8;
}

.dashboard-menu-pill-drink {
    background: #ecfdf5;
    color: #15803d;
}

.dashboard-payment-item {
    padding: 16px;
    border: 1px solid var(--dashboard-border);
    border-radius: 18px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
}

.dashboard-payment-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}

.dashboard-payment-head small {
    display: block;
    margin-top: 6px;
    color: var(--dashboard-muted);
    font-size: 0.8rem;
}

.dashboard-payment-head strong {
    color: var(--dashboard-ink);
    font-size: 0.92rem;
    font-weight: 800;
    white-space: nowrap;
}

.dashboard-payment-pill {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 0.74rem;
    font-weight: 700;
}

.dashboard-payment-bar {
    height: 10px;
    border-radius: 999px;
    background: #e2e8f0;
    overflow: hidden;
}

.dashboard-payment-bar span {
    display: block;
    height: 100%;
    border-radius: inherit;
}

.payment-tone-cash {
    background: #dcfce7;
    color: #15803d;
}

.dashboard-payment-bar .payment-tone-cash {
    background: linear-gradient(90deg, #22c55e 0%, #16a34a 100%);
}

.payment-tone-qris {
    background: #cffafe;
    color: #0f766e;
}

.dashboard-payment-bar .payment-tone-qris {
    background: linear-gradient(90deg, #06b6d4 0%, #0891b2 100%);
}

.payment-tone-transfer {
    background: #fef3c7;
    color: #b45309;
}

.dashboard-payment-bar .payment-tone-transfer {
    background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
}

.payment-tone-debit {
    background: #e0e7ff;
    color: #4338ca;
}

.dashboard-payment-bar .payment-tone-debit {
    background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);
}

.payment-tone-other {
    background: #e2e8f0;
    color: #334155;
}

.dashboard-payment-bar .payment-tone-other {
    background: linear-gradient(90deg, #94a3b8 0%, #64748b 100%);
}

.dashboard-empty-state {
    padding: 34px 18px;
    border: 1px dashed var(--dashboard-border);
    border-radius: 20px;
    background: var(--dashboard-surface-soft);
    text-align: center;
}

.dashboard-empty-state i {
    display: inline-flex;
    margin-bottom: 10px;
    color: #94a3b8;
    font-size: 2rem;
}

.dashboard-empty-state h6 {
    color: var(--dashboard-ink);
    font-weight: 700;
}

.dashboard-empty-state p {
    color: var(--dashboard-muted);
    font-size: 0.84rem;
}

@media (max-width: 991.98px) {
    .dashboard-hero-title {
        font-size: 1.7rem;
    }

    .dashboard-hero-glance {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .dashboard-revenue-spotlight {
        flex-direction: column;
    }

    .dashboard-revenue-spotlight-total {
        width: 100%;
        min-width: 0;
    }
}

@media (max-width: 575.98px) {

    .dashboard-hero-card .card-body,
    .dashboard-panel-card .card-body,
    .dashboard-stat-card .card-body {
        padding: 18px;
    }

    .dashboard-panel-header {
        padding: 18px 18px 0;
        flex-direction: column;
    }

    .dashboard-filter-card {
        padding: 18px;
    }

    .dashboard-chart-wrap {
        height: 300px;
    }

    .dashboard-donut-wrap {
        height: 210px;
    }

    .dashboard-menu-topline,
    .dashboard-payment-head {
        flex-direction: column;
    }

    .dashboard-revenue-insight-grid,
    .dashboard-composition-stat-row {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}
</style>
