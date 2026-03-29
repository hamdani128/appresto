<div ng-app="KasirTakeAwayApp" ng-controller="KasirTakeAwayAppController">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_transaksi">
                                        <i class="bx bx-wallet"></i> POS
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_takeaway_transactions"
                                        ng-click="LoadTakeawayTransactions()">
                                        <i class="bx bx-receipt"></i> List Transaksi
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <!-- ================= POS ================= -->
                                <!-- ================= POS ================= -->
                                <div class="tab-pane fade show active takeaway-pos-tab" id="tab_transaksi">

                                    <!-- FLOAT BUTTON MOBILE -->
                                    <button class="btn btn-primary btn-menu-floating d-md-none"
                                        data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
                                        <i class="bx bx-menu"></i> Menu
                                    </button>

                                    <div class="row">

                                        <!-- ================= DESKTOP MENU ================= -->
                                        <div class="col-md-4 col-lg-3 d-none d-md-block">
                                            <div class="card h-100 shadow-sm menu-panel-card takeaway-menu-card">
                                                <div class="card-body p-3">
                                                    <div class="menu-panel-heading">
                                                        <div>
                                                            <h5 class="mb-1">Daftar Menu</h5>
                                                            <small>Pilih item untuk masuk ke order list</small>
                                                        </div>
                                                        <span class="menu-count-badge">
                                                            {{(filteredMenu && filteredMenu.length) || 0}}
                                                        </span>
                                                    </div>

                                                    <div class="menu-toolbar">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text">
                                                                <i class="bx bx-search"></i>
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                ng-model="keywordMenu" ng-change="searchMenu()"
                                                                placeholder="Cari menu...">
                                                        </div>

                                                        <select class="form-select" ng-model="selectedCategory"
                                                            ng-change="searchMenu()"
                                                            ng-options="c.kategori as c.kategori for c in categories">
                                                            <option value="">Semua Kategori</option>
                                                        </select>
                                                    </div>

                                                    <div class="menu-list-scroll">
                                                        <div class="menu-list">
                                                            <button type="button" class="menu-list-item"
                                                                ng-repeat="dt in filteredMenu" ng-click="PilihMenu(dt)">
                                                                <span class="menu-list-index">{{$index + 1}}</span>
                                                                <span class="menu-list-content">
                                                                    <span class="menu-list-top">
                                                                        <span class="menu-list-name">{{dt.nama}}</span>
                                                                        <span class="menu-list-price">
                                                                            Rp {{dt.harga | number}}
                                                                        </span>
                                                                    </span>
                                                                    <span class="menu-list-meta">
                                                                        <span class="menu-pill">
                                                                            {{dt.kategori ? dt.kategori : 'Tanpa Kategori'}}
                                                                        </span>
                                                                        <span class="menu-pill menu-pill-soft">
                                                                            {{dt.jenis ? dt.jenis : 'Menu'}}
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </button>

                                                            <div class="menu-empty-state"
                                                                ng-if="!filteredMenu || filteredMenu.length === 0">
                                                                <i class="bx bx-search-alt"></i>
                                                                <h6 class="mb-1">Menu tidak ditemukan</h6>
                                                                <small>Coba ubah kata kunci atau kategori.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ================= MOBILE MENU ================= -->
                                        <div class="offcanvas offcanvas-start" tabindex="-1" id="menuOffcanvas">
                                            <div class="offcanvas-header">
                                                <div>
                                                    <h5 class="mb-0">Daftar Menu</h5>
                                                    <small class="text-muted">
                                                        {{(filteredMenu && filteredMenu.length) || 0}} item
                                                    </small>
                                                </div>
                                                <button class="btn-close" data-bs-dismiss="offcanvas"></button>
                                            </div>

                                            <div class="offcanvas-body menu-offcanvas-body">
                                                <div class="menu-toolbar">
                                                    <div class="input-group mb-2">
                                                        <span class="input-group-text">
                                                            <i class="bx bx-search"></i>
                                                        </span>
                                                        <input type="text" class="form-control"
                                                            ng-model="keywordMenu" ng-change="searchMenu()"
                                                            placeholder="Cari menu...">
                                                    </div>

                                                    <select class="form-select" ng-model="selectedCategory"
                                                        ng-change="searchMenu()"
                                                        ng-options="c.kategori as c.kategori for c in categories">
                                                        <option value="">Semua Kategori</option>
                                                    </select>
                                                </div>

                                                <div class="menu-list menu-list-mobile">
                                                    <button type="button" class="menu-list-item"
                                                        ng-repeat="dt in filteredMenu" ng-click="PilihMenu(dt)">
                                                        <span class="menu-list-index">{{$index + 1}}</span>
                                                        <span class="menu-list-content">
                                                            <span class="menu-list-top">
                                                                <span class="menu-list-name">{{dt.nama}}</span>
                                                                <span class="menu-list-price">
                                                                    Rp {{dt.harga | number}}
                                                                </span>
                                                            </span>
                                                            <span class="menu-list-meta">
                                                                <span class="menu-pill">
                                                                    {{dt.kategori ? dt.kategori : 'Tanpa Kategori'}}
                                                                </span>
                                                                <span class="menu-pill menu-pill-soft">
                                                                    {{dt.jenis ? dt.jenis : 'Menu'}}
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </button>

                                                    <div class="menu-empty-state"
                                                        ng-if="!filteredMenu || filteredMenu.length === 0">
                                                        <i class="bx bx-search-alt"></i>
                                                        <h6 class="mb-1">Menu tidak ditemukan</h6>
                                                        <small>Coba ubah kata kunci atau kategori.</small>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- ================= ORDER PANEL ================= -->
                                        <div class="col-md-8 col-lg-9">

                                            <div class="card shadow-sm queue-search-card takeaway-queue-card mb-3">
                                                <div class="card-body">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-12 col-lg-8">
                                                            <label class="form-label mb-1">Ambil No Antrian</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">
                                                                    <i class="bx bx-search-alt"></i>
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    ng-model="queueLookup"
                                                                    placeholder="Contoh: 001">
                                                            </div>
                                                            <small class="text-muted">
                                                                Masukkan no antrian takeaway yang statusnya masih
                                                                menunggu untuk lanjut pembayaran dan masih bisa
                                                                disesuaikan itemnya.
                                                            </small>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <div class="d-grid gap-2">
                                                                <button class="btn btn-dark w-100 queue-search-button"
                                                                    ng-click="loadQueueByNumber()"
                                                                    ng-disabled="draftOrderNo !== '-' || (LoadDataPesananList.length > 0 && !paymentCompleted)">
                                                                    <i class="bx bx-check-circle"></i>
                                                                    <span>Ambil Antrian</span>
                                                                </button>
                                                                <button class="btn btn-outline-dark w-100 queue-search-button"
                                                                    type="button" ng-click="openQueueListModal()">
                                                                    <i class="bx bx-list-ul"></i>
                                                                    <span>Daftar Antrian</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- INFO -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-12 col-sm-6 col-xl">
                                                    <div class="card shadow-sm takeaway-info-card takeaway-info-card-service">
                                                        <div class="card-body">
                                                            <div class="takeaway-info-icon bg-primary-subtle text-primary">
                                                                <i class="bx bx-shopping-bag"></i>
                                                            </div>
                                                            <div>
                                                                <small>Layanan</small>
                                                                <b id="lb_tambahan_no_meja">{{serviceLabel}}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl">
                                                    <div class="card shadow-sm takeaway-info-card takeaway-info-card-queue">
                                                        <div class="card-body">
                                                            <div class="takeaway-info-icon bg-info-subtle text-info">
                                                                <i class="bx bx-hash"></i>
                                                            </div>
                                                            <div>
                                                                <small>No Antrian</small>
                                                                <b>{{queueNumber}}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl">
                                                    <div class="card shadow-sm takeaway-info-card takeaway-info-card-order">
                                                        <div class="card-body">
                                                            <div
                                                                class="takeaway-info-icon bg-success-subtle text-success">
                                                                <i class="bx bx-receipt"></i>
                                                            </div>
                                                            <div>
                                                                <small>No Order</small>
                                                                <b id="lb_tambahan_no_order">{{draftOrderNo}}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl">
                                                    <div class="card shadow-sm takeaway-info-card takeaway-info-card-invoice">
                                                        <div class="card-body">
                                                            <div class="takeaway-info-icon bg-dark-subtle text-dark">
                                                                <i class="bx bx-receipt"></i>
                                                            </div>
                                                            <div>
                                                                <small>Invoice</small>
                                                                <b>{{invoiceNumber}}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl">
                                                    <div class="card shadow-sm takeaway-info-card takeaway-info-card-status">
                                                        <div class="card-body">
                                                            <div class="takeaway-info-icon bg-warning-subtle text-warning">
                                                                <i class="bx bx-time-five"></i>
                                                            </div>
                                                            <div>
                                                                <small>Status / Waktu</small>
                                                                <b id="lb_tambahan_created_at">{{orderStatusLabel}}</b>
                                                                <small class="takeaway-info-subtext">{{todayLabel}}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <!-- ORDER LIST -->
                                                <div class="col-12 col-xl-8">
                                                    <div class="card shadow-sm order-panel-card takeaway-order-card h-100">
                                                        <div class="card-header order-panel-header">
                                                            <div class="order-panel-title">
                                                                <div class="order-panel-eyebrow">
                                                                    <span class="panel-chip panel-chip-blue">
                                                                        <i class="bx bx-basket"></i>
                                                                        <span>Live Cart</span>
                                                                    </span>
                                                                    <span class="panel-chip panel-chip-soft"
                                                                        ng-if="draftOrderNo === '-'">
                                                                        <i class="bx bx-plus-circle"></i>
                                                                        <span>Order Baru</span>
                                                                    </span>
                                                                    <span class="panel-chip panel-chip-emerald"
                                                                        ng-if="draftOrderNo !== '-'">
                                                                        <i class="bx bx-receipt"></i>
                                                                        <span>{{draftOrderNo}}</span>
                                                                    </span>
                                                                </div>
                                                                <h5 class="mb-1">Order List</h5>
                                                                <small>Menu yang dipilih akan muncul di sini</small>
                                                            </div>
                                                            <div class="order-panel-side">
                                                                <span class="order-count-badge">
                                                                    {{(LoadDataPesananList && LoadDataPesananList.length) || 0}}
                                                                </span>
                                                                <small class="order-panel-caption">item aktif</small>
                                                            </div>
                                                        </div>

                                                        <div class="card-body p-0">
                                                            <div class="table-responsive order-table-wrap">
                                                                <table class="table order-table mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Menu</th>
                                                                            <th class="text-end">Harga</th>
                                                                            <th>Qty</th>
                                                                            <th class="text-end">Subtotal</th>
                                                                            <th class="text-center">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr ng-repeat="dt in LoadDataPesananList track by $index">
                                                                            <td class="order-index-cell">
                                                                                <span
                                                                                    class="order-index-pill">{{$index + 1}}</span>
                                                                            </td>
                                                                            <td>
                                                                                <div class="order-item-name">
                                                                                    {{dt.nama}}
                                                                                </div>
                                                                                <div class="order-item-meta">
                                                                                    <span class="order-meta-pill">
                                                                                        {{dt.kategori ? dt.kategori : 'Tanpa Kategori'}}
                                                                                    </span>
                                                                                    <span
                                                                                        class="order-meta-pill order-meta-pill-soft">
                                                                                        {{dt.jenis ? dt.jenis : 'Menu'}}
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span class="order-amount">
                                                                                    Rp {{dt.harga | number}}
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <div class="qty-control">
                                                                                    <button type="button"
                                                                                        class="qty-btn"
                                                                                        ng-click="changeQty(dt, -1)">
                                                                                        <i class="bx bx-minus"></i>
                                                                                    </button>
                                                                                    <span
                                                                                        class="qty-value">{{dt.qty}}</span>
                                                                                    <button type="button"
                                                                                        class="qty-btn"
                                                                                        ng-click="changeQty(dt, 1)">
                                                                                        <i class="bx bx-plus"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span class="order-subtotal-chip">
                                                                                    Rp {{dt.subtotal | number}}
                                                                                </span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-outline-danger order-remove-btn"
                                                                                    ng-click="removeItem(dt)">
                                                                                    <i class="bx bx-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>

                                                                        <tr ng-if="LoadDataPesananList.length==0">
                                                                            <td colspan="6">
                                                                                <div class="order-empty-state">
                                                                                    <i class="bx bx-cart"></i>
                                                                                    <h6 class="mb-1">Belum ada item</h6>
                                                                                    <small>Klik menu di sebelah kiri
                                                                                        untuk mulai membuat order.</small>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- PAYMENT -->
                                                <div class="col-12 col-xl-4">
                                                    <div class="card shadow-sm payment-card takeaway-payment-card h-100">
                                                        <div class="card-header payment-card-header">
                                                            <div class="payment-header-copy">
                                                                <div class="payment-panel-eyebrow">
                                                                    <span class="panel-chip panel-chip-emerald">
                                                                        <i class="bx bx-credit-card-front"></i>
                                                                        <span>Checkout</span>
                                                                    </span>
                                                                    <span class="panel-chip"
                                                                        ng-class="{'panel-chip-emerald': isPaymentReady(), 'panel-chip-amber': !isPaymentReady()}">
                                                                        <i class="bx"
                                                                            ng-class="{'bx-check-shield': isPaymentReady(), 'bx-time-five': !isPaymentReady()}"></i>
                                                                        <span>{{isPaymentReady() ? 'Siap Bayar' : 'Lengkapi Order'}}</span>
                                                                    </span>
                                                                </div>
                                                                <h5 class="mb-1">Ringkasan Pembayaran</h5>
                                                                <small>
                                                                    Bisa langsung bayar dari draft, atau simpan dulu
                                                                    sebagai antrian lalu lanjutkan nanti.
                                                                </small>
                                                            </div>
                                                            <div class="payment-header-side">
                                                                <span class="payment-method-badge"
                                                                    ng-class="{'payment-method-cash': payment_method === 'Cash', 'payment-method-qris': payment_method === 'QRIS', 'payment-method-debit': payment_method === 'Debit', 'payment-method-transfer': payment_method === 'Transfer'}">
                                                                    {{payment_method || 'Cash'}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="payment-alert"
                                                                ng-if="draftOrderNo === '-' && !paymentCompleted && LoadDataPesananList.length > 0">
                                                                <i class="bx bx-info-circle"></i>
                                                                <span>Draft ini bisa langsung dibayar, atau klik
                                                                    <b>Buat Antrian</b> jika ingin status
                                                                    <b>Menunggu</b>.</span>
                                                            </div>
                                                            <div class="payment-alert"
                                                                ng-if="draftOrderNo !== '-' && !paymentCompleted && LoadDataPesananList.length > 0">
                                                                <i class="bx bx-edit-alt"></i>
                                                                <span>Antrian yang sudah dipanggil masih bisa tambah
                                                                    atau kurangi item. Perubahan akan ikut saat
                                                                    <b>Lanjut Bayar</b>.</span>
                                                            </div>

                                                            <div class="payment-summary-panel">
                                                                <div class="summary-panel-title">Perhitungan Order</div>

                                                                <div class="summary-row">
                                                                    <span>Total Qty</span>
                                                                    <b>{{total_qty}}</b>
                                                                </div>

                                                                <div class="summary-row">
                                                                    <span>Subtotal</span>
                                                                    <b>Rp {{amount_total | number}}</b>
                                                                </div>

                                                                <div class="summary-input-group">
                                                                    <label class="form-label mb-1"
                                                                        for="discount-nominal">
                                                                        Discount (%)
                                                                    </label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm text-end"
                                                                        id="discount-nominal" min="0" max="100"
                                                                        ng-model="discount_nominal"
                                                                        ng-change="CalculateTotal()" placeholder="0"
                                                                        ng-disabled="!isPaymentReady()">
                                                                </div>

                                                                <div class="summary-input-group">
                                                                    <label class="form-label mb-1">PPN</label>
                                                                    <select class="form-select form-select-sm"
                                                                        ng-model="ppn_percent"
                                                                        ng-change="CalculateTotal()"
                                                                        ng-disabled="!isPaymentReady()">
                                                                        <option value="">0%</option>
                                                                        <option value="10">10%</option>
                                                                        <option value="11">11%</option>
                                                                    </select>
                                                                </div>

                                                                <div class="summary-row">
                                                                    <span>Potongan</span>
                                                                    <b>Rp {{discount_value | number}}</b>
                                                                </div>

                                                                <div class="summary-row summary-row-soft">
                                                                    <span>Tax</span>
                                                                    <b>Rp {{ppn_amount | number}}</b>
                                                                </div>
                                                            </div>

                                                            <div class="payment-summary-panel payment-summary-panel-accent">
                                                                <div class="summary-panel-title">Pembayaran</div>

                                                                <div class="summary-input-group">
                                                                    <label class="form-label mb-1">Metode Pembayaran</label>
                                                                    <select class="form-select form-select-sm"
                                                                        ng-model="payment_method"
                                                                        ng-change="syncPaymentState()"
                                                                        ng-disabled="!isPaymentReady()">
                                                                        <option value="Cash">Cash</option>
                                                                        <option value="QRIS">QRIS</option>
                                                                        <option value="Debit">Debit</option>
                                                                        <option value="Transfer">Transfer</option>
                                                                    </select>
                                                                </div>

                                                                <div class="summary-input-group"
                                                                    ng-if="payment_method === 'Cash'">
                                                                    <label class="form-label mb-1">Jumlah Dibayar</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm text-end"
                                                                        ng-model="amount_paid"
                                                                        ng-change="updatePaidAmount()" min="0"
                                                                        ng-disabled="!isPaymentReady()"
                                                                        placeholder="0">
                                                                </div>

                                                                <div class="cash-quick-grid"
                                                                    ng-if="payment_method === 'Cash'">
                                                                    <button type="button"
                                                                        class="btn cash-quick-btn cash-quick-btn-full"
                                                                        ng-click="setPaidAmount(grand_total)"
                                                                        ng-disabled="!isPaymentReady()">
                                                                        Uang Pas
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn cash-quick-btn"
                                                                        ng-repeat="amount in cashQuickAmounts"
                                                                        ng-click="setPaidAmount(amount)"
                                                                        ng-disabled="!isPaymentReady()">
                                                                        Rp {{amount | number}}
                                                                    </button>
                                                                </div>

                                                                <div class="summary-input-group"
                                                                    ng-if="payment_method !== 'Cash'">
                                                                    <label class="form-label mb-1">Jumlah Dibayar</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm text-end"
                                                                        ng-model="amount_paid" readonly>
                                                                    <small class="text-muted d-block mt-1">
                                                                        Untuk pembayaran non tunai, nominal dibayar
                                                                        otomatis mengikuti grand total.
                                                                    </small>
                                                                </div>

                                                                <div class="summary-input-group"
                                                                    ng-if="payment_method !== 'Cash'">
                                                                    <label class="form-label mb-1">Reference No.</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        ng-model="payment_reference"
                                                                        ng-disabled="!isPaymentReady()"
                                                                        placeholder="Opsional">
                                                                </div>

                                                                <div class="summary-row summary-row-highlight">
                                                                    <span>Kembalian</span>
                                                                    <b>Rp {{change_amount | number}}</b>
                                                                </div>
                                                            </div>

                                                            <div class="summary-total">
                                                                <div>
                                                                    <span>Grand Total</span>
                                                                    <small>Total akhir transaksi takeaway</small>
                                                                </div>
                                                                <b>Rp {{grand_total | number}}</b>
                                                            </div>

                                                            <div class="payment-helper-note"
                                                                ng-if="payment_method !== 'Cash'">
                                                                <i class="bx bx-receipt"></i>
                                                                <span>{{payment_reference ? 'Reference transaksi sudah terisi.' : 'Isi reference number jika transaksi non tunai membutuhkan bukti tambahan.'}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ACTION -->
                                            <div class="row mt-3 g-2">
                                                <div class="col-6 col-lg-3">
                                                    <button class="btn action-button action-button-print w-100"
                                                        ng-click="CetakBill()"
                                                        ng-disabled="!canPrintLastBill()">
                                                        <i class="bx bx-bluetooth"></i>
                                                        <span>Print Bluetooth</span>
                                                    </button>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <button class="btn action-button action-button-print w-100"
                                                        ng-click="CetakBillUSB()"
                                                        ng-disabled="!canPrintLastBill()">
                                                        <i class="bx bx-printer"></i>
                                                        <span>Print USB</span>
                                                    </button>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <button class="btn action-button action-button-split w-100"
                                                        ng-click="updateQueue()"
                                                        ng-disabled="!canUpdateQueue()">
                                                        <i class="bx bx-save"></i>
                                                        <span>Update Antrian</span>
                                                    </button>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <button class="btn action-button action-button-pay w-100"
                                                        ng-click="pay_after_service()"
                                                        ng-disabled="!isPaymentReady()">
                                                        <i class="bx bx-wallet"></i>
                                                        <span>Lanjut Bayar</span>
                                                    </button>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <button class="btn action-button action-button-split w-100"
                                                        ng-click="createQueue()"
                                                        ng-disabled="!isQueueReady()">
                                                        <i class="bx bx-add-to-queue"></i>
                                                        <span>Buat Antrian</span>
                                                    </button>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <button class="btn action-button action-button-cancel w-100"
                                                        ng-click="cancel_order()"
                                                        ng-disabled="LoadDataPesananList.length===0 && draftOrderNo === '-' && !paymentCompleted">
                                                        <i class="bx bx-trash"></i>
                                                        <span>{{getCancelButtonLabel()}}</span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- ================= LIST TRANSAKSI ================= -->
                                <div class="tab-pane fade" id="tab_takeaway_transactions">
                                    <div class="card shadow-sm transaction-list-card">
                                        <div class="card-header transaction-list-header">
                                            <div>
                                                <h5 class="mb-1">Transaksi Takeaway</h5>
                                                <small>Daftar invoice takeaway yang sudah dibayar dan bisa dicetak ulang
                                                    via printer bluetooth.</small>
                                            </div>
                                            <button class="btn btn-dark btn-sm" ng-click="LoadTakeawayTransactions()">
                                                <i class="bx bx-refresh"></i> Refresh
                                            </button>
                                        </div>

                                        <div class="card-body">
                                            <div class="row g-3 transaction-filter-row">
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label mb-1">Mulai Tanggal</label>
                                                    <input type="date" class="form-control"
                                                        ng-model="transactionFilter.start_date">
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label mb-1">Sampai Tanggal</label>
                                                    <input type="date" class="form-control"
                                                        ng-model="transactionFilter.end_date">
                                                </div>
                                                <div class="col-12 col-md-4 d-flex align-items-end">
                                                    <button class="btn btn-primary w-100"
                                                        ng-click="LoadTakeawayTransactions()">
                                                        <i class="bx bx-filter-alt"></i> Muat
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row g-3 transaction-summary-grid">
                                                <div class="col-12 col-sm-6 col-xl-3">
                                                    <div class="card transaction-summary-card transaction-summary-card-total h-100">
                                                        <div class="card-body">
                                                            <span class="transaction-summary-icon">
                                                                <i class="bx bx-receipt"></i>
                                                            </span>
                                                            <div>
                                                                <small>Total Transaksi</small>
                                                                <h5 class="mb-1">{{getTakeawayTransactionCount()}}</h5>
                                                                <p class="mb-0">Jumlah invoice takeaway sesuai filter aktif.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl-3">
                                                    <div class="card transaction-summary-card transaction-summary-card-amount h-100">
                                                        <div class="card-body">
                                                            <span class="transaction-summary-icon">
                                                                <i class="bx bx-wallet"></i>
                                                            </span>
                                                            <div>
                                                                <small>Total Omzet</small>
                                                                <h5 class="mb-1">Rp {{getTakeawayTransactionAmount() | number}}</h5>
                                                                <p class="mb-0">Akumulasi grand total transaksi takeaway.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl-3">
                                                    <div class="card transaction-summary-card transaction-summary-card-cash h-100">
                                                        <div class="card-body">
                                                            <span class="transaction-summary-icon">
                                                                <i class="bx bx-money"></i>
                                                            </span>
                                                            <div>
                                                                <small>Cash</small>
                                                                <h5 class="mb-1">Rp {{getTakeawayAmountByPayment('Cash') | number}}</h5>
                                                                <p class="mb-0">{{getTakeawayCountByPayment('Cash')}} transaksi dibayar tunai.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl-3">
                                                    <div class="card transaction-summary-card transaction-summary-card-qris h-100">
                                                        <div class="card-body">
                                                            <span class="transaction-summary-icon">
                                                                <i class="bx bx-qr-scan"></i>
                                                            </span>
                                                            <div>
                                                                <small>QRIS</small>
                                                                <h5 class="mb-1">Rp {{getTakeawayAmountByPayment('QRIS') | number}}</h5>
                                                                <p class="mb-0">{{getTakeawayCountByPayment('QRIS')}} transaksi dibayar via QRIS.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl-3">
                                                    <div class="card transaction-summary-card transaction-summary-card-bank h-100">
                                                        <div class="card-body">
                                                            <span class="transaction-summary-icon">
                                                                <i class="bx bx-buildings"></i>
                                                            </span>
                                                            <div>
                                                                <small>Bank Transfer</small>
                                                                <h5 class="mb-1">Rp {{getTakeawayAmountByPayment('Bank Transfer') | number}}</h5>
                                                                <p class="mb-0">{{getTakeawayCountByPayment('Bank Transfer')}} transaksi via transfer bank.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-xl-3">
                                                    <div class="card transaction-summary-card transaction-summary-card-average h-100">
                                                        <div class="card-body">
                                                            <span class="transaction-summary-icon">
                                                                <i class="bx bx-line-chart"></i>
                                                            </span>
                                                            <div>
                                                                <small>Rata-rata Invoice</small>
                                                                <h5 class="mb-1">Rp {{getTakeawayAverageTransactionAmount() | number}}</h5>
                                                                <p class="mb-0">Nilai rata-rata per invoice takeaway sesuai filter.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive transaction-table-wrap"
                                                ng-if="takeawayTransactions.length > 0">
                                                <table datatable="ng" id="takeawayTransactionsTable"
                                                    class="table table-hover align-middle transaction-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Invoice</th>
                                                            <th>Pembayaran</th>
                                                            <th>Waktu</th>
                                                            <th class="text-end">Grand Total</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="dt in takeawayTransactions track by dt.no_transaksi">
                                                            <td>{{$index + 1}}</td>
                                                            <td>
                                                                <div class="transaction-primary">{{dt.no_transaksi}}</div>
                                                                <div class="transaction-secondary">Order:
                                                                    {{dt.no_order}}</div>
                                                                <div class="transaction-secondary">Service:
                                                                    {{dt.metode_service || 'Takeaway'}}</div>
                                                            </td>
                                                            <td>
                                                                <span class="badge transaction-badge transaction-badge-service">
                                                                    {{dt.metode_service || 'Takeaway'}}
                                                                </span>
                                                                <span class="badge transaction-badge transaction-badge-payment">
                                                                    {{dt.metode || '-'}}
                                                                </span>
                                                            </td>
                                                            <td>{{dt.created_at || dt.tanggal}}</td>
                                                            <td class="text-end fw-semibold">
                                                                Rp {{(dt.amount_total || dt.subtotal || 0) | number}}
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="d-flex flex-wrap justify-content-center gap-2">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-secondary transaction-detail-btn"
                                                                        ng-click="showTransactionDetail(dt)">
                                                                        <i class="bx bx-list-ul"></i>
                                                                        <span>Detail</span>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-dark transaction-print-btn"
                                                                        ng-click="printTransaction(dt)"
                                                                        ng-disabled="dt.print_loading">
                                                                        <i class="bx bx-bluetooth"></i>
                                                                        <span>{{dt.print_loading ? 'Mencetak...' : 'Cetak Ulang'}}</span>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-warning transaction-print-btn"
                                                                        ng-click="printTransactionUSB(dt)"
                                                                        ng-disabled="dt.print_loading_usb">
                                                                        <i class="bx bx-printer"></i>
                                                                        <span>{{dt.print_loading_usb ? 'Mencetak...' : 'Cetak USB'}}</span>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="transaction-empty-state"
                                                ng-if="takeawayTransactions.length === 0">
                                                <i class="bx bx-receipt"></i>
                                                <h6 class="mb-1">Belum ada transaksi takeaway</h6>
                                                <small>Coba ubah filter tanggal atau selesaikan pembayaran takeaway
                                                    terlebih dahulu.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="my-modal-takeaway-queue-list" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content takeaway-queue-modal-content">
            <div class="modal-header takeaway-queue-modal-header text-white">
                <h5 class="modal-title">Daftar Antrian Takeaway</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body takeaway-queue-modal-body">
                <div class="takeaway-queue-modal-summary">
                    <div>
                        <small>Antrian Aktif</small>
                        <strong>{{takeawayQueueList.length}}</strong>
                    </div>
                    <span>Pilih antrian untuk langsung dimuat ke form pembayaran.</span>
                </div>
                <div class="table-responsive takeaway-queue-table-wrap">
                    <table class="table table-sm align-middle takeaway-queue-table">
                        <thead>
                            <tr>
                                <th>No.Antrian</th>
                                <th>No.Order</th>
                                <th>Waktu</th>
                                <th>Total Qty</th>
                                <th>List Item</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="queue in takeawayQueueList track by queue.queue_no">
                                <td>
                                    <div class="takeaway-queue-primary">{{queue.queue_no}}</div>
                                    <div class="takeaway-queue-secondary">
                                        {{queue.status_label}} • Hari Ini
                                    </div>
                                </td>
                                <td class="fw-semibold">{{queue.no_order}}</td>
                                <td class="takeaway-queue-secondary">{{queue.created_at}}</td>
                                <td>
                                    <span class="takeaway-queue-qty">{{queue.qty}}</span>
                                </td>
                                <td>
                                    <div ng-repeat="item in queue.detail track by $index" class="takeaway-queue-item">
                                        {{item.nama}} x{{item.qty}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm takeaway-queue-pick-btn"
                                        ng-click="selectQueueFromList(queue)">
                                        <i class="bx bx-check-circle"></i>
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                            <tr ng-if="takeawayQueueList.length === 0">
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada antrian takeaway yang aktif.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

                <div id="my-modal-takeaway-queue-print" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content takeaway-queue-print-content">
            <div class="modal-header takeaway-queue-print-header text-white">
                <h5 class="modal-title">Antrian Berhasil Dibuat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body takeaway-queue-print-body">
                <div class="takeaway-queue-print-top text-center mb-3">
                    <span class="takeaway-queue-print-badge">Queue Created</span>
                    <div class="takeaway-queue-print-title">QUEUE TAKEAWAY</div>
                    <h1 class="mb-1 takeaway-queue-print-number">{{queueReceiptDraft.queue_no}}</h1>
                    <div class="takeaway-queue-print-day-badge">Nomor Antrian Hari Ini</div>
                    <small class="text-muted">Order {{queueReceiptDraft.no_order}}</small>
                </div>
                <div class="takeaway-queue-print-card" ng-if="queueReceiptDraft">
                    <div class="takeaway-queue-print-meta">
                        <div>
                            <small>Waktu</small>
                            <strong>{{queueReceiptDraft.created_at}}</strong>
                        </div>
                        <div>
                            <small>Status</small>
                            <strong>{{queueReceiptDraft.status_label}}</strong>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div ng-repeat="item in queueReceiptDraft.detail track by $index" class="takeaway-queue-print-item">
                        <span>{{$index + 1}}. {{item.nama}}</span>
                        <b>x{{item.qty}}</b>
                    </div>
                </div>
            </div>
            <div class="modal-footer takeaway-queue-print-footer">
                <button type="button" class="btn takeaway-queue-print-btn takeaway-queue-print-btn-blue"
                    ng-click="printQueueBluetooth()">
                    <i class="bx bx-bluetooth"></i>
                    Print Bluetooth
                </button>
                <button type="button" class="btn takeaway-queue-print-btn takeaway-queue-print-btn-amber"
                    ng-click="printQueueUSB()">
                    <i class="bx bx-printer"></i>
                    Print USB
                </button>
                <button type="button" class="btn takeaway-queue-print-btn takeaway-queue-print-btn-slate"
                    data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>


<style>
.takeaway-pos-tab {
    padding-top: 6px;
}

.takeaway-queue-modal-content,
.takeaway-queue-print-content {
    border: 0;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 24px 50px -34px rgba(15, 23, 42, 0.78);
}

.takeaway-queue-modal-header {
    background: linear-gradient(135deg, #0f172a 0%, #1f3b57 65%, #0f766e 100%);
}

.takeaway-queue-print-header {
    background: linear-gradient(135deg, #15803d 0%, #0f766e 100%);
}

.takeaway-queue-modal-body,
.takeaway-queue-print-body {
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
}

.takeaway-queue-modal-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
    padding: 14px 16px;
    border: 1px solid #dbe3ee;
    border-radius: 16px;
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.takeaway-queue-modal-summary small,
.takeaway-queue-modal-summary span {
    color: #64748b;
}

.takeaway-queue-modal-summary strong {
    display: block;
    color: #0f172a;
    font-size: 1.35rem;
    line-height: 1;
}

.takeaway-queue-table-wrap {
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    background: #fff;
}

.takeaway-queue-table thead th {
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    white-space: nowrap;
}

.takeaway-queue-table tbody td {
    padding: 14px 12px;
    border-color: #eef2f7;
    vertical-align: top;
}

.takeaway-queue-primary {
    color: #0f172a;
    font-weight: 800;
}

.takeaway-queue-secondary {
    color: #64748b;
    font-size: 0.78rem;
}

.takeaway-queue-qty {
    min-width: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 10px;
    border-radius: 999px;
    background: #dbeafe;
    color: #1d4ed8;
    font-weight: 800;
}

.takeaway-queue-item {
    color: #334155;
    font-size: 0.83rem;
}

.takeaway-queue-item+.takeaway-queue-item {
    margin-top: 4px;
}

.takeaway-queue-pick-btn {
    border: 0;
    border-radius: 12px;
    padding: 8px 12px;
    background: linear-gradient(135deg, #0f766e 0%, #0f9b8e 100%);
    color: #fff;
    font-weight: 700;
}

.takeaway-queue-pick-btn:hover {
    color: #fff;
}

.takeaway-queue-print-top h4 {
    color: #0f172a;
    font-size: 1.8rem;
    font-weight: 800;
}

.takeaway-queue-print-title {
    margin-bottom: 8px;
    color: #0f766e;
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.16em;
    text-transform: uppercase;
}

.takeaway-queue-print-number {
    color: #0f172a;
    font-size: 4rem;
    line-height: 1;
    font-weight: 900;
    letter-spacing: 0.04em;
}

.takeaway-queue-print-badge {
    display: inline-flex;
    margin-bottom: 10px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #dcfce7;
    color: #15803d;
    font-size: 0.74rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.takeaway-queue-print-day-badge {
    display: inline-flex;
    margin-bottom: 10px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #e0f2fe;
    color: #0369a1;
    font-size: 0.74rem;
    font-weight: 800;
}

.takeaway-queue-print-card {
    padding: 16px;
    border: 1px solid #dbe3ee;
    border-radius: 18px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

.takeaway-queue-print-meta {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.takeaway-queue-print-meta small {
    display: block;
    margin-bottom: 4px;
    color: #64748b;
}

.takeaway-queue-print-meta strong {
    color: #0f172a;
    font-size: 0.92rem;
}

.takeaway-queue-print-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 8px 0;
    border-bottom: 1px dashed #dbe3ee;
    color: #334155;
}

.takeaway-queue-print-item:last-child {
    border-bottom: 0;
}

.takeaway-queue-print-item b {
    color: #0f172a;
}

.takeaway-queue-print-footer {
    gap: 10px;
    background: #fff;
}

.takeaway-queue-print-btn {
    border: 0;
    border-radius: 14px;
    padding: 10px 14px;
    color: #fff;
    font-weight: 700;
}

.takeaway-queue-print-btn-blue {
    background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
}

.takeaway-queue-print-btn-amber {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.takeaway-queue-print-btn-slate {
    background: linear-gradient(135deg, #475569 0%, #334155 100%);
}

.menu-panel-card {
    border: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
}

.takeaway-menu-card,
.takeaway-queue-card,
.takeaway-info-card,
.takeaway-order-card,
.takeaway-payment-card {
    box-shadow: 0 18px 34px -28px rgba(15, 23, 42, 0.58);
}

.takeaway-menu-card {
    background:
        radial-gradient(circle at top right, rgba(14, 165, 233, 0.18), transparent 28%),
        linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
}

.menu-panel-heading {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
}

.menu-panel-heading h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
}

.menu-panel-heading small {
    color: #64748b;
}

.menu-count-badge {
    min-width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: #dbeafe;
    color: #1d4ed8;
    font-weight: 700;
}

.menu-toolbar {
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.96) 0%, #f8fbff 100%);
    margin-bottom: 14px;
}

.menu-toolbar .input-group-text,
.menu-toolbar .form-control,
.menu-toolbar .form-select {
    border-color: #dbe3ee;
    box-shadow: none;
}

.menu-toolbar .input-group-text {
    background: #f8fafc;
    color: #64748b;
}

.menu-toolbar .form-control,
.menu-toolbar .form-select {
    font-size: 0.9rem;
}

.menu-list-scroll {
    max-height: calc(100vh - 285px);
    overflow-y: auto;
    padding-right: 4px;
}

.menu-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.menu-list-item {
    appearance: none;
    -webkit-appearance: none;
    width: 100%;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
    cursor: pointer;
    transition: 0.2s ease;
    text-align: left;
    font: inherit;
    color: inherit;
}

.menu-list-item:hover {
    border-color: #93c5fd;
    background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
}

.menu-list-index {
    width: 34px;
    height: 34px;
    flex: 0 0 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 0.8rem;
    font-weight: 700;
}

.menu-list-content {
    min-width: 0;
    flex: 1;
}

.menu-list-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 8px;
}

.menu-list-name {
    display: block;
    color: #0f172a;
    font-size: 0.92rem;
    font-weight: 700;
    line-height: 1.35;
}

.menu-list-price {
    flex-shrink: 0;
    color: #0f766e;
    font-size: 0.85rem;
    font-weight: 700;
    white-space: nowrap;
}

.menu-list-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.menu-pill {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 999px;
    background: #e0f2fe;
    color: #0f766e;
    font-size: 0.72rem;
    font-weight: 600;
}

.menu-pill-soft {
    background: #f1f5f9;
    color: #475569;
}

.menu-empty-state {
    padding: 28px 18px;
    border: 1px dashed #cbd5e1;
    border-radius: 16px;
    text-align: center;
    background: #ffffff;
    color: #64748b;
}

.menu-empty-state i {
    display: inline-flex;
    font-size: 2rem;
    margin-bottom: 8px;
    color: #94a3b8;
}

.menu-offcanvas-body {
    background: #f8fafc;
}

.menu-list-mobile {
    padding-bottom: 12px;
}

.queue-search-card {
    border: 1px solid #dbe3ee;
    border-radius: 20px;
}

.takeaway-queue-card {
    background:
        radial-gradient(circle at top right, rgba(15, 118, 110, 0.16), transparent 26%),
        linear-gradient(135deg, #ffffff 0%, #f0fdfa 100%);
}

.queue-search-card .card-body {
    padding: 18px 20px;
}

.queue-search-card .input-group-text,
.queue-search-card .form-control {
    border-color: #dbe3ee;
    box-shadow: none;
}

.queue-search-card .input-group-text {
    background: #f8fafc;
    color: #64748b;
}

.queue-search-button {
    min-height: 44px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 700;
}

.takeaway-info-card {
    border: 1px solid #e2e8f0;
    border-radius: 18px;
}

.takeaway-info-card-service {
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.takeaway-info-card-queue {
    background: linear-gradient(135deg, #ecfeff 0%, #ffffff 100%);
}

.takeaway-info-card-order {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
}

.takeaway-info-card-invoice {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}

.takeaway-info-card-status {
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
}

.takeaway-info-card .card-body {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 18px;
}

.takeaway-info-icon {
    width: 46px;
    height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 1.3rem;
}

.takeaway-info-card small {
    display: block;
    color: #64748b;
    margin-bottom: 2px;
}

.takeaway-info-card b {
    color: #0f172a;
    font-size: 0.95rem;
}

.takeaway-info-subtext {
    display: block;
    margin-top: 4px;
}

.order-panel-card,
.payment-card {
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
}

.takeaway-order-card {
    background:
        radial-gradient(circle at top right, rgba(59, 130, 246, 0.12), transparent 28%),
        linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
}

.takeaway-payment-card {
    background:
        radial-gradient(circle at top right, rgba(34, 197, 94, 0.14), transparent 30%),
        linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);
}

.order-panel-header,
.payment-card-header {
    padding: 18px 20px;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.96) 0%, #f8fafc 100%);
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.order-panel-header h5,
.payment-card-header h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
}

.order-panel-header small,
.payment-card-header small {
    color: #64748b;
}

.order-panel-title,
.payment-header-copy {
    min-width: 0;
    flex: 1;
}

.order-panel-side,
.payment-header-side {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}

.order-panel-eyebrow,
.payment-panel-eyebrow {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}

.panel-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 999px;
    border: 1px solid transparent;
    font-size: 0.72rem;
    font-weight: 700;
    line-height: 1;
}

.panel-chip i {
    font-size: 0.95rem;
}

.panel-chip-blue {
    background: #dbeafe;
    border-color: #bfdbfe;
    color: #1d4ed8;
}

.panel-chip-soft {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #475569;
}

.panel-chip-emerald {
    background: #dcfce7;
    border-color: #bbf7d0;
    color: #15803d;
}

.panel-chip-amber {
    background: #fef3c7;
    border-color: #fde68a;
    color: #b45309;
}

.order-count-badge {
    min-width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: #dbeafe;
    color: #1d4ed8;
    font-weight: 700;
}

.order-panel-caption {
    color: #64748b;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.payment-method-badge {
    min-width: 92px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    border-radius: 999px;
    border: 1px solid transparent;
    font-size: 0.76rem;
    font-weight: 700;
    line-height: 1;
    background: #eff6ff;
    color: #1d4ed8;
}

.payment-method-cash {
    background: #dcfce7;
    border-color: #bbf7d0;
    color: #15803d;
}

.payment-method-qris {
    background: #ede9fe;
    border-color: #ddd6fe;
    color: #6d28d9;
}

.payment-method-debit {
    background: #e0f2fe;
    border-color: #bae6fd;
    color: #0369a1;
}

.payment-method-transfer {
    background: #fef3c7;
    border-color: #fde68a;
    color: #b45309;
}

.order-table-wrap {
    max-height: 560px;
    overflow-y: auto;
}

.order-table thead th {
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 12px 14px;
    vertical-align: middle;
    white-space: nowrap;
}

.order-table tbody td {
    padding: 14px;
    border-color: #eef2f7;
    vertical-align: middle;
    color: #0f172a;
}

.order-table tbody tr {
    transition: 0.2s ease;
}

.order-table tbody tr:nth-child(even) {
    background: rgba(248, 250, 252, 0.78);
}

.order-table tbody tr:hover {
    background: #f0f9ff;
}

.order-index-cell {
    width: 58px;
}

.order-index-pill {
    min-width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
    color: #1d4ed8;
    font-size: 0.78rem;
    font-weight: 700;
}

.order-item-name {
    font-weight: 700;
    line-height: 1.35;
    color: #0f172a;
}

.order-item-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 4px;
    font-size: 0.78rem;
}

.order-meta-pill {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 0.72rem;
    font-weight: 700;
}

.order-meta-pill-soft {
    background: #f8fafc;
    color: #475569;
}

.order-amount {
    font-weight: 700;
    color: #0369a1;
}

.order-subtotal-chip {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 7px 12px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 0.82rem;
    font-weight: 700;
}

.qty-control {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 5px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.86);
    border: 1px solid #dbeafe;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
}

.qty-btn {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 999px;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1d4ed8;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

.qty-btn:hover {
    background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
}

.qty-value {
    min-width: 22px;
    text-align: center;
    font-weight: 700;
    color: #0f172a;
}

.order-remove-btn {
    border-radius: 12px;
    padding: 6px 10px;
    border-color: #fecaca;
    background: #fff5f5;
    color: #dc2626;
    transition: 0.2s ease;
}

.order-remove-btn:hover {
    border-color: #fca5a5;
    background: #fee2e2;
    color: #b91c1c;
}

.order-empty-state {
    padding: 40px 18px;
    margin: 14px;
    border: 1px dashed #cbd5e1;
    border-radius: 18px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    text-align: center;
    color: #64748b;
}

.order-empty-state i {
    display: inline-flex;
    font-size: 2.4rem;
    color: #cbd5e1;
    margin-bottom: 10px;
}

.payment-card .card-body {
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding: 18px 20px;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.58) 0%, rgba(248, 250, 252, 0.9) 100%);
}

.payment-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 14px;
    margin-bottom: 14px;
    border-radius: 14px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 0.84rem;
}

.payment-alert i {
    font-size: 1.1rem;
    margin-top: 1px;
}

.payment-summary-panel {
    padding: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.84);
    box-shadow: 0 12px 30px -28px rgba(15, 23, 42, 0.65);
}

.payment-summary-panel-accent {
    border-color: #bbf7d0;
    background: linear-gradient(180deg, rgba(240, 253, 244, 0.96) 0%, rgba(255, 255, 255, 0.96) 100%);
}

.summary-panel-title {
    margin-bottom: 12px;
    color: #0f766e;
    font-size: 0.74rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #eef2f7;
    color: #334155;
}

.summary-row b {
    color: #0f172a;
}

.summary-row-soft b {
    color: #2563eb;
}

.summary-row-highlight {
    margin-top: 14px;
    padding: 12px 14px;
    border: 1px solid #bbf7d0;
    border-radius: 14px;
    background: #ecfdf5;
    border-bottom: none;
}

.summary-input-group {
    margin-top: 12px;
}

.summary-input-group .form-label {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 600;
}

.summary-input-group .form-control,
.summary-input-group .form-select {
    min-height: 44px;
    border-color: #dbe3ee;
    border-radius: 12px;
    box-shadow: none;
    background: #ffffff;
}

.summary-input-group .form-control:focus,
.summary-input-group .form-select:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.12);
}

.cash-quick-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 8px;
    margin-top: 10px;
}

.cash-quick-btn {
    min-height: 42px;
    border: 1px solid #bfdbfe;
    border-radius: 12px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 0.8rem;
    font-weight: 700;
}

.cash-quick-btn:hover,
.cash-quick-btn:focus {
    background: #dbeafe;
    color: #1d4ed8;
}

.cash-quick-btn-full {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    border-color: #86efac;
    color: #15803d;
}

.cash-quick-btn-full:hover,
.cash-quick-btn-full:focus {
    background: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
    color: #166534;
}

.summary-total {
    margin-top: 4px;
    padding: 18px;
    border-radius: 18px;
    background: linear-gradient(135deg, #dcfce7 0%, #dbeafe 100%);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    font-weight: 700;
    color: #0f172a;
    box-shadow: 0 18px 30px -26px rgba(14, 165, 233, 0.55);
}

.summary-total>div {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.summary-total small {
    color: #334155;
    font-size: 0.72rem;
    font-weight: 600;
}

.summary-total b {
    font-size: 1.1rem;
}

.payment-helper-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 14px;
    border: 1px dashed #cbd5e1;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.82);
    color: #475569;
    font-size: 0.8rem;
}

.payment-helper-note i {
    margin-top: 1px;
    font-size: 1rem;
    color: #0f766e;
}

.action-button {
    min-height: 92px;
    border: none;
    border-radius: 18px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #ffffff;
    font-weight: 700;
    transition: 0.2s ease;
}

.action-button i {
    font-size: 1.4rem;
}

.action-button:hover:not(:disabled) {
    transform: translateY(-2px);
    color: #ffffff;
}

.action-button:disabled {
    opacity: 0.55;
    cursor: not-allowed;
}

.action-button-print {
    background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
}

.action-button-pay {
    background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
}

.action-button-split {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.action-button-cancel {
    background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
}

.transaction-list-card {
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
}

.transaction-list-header {
    padding: 18px 20px;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.transaction-list-header h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
}

.transaction-list-header small {
    color: #64748b;
}

.transaction-list-card .card-body {
    padding: 18px 20px;
}

.transaction-filter-row .form-control,
.transaction-filter-row .input-group-text {
    border-color: #dbe3ee;
    box-shadow: none;
}

.transaction-summary-grid {
    margin-bottom: 18px;
}

.transaction-summary-card {
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 14px 26px -22px rgba(15, 23, 42, 0.55);
}

.transaction-summary-card .card-body {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 18px;
}

.transaction-summary-icon {
    width: 46px;
    height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.transaction-summary-card small {
    display: block;
    margin-bottom: 4px;
    color: #64748b;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.transaction-summary-card h5 {
    color: #0f172a;
    font-weight: 800;
}

.transaction-summary-card p {
    color: #64748b;
    font-size: 0.81rem;
    line-height: 1.5;
}

.transaction-summary-card-total {
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.transaction-summary-card-total .transaction-summary-icon {
    background: #dbeafe;
    color: #1d4ed8;
}

.transaction-summary-card-amount {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
}

.transaction-summary-card-amount .transaction-summary-icon {
    background: #dcfce7;
    color: #15803d;
}

.transaction-summary-card-cash {
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
}

.transaction-summary-card-cash .transaction-summary-icon {
    background: #ffedd5;
    color: #c2410c;
}

.transaction-summary-card-qris {
    background: linear-gradient(135deg, #ecfeff 0%, #ffffff 100%);
}

.transaction-summary-card-qris .transaction-summary-icon {
    background: #cffafe;
    color: #0f766e;
}

.transaction-summary-card-bank {
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.transaction-summary-card-bank .transaction-summary-icon {
    background: #e2e8f0;
    color: #334155;
}

.transaction-summary-card-average {
    background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%);
}

.transaction-summary-card-average .transaction-summary-icon {
    background: #e0e7ff;
    color: #4338ca;
}

.transaction-filter-row .input-group-text {
    background: #f8fafc;
    color: #64748b;
}

.transaction-table-wrap {
    margin-top: 18px;
}

.transaction-table thead th {
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 12px 14px;
    vertical-align: middle;
    white-space: nowrap;
}

.transaction-table tbody td {
    padding: 14px;
    border-color: #eef2f7;
    vertical-align: middle;
    color: #0f172a;
}

.transaction-primary {
    font-weight: 700;
    color: #0f172a;
}

.transaction-secondary {
    margin-top: 3px;
    color: #64748b;
    font-size: 0.78rem;
}

.transaction-badge {
    display: inline-flex;
    align-items: center;
    margin-right: 6px;
    margin-bottom: 4px;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
}

.transaction-badge-service {
    background: #dcfce7;
    color: #166534;
}

.transaction-badge-payment {
    background: #e0f2fe;
    color: #0f766e;
}

.transaction-print-btn {
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.transaction-detail-btn {
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.transaction-detail-cell {
    background: #f8fafc;
}

.transaction-detail-loading {
    padding: 12px 0;
    color: #64748b;
}

.transaction-detail-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.transaction-detail-table thead th {
    background: #ffffff;
}

.transaction-empty-state {
    padding: 36px 18px;
    text-align: center;
    color: #64748b;
}

.transaction-empty-state i {
    display: inline-flex;
    font-size: 2.2rem;
    color: #cbd5e1;
    margin-bottom: 10px;
}

.btn-menu-floating {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 1050;
    border-radius: 50px;
}

@media (max-width: 991.98px) {
    .menu-list-scroll {
        max-height: none;
        overflow: visible;
        padding-right: 0;
    }
}

@media (max-width: 575.98px) {
    .menu-list-item {
        padding: 12px;
    }

    .menu-list-top {
        flex-direction: column;
        gap: 4px;
    }

    .menu-list-price {
        white-space: normal;
    }

    .takeaway-info-card .card-body,
    .payment-card .card-body,
    .queue-search-card .card-body {
        padding: 14px;
    }

    .order-panel-header,
    .payment-card-header {
        padding: 14px;
    }

    .order-panel-side,
    .payment-header-side {
        align-items: flex-start;
    }

    .payment-method-badge {
        min-width: 0;
    }

    .order-table thead th,
    .order-table tbody td {
        padding: 10px;
    }

    .payment-summary-panel,
    .summary-total {
        padding: 14px;
    }

    .action-button {
        min-height: 82px;
    }
}
</style>
