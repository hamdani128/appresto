<div ng-app="KasirApp" ng-controller="KasirAppController" class="kasir-pos-page">
    <div class="page-wrapper">
        <div class="page-content">

            <!-- Tombol untuk membuka daftar meja (muncul di layar < 992px, yaitu mobile dan tablet) -->
            <div class="d-lg-none mb-3">
                <button class="btn kasir-mobile-table-toggle w-100" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasTables">
                    <span class="d-flex align-items-center justify-content-between gap-3">
                        <span class="d-inline-flex align-items-center gap-2">
                            <i class="bx bx-table"></i>
                            <span>Daftar Meja</span>
                        </span>
                        <span class="kasir-mobile-table-count">{{LoadData.length}}</span>
                    </span>
                </button>
            </div>

            <!-- Offcanvas untuk daftar meja di mobile & tablet -->
            <div class="offcanvas offcanvas-start kasir-table-offcanvas" tabindex="-1" id="offcanvasTables"
                aria-labelledby="offcanvasTablesLabel">
                <div class="offcanvas-header kasir-offcanvas-header">
                    <div>
                        <h5 class="offcanvas-title mb-1" id="offcanvasTablesLabel">Daftar Meja</h5>
                        <small>Pilih meja kosong untuk booking baru atau buka order yang aktif.</small>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="kasir-table-summary mb-3">
                        <span class="kasir-status-pill kasir-status-pill-available">
                            <i class="bx bx-check-circle"></i>
                            Available {{(LoadData | filter:{status:'0'}).length}}
                        </span>
                        <span class="kasir-status-pill kasir-status-pill-occupied">
                            <i class="bx bx-receipt"></i>
                            Occupied {{(LoadData | filter:{status:'1'}).length}}
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6 col-sm-4" ng-repeat="dt in LoadData" ng-if="LoadData.length > 0">
                            <!-- Meja kosong -->
                            <div class="card kasir-table-card bg-secondary" id="bg_mobile_{{$index}}"
                                ng-if="dt.status === '0'"
                                ng-click="SelectedMeja('bg_mobile_' + $index, dt); hideOffcanvas()">
                                <div class="card-body">
                                    <div class="kasir-table-card-head">
                                        <span class="kasir-table-state">
                                            <i class="bx bx-plus-circle"></i> Ready
                                        </span>
                                        <i class="bx bx-chair kasir-table-icon"></i>
                                    </div>
                                    <h3 class="kasir-table-number">{{dt.no_meja}}</h3>
                                    <p class="kasir-table-caption">Tap to create a new booking</p>
                                    <span class="kasir-table-badge">Available</span>
                                </div>
                            </div>
                            <!-- Meja terisi -->
                            <div class="card kasir-table-card bg-primary" ng-if="dt.status === '1'"
                                ng-click="ShowListBelanja(dt); hideOffcanvas()">
                                <div class="card-body">
                                    <div class="kasir-table-card-head">
                                        <span class="kasir-table-state">
                                            <i class="bx bx-receipt"></i> Active
                                        </span>
                                        <i class="bx bx-food-menu kasir-table-icon"></i>
                                    </div>
                                    <h3 class="kasir-table-number">{{dt.no_meja}}</h3>
                                    <p class="kasir-table-caption">Open active order and payment</p>
                                    <span class="kasir-table-badge">Occupied</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" ng-if="LoadData.length === 0">
                            <div class="kasir-empty-state kasir-empty-state-compact">
                                <i class="bx bx-grid-alt"></i>
                                <h6 class="mb-1">Tidak ada meja aktif</h6>
                                <small>Data meja belum tersedia untuk ditampilkan.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid utama: untuk layar lg ke atas, tampilkan sidebar + konten -->
            <div class="row g-4">
                <!-- Sidebar daftar meja untuk desktop (≥992px) -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="card radius-10 w-100 kasir-table-sidebar">
                        <div class="card-header kasir-table-sidebar-header">
                            <div>
                                <span class="kasir-shell-eyebrow">Dining Floor</span>
                                <h5 class="mb-1 text-white d-flex align-items-center gap-2">
                                    <i class="bx bx-table"></i> Table List
                                </h5>
                                <p class="mb-0 kasir-shell-subtitle">Monitor meja kosong dan order yang sedang berjalan.</p>
                            </div>
                            <span class="kasir-header-count">{{LoadData.length}}</span>
                        </div>
                        <div class="card-body">
                            <div class="kasir-table-summary mb-3">
                                <span class="kasir-status-pill kasir-status-pill-available">
                                    <i class="bx bx-check-circle"></i>
                                    Available {{(LoadData | filter:{status:'0'}).length}}
                                </span>
                                <span class="kasir-status-pill kasir-status-pill-occupied">
                                    <i class="bx bx-receipt"></i>
                                    Occupied {{(LoadData | filter:{status:'1'}).length}}
                                </span>
                            </div>
                            <div class="row g-3">
                                <div class="col-6" ng-repeat="dt in LoadData" ng-if="LoadData.length > 0">
                                    <!-- Meja kosong -->
                                    <div class="card kasir-table-card bg-secondary" id="bg_desktop_{{$index}}"
                                        ng-if="dt.status === '0'"
                                        ng-click="SelectedMeja('bg_desktop_' + $index, dt)">
                                        <div class="card-body">
                                            <div class="kasir-table-card-head">
                                                <span class="kasir-table-state">
                                                    <i class="bx bx-plus-circle"></i> Ready
                                                </span>
                                                <i class="bx bx-chair kasir-table-icon"></i>
                                            </div>
                                            <h3 class="kasir-table-number">{{dt.no_meja}}</h3>
                                            <p class="kasir-table-caption">Create a new dine-in booking</p>
                                            <span class="kasir-table-badge">Available</span>
                                        </div>
                                    </div>
                                    <!-- Meja terisi -->
                                    <div class="card kasir-table-card bg-primary" ng-if="dt.status === '1'"
                                        ng-click="ShowListBelanja(dt)">
                                        <div class="card-body">
                                            <div class="kasir-table-card-head">
                                                <span class="kasir-table-state">
                                                    <i class="bx bx-receipt"></i> Active
                                                </span>
                                                <i class="bx bx-food-menu kasir-table-icon"></i>
                                            </div>
                                            <h3 class="kasir-table-number">{{dt.no_meja}}</h3>
                                            <p class="kasir-table-caption">Review active order and payment</p>
                                            <span class="kasir-table-badge">Occupied</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" ng-if="LoadData.length === 0">
                                    <div class="kasir-empty-state kasir-empty-state-compact">
                                        <i class="bx bx-grid-alt"></i>
                                        <h6 class="mb-1">Tidak ada meja aktif</h6>
                                        <small>Daftar meja akan muncul di panel ini.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Utama (Operasional) - lebar penuh di mobile/tablet, 9 kolom di desktop -->
                <div class="col-12 col-lg-9">
                    <div class="card radius-10 overflow-hidden w-100 shadow-sm kasir-shell-card">
                        <div class="card-header kasir-shell-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="kasir-shell-eyebrow">Dine In Cashier</span>
                                <h5 class="mb-1 text-white d-flex align-items-center gap-2 fw-semibold">
                                    <i class="bx bx-slider-alt fs-5"></i> Operation Dashboard
                                </h5>
                                <p class="mb-0 kasir-shell-subtitle">
                                    Pilih meja, buat booking, lalu lanjutkan ke order dan pembayaran dari satu layar.
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn kasir-dashboard-btn" ng-click="BackToHome()">
                                    <i class="bx bx-home me-1"></i> Dashboard
                                </button>
                            </div>
                        </div>
                        <div class="card-body kasir-shell-body">
                            <!-- Transactions Table -->
                            <div class="row" id="table_row_order" style="display: block;">
                                <div class="col-12">
                                    <div class="card kasir-section-card mb-4">
                                        <div class="card-header kasir-section-header">

                                            <div>
                                                <h6 class="mb-1 text-dark fw-semibold">
                                                    <i class="bx bx-receipt me-2"></i>Recent Transactions
                                                </h6>
                                                <small>Riwayat transaksi dine in yang selesai hari ini.</small>
                                            </div>

                                            <div class="kasir-toolbar-actions">
                                                <button class="btn kasir-toolbar-btn kasir-toolbar-btn-dark" type="button"
                                                    ng-click="OpenCashDrawerPenarikan()">
                                                    <i class='bx bx-box me-1'></i>
                                                    Open Drawer
                                                </button>
                                                <button ng-if="saldo_awal === '0'"
                                                    class="btn kasir-toolbar-btn kasir-toolbar-btn-warning"
                                                    ng-click="SaldoAwalEntry()">
                                                    <i class="bx bx-wallet me-1"></i> Saldo Awal
                                                </button>

                                                <button class="btn kasir-toolbar-btn kasir-toolbar-btn-danger"
                                                    ng-click="TarikUang()">
                                                    <i class="bx bx-money me-1"></i> Tarik Uang
                                                </button>
                                            </div>

                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive kasir-transaction-wrap">
                                                <table datatable="ng" dt-options="vm.dtOptions"
                                                    class="table table-hover mb-0 kasir-transaction-table"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Transaction</th>
                                                            <th class="d-none d-sm-table-cell">Metode</th>
                                                            <th class="d-none d-sm-table-cell">Tanggal</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="dt in LoadDataRowTransaksi"
                                                            ng-if="LoadDataRowTransaksi.length > 0"
                                                            class="kasir-transaction-row">
                                                            <td class="text-center">
                                                                {{$index + 1}}</td>
                                                            <td>
                                                                <div class="kasir-transaction-title">
                                                                    {{dt.no_transaksi}}
                                                                    <span ng-if="dt.no_split" class="badge kasir-split-badge">
                                                                        {{dt.no_split}}
                                                                    </span>
                                                                </div>
                                                                <div class="kasir-transaction-meta">
                                                                    Order: {{dt.no_order}} • Table: {{dt.no_meja}}
                                                                </div>
                                                            </td>
                                                            <td class="d-none d-sm-table-cell">
                                                                <span class="badge kasir-soft-badge kasir-soft-badge-info">
                                                                    {{dt.metode}}
                                                                </span>
                                                            </td>
                                                            <td class="d-none d-sm-table-cell kasir-transaction-date">
                                                                <i class="bx bx-calendar me-1"></i> {{dt.created_at}}
                                                            </td>
                                                            <td>
                                                                <span class="badge rounded-pill kasir-soft-badge kasir-soft-badge-success">
                                                                    <i class="bx bx-check-circle me-1"></i> Complete
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-sm kasir-table-action-btn"
                                                                    ng-click="ShowDetailTransaksi(dt)">
                                                                    <i class="bx bx-printer"></i> Print
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr ng-if="LoadDataRowTransaksi.length === 0">
                                                            <td colspan="6" class="text-center">
                                                                <div class="kasir-empty-state">
                                                                    <i class="bx bx-package"></i>
                                                                    <h6 class="mb-1">No transactions available</h6>
                                                                    <small>Transaksi terbaru akan tampil otomatis di sini.</small>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons (New Booking) -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="input-group button-group">
                                        <button class="btn btn-md w-100 kasir-primary-cta" id="btn_booking"
                                            ng-click="Create_Booking()" style="display: none;">
                                            <i class="bx bx-plus-circle me-2"></i> New Booking
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Info -->
                            <div id="row_no_meja" style="display: none;">
                                <div class="kasir-subsection-heading pt-2">
                                    <div>
                                        <h6 class="mb-1">Active Booking</h6>
                                        <small>Nomor booking dan meja yang saat ini sedang dipilih.</small>
                                    </div>
                                </div>
                                <div class="row g-3 pt-1">
                                    <div class="col-md-6">
                                        <div class="card kasir-info-card kasir-info-card-primary h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="kasir-info-icon">
                                                        <i class="bx bx-calendar-check"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-muted">Booking Number</h6>
                                                        <h5 class="mb-0 text-dark fw-bold mt-1" id="no_booking">-</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card kasir-info-card kasir-info-card-success h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="kasir-info-icon">
                                                        <i class="bx bx-table"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-muted">Table Number</h6>
                                                        <h5 class="mb-0 text-dark fw-bold mt-1" id="no_meja">-</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operation Buttons -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="kasir-ops-grid kasir-ops-grid-main">
                                        <button class="btn kasir-op-button kasir-op-button-move" id="btn_pindah_meja"
                                            style="display: none;"
                                            ng-click="PindahMeja()">
                                            <i class="bx bx-move"></i>
                                            <span class="kasir-button-title">Move Table</span>
                                            <small>Pindahkan order ke meja lain</small>
                                        </button>
                                        <button class="btn kasir-op-button kasir-op-button-merge" id="btn_gabung_bill"
                                            style="display: none;"
                                            ng-click="GabungBill()">
                                            <i class="bx bx-merge"></i>
                                            <span class="kasir-button-title">Merge Bill</span>
                                            <small>Gabungkan tagihan yang terkait</small>
                                        </button>
                                        <button class="btn kasir-op-button kasir-op-button-add" id="btn_tambah_pesanan"
                                            style="display: none;"
                                            ng-click="TambahPesanan()">
                                            <i class="bx bx-plus-circle"></i>
                                            <span class="kasir-button-title">Add Order Items</span>
                                            <small>Tambahkan menu ke order aktif</small>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Count -->
                            <div class="pt-2" id="row_count_pesanan" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <div class="card kasir-counter-card kasir-counter-card-food h-100">
                                            <div class="card-body">
                                                <div class="kasir-counter-icon">
                                                    <i class="bx bx-food-menu"></i>
                                                </div>
                                                <div class="kasir-counter-copy">
                                                    <span class="kasir-counter-label">FOOD</span>
                                                    <h4 class="mb-0" id="lb_makanan_list_pesanan">0</h4>
                                                    <small class="kasir-counter-note">Total item makanan aktif</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card kasir-counter-card kasir-counter-card-drink h-100">
                                            <div class="card-body">
                                                <div class="kasir-counter-icon">
                                                    <i class="bx bx-drink"></i>
                                                </div>
                                                <div class="kasir-counter-copy">
                                                    <span class="kasir-counter-label">DRINK</span>
                                                    <h4 class="mb-0" id="lb_minuman_list_pesanan">0</h4>
                                                    <small class="kasir-counter-note">Total item minuman aktif</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div id="row_list_pesanan" style="display: none;">
                                <div class="card kasir-order-shell mb-4">
                                    <div class="card-header kasir-section-header">
                                        <div>
                                            <h5 class="mb-1 text-dark d-flex align-items-center">
                                                <i class="bx bx-detail me-2"></i>Order Details
                                            </h5>
                                            <small>Kelola item dine in dan hitung pembayaran sebelum checkout.</small>
                                        </div>
                                        <span class="kasir-count-badge">
                                            {{(LoadDataPesananList && LoadDataPesananList.length) || 0}}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3 mb-4">
                                            <div class="col-12 col-md-4">
                                                <div class="card kasir-detail-info-card h-100">
                                                    <div class="card-body">
                                                        <div class="kasir-detail-icon kasir-detail-icon-blue">
                                                            <i class="bx bx-table"></i>
                                                        </div>
                                                        <div>
                                                            <small class="kasir-detail-label">Table No</small>
                                                            <strong id="lb_tambahan_no_meja" class="kasir-detail-value">-</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="card kasir-detail-info-card h-100">
                                                    <div class="card-body">
                                                        <div class="kasir-detail-icon kasir-detail-icon-green">
                                                            <i class="bx bx-receipt"></i>
                                                        </div>
                                                        <div>
                                                            <small class="kasir-detail-label">Order No</small>
                                                            <strong id="lb_tambahan_no_order" class="kasir-detail-value">-</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="card kasir-detail-info-card h-100">
                                                    <div class="card-body">
                                                        <div class="kasir-detail-icon kasir-detail-icon-amber">
                                                            <i class="bx bx-calendar"></i>
                                                        </div>
                                                        <div>
                                                            <small class="kasir-detail-label">Created At</small>
                                                            <strong id="lb_tambahan_created_at" class="kasir-detail-value">-</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-12 col-xl-8">
                                                <div class="card kasir-order-panel-card h-100">
                                                    <div class="card-header kasir-panel-header">
                                                        <div>
                                                            <h6 class="mb-1">Order Items</h6>
                                                            <small>Semua item yang aktif pada meja ini.</small>
                                                        </div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="table-responsive kasir-order-table-wrap">
                                                            <table class="table kasir-order-table mb-0"
                                                                id="tb_pesanan_list">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Category</th>
                                                                        <th>Item</th>
                                                                        <th class="d-none d-sm-table-cell text-end">
                                                                            Price</th>
                                                                        <th>Qty</th>
                                                                        <th class="d-none d-sm-table-cell text-end">
                                                                            Subtotal</th>
                                                                        <th class="d-none d-sm-table-cell">Type</th>
                                                                        <th class="d-none d-sm-table-cell text-end">
                                                                            Discount Amt</th>
                                                                        <th>Disc. %</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tb_pesanan_list_body_menu">
                                                                    <tr ng-repeat="dt in LoadDataPesananList"
                                                                        ng-if="LoadDataPesananList.length > 0">
                                                                        <td>{{$index + 1}}</td>
                                                                        <td>
                                                                            <span class="kasir-badge kasir-badge-blue">
                                                                                {{dt.kategori}}
                                                                            </span>
                                                                        </td>
                                                                        <td class="kasir-order-item-name">
                                                                            {{ dt.nama }}
                                                                        </td>
                                                                        <td
                                                                            class="d-none d-sm-table-cell text-end fw-semibold">
                                                                            {{ dt.harga | currency:"Rp. ":0 }}
                                                                        </td>
                                                                        <td>
                                                                            <span class="kasir-qty-pill">{{ dt.qty }}</span>
                                                                        </td>
                                                                        <td
                                                                            class="d-none d-sm-table-cell text-end fw-semibold">
                                                                            {{ dt.subtotal | currency:"Rp. ":0 }}
                                                                        </td>
                                                                        <td class="d-none d-sm-table-cell">
                                                                            <span class="kasir-badge kasir-badge-green">
                                                                                {{dt.jenis}}
                                                                            </span>
                                                                        </td>
                                                                        <td
                                                                            class="d-none d-sm-table-cell text-end text-danger fw-semibold">
                                                                            {{ dt.potongan | currency:"Rp. ":0 }}
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm text-center kasir-discount-input"
                                                                                ng-model="dt.discount"
                                                                                ng-change="CalculateRowSubtotal(dt)">
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button
                                                                                class="btn btn-sm kasir-order-detail-btn"
                                                                                ng-click="ShowDetailPesanan(dt)">
                                                                                <i class="bx bx-show"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr ng-if="LoadDataPesananList.length === 0">
                                                                        <td colspan="10" class="text-center">
                                                                            <div
                                                                                class="kasir-empty-state kasir-empty-state-compact">
                                                                                <i class="bx bx-cart"></i>
                                                                                <h6 class="mb-1">No order items available
                                                                                </h6>
                                                                                <small>Item yang aktif akan muncul di panel
                                                                                    ini.</small>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-xl-4">
                                                <div class="card kasir-payment-card h-100">
                                                    <div class="card-header kasir-panel-header">
                                                        <div>
                                                            <h6 class="mb-1"><i
                                                                    class="bx bx-calculator me-2"></i>Payment Calculation
                                                            </h6>
                                                            <small>Ringkasan tagihan sebelum proses pembayaran.</small>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="kasir-summary-row">
                                                            <span>Total Quantity</span>
                                                            <div class="kasir-summary-field">
                                                                <input type="text"
                                                                    class="form-control form-control-sm text-end fw-bold"
                                                                    id="qty-total" value="0" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="kasir-summary-row">
                                                            <span>Subtotal</span>
                                                            <div class="kasir-summary-field">
                                                                <input type="text"
                                                                    class="form-control form-control-sm text-end fw-bold"
                                                                    ng-model="amount_total" id="amount-total" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="kasir-summary-group">
                                                            <label for="discount-nominal">Discount (%)</label>
                                                            <input type="text"
                                                                class="form-control form-control-sm text-end"
                                                                name="discount-nominal" id="discount-nominal"
                                                                onkeyup="angular.element(this).scope().CalculateTotal()"
                                                                placeholder="%">
                                                            <input type="text"
                                                                class="form-control form-control-sm text-end"
                                                                name="discount-value" id="discount-value" value="0"
                                                                readonly>
                                                        </div>

                                                        <div class="kasir-summary-group">
                                                            <label for="ppn-select">Tax (PPN)</label>
                                                            <select class="form-select form-select-sm" id="ppn-select"
                                                                ng-model="ppn_percent"
                                                                onchange="angular.element(this).scope().CalculateTotal()">
                                                                <option value="">Select</option>
                                                                <option value="10">10%</option>
                                                                <option value="11">11%</option>
                                                            </select>
                                                        </div>

                                                        <div class="kasir-summary-row">
                                                            <span>Tax Amount</span>
                                                            <div class="kasir-summary-field">
                                                                <input type="text"
                                                                    class="form-control form-control-sm text-end"
                                                                    id="amount-ppn" ng-model="ppn_amount" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="kasir-grand-total-card">
                                                            <span>Grand Total</span>
                                                            <input type="text"
                                                                class="form-control form-control-sm text-end fw-bold fs-6 kasir-grand-total-input"
                                                                id="grand-total" ng-model="grand_total" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="kasir-action-grid mt-3" id="payment-action-buttons">
                                            <button class="btn kasir-action-button kasir-action-button-print w-100"
                                                ng-click="CetakBill()">
                                                <i class="bx bx-printer"></i>
                                                <span class="kasir-button-title">Print Bill</span>
                                            </button>
                                            <button class="btn kasir-action-button kasir-action-button-print w-100"
                                                ng-click="CetakOrderOnly()">
                                                <i class="bx bx-list-ul"></i>
                                                <span class="kasir-button-title">Print Order</span>
                                            </button>
                                            <button class="btn kasir-action-button kasir-action-button-split w-100"
                                                ng-click="SplitBill()">
                                                <i class="bx bx-credit-card"></i>
                                                <span class="kasir-button-title">Split Bill</span>
                                            </button>
                                            <button class="btn kasir-action-button kasir-action-button-pay w-100"
                                                ng-click="pay_after_service()">
                                                <i class="bx bx-wallet"></i>
                                                <span class="kasir-button-title">Pay Now</span>
                                            </button>
                                            <button class="btn kasir-action-button kasir-action-button-cancel w-100"
                                                ng-click="cancel_order()">
                                                <i class="bx bx-x-circle"></i>
                                                <span class="kasir-button-title">Cancel Order</span>
                                            </button>
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

    <?php require_once "kasir-modal-bill-billing.php"?>
    <?php require_once "kasir-modal-booking.php"?>
    <?php require_once "kasir-modal-cancel-order.php"?>
    <?php require_once "kasir-modal-cetak-bill.php"?>
    <?php require_once "kasir-modal-print-order-only.php"?>
    <?php require_once "kasir-modal-gabung-bill.php"?>
    <?php require_once "kasir-modal-list-detail.php"?>
    <?php require_once "kasir-modal-payment-after-service.php"?>
    <?php require_once "kasir-modal-payment-before-service.php"?>
    <?php require_once "kasir-modal-pindah-meja.php"?>
    <?php require_once "kasir-modal-saldo-awal.php"?>
    <?php require_once "kasir-modal-split-bill.php"?>
    <?php require_once "kasir-modal-tambah-pesanan.php"?>
    <?php require_once "kasir-modal-tarik-uang.php"?>
</div>

<script>
function formatItem(name, qty, price) {
    const left = name.padEnd(16);
    const right = (qty + "x" + price).padStart(14);
    return left + right;
}
</script>

<style>
.kasir-pos-page {
    --kasir-bg: #f4f7fb;
    --kasir-surface: #ffffff;
    --kasir-border: #dbe3ee;
    --kasir-border-soft: #e8eef5;
    --kasir-text: #0f172a;
    --kasir-muted: #64748b;
    --kasir-primary: #0f766e;
    --kasir-primary-dark: #115e59;
    --kasir-blue: #2563eb;
    --kasir-blue-soft: #dbeafe;
    --kasir-amber: #d97706;
    --kasir-amber-soft: #fef3c7;
    --kasir-green: #15803d;
    --kasir-green-soft: #dcfce7;
    --kasir-red: #dc2626;
    --kasir-red-soft: #fee2e2;
}

.kasir-pos-page .page-content {
    background:
        radial-gradient(circle at top right, rgba(14, 165, 233, 0.08), transparent 28%),
        radial-gradient(circle at top left, rgba(13, 148, 136, 0.1), transparent 24%),
        var(--kasir-bg);
}

.kasir-mobile-table-toggle {
    border: 0;
    border-radius: 18px;
    padding: 0.95rem 1.1rem;
    background: linear-gradient(135deg, #0f172a 0%, #1f3b57 100%);
    color: #fff;
    font-weight: 700;
    box-shadow: 0 18px 30px -20px rgba(15, 23, 42, 0.9);
}

.kasir-mobile-table-count,
.kasir-header-count {
    min-width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    color: #fff;
    font-weight: 700;
}

.kasir-count-badge {
    min-width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: var(--kasir-blue-soft);
    color: var(--kasir-blue);
    font-weight: 800;
}

.kasir-table-offcanvas .offcanvas-header,
.kasir-table-sidebar-header,
.kasir-shell-header {
    border: 0;
    background: linear-gradient(135deg, #0f172a 0%, #1f3b57 50%, #0f766e 100%);
}

.kasir-offcanvas-header small,
.kasir-shell-subtitle {
    display: block;
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.85rem;
}

.kasir-table-offcanvas .offcanvas-body,
.kasir-table-sidebar > .card-body,
.kasir-shell-body {
    background: linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
}

.kasir-shell-card,
.kasir-table-sidebar,
.kasir-section-card,
.kasir-order-shell,
.kasir-order-panel-card,
.kasir-payment-card,
.kasir-info-card,
.kasir-detail-info-card,
.kasir-counter-card {
    border: 1px solid var(--kasir-border);
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 16px 38px -30px rgba(15, 23, 42, 0.6);
}

.kasir-shell-eyebrow {
    display: inline-block;
    margin-bottom: 0.45rem;
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.kasir-dashboard-btn,
.kasir-toolbar-btn,
.kasir-table-action-btn,
.kasir-order-detail-btn {
    border: 0;
    border-radius: 14px;
    font-weight: 700;
    transition: 0.2s ease;
}

.kasir-dashboard-btn {
    background: rgba(255, 255, 255, 0.14);
    color: #fff;
    padding: 0.75rem 1rem;
}

.kasir-dashboard-btn:hover,
.kasir-toolbar-btn:hover,
.kasir-table-action-btn:hover,
.kasir-order-detail-btn:hover,
.kasir-primary-cta:hover,
.kasir-op-button:hover,
.kasir-action-button:hover {
    transform: translateY(-2px);
}

.kasir-table-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
}

.kasir-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 0.8rem;
    border-radius: 999px;
    font-size: 0.76rem;
    font-weight: 700;
}

.kasir-status-pill-available {
    background: var(--kasir-green-soft);
    color: var(--kasir-green);
}

.kasir-status-pill-occupied {
    background: var(--kasir-blue-soft);
    color: var(--kasir-blue);
}

.kasir-table-card {
    cursor: pointer;
    border: 0;
    min-height: 172px;
    color: #fff;
    transition: 0.22s ease;
}

.kasir-table-card .card-body {
    padding: 1rem;
    background: transparent;
}

.kasir-table-card:hover {
    transform: translateY(-4px);
}

.kasir-table-card.bg-secondary {
    background: linear-gradient(145deg, #475569 0%, #334155 100%);
}

.kasir-table-card.bg-primary {
    background: linear-gradient(145deg, #2563eb 0%, #1d4ed8 100%);
}

.kasir-table-card.bg-warning {
    background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 18px 32px -24px rgba(217, 119, 6, 0.9);
}

.kasir-table-card-head,
.kasir-info-card .card-body,
.kasir-detail-info-card .card-body,
.kasir-counter-card .card-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.9rem;
}

.kasir-table-state,
.kasir-table-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.34rem 0.7rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.14);
    font-size: 0.72rem;
    font-weight: 700;
}

.kasir-table-icon {
    font-size: 1.3rem;
    opacity: 0.9;
}

.kasir-table-number {
    margin: 1.1rem 0 0.35rem;
    color: #fff;
    font-size: 1.95rem;
    font-weight: 800;
}

.kasir-table-caption {
    margin-bottom: 1rem;
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.8rem;
}

.kasir-section-header,
.kasir-panel-header {
    padding: 1rem 1.2rem;
    border-bottom: 1px solid var(--kasir-border);
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.kasir-section-header small,
.kasir-panel-header small,
.kasir-subsection-heading small {
    color: var(--kasir-muted);
}

.kasir-toolbar-actions,
.kasir-ops-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.kasir-ops-grid-main {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    width: 100%;
}

.kasir-action-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.75rem;
}

.kasir-toolbar-btn {
    padding: 0.72rem 1rem;
    color: #fff;
}

.kasir-toolbar-btn-dark {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.kasir-toolbar-btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.kasir-toolbar-btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
}

.kasir-transaction-table thead th,
.kasir-order-table thead th {
    background: #f8fbff;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

.kasir-transaction-table thead th {
    padding: 0.9rem 1rem;
}

.kasir-transaction-wrap,
.kasir-order-table-wrap {
    overflow: auto;
}

.kasir-transaction-table tbody td,
.kasir-order-table tbody td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-color: var(--kasir-border-soft);
    color: var(--kasir-text);
}

.kasir-transaction-row:hover,
.kasir-order-table tbody tr:hover {
    background: #f8fbff;
}

.kasir-transaction-title,
.kasir-order-item-name {
    font-weight: 700;
    color: var(--kasir-text);
}

.kasir-transaction-meta,
.kasir-transaction-date {
    color: var(--kasir-muted);
    font-size: 0.82rem;
}

.kasir-split-badge,
.kasir-soft-badge,
.kasir-badge,
.kasir-qty-pill {
    border-radius: 999px;
    font-weight: 700;
}

.kasir-split-badge {
    background: #fff1f2;
    color: #be123c;
}

.kasir-soft-badge {
    padding: 0.38rem 0.75rem;
}

.kasir-soft-badge-info,
.kasir-badge-blue,
.kasir-qty-pill {
    background: var(--kasir-blue-soft);
    color: var(--kasir-blue);
}

.kasir-soft-badge-success,
.kasir-badge-green {
    background: var(--kasir-green-soft);
    color: var(--kasir-green);
}

.kasir-table-action-btn,
.kasir-order-detail-btn {
    background: linear-gradient(135deg, #0f766e 0%, #0f9b8e 100%);
    color: #fff;
    padding: 0.55rem 0.9rem;
}

.kasir-primary-cta {
    border: 0;
    border-radius: 18px;
    padding: 0.95rem 1.2rem;
    background: linear-gradient(135deg, #0f766e 0%, #0f9b8e 100%);
    color: #fff;
    font-weight: 800;
    box-shadow: 0 18px 30px -20px rgba(15, 118, 110, 0.9);
}

.kasir-subsection-heading {
    margin-bottom: 0.85rem;
}

.kasir-info-card .card-body,
.kasir-detail-info-card .card-body,
.kasir-counter-card .card-body {
    padding: 1rem 1.1rem;
    justify-content: flex-start;
}

.kasir-counter-copy {
    min-width: 0;
}

.kasir-info-icon,
.kasir-detail-icon,
.kasir-counter-icon {
    width: 46px;
    height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    font-size: 1.2rem;
}

.kasir-info-card-primary .kasir-info-icon,
.kasir-detail-icon-blue {
    background: var(--kasir-blue-soft);
    color: var(--kasir-blue);
}

.kasir-info-card-success .kasir-info-icon,
.kasir-detail-icon-green {
    background: var(--kasir-green-soft);
    color: var(--kasir-green);
}

.kasir-detail-icon-amber,
.kasir-counter-card-food .kasir-counter-icon {
    background: var(--kasir-amber-soft);
    color: var(--kasir-amber);
}

.kasir-counter-card-drink .kasir-counter-icon {
    background: var(--kasir-blue-soft);
    color: var(--kasir-blue);
}

.kasir-op-button,
.kasir-action-button {
    min-height: 102px;
    border: 0;
    border-radius: 20px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    color: #fff;
    font-weight: 800;
    transition: 0.2s ease;
}

.kasir-ops-grid-main .kasir-op-button {
    width: 100%;
    min-width: 0;
    min-height: 118px;
    align-items: flex-start;
    justify-content: flex-start;
    text-align: left;
    padding: 1.1rem 1.15rem;
    box-shadow: 0 18px 30px -24px rgba(15, 23, 42, 0.75);
}

.kasir-action-grid .kasir-action-button {
    width: 100%;
    box-shadow: 0 18px 30px -24px rgba(15, 23, 42, 0.75);
}

.kasir-button-title {
    display: block;
    font-size: 0.98rem;
    line-height: 1.25;
}

.kasir-op-button small {
    display: block;
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.75rem;
    font-weight: 600;
    line-height: 1.45;
}

.kasir-op-button i,
.kasir-action-button i {
    font-size: 1.4rem;
}

.kasir-op-button-move,
.kasir-action-button-cancel {
    background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
}

.kasir-op-button-merge,
.kasir-action-button-split {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.kasir-op-button-add,
.kasir-action-button-print {
    background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
}

.kasir-action-button-pay {
    background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
}

.kasir-counter-card {
    background: linear-gradient(180deg, #fff 0%, #f8fbff 100%);
}

.kasir-counter-card-food {
    background:
        radial-gradient(circle at top right, rgba(245, 158, 11, 0.24), transparent 32%),
        linear-gradient(135deg, #fff7ed 0%, #fffbeb 58%, #ffffff 100%);
    border-color: #fcd34d;
}

.kasir-counter-card-drink {
    background:
        radial-gradient(circle at top right, rgba(14, 165, 233, 0.22), transparent 34%),
        linear-gradient(135deg, #eff6ff 0%, #ecfeff 56%, #ffffff 100%);
    border-color: #93c5fd;
}

.kasir-counter-card-food .kasir-counter-icon,
.kasir-counter-card-drink .kasir-counter-icon {
    box-shadow: 0 14px 22px -18px rgba(15, 23, 42, 0.9);
}

.kasir-counter-label,
.kasir-detail-label {
    display: block;
    margin-bottom: 0.2rem;
    color: var(--kasir-muted);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
}

.kasir-counter-card h4,
.kasir-detail-value {
    color: var(--kasir-text);
    font-weight: 800;
}

.kasir-counter-card-food .kasir-counter-label {
    color: #b45309;
}

.kasir-counter-card-drink .kasir-counter-label {
    color: #0369a1;
}

.kasir-counter-card-food h4 {
    color: #9a3412;
}

.kasir-counter-card-drink h4 {
    color: #1d4ed8;
}

.kasir-counter-note {
    display: block;
    margin-top: 0.32rem;
    font-size: 0.76rem;
    font-weight: 600;
    line-height: 1.45;
}

.kasir-counter-card-food .kasir-counter-note {
    color: rgba(154, 52, 18, 0.76);
}

.kasir-counter-card-drink .kasir-counter-note {
    color: rgba(29, 78, 216, 0.76);
}

.kasir-order-table-wrap {
    max-height: 560px;
}

.kasir-discount-input,
.kasir-summary-group .form-control,
.kasir-summary-group .form-select,
.kasir-summary-field .form-control,
.kasir-grand-total-input {
    border-color: var(--kasir-border);
    border-radius: 12px;
    box-shadow: none;
}

.kasir-discount-input {
    min-width: 72px;
}

.kasir-summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--kasir-border-soft);
    color: #334155;
    font-weight: 700;
}

.kasir-summary-field {
    width: 140px;
}

.kasir-summary-group {
    margin-top: 1rem;
}

.kasir-summary-group label {
    display: block;
    margin-bottom: 0.45rem;
    color: var(--kasir-muted);
    font-size: 0.82rem;
    font-weight: 700;
}

.kasir-summary-group .form-control + .form-control {
    margin-top: 0.55rem;
}

.kasir-grand-total-card {
    margin-top: 1.15rem;
    padding: 1rem;
    border-radius: 18px;
    background: linear-gradient(135deg, #dcfce7 0%, #dbeafe 100%);
}

.kasir-grand-total-card span {
    display: block;
    margin-bottom: 0.55rem;
    color: var(--kasir-text);
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.kasir-grand-total-input {
    background: rgba(255, 255, 255, 0.76);
    border-width: 2px;
    color: var(--kasir-green);
}

.kasir-empty-state {
    padding: 2rem 1rem;
    color: var(--kasir-muted);
    text-align: center;
}

.kasir-empty-state-compact {
    padding: 1.4rem 1rem;
}

.kasir-empty-state i {
    display: inline-flex;
    margin-bottom: 0.55rem;
    font-size: 2rem;
    color: #cbd5e1;
}

@media (max-width: 991.98px) {
    .kasir-shell-header,
    .kasir-section-header,
    .kasir-panel-header,
    .kasir-table-sidebar-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .kasir-toolbar-actions,
    .kasir-ops-grid {
        width: 100%;
    }

    .kasir-toolbar-btn,
    .kasir-op-button {
        flex: 1 1 180px;
    }

    .kasir-ops-grid-main {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .kasir-action-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .kasir-action-grid .kasir-action-button {
        min-height: 72px;
        flex-direction: row;
        justify-content: center;
        gap: 0.7rem;
        padding: 0.9rem 1rem;
    }

    .kasir-action-grid .kasir-action-button .kasir-button-title {
        font-size: 0.94rem;
        line-height: 1.2;
    }
}

@media (max-width: 767.98px) {
    .kasir-table-card {
        min-height: 154px;
    }

    .kasir-table-number {
        font-size: 1.6rem;
    }

    .kasir-summary-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .kasir-summary-field {
        width: 100%;
    }

    .kasir-action-button,
    .kasir-op-button {
        min-height: 92px;
    }

    .kasir-ops-grid-main {
        grid-template-columns: 1fr;
    }

    .kasir-action-grid {
        gap: 0.65rem;
    }

    .kasir-action-grid .kasir-action-button {
        min-height: 64px;
        padding: 0.8rem 0.9rem;
        gap: 0.55rem;
    }

    .kasir-action-grid .kasir-action-button i {
        font-size: 1.18rem;
    }

    .kasir-ops-grid-main .kasir-op-button {
        min-height: 104px;
    }

    .kasir-transaction-table tbody td,
    .kasir-order-table tbody td {
        padding: 0.8rem 0.7rem;
    }
}
</style>

<!-- style -->
<style>
.card-body-scrollable {
    max-height: 700px;
    /* Sesuaikan tinggi maksimum sesuai kebutuhan */
    overflow-y: auto;
}

#card-body-scrollable2 {
    max-height: 400px;
    /* Sesuaikan tinggi maksimum sesuai kebutuhan */
    overflow-y: auto;
}
</style>

<style>
.pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.pagination .page-item {
    display: inline;
}

.pagination .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
}

.pagination .page-link:hover {
    z-index: 2;
    color: #0056b3;
    text-decoration: none;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        display: block;
        width: 100%;
        white-space: nowrap;
    }
}


.modal.modal-right .modal-dialog {
    position: fixed;
    margin: auto;
    width: 100%;
    /* Sesuaikan ukuran modal */
    height: 100%;
    right: 0;
    top: 0;
    bottom: 0;
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
}

.modal.modal-right.show .modal-dialog {
    transform: translateX(0);
}
</style>

<style>
@media print {
    body * {
        visibility: hidden;
    }

    #printArea,
    #printArea * {
        visibility: visible;
    }

    #printArea {
        position: absolute;
        left: 0;
        top: 00px;
        width: 280px;
        /* Sesuaikan ukuran kertas printer */
        font-family: Arial, Helvetica, sans-serif, monospace;
        font-size: 12px;
        margin: 0;
        padding: 0;
        margin-top: -80px;
    }

    @page {
        size: auto;
        /* Biarkan browser menyesuaikan tinggi sesuai isi */
        margin: 0;
        /* Hilangkan margin default browser */
    }

    .text-center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    hr {
        border: none;
        border-top: 5px dashed #000;
        margin: 4px 0;
        color: #000;
    }

    .total-line {
        font-weight: bold;
        font-size: 13px;
        padding-left: 10px;
    }

    .card-menu-scroll {
        max-height: 60vh;
        /* Tinggi menu list tetap scrollable */
        overflow-y: auto;
    }

}
</style>

<!-- Responsive Design CSS -->
<style>
/* Responsive adjustments for payment buttons */
@media (max-width: 576px) {
    #payment-action-buttons .col-12 {
        padding: 0.25rem !important;
    }

    #payment-action-buttons button {
        min-height: 85px !important;
        padding: 0.75rem !important;
        margin-bottom: 0.5rem;
    }

    #payment-action-buttons i {
        font-size: 1.4rem !important;
        margin-bottom: 0.5rem !important;
    }

    #payment-action-buttons span {
        font-size: 0.75rem !important;
    }
}

@media (min-width: 577px) and (max-width: 768px) {
    #payment-action-buttons button {
        min-height: 90px !important;
        padding: 0.85rem !important;
    }

    #payment-action-buttons i {
        font-size: 1.6rem !important;
    }

    #payment-action-buttons span {
        font-size: 0.8rem !important;
    }
}

@media (min-width: 769px) and (max-width: 992px) {
    #payment-action-buttons button {
        min-height: 95px !important;
    }
}

/* Touch-friendly on mobile */
@media (hover: none) and (pointer: coarse) {
    #payment-action-buttons button:active {
        transform: scale(0.98) !important;
        transition: transform 0.1s !important;
    }
}

/* Better spacing for tablet */
@media (min-width: 577px) and (max-width: 992px) {
    #payment-action-buttons {
        gap: 0.75rem !important;
    }

    #payment-action-buttons .col-sm-6 {
        margin-bottom: 0.5rem;
    }
}

/* Ensure consistent button height on all screens */
#payment-action-buttons button {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
}
</style>

<style>
.table-card {
    transition: all 0.2s;
    border-radius: 10px;
    cursor: pointer;
}

.table-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }

    .btn {
        font-size: 0.8rem;
        padding: 0.5rem;
    }

    .table td,
    .table th {
        padding: 0.5rem;
        white-space: nowrap;
    }
}
</style>

<style>
/* Penyesuaian tambahan untuk responsif */
.table-card {
    background-color: #f8f9fc;
}

.table thead th {
    white-space: nowrap;
}

/* Kartu meja */
.table-card .card {
    cursor: pointer;
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.table-card .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.table-card .card.bg-secondary {
    background: linear-gradient(145deg, #6c757d, #5a6268);
}

.table-card .card.bg-primary {
    background: linear-gradient(145deg, #007bff, #0056b3);
}

/* Tombol aksi besar */
.action-button {
    border-radius: 10px;
    border: none;
    transition: all 0.3s;
    min-height: 80px;
}

.action-button i {
    font-size: 1.8rem;
}

/* Responsif untuk mobile */
@media (max-width: 767px) {
    .action-button {
        min-height: 70px;
        font-size: 0.8rem;
    }

    .action-button i {
        font-size: 1.5rem;
    }
}

/* Offcanvas disesuaikan */
.offcanvas-body {
    background-color: #f8f9fc;
}
</style>

<style>
.menu-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.menu-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.menu-card .card-body {
    padding: 0.5rem;
}
</style>
