<div ng-app="ReportPeriodeApp" ng-controller="ReportPeriodeController">
    <style>
        .report-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
            color: #fff;
            border-radius: 18px;
            padding: 1.5rem;
        }

        .report-hero h3,
        .report-hero .text-uppercase,
        .report-hero p,
        .report-hero small {
            color: #fff !important;
        }

        .report-filter-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.18);
        }

        .report-filter-card .form-label {
            color: #0f172a;
        }

        .report-filter-card .form-control {
            border-color: #cbd5e1;
            box-shadow: none;
        }

        .report-filter-card .form-control:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 0.2rem rgba(29, 78, 216, 0.12);
        }

        .report-stat-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            height: 100%;
            position: relative;
        }

        .report-stat-card .card-body {
            padding: 1.25rem;
            position: relative;
            z-index: 2;
        }

        .report-stat-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0.96;
            z-index: 1;
        }

        .report-stat-card::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            right: -32px;
            top: -28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.16);
            z-index: 1;
        }

        .report-stat-card.report-stat-total::before {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }

        .report-stat-card.report-stat-dinein::before {
            background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);
        }

        .report-stat-card.report-stat-takeaway::before {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        .report-stat-card.report-stat-average::before {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
        }

        .report-stat-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.8rem;
        }

        .report-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            color: #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.14);
        }

        .report-stat-total .report-stat-icon {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        }

        .report-stat-dinein .report-stat-icon {
            background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
        }

        .report-stat-takeaway .report-stat-icon {
            background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
        }

        .report-stat-average .report-stat-icon {
            background: linear-gradient(135deg, #ea580c 0%, #fb923c 100%);
        }

        .report-stat-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .report-stat-value {
            font-size: 1.7rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
        }

        .report-stat-note {
            color: #64748b;
            font-size: 0.9rem;
        }

        .report-soft-card {
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .report-soft-card .card-body {
            padding: 1.35rem;
        }

        .report-section-title {
            font-weight: 700;
            color: #0f172a;
        }

        .report-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 0.9rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .report-panel-meta {
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
        }

        .report-panel-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #fff;
            flex: 0 0 auto;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
        }

        .report-panel-icon-payments {
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        }

        .report-panel-icon-service {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        }

        .report-panel-icon-items {
            background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
        }

        .report-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.7rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .report-badge-dinein {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .report-badge-takeaway {
            background: #dcfce7;
            color: #15803d;
        }

        .report-table th {
            white-space: nowrap;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #475569;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .report-table td {
            vertical-align: middle;
            border-color: #eef2f7;
        }

        .report-table tbody tr:nth-child(even) {
            background: #fcfdff;
        }

        .report-table tbody tr:hover {
            background: #eff6ff;
            transition: background-color 0.18s ease;
        }

        .report-table thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .report-muted {
            color: #64748b;
        }
    </style>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Report</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan Periode</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="report-hero mb-4">
                <div class="row align-items-center g-3">
                    <div class="col-lg-7">
                        <div class="text-uppercase small fw-semibold opacity-75 mb-2">Laporan Operasional</div>
                        <h3 class="fw-bold mb-2">Ringkasan pendapatan, rekap item, dan performa takeaway</h3>
                        <p class="mb-0 opacity-75">Halaman ini sekarang menampilkan total omzet, pembagian dine in vs takeaway, metode pembayaran, dan detail item untuk kebutuhan cek harian maupun cetak laporan panjang.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="card border-0 report-filter-card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-md-2 d-grid">
                                        <label class="form-label d-none d-md-block">&nbsp;</label>
                                        <button class="btn btn-dark" ng-click="CheckFilter()">
                                            <i class="bx bx-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                    <small class="text-muted">Periode aktif: {{start_date}} s/d {{end_date}}</small>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-success" type="button" ng-click="printLaporanUSB()">
                                            <i class="bx bx-printer"></i>
                                            Cetak USB
                                        </button>
                                        <button class="btn btn-info text-white" type="button" ng-click="printLaporanBluetooth()">
                                            <i class="bx bx-printer"></i>
                                            Bluetooth
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-3">
                    <div class="card report-stat-card report-stat-total">
                        <div class="card-body">
                            <div class="report-stat-head">
                                <div class="report-stat-label mb-0">Total Pendapatan</div>
                                <span class="report-stat-icon">
                                    <i class="bx bx-wallet"></i>
                                </span>
                            </div>
                            <div class="report-stat-value">{{ report.overview.total_pendapatan | currency:'Rp ' }}</div>
                            <div class="report-stat-note mt-2">{{ report.overview.jumlah_transaksi || 0 }} transaksi | {{ report.overview.total_qty || 0 }} item</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card report-stat-card report-stat-dinein">
                        <div class="card-body">
                            <div class="report-stat-head">
                                <div class="report-stat-label mb-0">Dine In</div>
                                <span class="report-stat-icon">
                                    <i class="bx bx-store"></i>
                                </span>
                            </div>
                            <div class="report-stat-value">{{ report.overview.total_dine_in | currency:'Rp ' }}</div>
                            <div class="report-stat-note mt-2">{{ report.overview.transaksi_dine_in || 0 }} transaksi | {{ report.overview.qty_dine_in || 0 }} item</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card report-stat-card report-stat-takeaway">
                        <div class="card-body">
                            <div class="report-stat-head">
                                <div class="report-stat-label mb-0">Takeaway</div>
                                <span class="report-stat-icon">
                                    <i class="bx bx-shopping-bag"></i>
                                </span>
                            </div>
                            <div class="report-stat-value">{{ report.overview.total_takeaway | currency:'Rp ' }}</div>
                            <div class="report-stat-note mt-2">{{ report.overview.transaksi_takeaway || 0 }} transaksi | {{ report.overview.qty_takeaway || 0 }} item</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card report-stat-card report-stat-average">
                        <div class="card-body">
                            <div class="report-stat-head">
                                <div class="report-stat-label mb-0">Rata-rata Per Transaksi</div>
                                <span class="report-stat-icon">
                                    <i class="bx bx-trending-up"></i>
                                </span>
                            </div>
                            <div class="report-stat-value">{{ report.overview.rata_transaksi | currency:'Rp ' }}</div>
                            <div class="report-stat-note mt-2">Porsi takeaway {{ report.overview.porsi_takeaway || 0 }}%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-7">
                    <div class="card report-soft-card h-100">
                        <div class="card-body">
                            <div class="report-panel-head">
                                <div class="report-panel-meta">
                                    <span class="report-panel-icon report-panel-icon-payments">
                                        <i class="bx bx-credit-card-front"></i>
                                    </span>
                                    <div>
                                        <h5 class="report-section-title mb-1">Ringkasan Pembayaran & Kas</h5>
                                        <p class="report-muted mb-0">Memantau metode bayar yang dipakai dan posisi kas laci dalam periode terpilih.</p>
                                    </div>
                                </div>
                                <span class="report-badge report-badge-dinein">
                                    <i class="bx bx-pulse"></i>
                                    Cashflow
                                </span>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle report-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Informasi</th>
                                            <th class="text-center">Jumlah Trx</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="row in report.payment_rows">
                                            <td>{{row.metode}}</td>
                                            <td class="text-center">{{row.jumlah}}</td>
                                            <td class="text-end fw-semibold">{{ row.total | currency:'Rp ' }}</td>
                                        </tr>
                                        <tr class="table-light fw-semibold">
                                            <td>Saldo Awal</td>
                                            <td class="text-center">-</td>
                                            <td class="text-end">{{ report.saldo_awal | currency:'Rp ' }}</td>
                                        </tr>
                                        <tr class="table-light fw-semibold">
                                            <td>Pengeluaran / Tarik Uang</td>
                                            <td class="text-center">-</td>
                                            <td class="text-end text-danger">- {{ report.pengeluaran | currency:'Rp ' }}</td>
                                        </tr>
                                        <tr class="table-success fw-bold">
                                            <td>Total Kas Dalam Laci</td>
                                            <td class="text-center">-</td>
                                            <td class="text-end">{{ total_laci | currency:'Rp ' }}</td>
                                        </tr>
                                        <tr class="table-dark fw-bold">
                                            <td>Pendapatan Bersih</td>
                                            <td class="text-center">-</td>
                                            <td class="text-end">{{ pendapatan_bersih | currency:'Rp ' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5">
                    <div class="card report-soft-card h-100">
                        <div class="card-body">
                            <div class="report-panel-head">
                                <div class="report-panel-meta">
                                    <span class="report-panel-icon report-panel-icon-service">
                                        <i class="bx bx-bar-chart-alt-2"></i>
                                    </span>
                                    <div>
                                        <h5 class="report-section-title mb-1">Ringkasan Layanan</h5>
                                        <p class="report-muted mb-0">Perbandingan performa dine in dan takeaway dalam satu periode.</p>
                                    </div>
                                </div>
                                <span class="report-badge report-badge-takeaway">
                                    <i class="bx bx-target-lock"></i>
                                    Service Mix
                                </span>
                            </div>
                            <div class="d-grid gap-3">
                                <div class="p-3 rounded-4 border" ng-repeat="service in report.service_summary">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="report-badge" ng-class="service.service_label === 'Takeaway' ? 'report-badge-takeaway' : 'report-badge-dinein'">
                                            <i class="bx" ng-class="service.service_label === 'Takeaway' ? 'bx-shopping-bag' : 'bx-store'"></i>
                                            {{service.service_label}}
                                        </span>
                                        <strong>{{ service.total | currency:'Rp ' }}</strong>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="small text-muted">Jumlah Transaksi</div>
                                            <div class="fw-semibold">{{service.jumlah_transaksi}}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="small text-muted">Total Item</div>
                                            <div class="fw-semibold">{{service.total_qty}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-2">Top Item Terjual</h6>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle report-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Layanan</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in report.top_items">
                                            <td>
                                                <div class="fw-semibold">{{item.nama}}</div>
                                                <small class="text-muted">{{item.jenis}} • {{item.kategori}}</small>
                                            </td>
                                            <td>
                                                <span class="report-badge" ng-class="item.service_label === 'Takeaway' ? 'report-badge-takeaway' : 'report-badge-dinein'">
                                                    {{item.service_label}}
                                                </span>
                                            </td>
                                            <td class="text-center">{{item.qty}}</td>
                                            <td class="text-end">{{ item.subtotal | currency:'Rp ' }}</td>
                                        </tr>
                                        <tr ng-if="!report.top_items.length">
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data item pada periode ini.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card report-soft-card">
                        <div class="card-body">
                            <div class="report-panel-head">
                                <div class="report-panel-meta">
                                    <span class="report-panel-icon report-panel-icon-items">
                                        <i class="bx bx-receipt"></i>
                                    </span>
                                    <div>
                                        <h5 class="report-section-title mb-1">Rekap Item Per Layanan</h5>
                                        <p class="report-muted mb-0">Detail item ini juga ikut masuk saat cetak laporan panjang, jadi bisa dipakai untuk cek performa menu dan takeaway.</p>
                                    </div>
                                </div>
                                <span class="report-badge report-badge-dinein">
                                    <i class="bx bx-list-ul"></i>
                                    Item Detail
                                </span>
                            </div>

                            <div class="row g-4">
                                <div class="col-xl-6" ng-repeat="group in report.detail_groups">
                                    <div class="border rounded-4 h-100 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                            <div>
                                                <span class="report-badge" ng-class="group.service_label === 'Takeaway' ? 'report-badge-takeaway' : 'report-badge-dinein'">
                                                    {{group.service_label}}
                                                </span>
                                                <div class="small text-muted mt-2">{{group.total_qty}} item • {{ group.total_amount | currency:'Rp ' }}</div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm align-middle report-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Menu</th>
                                                        <th>Mitra</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-end">Harga</th>
                                                        <th class="text-end">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="item in group.items">
                                                        <td>
                                                            <div class="fw-semibold">{{item.nama}}</div>
                                                            <small class="text-muted">{{item.jenis}} • {{item.kategori}}</small>
                                                        </td>
                                                        <td>{{item.owner_name}}</td>
                                                        <td class="text-center">{{item.qty}}</td>
                                                        <td class="text-end">{{ item.harga | currency:'Rp ' }}</td>
                                                        <td class="text-end fw-semibold">{{ item.subtotal | currency:'Rp ' }}</td>
                                                    </tr>
                                                    <tr ng-if="!group.items.length">
                                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data {{group.service_label}} pada periode ini.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
