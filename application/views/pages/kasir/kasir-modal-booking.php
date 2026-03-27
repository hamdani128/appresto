<!-- Modal Booking Responsive -->
<div class="modal fade modal-right" id="my-modal-booking" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen modal-xl">
        <div class="modal-content">
            <div class="modal-header booking-modal-topbar">
                <div class="booking-modal-header-copy">
                    <span class="booking-modal-eyebrow">Booking Builder</span>
                    <h5 class="modal-title text-white">
                        <i class='bx bx-receipt'></i>
                        No.Pesanan <span class="booking-modal-pill" id="lb_no_booking"></span>
                        <span class="mx-2">|</span>
                        <i class='bx bx-table'></i>
                        No.Meja <span class="booking-modal-pill" id="lb_no_meja"></span>
                    </h5>
                    <small class="booking-modal-subtitle">Pilih menu di kiri, review pesanan di kanan, lalu simpan.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body booking-workspace">
                <div class="booking-mobile-menu-bar d-lg-none mb-3">
                    <button class="btn booking-mobile-menu-trigger w-100" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileBookingMenu" aria-controls="mobileBookingMenu">
                        <span class="d-flex align-items-center justify-content-between gap-3">
                            <span class="d-inline-flex align-items-center gap-2">
                                <i class="bx bx-grid-alt"></i>
                                <span>Menu &amp; Filter</span>
                            </span>
                            <span class="booking-mobile-menu-count">
                                {{(filteredMenu && filteredMenu.length) || 0}}
                            </span>
                        </span>
                    </button>
                    <small class="booking-mobile-menu-helper">Buka drawer menu untuk cari item, lalu tap menu agar
                        langsung masuk ke cart.</small>
                </div>

                <div class="offcanvas offcanvas-start booking-menu-offcanvas d-lg-none" tabindex="-1"
                    id="mobileBookingMenu">
                    <div class="offcanvas-header">
                        <div class="booking-offcanvas-copy">
                            <span class="booking-modal-eyebrow">Drawer Menu</span>
                            <h5 class="mb-1">Daftar Menu</h5>
                            <small>Pilih menu dari panel samping lalu kembali ke cart.</small>
                        </div>
                        <div class="booking-offcanvas-actions">
                            <span class="booking-panel-count">
                                {{(filteredMenu && filteredMenu.length) || 0}}
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                    </div>
                    <div class="offcanvas-body">
                        <div class="booking-panel-heading">
                            <div>
                                <h6 class="mb-1">Pilih Menu</h6>
                                <small>Tap item untuk langsung masuk ke daftar pesanan.</small>
                            </div>
                            <span class="booking-panel-count">
                                {{(filteredMenu && filteredMenu.length) || 0}}
                            </span>
                        </div>
                        <div class="booking-filter-shell">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary">Pencarian</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i
                                                class='bx bx-search'></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0"
                                            ng-model="keywordMenu" ng-change="searchMenu()" placeholder="Cari menu...">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary">Kategori</label>
                                    <select class="form-select" ng-model="selectedCategory" ng-change="searchMenu()"
                                        ng-options="c.kategori as c.kategori for c in categories">
                                        <option value="">Semua Kategori</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="menu-grid mobile-menu-grid">
                            <div class="row g-2 menu-grid-row">
                                <div class="col-6" ng-repeat="dt in filteredMenu">
                                    <div class="menu-card" ng-click="PilihMenu(dt)" data-bs-dismiss="offcanvas">
                                        <div class="menu-card-img">
                                            <img ng-if="dt.jenis=='Makanan' && !dt.img"
                                                src="<?php echo base_url('public/assets/images/foodbar.png') ?>"
                                                alt="{{dt.nama}}">
                                            <img ng-if="dt.jenis=='Makanan' && dt.img"
                                                src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                alt="{{dt.nama}}">
                                            <img ng-if="dt.jenis=='Minuman' && !dt.img"
                                                src="<?php echo base_url('public/assets/images/refreshments.png') ?>"
                                                alt="{{dt.nama}}">
                                            <img ng-if="dt.jenis=='Minuman' && dt.img"
                                                src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                alt="{{dt.nama}}">
                                            <span class="status-badge"
                                                ng-class="dt.status_food=='1' ? 'bg-success' : 'bg-danger'">
                                                {{dt.status_food=='1' ? 'Ready' : 'Close'}}
                                            </span>
                                        </div>
                                        <div class="menu-card-body">
                                            <h6 class="menu-title">{{dt.nama}}</h6>
                                            <div class="menu-meta-row">
                                                <span class="menu-price">Rp {{dt.harga | number}}</span>
                                                <span class="menu-category">{{dt.jenis}}</span>
                                            </div>
                                            <div class="menu-action-hint">
                                                <i class="bx bx-plus-circle"></i>
                                                <span>Tambah ke pesanan</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" ng-if="!filteredMenu || filteredMenu.length === 0">
                                    <div class="booking-menu-empty">
                                        <i class="bx bx-search-alt"></i>
                                        <h6 class="mb-1">Menu tidak ditemukan</h6>
                                        <small>Coba ubah kata kunci atau kategori pencarian.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- LEFT PANEL: Menu -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="card menu-panel h-100">
                            <div class="card-body">
                                <div class="booking-panel-heading">
                                    <div>
                                        <h6 class="mb-1">Pilih Menu</h6>
                                        <small>Klik kartu menu untuk menambahkan item ke pesanan.</small>
                                    </div>
                                    <span class="booking-panel-count">
                                        {{(filteredMenu && filteredMenu.length) || 0}}
                                    </span>
                                </div>
                                <div class="booking-filter-shell">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold text-secondary">Pencarian</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0"><i
                                                        class='bx bx-search'></i></span>
                                                <input type="text" class="form-control border-start-0 ps-0"
                                                    ng-model="keywordMenu" ng-change="searchMenu()"
                                                    placeholder="Cari menu...">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold text-secondary">Kategori</label>
                                            <select class="form-select" ng-model="selectedCategory"
                                                ng-change="searchMenu()"
                                                ng-options="c.kategori as c.kategori for c in categories">
                                                <option value="">Semua Kategori</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="booking-filter-hints">
                                        <span class="booking-filter-chip">
                                            <i class="bx bx-tap"></i> Tap menu untuk tambah item
                                        </span>
                                        <span class="booking-filter-chip">
                                            <i class="bx bx-check-shield"></i> Menu ready bisa langsung dipilih
                                        </span>
                                    </div>
                                </div>

                                <!-- Menu Grid -->
                                <div class="menu-grid">
                                    <div class="row g-2 menu-grid-row" id="menu-grid-container">
                                        <div class="col-6 col-md-4 col-lg-3" ng-repeat="dt in filteredMenu">
                                            <div class="menu-card" ng-click="PilihMenu(dt)">
                                                <div class="menu-card-img">
                                                    <img ng-if="dt.jenis=='Makanan' && !dt.img"
                                                        src="<?php echo base_url('public/assets/images/foodbar.png') ?>"
                                                        alt="{{dt.nama}}">
                                                    <img ng-if="dt.jenis=='Makanan' && dt.img"
                                                        src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                        alt="{{dt.nama}}">
                                                    <img ng-if="dt.jenis=='Minuman' && !dt.img"
                                                        src="<?php echo base_url('public/assets/images/refreshments.png') ?>"
                                                        alt="{{dt.nama}}">
                                                    <img ng-if="dt.jenis=='Minuman' && dt.img"
                                                        src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                        alt="{{dt.nama}}">
                                                    <span class="status-badge"
                                                        ng-class="dt.status_food=='1' ? 'bg-success' : 'bg-danger'">
                                                        {{dt.status_food=='1' ? 'Ready' : 'Close'}}
                                                    </span>
                                                </div>
                                                <div class="menu-card-body">
                                                    <h6 class="menu-title">{{dt.nama}}</h6>
                                                    <div class="menu-meta-row">
                                                        <span class="menu-price">Rp {{dt.harga | number}}</span>
                                                        <span class="menu-category">{{dt.jenis}}</span>
                                                    </div>
                                                    <div class="menu-action-hint">
                                                        <i class="bx bx-plus-circle"></i>
                                                        <span>Tambah ke pesanan</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" ng-if="!filteredMenu || filteredMenu.length === 0">
                                            <div class="booking-menu-empty">
                                                <i class="bx bx-search-alt"></i>
                                                <h6 class="mb-1">Menu tidak ditemukan</h6>
                                                <small>Coba ubah kata kunci atau kategori pencarian.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT PANEL: Daftar Pesanan -->
                    <div class="col-12 col-lg-6">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="card order-panel">
                                    <div class="card-header bg-white py-3 d-flex align-items-start justify-content-between booking-order-header">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class='bx bx-list-ul fs-4 me-2 text-primary'></i>
                                                <h5 class="mb-0 fw-semibold">Daftar Pesanan</h5>
                                            </div>
                                            <small class="booking-panel-subtitle">Review item, qty, dan owner sebelum simpan.</small>
                                        </div>
                                        <span class="booking-panel-tag">Live Cart</span>
                                    </div>
                                    <div class="booking-order-note">
                                        <i class="bx bx-info-circle"></i>
                                        <span>Gunakan tombol `+`, `-`, dan hapus untuk mengatur qty sebelum menyimpan.</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" style="max-height: 55vh; overflow-y: auto;">
                                            <table class="table-order" id="tb_pesanan">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Cat.</th>
                                                        <th>Menu</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Jenis</th>
                                                        <th>Owner</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_pesanan_body">
                                                    <!-- AngularJS will populate -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="col-12">
                                <div class="booking-save-panel">
                                    <div class="booking-save-copy">
                                        <h6 class="mb-1">Siap simpan pesanan?</h6>
                                        <small>Semua item pada cart akan masuk ke meja yang sedang aktif.</small>
                                    </div>
                                    <button class="btn-simpan" ng-click="SimpanDataOrder()">
                                        <i class='bx bx-save me-2'></i> Simpan Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- modal-body -->
        </div> <!-- modal-content -->
    </div> <!-- modal-dialog -->
</div>
<!-- modal -->



<style>
/* ===== MODERN REDESIGN ===== */
#my-modal-booking .modal-content {
    border: none;
    border-radius: 24px 24px 0 0;
    overflow: hidden;
    background: #f8fafc;
}

#my-modal-booking .booking-workspace {
    background:
        radial-gradient(circle at top right, rgba(37, 99, 235, 0.06), transparent 22%),
        radial-gradient(circle at top left, rgba(14, 165, 233, 0.08), transparent 18%),
        #f8fafc;
}

/* Header with gradient */
#my-modal-booking .booking-modal-topbar {
    background-color: #102a43 !important;
    background-image:
        radial-gradient(circle at top right, rgba(45, 212, 191, 0.18), transparent 26%),
        linear-gradient(145deg, #102a43 0%, #0f172a 60%, #0b3b59 100%) !important;
    border-bottom: none;
    padding: 1.25rem 1.75rem;
    box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.08);
    color: #fff;
}

#my-modal-booking .modal-header h5 {
    font-weight: 600;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.2rem;
}

#my-modal-booking .modal-header h5 i {
    font-size: 1.4rem;
}

#my-modal-booking .booking-modal-header-copy {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
}

#my-modal-booking .booking-modal-eyebrow {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.72);
}

#my-modal-booking .booking-modal-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    min-height: 32px;
    padding: 0.25rem 0.8rem;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    background: rgba(15, 118, 110, 0.28);
    color: white;
    font-weight: 700;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
}

#my-modal-booking .booking-modal-pill:empty::before {
    content: "--";
    opacity: 0.58;
}

#my-modal-booking .booking-modal-subtitle {
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.82rem;
}

#my-modal-booking .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
    transition: opacity 0.2s;
    background-size: 0.8rem;
}

#my-modal-booking .booking-mobile-menu-bar {
    position: sticky;
    top: -0.25rem;
    z-index: 6;
}

#my-modal-booking .booking-mobile-menu-trigger {
    border: none;
    border-radius: 18px;
    padding: 0.9rem 1rem;
    background:
        radial-gradient(circle at top right, rgba(45, 212, 191, 0.28), transparent 28%),
        linear-gradient(135deg, #0f3d5e 0%, #102a43 52%, #0f766e 100%);
    color: #ffffff;
    box-shadow: 0 18px 30px -18px rgba(15, 61, 94, 0.72);
    text-align: left;
}

#my-modal-booking .booking-mobile-menu-trigger:hover,
#my-modal-booking .booking-mobile-menu-trigger:focus {
    color: #ffffff;
    box-shadow: 0 20px 34px -18px rgba(15, 61, 94, 0.82);
}

#my-modal-booking .booking-mobile-menu-trigger .bx {
    font-size: 1.15rem;
}

#my-modal-booking .booking-mobile-menu-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    min-height: 32px;
    padding: 0.2rem 0.7rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.16);
    font-size: 0.76rem;
    font-weight: 700;
}

#my-modal-booking .booking-mobile-menu-helper {
    display: block;
    margin-top: 0.55rem;
    padding: 0 0.25rem;
    color: #64748b;
    font-size: 0.76rem;
    line-height: 1.45;
}

#my-modal-booking .booking-menu-offcanvas {
    width: min(88vw, 360px);
    border-right: none;
    background:
        radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 20%),
        #f8fafc;
    z-index: 1065;
}

#my-modal-booking .booking-menu-offcanvas .offcanvas-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 1rem 1rem 0.9rem;
    background:
        radial-gradient(circle at top right, rgba(45, 212, 191, 0.2), transparent 34%),
        linear-gradient(145deg, #102a43 0%, #0f172a 58%, #0b3b59 100%);
    color: #ffffff;
}

#my-modal-booking .booking-menu-offcanvas .offcanvas-header h5 {
    color: #ffffff;
}

#my-modal-booking .booking-menu-offcanvas .offcanvas-header small {
    color: rgba(255, 255, 255, 0.76);
}

#my-modal-booking .booking-offcanvas-copy {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

#my-modal-booking .booking-offcanvas-actions {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
}

#my-modal-booking .booking-menu-offcanvas .booking-panel-count {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #ffffff;
}

#my-modal-booking .booking-menu-offcanvas .btn-close {
    margin: 0;
}

#my-modal-booking .booking-menu-offcanvas .offcanvas-body {
    padding: 1rem;
}

/* Cards */
#my-modal-booking .card {
    border: none;
    border-radius: 20px;
    background: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
}

#my-modal-booking .menu-panel {
    background: #ffffff;
}

#my-modal-booking .booking-panel-heading {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

#my-modal-booking .booking-panel-heading h6 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f3d5e;
}

#my-modal-booking .booking-panel-heading small,
#my-modal-booking .booking-panel-subtitle {
    color: #64748b;
}

#my-modal-booking .booking-panel-count,
#my-modal-booking .booking-panel-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    padding: 0.35rem 0.8rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
}

#my-modal-booking .booking-panel-count {
    background: #dbeafe;
    color: #1d4ed8;
}

#my-modal-booking .booking-panel-tag {
    background: #f1f5f9;
    color: #475569;
}

#my-modal-booking .booking-filter-shell {
    padding: 14px;
    margin-bottom: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

#my-modal-booking .booking-filter-hints {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

#my-modal-booking .booking-filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.36rem 0.72rem;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 0.72rem;
    font-weight: 700;
}

/* Form controls */
#my-modal-booking .form-control,
#my-modal-booking .form-select {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 0.6rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s;
}

#my-modal-booking .form-control:focus,
#my-modal-booking .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

#my-modal-booking .input-group-text {
    border: 1px solid #e2e8f0;
    border-radius: 12px 0 0 12px;
    background: white;
    color: #64748b;
}

#my-modal-booking .input-group .form-control {
    border-radius: 0 12px 12px 0;
}

/* Menu Grid */
#my-modal-booking .menu-grid {
    max-height: 62vh;
    overflow-y: auto;
    padding-right: 4px;
}

#my-modal-booking .mobile-menu-grid {
    max-height: calc(100vh - 260px);
    padding-right: 0;
}

#my-modal-booking .menu-grid-row > [class*="col-"] {
    display: flex;
}

#my-modal-booking .menu-grid-row .menu-card {
    width: 100%;
}

#my-modal-booking .menu-grid::-webkit-scrollbar {
    width: 6px;
}

#my-modal-booking .menu-grid::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

#my-modal-booking .menu-grid::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

#my-modal-booking .menu-grid::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

#my-modal-booking .booking-menu-empty {
    padding: 1.4rem 1rem;
    border: 1px dashed #cbd5e1;
    border-radius: 18px;
    text-align: center;
    color: #64748b;
    background: #ffffff;
}

#my-modal-booking .booking-menu-empty i {
    display: inline-flex;
    margin-bottom: 0.55rem;
    font-size: 2rem;
    color: #94a3b8;
}

/* Modern Menu Card */
#my-modal-booking .menu-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.02);
    border: 1px solid #edf2f7;
    transition: all 0.25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

#my-modal-booking .menu-card:hover {
    transform: translateY(-3px);
    border-color: #3b82f6;
    box-shadow: 0 16px 22px -10px rgba(59, 130, 246, 0.2);
}

#my-modal-booking .menu-card-img {
    position: relative;
    width: 100%;
    padding-top: 64%;
    background: #f8fafc;
    overflow: hidden;
}

#my-modal-booking .menu-card-img img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

#my-modal-booking .menu-card:hover .menu-card-img img {
    transform: scale(1.05);
}

#my-modal-booking .status-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 0.56rem;
    font-weight: 600;
    padding: 0.18rem 0.55rem;
    border-radius: 30px;
    color: white;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(2px);
}

#my-modal-booking .status-badge.bg-success {
    background: rgba(34, 197, 94, 0.9) !important;
}

#my-modal-booking .status-badge.bg-danger {
    background: rgba(239, 68, 68, 0.9) !important;
}

#my-modal-booking .menu-card-body {
    padding: 0.62rem 0.65rem 0.72rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

#my-modal-booking .menu-title {
    font-weight: 600;
    font-size: 0.82rem;
    line-height: 1.3;
    color: #102a43;
    margin-bottom: 0.18rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.05rem;
}

#my-modal-booking .menu-card:hover .menu-title {
    color: #0f766e;
}

#my-modal-booking .menu-price {
    font-weight: 700;
    color: #2563eb;
    font-size: 0.82rem;
}

#my-modal-booking .menu-meta-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}

#my-modal-booking .menu-category {
    background: #f1f5f9;
    padding: 0.16rem 0.45rem;
    border-radius: 40px;
    font-size: 0.56rem;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
}

#my-modal-booking .menu-action-hint {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    margin-top: auto;
    padding-top: 0.45rem;
    color: #0f766e;
    font-size: 0.68rem;
    font-weight: 700;
}

/* Order Panel */
#my-modal-booking .order-panel {
    background: white;
    border-radius: 20px;
    overflow: hidden;
}

#my-modal-booking .order-panel .card-header {
    border-bottom: 1px solid #edf2f7;
    background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
    padding: 1rem 1.25rem;
}

#my-modal-booking .order-panel .card-header h5 {
    color: #0f3d5e;
}

#my-modal-booking .booking-order-note {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 12px 18px;
    border-top: 1px solid #edf2f7;
    border-bottom: 1px solid #edf2f7;
    background: #f8fafc;
    color: #475569;
    font-size: 0.78rem;
}

#my-modal-booking .booking-order-note i {
    font-size: 1rem;
    color: #2563eb;
    margin-top: 1px;
}

/* Modern Table */
#my-modal-booking .table-order {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 6px;
    padding: 0 0.5rem;
}

#my-modal-booking .table-order thead th {
    background: #f8fafc;
    color: #1e293b;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.85rem 0.5rem;
    border: none;
    white-space: nowrap;
    color: #475569;
    position: sticky;
    top: 0;
    z-index: 2;
}

#my-modal-booking .table-order tbody tr {
    transition: transform 0.12s ease;
}

#my-modal-booking .table-order tbody td {
    padding: 0.85rem 0.5rem;
    border-top: 1px solid #edf2f7;
    border-bottom: 1px solid #edf2f7;
    vertical-align: middle;
    font-size: 0.85rem;
    color: #334155;
    background: white;
}

#my-modal-booking .table-order tbody tr:hover {
    transform: translateY(-1px);
}

#my-modal-booking .table-order tbody td:first-child {
    border-left: 1px solid #edf2f7;
    border-radius: 14px 0 0 14px;
}

#my-modal-booking .table-order tbody td:last-child {
    border-right: 1px solid #edf2f7;
    border-radius: 0 14px 14px 0;
}

#my-modal-booking #tb_pesanan_body .qty-cell {
    font-weight: 700;
    color: #0f172a;
}

#my-modal-booking #tb_pesanan_body .btn {
    width: 30px;
    height: 30px;
    padding: 0;
    margin-right: 6px;
    border: none;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: none;
}

#my-modal-booking #tb_pesanan_body .btn-dark {
    background: #0f172a;
}

#my-modal-booking #tb_pesanan_body .btn-danger {
    background: #ef4444;
}

/* Badge in table */
#my-modal-booking .badge-category {
    background: #e2e8f0;
    color: #334155;
    font-weight: 500;
    padding: 0.25rem 0.75rem;
    border-radius: 30px;
    font-size: 0.7rem;
}

/* Action button */
#my-modal-booking .btn-action {
    padding: 0.3rem 0.6rem;
    border-radius: 10px;
    border: none;
    background: transparent;
    color: #94a3b8;
    transition: all 0.15s;
}

#my-modal-booking .btn-action:hover {
    background: #fee2e2;
    color: #ef4444 !important;
}

/* Simpan button */
#my-modal-booking .btn-simpan {
    padding: 0.9rem 1.5rem;
    border-radius: 60px;
    font-weight: 600;
    background: linear-gradient(145deg, #2563eb, #1d4ed8);
    border: none;
    box-shadow: 0 10px 20px -8px #2563eb80;
    transition: all 0.2s;
    color: white;
    width: 100%;
    font-size: 1rem;
    letter-spacing: 0.3px;
}

#my-modal-booking .btn-simpan:hover {
    background: linear-gradient(145deg, #1d4ed8, #1e3a8a);
    box-shadow: 0 15px 25px -8px #1d4ed8;
    transform: translateY(-2px);
}

#my-modal-booking .booking-save-panel {
    padding: 16px 18px;
    border: 1px solid #dbeafe;
    border-radius: 22px;
    background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%);
}

#my-modal-booking .booking-save-copy {
    margin-bottom: 12px;
}

#my-modal-booking .booking-save-copy h6 {
    font-size: 0.98rem;
    font-weight: 700;
    color: #0f3d5e;
}

#my-modal-booking .booking-save-copy small {
    color: #64748b;
}

/* ===== TABLET OPTIMIZATION (768px - 991px) ===== */
@media (min-width: 768px) and (max-width: 991.98px) {
    #my-modal-booking .modal-dialog {
        max-width: 98%;
        margin: 0.5rem auto;
    }

    /* Adjust menu card size */
    #my-modal-booking .menu-card-img {
        padding-top: 60%;
    }

    #my-modal-booking .menu-title {
        font-size: 0.76rem;
        min-height: 2rem;
    }

    #my-modal-booking .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-booking .menu-category {
        font-size: 0.52rem;
        padding: 0.14rem 0.42rem;
    }

    /* Table adjustments */
    #my-modal-booking .table-order thead th {
        font-size: 0.65rem;
        padding: 0.7rem 0.3rem;
    }

    #my-modal-booking .table-order tbody td {
        font-size: 0.75rem;
        padding: 0.7rem 0.3rem;
    }

    #my-modal-booking .badge-category {
        font-size: 0.6rem;
        padding: 0.2rem 0.5rem;
    }

    /* Reduce padding on cards */
    #my-modal-booking .card-body {
        padding: 1rem;
    }
}

/* ===== MOBILE (below 768) ===== */
@media (max-width: 767.98px) {
    #my-modal-booking .booking-workspace {
        padding-top: 0.4rem;
    }

    #my-modal-booking .booking-panel-heading,
    #my-modal-booking .booking-order-header {
        flex-direction: column;
        align-items: flex-start !important;
    }

    #my-modal-booking .modal-header h5 {
        font-size: 1rem;
    }

    #my-modal-booking .modal-header {
        padding: 1rem 1rem 0.95rem;
    }

    #my-modal-booking .booking-modal-subtitle {
        font-size: 0.76rem;
    }

    #my-modal-booking .menu-grid {
        max-height: none;
    }

    #my-modal-booking .mobile-menu-grid {
        max-height: calc(100vh - 235px);
    }

    #my-modal-booking .menu-card-img {
        padding-top: 58%;
    }

    #my-modal-booking .menu-title {
        font-size: 0.75rem;
        min-height: 1.85rem;
    }

    #my-modal-booking .menu-card-body {
        padding: 0.55rem 0.56rem 0.62rem;
    }

    #my-modal-booking .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-booking .menu-category {
        font-size: 0.52rem;
    }

    #my-modal-booking .mobile-menu-grid .menu-action-hint {
        display: none;
    }

    #my-modal-booking .booking-filter-shell {
        padding: 12px;
    }

    #my-modal-booking .booking-order-note {
        padding: 10px 14px;
    }
}

/* ===== OPTIMASI TABLET AGAR TIDAK SCROLL VERTIKAL ===== */
@media (min-width: 768px) and (max-width: 991.98px) and (orientation: landscape) {

    /* Kurangi tinggi card menu */
    #my-modal-booking .menu-card-img {
        padding-top: 60%;
        /* Lebih pendek dari 70% */
    }

    #my-modal-booking .menu-card-body {
        padding: 0.4rem 0.5rem 0.5rem;
    }

    #my-modal-booking .menu-title {
        font-size: 0.7rem;
        min-height: 1.8rem;
        line-height: 1.2;
        -webkit-line-clamp: 2;
    }

    #my-modal-booking .menu-price {
        font-size: 0.7rem;
    }

    #my-modal-booking .menu-category {
        font-size: 0.5rem;
        padding: 0.1rem 0.4rem;
    }

    /* Kurangi tinggi kontainer menu */
    #my-modal-booking .menu-grid {
        max-height: 45vh;
    }

    /* Kurangi padding pada card panel */
    #my-modal-booking .card-body {
        padding: 0.75rem;
    }

    /* Perkecil elemen search */
    #my-modal-booking .form-control,
    #my-modal-booking .form-select,
    #my-modal-booking .input-group-text {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
    }

    #my-modal-booking .form-label {
        margin-bottom: 0.2rem;
        font-size: 0.8rem;
    }

    /* Perkecil tabel pesanan */
    #my-modal-booking .table-order thead th {
        padding: 0.5rem 0.25rem;
        font-size: 0.6rem;
    }

    #my-modal-booking .table-order tbody td {
        padding: 0.5rem 0.25rem;
        font-size: 0.7rem;
    }

    #my-modal-booking .badge-category {
        font-size: 0.55rem;
        padding: 0.15rem 0.4rem;
    }

    /* Tombol simpan lebih kecil */
    #my-modal-booking .btn-simpan {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }
}

/* Untuk tablet portrait (mungkin tetap butuh scroll, tapi kita optimasi juga) */
@media (min-width: 768px) and (max-width: 991.98px) and (orientation: portrait) {
    #my-modal-booking .menu-grid {
        max-height: 50vh;
    }

    #my-modal-booking .menu-card-img {
        padding-top: 65%;
    }

    #my-modal-booking .menu-title {
        font-size: 0.75rem;
        min-height: 2rem;
    }
}
</style>
