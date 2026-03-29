<div ng-app="ListTransaksiApp" ng-controller="ListTransaksiAppController" class="transaksi-kasir-page">

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card transaksi-shell-card mb-4">
                <div class="card-body transaksi-shell-header">
                    <div>
                        <span class="transaksi-shell-eyebrow">Kasir Transaction Center</span>
                        <h4 class="mb-2 text-white d-flex align-items-center gap-2">
                            <i class="bx bx-receipt"></i>
                            Informasi Transaksi Kasir
                        </h4>
                        <p class="mb-0 transaksi-shell-subtitle">
                            Halaman ini fokus ke transaksi kasir dan dine in. Transaksi takeaway dipisahkan ke menu
                            takeaway agar monitoring transaksi lebih rapi.
                        </p>
                    </div>
                    <div class="transaksi-shell-badge">
                        <i class="bx bx-store-alt"></i>
                        <span>{{getSelectedTypeLabel()}}</span>
                    </div>
                </div>
            </div>

            <div class="card transaksi-filter-card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3">
                        <div>
                            <h6 class="mb-1">Filter Transaksi Kasir</h6>
                            <small>Pilih periode dan owner yang ingin ditinjau. Data takeaway tidak ditampilkan di
                                halaman ini.</small>
                        </div>
                        <span class="transaksi-filter-note">
                            <i class="bx bx-shield-quarter"></i>
                            Khusus transaksi kasir
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="type_transaction">Type Transaction</label>
                                <div class="input-group">
                                    <select class="form-select" id="type_transaction" name="type_transaction">
                                        <option value="All">All</option>
                                        <option value="Owner">Owner</option>
                                        <option ng-repeat="dt in ComboMitraData" value="{{dt.kode}}">
                                            {{dt.kode}} - {{dt.nama}}
                                        </option>
                                    </select>
                                    <button class="btn transaksi-filter-btn" ng-click="FilterData()">
                                        <i class='bx bx-search'></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card transaksi-summary-card transaksi-summary-card-primary h-100">
                        <div class="card-body">
                            <span class="transaksi-summary-icon">
                                <i class="bx bx-receipt"></i>
                            </span>
                            <div>
                                <small>Total Transaksi</small>
                                <h4 class="mb-1">{{(data_transaksi && data_transaksi.length) || 0}}</h4>
                                <p class="mb-0">Jumlah invoice kasir pada periode terpilih.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card transaksi-summary-card transaksi-summary-card-success h-100">
                        <div class="card-body">
                            <span class="transaksi-summary-icon">
                                <i class="bx bx-wallet"></i>
                            </span>
                            <div>
                                <small>Total Subtotal</small>
                                <h4 class="mb-1">{{sumField(data_transaksi, 'subtotal') | currency:'Rp. '}}</h4>
                                <p class="mb-0">Akumulasi subtotal transaksi kasir yang tampil.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card transaksi-summary-card transaksi-summary-card-warning h-100">
                        <div class="card-body">
                            <span class="transaksi-summary-icon">
                                <i class="bx bx-credit-card-front"></i>
                            </span>
                            <div>
                                <small>Saldo Awal</small>
                                <h4 class="mb-1">{{sumField(saldo_awal_data, 'saldo') | currency:'Rp. '}}</h4>
                                <p class="mb-0">Ringkasan saldo awal pada rentang tanggal aktif.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card transaksi-summary-card transaksi-summary-card-danger h-100">
                        <div class="card-body">
                            <span class="transaksi-summary-icon">
                                <i class="bx bx-trending-down"></i>
                            </span>
                            <div>
                                <small>Pengeluaran</small>
                                <h4 class="mb-1">{{sumField(pengeluaran_data, 'amount') | currency:'Rp. '}}</h4>
                                <p class="mb-0">Biaya operasional kasir pada periode yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card transaksi-summary-card transaksi-summary-card-dark h-100">
                        <div class="card-body">
                            <span class="transaksi-summary-icon">
                                <i class="bx bx-line-chart"></i>
                            </span>
                            <div>
                                <small>Posisi Kas Bersih</small>
                                <h4 class="mb-1">{{getNetCashMovement() | currency:'Rp. '}}</h4>
                                <p class="mb-0">Subtotal transaksi + saldo awal - pengeluaran pada periode aktif.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card transaksi-summary-card transaksi-summary-card-info h-100">
                        <div class="card-body">
                            <span class="transaksi-summary-icon">
                                <i class="bx bx-table"></i>
                            </span>
                            <div>
                                <small>Meja Terlibat</small>
                                <h4 class="mb-1">{{countDistinct(data_transaksi, 'no_meja')}}</h4>
                                <p class="mb-0">Jumlah meja dine in yang tercatat pada transaksi terfilter.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card transaksi-content-card">
                <div class="card-body">
                    <ul class="nav nav-tabs transaksi-nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_transaksi">
                                <i class="bx bx-receipt"></i> Transaksi
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_saldo_awal">
                                <i class="bx bx-wallet"></i> Saldo Awal
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_pengeluaran">
                                <i class="bx bx-minus-circle"></i> Pengeluaran
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <!-- ================= TRANSAKSI ================= -->
                        <div class="tab-pane fade show active" id="tab_transaksi">
                            <div class="transaksi-insight-grid">
                                <span class="transaksi-insight-pill">
                                    <i class="bx bx-calendar"></i>
                                    Periode: {{getDateRangeLabel()}}
                                </span>
                                <span class="transaksi-insight-pill">
                                    <i class="bx bx-user-pin"></i>
                                    Filter: {{getSelectedTypeLabel()}}
                                </span>
                                <span class="transaksi-insight-pill">
                                    <i class="bx bx-money"></i>
                                    Cash: {{countByField(data_transaksi, 'metode', 'Cash')}}
                                </span>
                                <span class="transaksi-insight-pill">
                                    <i class="bx bx-qr-scan"></i>
                                    QRIS: {{countByField(data_transaksi, 'metode', 'QRIS')}}
                                </span>
                                <span class="transaksi-insight-pill">
                                    <i class="bx bx-buildings"></i>
                                    Transfer: {{countByField(data_transaksi, 'metode', 'Bank Transfer')}}
                                </span>
                            </div>

                            <div class="transaksi-table-header">
                                <div>
                                    <h6 class="mb-1">Daftar Transaksi Kasir</h6>
                                    <small>Histori transaksi dine in/kasir sesuai filter aktif.</small>
                                </div>
                                <span class="transaksi-filter-note">
                                    <i class="bx bx-list-check"></i>
                                    {{(data_transaksi && data_transaksi.length) || 0}} transaksi
                                </span>
                            </div>

                            <div class="table-responsive transaksi-table-wrap">
                                <table class="table table-hover align-middle transaksi-kasir-table" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width:50px;"></th>
                                            <th>#</th>
                                            <th>Invoice</th>
                                            <th>Service</th>
                                            <th>Payment</th>
                                            <th>Date</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat-start="dt in data_transaksi">

                                            <td class="text-center">
                                                <button class="btn btn-sm transaksi-toggle-btn" ng-click="toggleRow(dt)">
                                                    <i class="bx"
                                                        ng-class="dt.expanded ? 'bx-minus-circle text-danger' : 'bx-plus-circle text-success'">
                                                    </i>
                                                </button>
                                            </td>

                                            <td class="text-center">{{$index + 1}}</td>
                                            <td>
                                                <div class="transaksi-primary-text">{{dt.no_transaksi}}</div>
                                                <div class="transaksi-secondary-meta">
                                                    <span ng-if="dt.created_by">Kasir: {{dt.created_by}}</span>
                                                    <span ng-if="dt.no_split">Split: {{dt.no_split}}</span>
                                                </div>
                                                <small>Order: {{dt.no_order}}</small><br>
                                                <small>Table: {{dt.no_meja}}</small>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge transaksi-badge transaksi-badge-service">
                                                    {{dt.metode_service}}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge transaksi-badge" ng-class="{
													'transaksi-badge-cash': dt.metode == 'Cash',
													'transaksi-badge-qris': dt.metode == 'QRIS',
													'transaksi-badge-bank': dt.metode == 'Bank Transfer'
												}">
                                                    {{dt.metode}}
                                                </span>
                                            </td>
                                            <td>{{dt.created_at}}</td>
                                            <td class="text-end fw-bold">
                                                {{dt.subtotal || 0 | currency:'Rp. '}}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn transaksi-print-btn" ng-click="printCard(dt)">
                                                        <i class="bx bx-printer"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr ng-repeat-end ng-if="dt.expanded">
                                            <td colspan="8" class="transaksi-detail-row">

                                                <div ng-if="dt.loading" class="text-center p-2">
                                                    Loading detail...
                                                </div>

                                                <div ng-if="!dt.loading">

                                                    <!-- 🔥 SUMMARY SECTION -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <span class="badge transaksi-badge transaksi-badge-qris">
                                                                Total Item : {{ getTotalQtyToggleRow(dt.detail_items) }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <table class="table table-sm transaksi-detail-table">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th>Kategori</th>
                                                                <th>Nama</th>
                                                                <th>Harga</th>
                                                                <th>Qty</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="item in dt.detail_items">
                                                                <td>{{item.kategori}}</td>
                                                                <td>{{item.nama}}</td>
                                                                <td class="text-center">
                                                                    {{item.harga | currency:'Rp. '}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{item.qty}}
                                                                </td>
                                                                <td class="text-end">
                                                                    {{item.qty * item.harga | currency:'Rp. '}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr ng-if="data_transaksi.length === 0">
                                            <td colspan="8" class="text-center py-4">
                                                <div class="transaksi-empty-state">
                                                    <i class="bx bx-package"></i>
                                                    <h6 class="mb-1">Belum ada transaksi kasir</h6>
                                                    <small>Periksa filter tanggal atau gunakan halaman takeaway untuk
                                                        transaksi takeaway.</small>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!-- ================= SALDO AWAL ================= -->
                        <div class="tab-pane fade" id="tab_saldo_awal">
                            <div class="card transaksi-subcard shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive transaksi-table-wrap">
                                        <table class="table table-hover align-middle transaksi-kasir-table">
                                            <thead class="transaksi-table-head-warning">
                                                <tr class="text-center">
                                                    <th style="width:50px">#</th>
                                                    <th>Amount</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal</th>
                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ; ?>
                                                    <th>Action</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="dt in saldo_awal_data">
                                                    <td class="text-center">{{$index+1}}</td>
                                                    <td class="text-end fw-bold text-success">
                                                        {{dt.saldo | currency:'Rp '}}
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{dt.keterangan || '-'}}
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        {{dt.created_at | date:'dd-MM-yyyy HH:mm'}}
                                                    </td>

                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ; ?>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-warning transaksi-mini-btn"
                                                            ng-click="editSaldoAwal(dt.id)">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger transaksi-mini-btn"
                                                            ng-click="deleteSaldoAwal(dt.id)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>

                                                <tr ng-if="saldo_awal_data.length == 0">
                                                    <td colspan="<?php echo $this->session->userdata('level') == 'Super Admin' ? '5' : '4'; ?>"
                                                        class="text-center text-muted">
                                                        Belum ada saldo awal
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ================= PENGELUARAN ================= -->
                        <div class="tab-pane fade" id="tab_pengeluaran">
                            <div class="card transaksi-subcard shadow-sm border-0">
                                <div class="card-body">

                                    <div class="table-responsive transaksi-table-wrap">

                                        <table class="table table-hover align-middle transaksi-kasir-table">

                                            <thead class="transaksi-table-head-danger">
                                                <tr class="text-center">
                                                    <th style="width:50px">#</th>
                                                    <th>Amount</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal</th>

                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ?>
                                                    <th>Action</th>
                                                    <?php endif; ?>

                                                </tr>
                                            </thead>

                                            <tbody>

                                                <tr ng-repeat="dt in pengeluaran_data">

                                                    <td class="text-center">{{$index+1}}</td>

                                                    <td class="text-end fw-bold text-danger">
                                                        {{dt.amount | currency:'Rp '}}
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{dt.keterangan || '-'}}
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        {{dt.created_at | date:'dd-MM-yyyy HH:mm'}}
                                                    </td>

                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ?>
                                                    <td class="text-center">

                                                        <button class="btn btn-sm btn-warning transaksi-mini-btn"
                                                            ng-click="editPengeluaran(dt.id)">
                                                            <i class="bx bx-edit"></i>
                                                        </button>

                                                        <button class="btn btn-sm btn-danger transaksi-mini-btn"
                                                            ng-click="deletePengeluaran(dt.id)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>

                                                    </td>
                                                    <?php endif; ?>

                                                </tr>

                                                <tr ng-if="pengeluaran_data.length == 0">
                                                    <td colspan="<?php echo $this->session->userdata('level') == 'Super Admin' ? '5' : '4'; ?>"
                                                        class="text-center text-muted">
                                                        Belum ada pengeluaran
                                                    </td>
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

    <style>
    .transaksi-kasir-page {
        --transaksi-bg: #f4f7fb;
        --transaksi-surface: #ffffff;
        --transaksi-border: #dbe3ee;
        --transaksi-border-soft: #e8eef5;
        --transaksi-text: #0f172a;
        --transaksi-muted: #64748b;
        --transaksi-blue: #2563eb;
        --transaksi-blue-soft: #dbeafe;
        --transaksi-green: #15803d;
        --transaksi-green-soft: #dcfce7;
        --transaksi-amber: #d97706;
        --transaksi-amber-soft: #fef3c7;
        --transaksi-red: #dc2626;
        --transaksi-red-soft: #fee2e2;
    }

    .transaksi-kasir-page .page-content {
        background:
            radial-gradient(circle at top right, rgba(14, 165, 233, 0.08), transparent 28%),
            radial-gradient(circle at top left, rgba(13, 148, 136, 0.1), transparent 24%),
            var(--transaksi-bg);
    }

    .transaksi-shell-card,
    .transaksi-filter-card,
    .transaksi-content-card,
    .transaksi-summary-card,
    .transaksi-subcard {
        border: 1px solid var(--transaksi-border);
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 16px 38px -30px rgba(15, 23, 42, 0.6);
    }

    .transaksi-shell-card {
        border: 0;
    }

    .transaksi-shell-header {
        padding: 1.35rem 1.5rem;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        background: linear-gradient(135deg, #0f172a 0%, #1f3b57 55%, #0f766e 100%);
    }

    .transaksi-shell-eyebrow {
        display: inline-block;
        margin-bottom: 0.45rem;
        color: rgba(255, 255, 255, 0.74);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .transaksi-shell-subtitle {
        max-width: 760px;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
    }

    .transaksi-shell-badge,
    .transaksi-filter-note {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .transaksi-shell-badge {
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
    }

    .transaksi-filter-card .card-body,
    .transaksi-content-card .card-body {
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    }

    .transaksi-filter-card h6,
    .transaksi-table-header h6 {
        color: var(--transaksi-text);
        font-weight: 800;
    }

    .transaksi-filter-card small,
    .transaksi-table-header small {
        color: var(--transaksi-muted);
    }

    .transaksi-filter-note {
        background: var(--transaksi-blue-soft);
        color: var(--transaksi-blue);
    }

    .transaksi-filter-btn {
        border: 0;
        background: linear-gradient(135deg, #0f172a 0%, #1f3b57 100%);
        color: #fff;
        font-weight: 700;
    }

    .transaksi-summary-card .card-body {
        display: flex;
        align-items: flex-start;
        gap: 0.95rem;
        padding: 1.1rem 1.15rem;
    }

    .transaksi-summary-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .transaksi-summary-card small {
        display: block;
        margin-bottom: 0.2rem;
        color: var(--transaksi-muted);
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .transaksi-summary-card h4 {
        color: var(--transaksi-text);
        font-weight: 800;
    }

    .transaksi-summary-card p {
        color: var(--transaksi-muted);
        font-size: 0.82rem;
        line-height: 1.55;
    }

    .transaksi-summary-card-primary {
        background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
    }

    .transaksi-summary-card-primary .transaksi-summary-icon {
        background: var(--transaksi-blue-soft);
        color: var(--transaksi-blue);
    }

    .transaksi-summary-card-success {
        background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
    }

    .transaksi-summary-card-success .transaksi-summary-icon {
        background: var(--transaksi-green-soft);
        color: var(--transaksi-green);
    }

    .transaksi-summary-card-warning {
        background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
    }

    .transaksi-summary-card-warning .transaksi-summary-icon {
        background: var(--transaksi-amber-soft);
        color: var(--transaksi-amber);
    }

    .transaksi-summary-card-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
    }

    .transaksi-summary-card-danger .transaksi-summary-icon {
        background: var(--transaksi-red-soft);
        color: var(--transaksi-red);
    }

    .transaksi-summary-card-dark {
        background: linear-gradient(135deg, #e2e8f0 0%, #ffffff 100%);
    }

    .transaksi-summary-card-dark .transaksi-summary-icon {
        background: #cbd5e1;
        color: #0f172a;
    }

    .transaksi-summary-card-info {
        background: linear-gradient(135deg, #ecfeff 0%, #ffffff 100%);
    }

    .transaksi-summary-card-info .transaksi-summary-icon {
        background: #cffafe;
        color: #0f766e;
    }

    .transaksi-nav-tabs {
        gap: 0.75rem;
        border-bottom: 0;
    }

    .transaksi-nav-tabs .nav-link {
        border: 1px solid var(--transaksi-border);
        border-radius: 14px;
        color: var(--transaksi-muted);
        font-weight: 700;
    }

    .transaksi-nav-tabs .nav-link.active {
        border-color: transparent;
        background: linear-gradient(135deg, #0f172a 0%, #1f3b57 100%);
        color: #fff;
        box-shadow: 0 16px 28px -22px rgba(15, 23, 42, 0.9);
    }

    .transaksi-table-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .transaksi-insight-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.7rem;
        margin-bottom: 1rem;
    }

    .transaksi-insight-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.52rem 0.88rem;
        border-radius: 999px;
        background: #eef4fb;
        color: #334155;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .transaksi-table-wrap {
        border: 1px solid var(--transaksi-border);
        border-radius: 18px;
        background: var(--transaksi-surface);
    }

    .transaksi-kasir-table {
        margin-bottom: 0;
    }

    .transaksi-kasir-table thead th {
        border: 0;
        background: #f8fbff;
        color: #475569;
        font-size: 0.74rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .transaksi-kasir-table tbody td {
        padding: 0.95rem 1rem;
        vertical-align: middle;
        border-color: var(--transaksi-border-soft);
        color: var(--transaksi-text);
    }

    .transaksi-kasir-table tbody tr:hover {
        background: #f8fbff;
    }

    .transaksi-primary-text {
        font-weight: 800;
        color: var(--transaksi-text);
    }

    .transaksi-secondary-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin: 0.22rem 0 0.28rem;
    }

    .transaksi-secondary-meta span {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.73rem;
        font-weight: 700;
    }

    .transaksi-badge {
        border-radius: 999px;
        font-weight: 700;
        padding: 0.42rem 0.75rem;
    }

    .transaksi-badge-service,
    .transaksi-badge-cash {
        background: var(--transaksi-green-soft);
        color: var(--transaksi-green);
    }

    .transaksi-badge-qris {
        background: var(--transaksi-blue-soft);
        color: var(--transaksi-blue);
    }

    .transaksi-badge-bank {
        background: #e2e8f0;
        color: #334155;
    }

    .transaksi-toggle-btn,
    .transaksi-print-btn,
    .transaksi-mini-btn {
        border: 0;
        border-radius: 12px;
    }

    .transaksi-toggle-btn {
        background: #eef2ff;
    }

    .transaksi-print-btn {
        background: linear-gradient(135deg, #0f172a 0%, #1f3b57 100%);
        color: #fff;
    }

    .transaksi-detail-row {
        background: #f8fbff;
        padding: 1rem !important;
    }

    .transaksi-detail-table {
        margin-bottom: 0;
        border: 1px solid var(--transaksi-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .transaksi-detail-table thead th {
        background: #eef4fb;
        color: #475569;
        border-bottom: 1px solid var(--transaksi-border);
    }

    .transaksi-empty-state {
        padding: 1.4rem 1rem;
        color: var(--transaksi-muted);
        text-align: center;
    }

    .transaksi-empty-state i {
        display: inline-flex;
        margin-bottom: 0.55rem;
        font-size: 2rem;
        color: #cbd5e1;
    }

    .transaksi-table-head-warning th {
        background: #fffbeb !important;
        color: #b45309 !important;
    }

    .transaksi-table-head-danger th {
        background: #fef2f2 !important;
        color: #b91c1c !important;
    }

    @media (max-width: 991.98px) {
        .transaksi-shell-header,
        .transaksi-table-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .transaksi-insight-grid {
            gap: 0.6rem;
        }
    }

    @media (max-width: 767.98px) {
        .transaksi-shell-header,
        .transaksi-filter-card .card-body,
        .transaksi-content-card .card-body {
            padding: 1rem;
        }

        .transaksi-nav-tabs {
            flex-direction: column;
        }
    }
    </style>

    <!-- Show Modal Detail -->
    <!-- Modal Bill Biling -->
    <div id="my-modal-bill-billing" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_bill_billing_no_pesanan"></label> |
                        No.Meja
                        <label id="lb_bill_billing_no_meja"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body" id="printArea3">
                            <div>
                                <div class="text-center bold" style="font-size: 14px;margin-top: 0px;">
                                    <img id="receipt_logo_billing" src="" alt="Logo Struk"
                                        style="display:none; max-width:72px; max-height:72px; margin-bottom:6px;">
                                    <h5 id="receipt_company_billing"></h5>
                                </div>
                                <div class="text-center" id="receipt_address_billing"></div>
                                <hr>
                                <div style="padding-left: 18px;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 20%;">
                                                Tanggal
                                            </td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 75%;"><span id="bill_billing_date_show"
                                                    style="font-weight: 500;"></span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Kasir
                                            </td>
                                            <td>:</td>
                                            <td><span id="bill_billing_chasier_show" style="font-weight: 500;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                No.order
                                            </td>
                                            <td>:</td>
                                            <td><span id="bill_billing_no_order_show" style="font-weight: 500;"></span>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <hr>
                                <div style="padding-left: 18px;">
                                    <!-- Barang -->
                                    <table style="width: 100%; font-size: 13px;">
                                        <tbody ng-repeat="group in groupedOrders">
                                            <tr class="fw-bold">
                                                <td colspan="3" style="padding-top: 0px; padding-bottom: 2px;">
                                                    Table : {{ group.no_meja }}
                                                    <hr class="my-1">
                                                </td>
                                            </tr>
                                            <tr ng-repeat="item in group.items">
                                                <td style="width: 8%; text-align: center;">[{{ item.qty }}]</td>
                                                <td style="width: 60%;">
                                                    {{ item.nama }}
                                                    <span ng-if="item.potongan !== null">
                                                        ({{item.discount}}%)
                                                    </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;">
                                                    {{ (item.qty * item.harga) - item.potongan | currency:'Rp ':0 }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <hr>
                                <!-- Perhitungan -->
                                <div style="padding-left: 18px;">
                                    <table style="width: 100%;">
                                        <tr>

                                            <td style="width: 100%;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td>Qty</td>
                                                        <td style="width: 10px;">:</td>
                                                        <td style="text-align: right;padding-right: 10px;font-weight: 500;"
                                                            id="bill_billing_qty_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Subtotal</td>
                                                        <td style="width: 10px;">:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_subtotal_show">0
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Discount (<label for=""
                                                                id="bill_billing_discount_persen"></label>%)</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_discount_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PPN (10%)</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_ppn_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Grand Total</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_grand_total_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Metode Bayar</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_metode_show">-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Dibayar</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_jumlah_dibayar_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kembalian</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_kembalian_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Service Metode</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_service_metode_show">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <hr>
                                <div class="text-center bold">
                                    -- TERIMA KASIH --
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Bill Biling -->
    <!-- End Modal Detail -->
</div>
