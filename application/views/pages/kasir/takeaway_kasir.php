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
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_saldo_awal"
                                        ng-click="LoadTakeawayTransactions()">
                                        <i class="bx bx-receipt"></i> List Transaksi
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <!-- ================= POS ================= -->
                                <!-- ================= POS ================= -->
                                <div class="tab-pane fade show active" id="tab_transaksi">

                                    <!-- FLOAT BUTTON MOBILE -->
                                    <button class="btn btn-primary btn-menu-floating d-md-none"
                                        data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
                                        <i class="bx bx-menu"></i> Menu
                                    </button>

                                    <div class="row">

                                        <!-- ================= DESKTOP MENU ================= -->
                                        <div class="col-md-4 col-lg-3 d-none d-md-block">
                                            <div class="card h-100 shadow-sm menu-panel-card">
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

                                            <div class="card shadow-sm queue-search-card mb-3">
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
                                                                    placeholder="Contoh: TA001">
                                                            </div>
                                                            <small class="text-muted">
                                                                Masukkan no antrian takeaway yang statusnya masih
                                                                menunggu untuk lanjut pembayaran.
                                                            </small>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <button class="btn btn-dark w-100 queue-search-button"
                                                                ng-click="loadQueueByNumber()"
                                                                ng-disabled="draftOrderNo !== '-' || (LoadDataPesananList.length > 0 && !paymentCompleted)">
                                                                <i class="bx bx-check-circle"></i>
                                                                <span>Ambil Antrian</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- INFO -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-12 col-sm-6 col-xl">
                                                    <div class="card shadow-sm takeaway-info-card">
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
                                                    <div class="card shadow-sm takeaway-info-card">
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
                                                    <div class="card shadow-sm takeaway-info-card">
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
                                                    <div class="card shadow-sm takeaway-info-card">
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
                                                    <div class="card shadow-sm takeaway-info-card">
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
                                                    <div class="card shadow-sm order-panel-card h-100">
                                                        <div class="card-header order-panel-header">
                                                            <div>
                                                                <h5 class="mb-1">Order List</h5>
                                                                <small>Menu yang dipilih akan muncul di sini</small>
                                                            </div>
                                                            <span class="order-count-badge">
                                                                {{(LoadDataPesananList && LoadDataPesananList.length) || 0}}
                                                            </span>
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
                                                                            <td>{{$index + 1}}</td>
                                                                            <td>
                                                                                <div class="order-item-name">
                                                                                    {{dt.nama}}
                                                                                </div>
                                                                                <div class="order-item-meta">
                                                                                    {{dt.kategori ? dt.kategori : 'Tanpa Kategori'}}
                                                                                    |
                                                                                    {{dt.jenis ? dt.jenis : 'Menu'}}
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                Rp {{dt.harga | number}}
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
                                                                            <td class="text-end fw-semibold">
                                                                                Rp {{dt.subtotal | number}}
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
                                                    <div class="card shadow-sm payment-card h-100">
                                                        <div class="card-header payment-card-header">
                                                            <div>
                                                                <h5 class="mb-1">Ringkasan Pembayaran</h5>
                                                                <small>
                                                                    Bisa langsung bayar dari draft, atau simpan dulu
                                                                    sebagai antrian lalu lanjutkan nanti.
                                                                </small>
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

                                                            <div class="summary-row">
                                                                <span>Total Qty</span>
                                                                <b>{{total_qty}}</b>
                                                            </div>

                                                            <div class="summary-row">
                                                                <span>Subtotal</span>
                                                                <b>Rp {{amount_total | number}}</b>
                                                            </div>

                                                            <div class="summary-input-group">
                                                                <label class="form-label mb-1" for="discount-nominal">
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

                                                            <div class="summary-row">
                                                                <span>Tax</span>
                                                                <b>Rp {{ppn_amount | number}}</b>
                                                            </div>

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

                                                            <div class="summary-input-group">
                                                                <label class="form-label mb-1">Jumlah Dibayar</label>
                                                                <input type="number"
                                                                    class="form-control form-control-sm text-end"
                                                                    ng-model="amount_paid"
                                                                    ng-change="updatePaidAmount()" min="0"
                                                                    ng-disabled="!isPaymentReady()"
                                                                    placeholder="0">
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

                                                            <div class="summary-row">
                                                                <span>Kembalian</span>
                                                                <b>Rp {{change_amount | number}}</b>
                                                            </div>

                                                            <div class="summary-total">
                                                                <span>Grand Total</span>
                                                                <b>Rp {{grand_total | number}}</b>
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
                                <div class="tab-pane fade" id="tab_saldo_awal">
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
            </div>
        </div>
    </div>
</div>


<style>
.menu-panel-card {
    border: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
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
    background: #ffffff;
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
    background: #ffffff;
    cursor: pointer;
    transition: 0.2s ease;
    text-align: left;
    font: inherit;
    color: inherit;
}

.menu-list-item:hover {
    border-color: #93c5fd;
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

.order-panel-header,
.payment-card-header {
    padding: 18px 20px;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
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

.order-table tbody tr:hover {
    background: #f8fafc;
}

.order-item-name {
    font-weight: 700;
    line-height: 1.35;
    color: #0f172a;
}

.order-item-meta {
    margin-top: 4px;
    color: #64748b;
    font-size: 0.78rem;
}

.qty-control {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px;
    border-radius: 999px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}

.qty-btn {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 999px;
    background: #e2e8f0;
    color: #0f172a;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

.qty-btn:hover {
    background: #cbd5e1;
}

.qty-value {
    min-width: 22px;
    text-align: center;
    font-weight: 700;
    color: #0f172a;
}

.order-remove-btn {
    border-radius: 10px;
}

.order-empty-state {
    padding: 40px 18px;
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
    padding: 18px 20px;
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

.summary-input-group {
    margin-top: 14px;
}

.summary-input-group .form-label {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 600;
}

.summary-input-group .form-control,
.summary-input-group .form-select {
    border-color: #dbe3ee;
    border-radius: 12px;
    box-shadow: none;
}

.summary-total {
    margin-top: 16px;
    padding: 16px;
    border-radius: 18px;
    background: linear-gradient(135deg, #dcfce7 0%, #dbeafe 100%);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    font-weight: 700;
    color: #0f172a;
}

.summary-total b {
    font-size: 1.1rem;
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

    .order-table thead th,
    .order-table tbody td {
        padding: 10px;
    }

    .action-button {
        min-height: 82px;
    }
}
</style>
