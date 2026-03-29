<!-- Modal Tambah Pesanan -->
<div class="modal fade modal-right" id="my-modal-tambah-pesanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen modal-xl">
        <div class="modal-content">
            <div class="modal-header tambah-modal-topbar">
                <div class="tambah-modal-header-copy">
                    <span class="tambah-modal-eyebrow">Order Extension</span>
                    <h5 class="modal-title text-white">
                        <i class='bx bx-plus-circle'></i>
                        No.Pesanan <span class="tambah-modal-pill" id="lb_no_booking_tambahan"></span>
                        <span class="mx-2">|</span>
                        <i class='bx bx-table'></i>
                        No.Meja <span class="tambah-modal-pill" id="lb_no_meja_tambah_pesanan"></span>
                    </h5>
                    <small class="tambah-modal-subtitle">Tambah item ke pesanan aktif, review cart, lalu simpan.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body tambah-workspace">
                <!-- Mobile menu now uses offcanvas drawer -->

                <div class="tambah-mobile-menu-bar d-lg-none mb-3">
                    <button class="btn tambah-mobile-menu-trigger w-100" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileTambahPesananMenu" aria-controls="mobileTambahPesananMenu">
                        <span class="d-flex align-items-center justify-content-between gap-3">
                            <span class="d-inline-flex align-items-center gap-2">
                                <i class="bx bx-grid-alt"></i>
                                <span>Menu &amp; Filter</span>
                            </span>
                            <span class="tambah-mobile-menu-count">{{(filteredMenu && filteredMenu.length) || 0}}</span>
                        </span>
                    </button>
                    <small class="tambah-mobile-menu-helper">Buka drawer menu untuk cari item, lalu tap menu agar
                        langsung masuk ke daftar pesanan.</small>
                </div>

                <div class="offcanvas offcanvas-start tambah-menu-offcanvas d-lg-none" tabindex="-1"
                    id="mobileTambahPesananMenu">
                    <div class="offcanvas-header">
                        <div class="tambah-offcanvas-copy">
                            <span class="tambah-modal-eyebrow">Drawer Menu</span>
                            <h5 class="mb-1">Daftar Menu</h5>
                            <small>Pilih menu dari panel samping lalu kembali ke cart.</small>
                        </div>
                        <div class="tambah-offcanvas-actions">
                            <span class="tambah-panel-count">{{(filteredMenu && filteredMenu.length) || 0}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                    </div>
                    <div class="offcanvas-body">
                        <div class="tambah-panel-heading">
                            <div>
                                <h6 class="mb-1">Pilih Menu Tambahan</h6>
                                <small>Tap item untuk langsung masuk ke daftar pesanan.</small>
                            </div>
                            <span class="tambah-panel-count">{{(filteredMenu && filteredMenu.length) || 0}}</span>
                        </div>
                        <div class="tambah-filter-shell">
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
                            <div class="row g-2 tambah-menu-grid-row">
                                <div class="col-6" ng-repeat="dt in filteredMenu">
                                    <div class="menu-card" ng-click="PilihMenuTambahan(dt)" data-bs-dismiss="offcanvas">
                                            <div class="menu-card-img">
                                            <img ng-if="dt.jenis=='Makanan' && !dt.img"
                                                src="<?php echo base_url('public/assets/images/makanan.png') ?>"
                                                alt="{{dt.nama}}">
                                            <img ng-if="dt.jenis=='Makanan' && dt.img"
                                                src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                alt="{{dt.nama}}">
                                            <img ng-if="dt.jenis=='Minuman' && !dt.img"
                                                src="<?php echo base_url('public/assets/images/minuman.png') ?>"
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
                                    <div class="tambah-menu-empty">
                                        <i class="bx bx-search-alt"></i>
                                        <h6 class="mb-1">Menu tidak ditemukan</h6>
                                        <small>Coba ubah kata kunci atau kategori pencarian.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <div class="row g-4">
                        <!-- Kolom Kiri: Menu -->
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="card menu-panel h-100">
                                <div class="card-body">
                                    <div class="tambah-panel-heading">
                                        <div>
                                            <h6 class="mb-1">Pilih Menu Tambahan</h6>
                                            <small>Klik kartu menu untuk menambahkan item ke pesanan.</small>
                                        </div>
                                        <span
                                            class="tambah-panel-count">{{(filteredMenu && filteredMenu.length) || 0}}</span>
                                    </div>
                                    <div class="tambah-filter-shell">
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
                                        <div class="tambah-filter-hints">
                                            <span class="tambah-filter-chip">
                                                <i class="bx bx-tap"></i> Tap menu untuk tambah item
                                            </span>
                                            <span class="tambah-filter-chip">
                                                <i class="bx bx-check-shield"></i> Menu ready bisa langsung dipilih
                                            </span>
                                        </div>
                                    </div>
                                    <div class="menu-grid">
                                        <div class="row g-2 tambah-menu-grid-row">
                                            <div class="col-6 col-md-4 col-lg-3" ng-repeat="dt in filteredMenu"
                                                ng-if="filteredMenu.length > 0">
                                                <div class="menu-card" ng-click="PilihMenuTambahan(dt)">
                                                    <div class="menu-card-img">
                                                        <img ng-if="dt.jenis=='Makanan' && !dt.img"
                                                            src="<?php echo base_url('public/assets/images/makanan.png') ?>"
                                                            alt="{{dt.nama}}">
                                                        <img ng-if="dt.jenis=='Makanan' && dt.img"
                                                            src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                            alt="{{dt.nama}}">
                                                        <img ng-if="dt.jenis=='Minuman' && !dt.img"
                                                            src="<?php echo base_url('public/assets/images/minuman.png') ?>"
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
                                                <div class="tambah-menu-empty">
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
                        <!-- Kolom Kanan: Keranjang -->
                        <div class="col-12 col-lg-6">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="card order-panel">
                                        <div
                                            class="card-header bg-white py-3 d-flex align-items-start justify-content-between tambah-order-header">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <i class='bx bx-list-ul fs-4 me-2 text-primary'></i>
                                                    <h5 class="mb-0 fw-semibold">Daftar Pesanan Tambahan</h5>
                                                </div>
                                                <small class="tambah-panel-subtitle">Review item, qty, dan owner sebelum
                                                    simpan.</small>
                                            </div>
                                            <span class="tambah-panel-tag">Live Cart</span>
                                        </div>
                                        <div class="tambah-order-note">
                                            <i class="bx bx-info-circle"></i>
                                            <span>Gunakan tombol `+`, `-`, dan hapus untuk mengatur qty sebelum
                                                menyimpan.</span>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive" style="max-height: 55vh; overflow-y: auto;">
                                                <table class="table-order" id="tb_pesanan_tambahan">
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
                                                    <tbody id="tb_pesanan_body_tambahan">
                                                        <!-- diisi AngularJS -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="tambah-save-panel">
                                        <div class="tambah-save-copy">
                                            <h6 class="mb-1">Siap simpan tambahan pesanan?</h6>
                                            <small>Semua item pada cart akan ditambahkan ke meja yang sedang
                                                aktif.</small>
                                        </div>
                                        <button class="btn-simpan-tambahan" ng-click="SimpanDataOrderTambahan()">
                                            <i class='bx bx-save me-2'></i> Tambah Pesanan
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
<!-- End Tambah Pesanan -->



<style>
/* =======================================================
   MODAL TAMBAH PESANAN - PROFESSIONAL POS VERSION
   ======================================================= */

#my-modal-tambah-pesanan .modal-content {
    border: none;
    border-radius: 20px 20px 0 0;
    overflow: hidden;
    background: #f9fafb;
}

/* ================= HEADER ================= */

#my-modal-tambah-pesanan .modal-header.bg-gradient {
    background: #0f172a;
    border-bottom: 1px solid #1e293b;
    padding: 14px 20px;
}

#my-modal-tambah-pesanan .modal-header h5 {
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.3px;
}

#my-modal-tambah-pesanan .modal-header .badge {
    background: #ffffff;
    color: #0f172a;
    font-weight: 600;
    font-size: 0.75rem;
    border-radius: 20px;
    padding: 4px 10px;
}

#my-modal-tambah-pesanan .btn-close {
    filter: brightness(0) invert(1);
}

/* ================= CARD PANEL ================= */

#my-modal-tambah-pesanan .card {
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    box-shadow: none;
}

/* ================= SEARCH ================= */

#my-modal-tambah-pesanan .search-filter .form-control,
#my-modal-tambah-pesanan .search-filter .form-select {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    font-size: 0.85rem;
}

#my-modal-tambah-pesanan .search-filter .form-control:focus,
#my-modal-tambah-pesanan .search-filter .form-select:focus {
    border-color: #2563eb;
    box-shadow: none;
}

/* ================= MENU GRID ================= */

#my-modal-tambah-pesanan .menu-grid,
#my-modal-tambah-pesanan .menu-grid-mobile {
    max-height: 65vh;
    overflow-y: auto;
    padding-right: 4px;
}

/* Scrollbar clean */
#my-modal-tambah-pesanan .menu-grid::-webkit-scrollbar,
#my-modal-tambah-pesanan .menu-grid-mobile::-webkit-scrollbar {
    width: 6px;
}

#my-modal-tambah-pesanan .menu-grid::-webkit-scrollbar-thumb,
#my-modal-tambah-pesanan .menu-grid-mobile::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
}

/* ================= MENU CARD ================= */

#my-modal-tambah-pesanan .menu-card {
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    background: #ffffff;
    transition: all 0.18s ease;
    cursor: pointer;
}

#my-modal-tambah-pesanan .menu-card:hover {
    border-color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.08);
}

/* Compact image */
#my-modal-tambah-pesanan .menu-card-img {
    position: relative;
    padding-top: 65%;
    overflow: hidden;
    background: #f1f5f9;
}

#my-modal-tambah-pesanan .menu-card-img img {
    position: absolute;
    top: 0;
    left: 0;
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#my-modal-tambah-pesanan .status-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 0.55rem;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 20px;
    color: #ffffff;
    letter-spacing: 0.3px;
}

#my-modal-tambah-pesanan .status-badge.bg-success {
    background: #22c55e !important;
}

#my-modal-tambah-pesanan .status-badge.bg-danger {
    background: #ef4444 !important;
}

#my-modal-tambah-pesanan .menu-card-body {
    padding: 8px 10px 10px;
}

#my-modal-tambah-pesanan .menu-title {
    font-size: 0.8rem;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.3;
    min-height: 32px;
    overflow: hidden;
}

#my-modal-tambah-pesanan .menu-price {
    font-size: 0.8rem;
    font-weight: 700;
    color: #1d4ed8;
}

#my-modal-tambah-pesanan .menu-category {
    font-size: 0.55rem;
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 20px;
    font-weight: 500;
    color: #475569;
}

/* Grid spacing */
#my-modal-tambah-pesanan .row.g-2>[class*="col-"] {
    padding: 6px;
}

/* ================= TABLE ORDER ================= */

#my-modal-tambah-pesanan .table-order {
    width: 100%;
    font-size: 0.8rem;
    border-collapse: collapse;
}

#my-modal-tambah-pesanan .table-order thead th {
    background: #f1f5f9;
    color: #475569;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    padding: 8px 6px;
    border-bottom: 1px solid #e5e7eb;
}

#my-modal-tambah-pesanan .table-order tbody td {
    padding: 8px 6px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}

#my-modal-tambah-pesanan .table-order tbody tr:hover {
    background: #f8fafc;
}

/* ================= CART MOBILE ================= */

#my-modal-tambah-pesanan .cart-item {
    background: #ffffff;
    border-radius: 12px;
    padding: 10px;
    margin-bottom: 8px;
    border: 1px solid #e5e7eb;
}

#my-modal-tambah-pesanan .cart-item-info strong {
    font-size: 0.85rem;
    color: #0f172a;
}

#my-modal-tambah-pesanan .cart-item-info {
    font-size: 0.75rem;
    color: #475569;
}

/* ================= BUTTON PRIMARY ================= */

#my-modal-tambah-pesanan .btn-primary {
    background: #2563eb;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    padding: 10px;
    transition: all 0.15s ease;
}

#my-modal-tambah-pesanan .btn-primary:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}

/* ================= TABS MOBILE ================= */

#my-modal-tambah-pesanan .nav-tabs {
    border-bottom: 1px solid #e5e7eb;
    background: #ffffff;
}

#my-modal-tambah-pesanan .nav-tabs .nav-link {
    border: none;
    color: #64748b;
    font-weight: 600;
    font-size: 0.85rem;
}

#my-modal-tambah-pesanan .nav-tabs .nav-link.active {
    color: #2563eb;
    border-bottom: 2px solid #2563eb;
}

/* ================= TABLET OPTIMIZATION ================= */

@media (min-width: 768px) and (max-width: 991.98px) {

    #my-modal-tambah-pesanan .menu-title {
        font-size: 0.75rem;
    }

    #my-modal-tambah-pesanan .menu-price {
        font-size: 0.75rem;
    }

    #my-modal-tambah-pesanan .table-order thead th {
        font-size: 0.55rem;
    }

    #my-modal-tambah-pesanan .table-order tbody td {
        font-size: 0.65rem;
    }
}
</style>
<style>
@media (min-width: 768px) and (max-width: 991.98px) {
    #my-modal-tambah-pesanan .menu-card-img {
        padding-top: 60%;
    }

    #my-modal-tambah-pesanan .menu-title,
    #my-modal-tambah-pesanan .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-category {
        font-size: 0.52rem;
        padding: 0.14rem 0.42rem;
    }

    #my-modal-tambah-pesanan .table-order thead th {
        font-size: 0.65rem;
        padding: 0.7rem 0.3rem;
    }

    #my-modal-tambah-pesanan .table-order tbody td {
        font-size: 0.75rem;
        padding: 0.7rem 0.3rem;
    }
}

@media (max-width: 767.98px) {
    #my-modal-tambah-pesanan .tambah-workspace {
        padding-top: 0.4rem;
    }

    #my-modal-tambah-pesanan .tambah-panel-heading,
    #my-modal-tambah-pesanan .tambah-order-header {
        flex-direction: column;
        align-items: flex-start !important;
    }

    #my-modal-tambah-pesanan .modal-header {
        padding: 1rem 1rem 0.95rem;
    }

    #my-modal-tambah-pesanan .modal-header h5 {
        font-size: 1rem;
    }

    #my-modal-tambah-pesanan .tambah-modal-subtitle {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-grid {
        max-height: none;
    }

    #my-modal-tambah-pesanan .mobile-menu-grid {
        max-height: calc(100vh - 235px);
    }

    #my-modal-tambah-pesanan .menu-card-img {
        padding-top: 58%;
    }

    #my-modal-tambah-pesanan .menu-title {
        font-size: 0.75rem;
        min-height: 1.85rem;
    }

    #my-modal-tambah-pesanan .menu-card-body {
        padding: 0.55rem 0.56rem 0.62rem;
    }

    #my-modal-tambah-pesanan .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-category {
        font-size: 0.52rem;
    }

    #my-modal-tambah-pesanan .mobile-menu-grid .menu-action-hint {
        display: none;
    }

    #my-modal-tambah-pesanan .tambah-filter-shell {
        padding: 12px;
    }

    #my-modal-tambah-pesanan .tambah-order-note {
        padding: 10px 14px;
    }
}
</style>
<style>
#my-modal-tambah-pesanan .menu-card-img img {
    transition: transform 0.3s;
}

#my-modal-tambah-pesanan .menu-card:hover .menu-card-img img {
    transform: scale(1.05);
}

#my-modal-tambah-pesanan .status-badge {
    font-size: 0.56rem;
    padding: 0.18rem 0.55rem;
    text-transform: uppercase;
}

#my-modal-tambah-pesanan .btn-simpan-tambahan {
    padding: 0.9rem 1.5rem;
    border-radius: 60px;
    font-weight: 600;
    background: linear-gradient(145deg, #2563eb, #1d4ed8);
    border: none;
    box-shadow: 0 10px 20px -8px #2563eb80;
    transition: all 0.2s;
    color: #ffffff;
    width: 100%;
    font-size: 1rem;
    letter-spacing: 0.3px;
}

#my-modal-tambah-pesanan .btn-simpan-tambahan:hover {
    background: linear-gradient(145deg, #1d4ed8, #1e3a8a);
    box-shadow: 0 15px 25px -8px #1d4ed8;
    transform: translateY(-2px);
    color: #ffffff;
}

#my-modal-tambah-pesanan .tambah-save-panel {
    padding: 16px 18px;
    border: 1px solid #dbeafe;
    border-radius: 22px;
    background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%);
}

#my-modal-tambah-pesanan .tambah-save-copy {
    margin-bottom: 12px;
}

#my-modal-tambah-pesanan .tambah-save-copy h6 {
    font-size: 0.98rem;
    font-weight: 700;
    color: #0f3d5e;
}

#my-modal-tambah-pesanan .tambah-save-copy small {
    color: #64748b;
}

@media (min-width: 768px) and (max-width: 991.98px) {
    #my-modal-tambah-pesanan .menu-card-img {
        padding-top: 60%;
    }

    #my-modal-tambah-pesanan .menu-title,
    #my-modal-tambah-pesanan .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-category {
        font-size: 0.52rem;
        padding: 0.14rem 0.42rem;
    }

    #my-modal-tambah-pesanan .table-order thead th {
        font-size: 0.65rem;
        padding: 0.7rem 0.3rem;
    }

    #my-modal-tambah-pesanan .table-order tbody td {
        font-size: 0.75rem;
        padding: 0.7rem 0.3rem;
    }
}

@media (max-width: 767.98px) {
    #my-modal-tambah-pesanan .tambah-workspace {
        padding-top: 0.4rem;
    }

    #my-modal-tambah-pesanan .tambah-panel-heading,
    #my-modal-tambah-pesanan .tambah-order-header {
        flex-direction: column;
        align-items: flex-start !important;
    }

    #my-modal-tambah-pesanan .modal-header {
        padding: 1rem 1rem 0.95rem;
    }

    #my-modal-tambah-pesanan .modal-header h5 {
        font-size: 1rem;
    }

    #my-modal-tambah-pesanan .tambah-modal-subtitle {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-grid {
        max-height: none;
    }

    #my-modal-tambah-pesanan .mobile-menu-grid {
        max-height: calc(100vh - 235px);
    }

    #my-modal-tambah-pesanan .menu-card-img {
        padding-top: 58%;
    }

    #my-modal-tambah-pesanan .menu-title {
        font-size: 0.75rem;
        min-height: 1.85rem;
    }

    #my-modal-tambah-pesanan .menu-card-body {
        padding: 0.55rem 0.56rem 0.62rem;
    }

    #my-modal-tambah-pesanan .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-category {
        font-size: 0.52rem;
    }

    #my-modal-tambah-pesanan .mobile-menu-grid .menu-action-hint {
        display: none;
    }

    #my-modal-tambah-pesanan .tambah-filter-shell {
        padding: 12px;
    }

    #my-modal-tambah-pesanan .tambah-order-note {
        padding: 10px 14px;
    }
}
</style>
<style>
#my-modal-tambah-pesanan .card {
    border: none;
    border-radius: 20px;
    background: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
}

#my-modal-tambah-pesanan .menu-grid {
    max-height: 62vh;
    overflow-y: auto;
    padding-right: 4px;
}

#my-modal-tambah-pesanan .mobile-menu-grid {
    max-height: calc(100vh - 260px);
    padding-right: 0;
}

#my-modal-tambah-pesanan .tambah-menu-grid-row>[class*="col-"] {
    display: flex;
}

#my-modal-tambah-pesanan .tambah-menu-grid-row .menu-card {
    width: 100%;
}

#my-modal-tambah-pesanan .tambah-menu-empty {
    padding: 1.4rem 1rem;
    border: 1px dashed #cbd5e1;
    border-radius: 18px;
    text-align: center;
    color: #64748b;
    background: #ffffff;
}

#my-modal-tambah-pesanan .tambah-menu-empty i {
    display: inline-flex;
    margin-bottom: 0.55rem;
    font-size: 2rem;
    color: #94a3b8;
}

#my-modal-tambah-pesanan .menu-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.02);
    border: 1px solid #edf2f7;
    transition: all 0.25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

#my-modal-tambah-pesanan .menu-card:hover {
    transform: translateY(-3px);
    border-color: #3b82f6;
    box-shadow: 0 16px 22px -10px rgba(59, 130, 246, 0.2);
}

#my-modal-tambah-pesanan .menu-card-img {
    position: relative;
    width: 100%;
    padding-top: 64%;
    background: #f8fafc;
    overflow: hidden;
}

#my-modal-tambah-pesanan .menu-card-body {
    padding: 0.62rem 0.65rem 0.72rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}

#my-modal-tambah-pesanan .menu-title {
    font-size: 0.82rem;
    font-weight: 600;
    line-height: 1.3;
    color: #102a43;
    min-height: 2.05rem;
    margin-bottom: 0.18rem;
}

#my-modal-tambah-pesanan .menu-meta-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}

#my-modal-tambah-pesanan .menu-price {
    font-size: 0.82rem;
    font-weight: 700;
    color: #2563eb;
}

#my-modal-tambah-pesanan .menu-category {
    padding: 0.16rem 0.45rem;
    border-radius: 40px;
    font-size: 0.56rem;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
    text-transform: uppercase;
}

#my-modal-tambah-pesanan .menu-action-hint {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    margin-top: auto;
    padding-top: 0.45rem;
    color: #0f766e;
    font-size: 0.68rem;
    font-weight: 700;
}

#my-modal-tambah-pesanan .order-panel {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
}

#my-modal-tambah-pesanan .order-panel .card-header {
    border-bottom: 1px solid #edf2f7;
    background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
    padding: 1rem 1.25rem;
}

#my-modal-tambah-pesanan .order-panel .card-header h5 {
    color: #0f3d5e;
}

#my-modal-tambah-pesanan .tambah-order-note {
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

#my-modal-tambah-pesanan .tambah-order-note i {
    color: #2563eb;
}

#my-modal-tambah-pesanan .table-order {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 6px;
    padding: 0 0.5rem;
}

#my-modal-tambah-pesanan .table-order thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.85rem 0.5rem;
    border: none;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 2;
}

#my-modal-tambah-pesanan .table-order tbody td {
    padding: 0.85rem 0.5rem;
    border-top: 1px solid #edf2f7;
    border-bottom: 1px solid #edf2f7;
    vertical-align: middle;
    font-size: 0.85rem;
    color: #334155;
    background: #ffffff;
}

#my-modal-tambah-pesanan .table-order tbody td:first-child {
    border-left: 1px solid #edf2f7;
    border-radius: 14px 0 0 14px;
}

#my-modal-tambah-pesanan .table-order tbody td:last-child {
    border-right: 1px solid #edf2f7;
    border-radius: 0 14px 14px 0;
}

#my-modal-tambah-pesanan #tb_pesanan_body_tambahan .qty-cell {
    font-weight: 700;
    color: #0f172a;
}

#my-modal-tambah-pesanan #tb_pesanan_body_tambahan .btn {
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

#my-modal-tambah-pesanan #tb_pesanan_body_tambahan .btn-dark {
    background: #0f172a;
}

#my-modal-tambah-pesanan #tb_pesanan_body_tambahan .btn-danger {
    background: #ef4444;
}
</style>
<style>
#my-modal-tambah-pesanan .modal-content {
    border: none;
    border-radius: 24px 24px 0 0;
    overflow: hidden;
    background: #f8fafc;
}

#my-modal-tambah-pesanan .tambah-workspace {
    background:
        radial-gradient(circle at top right, rgba(37, 99, 235, 0.06), transparent 22%),
        radial-gradient(circle at top left, rgba(14, 165, 233, 0.08), transparent 18%),
        #f8fafc;
}

#my-modal-tambah-pesanan .tambah-modal-topbar {
    background-color: #102a43 !important;
    background-image:
        radial-gradient(circle at top right, rgba(45, 212, 191, 0.18), transparent 26%),
        linear-gradient(145deg, #102a43 0%, #0f172a 60%, #0b3b59 100%) !important;
    border-bottom: none;
    padding: 1.25rem 1.75rem;
    box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.08);
    color: #ffffff;
}

#my-modal-tambah-pesanan .modal-header h5 {
    font-weight: 600;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.2rem;
}

#my-modal-tambah-pesanan .modal-header h5 i {
    font-size: 1.35rem;
}

#my-modal-tambah-pesanan .tambah-modal-header-copy {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
}

#my-modal-tambah-pesanan .tambah-modal-eyebrow {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.72);
}

#my-modal-tambah-pesanan .tambah-modal-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    min-height: 32px;
    padding: 0.25rem 0.8rem;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    background: rgba(15, 118, 110, 0.28);
    color: #ffffff;
    font-weight: 700;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
}

#my-modal-tambah-pesanan .tambah-modal-pill:empty::before {
    content: "--";
    opacity: 0.58;
}

#my-modal-tambah-pesanan .tambah-modal-subtitle {
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.82rem;
}

#my-modal-tambah-pesanan .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
    transition: opacity 0.2s;
    background-size: 0.8rem;
}

#my-modal-tambah-pesanan .tambah-mobile-menu-bar {
    position: sticky;
    top: -0.25rem;
    z-index: 6;
}

#my-modal-tambah-pesanan .tambah-mobile-menu-trigger {
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

#my-modal-tambah-pesanan .tambah-mobile-menu-trigger:hover,
#my-modal-tambah-pesanan .tambah-mobile-menu-trigger:focus {
    color: #ffffff;
}

#my-modal-tambah-pesanan .tambah-mobile-menu-count,
#my-modal-tambah-pesanan .tambah-panel-count,
#my-modal-tambah-pesanan .tambah-panel-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
}

#my-modal-tambah-pesanan .tambah-mobile-menu-count {
    min-height: 32px;
    padding: 0.2rem 0.7rem;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.16);
}

#my-modal-tambah-pesanan .tambah-mobile-menu-helper {
    display: block;
    margin-top: 0.55rem;
    padding: 0 0.25rem;
    color: #64748b;
    font-size: 0.76rem;
    line-height: 1.45;
}

#my-modal-tambah-pesanan .tambah-menu-offcanvas {
    width: min(88vw, 360px);
    border-right: none;
    background:
        radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 20%),
        #f8fafc;
    z-index: 1065;
}

#my-modal-tambah-pesanan .tambah-menu-offcanvas .offcanvas-header {
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

#my-modal-tambah-pesanan .tambah-menu-offcanvas .offcanvas-header h5,
#my-modal-tambah-pesanan .tambah-menu-offcanvas .tambah-panel-count {
    color: #ffffff;
}

#my-modal-tambah-pesanan .tambah-menu-offcanvas .offcanvas-header small {
    color: rgba(255, 255, 255, 0.76);
}

#my-modal-tambah-pesanan .tambah-offcanvas-copy,
#my-modal-tambah-pesanan .tambah-modal-header-copy {
    display: flex;
    flex-direction: column;
}

#my-modal-tambah-pesanan .tambah-offcanvas-actions,
#my-modal-tambah-pesanan .tambah-panel-heading {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
}

#my-modal-tambah-pesanan .tambah-menu-offcanvas .offcanvas-body {
    padding: 1rem;
}

#my-modal-tambah-pesanan .tambah-panel-heading {
    margin-bottom: 1rem;
}

#my-modal-tambah-pesanan .tambah-panel-heading h6 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f3d5e;
}

#my-modal-tambah-pesanan .tambah-panel-heading small,
#my-modal-tambah-pesanan .tambah-panel-subtitle {
    color: #64748b;
}

#my-modal-tambah-pesanan .tambah-panel-count {
    padding: 0.35rem 0.8rem;
    background: #dbeafe;
    color: #1d4ed8;
}

#my-modal-tambah-pesanan .tambah-panel-tag {
    padding: 0.35rem 0.8rem;
    background: #f1f5f9;
    color: #475569;
}

#my-modal-tambah-pesanan .tambah-filter-shell {
    padding: 14px;
    margin-bottom: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

#my-modal-tambah-pesanan .tambah-filter-hints {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

#my-modal-tambah-pesanan .tambah-filter-chip {
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

#my-modal-tambah-pesanan .form-control,
#my-modal-tambah-pesanan .form-select {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 0.6rem 1rem;
    font-size: 0.95rem;
}

#my-modal-tambah-pesanan .form-control:focus,
#my-modal-tambah-pesanan .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

#my-modal-tambah-pesanan .input-group-text {
    border: 1px solid #e2e8f0;
    border-radius: 12px 0 0 12px;
    background: #ffffff;
    color: #64748b;
}

#my-modal-tambah-pesanan .input-group .form-control {
    border-radius: 0 12px 12px 0;
}
</style>
<style>
@media (min-width: 768px) and (max-width: 991.98px) {
    #my-modal-tambah-pesanan .menu-card-img {
        padding-top: 60%;
    }

    #my-modal-tambah-pesanan .menu-title,
    #my-modal-tambah-pesanan .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-category {
        font-size: 0.52rem;
        padding: 0.14rem 0.42rem;
    }

    #my-modal-tambah-pesanan .table-order thead th {
        font-size: 0.65rem;
        padding: 0.7rem 0.3rem;
    }

    #my-modal-tambah-pesanan .table-order tbody td {
        font-size: 0.75rem;
        padding: 0.7rem 0.3rem;
    }
}

@media (max-width: 767.98px) {
    #my-modal-tambah-pesanan .tambah-workspace {
        padding-top: 0.4rem;
    }

    #my-modal-tambah-pesanan .tambah-panel-heading,
    #my-modal-tambah-pesanan .tambah-order-header {
        flex-direction: column;
        align-items: flex-start !important;
    }

    #my-modal-tambah-pesanan .modal-header {
        padding: 1rem 1rem 0.95rem;
    }

    #my-modal-tambah-pesanan .modal-header h5 {
        font-size: 1rem;
    }

    #my-modal-tambah-pesanan .tambah-modal-subtitle {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-grid {
        max-height: none;
    }

    #my-modal-tambah-pesanan .mobile-menu-grid {
        max-height: calc(100vh - 235px);
    }

    #my-modal-tambah-pesanan .menu-card-img {
        padding-top: 58%;
    }

    #my-modal-tambah-pesanan .menu-title {
        font-size: 0.75rem;
        min-height: 1.85rem;
    }

    #my-modal-tambah-pesanan .menu-card-body {
        padding: 0.55rem 0.56rem 0.62rem;
    }

    #my-modal-tambah-pesanan .menu-price {
        font-size: 0.76rem;
    }

    #my-modal-tambah-pesanan .menu-category {
        font-size: 0.52rem;
    }

    #my-modal-tambah-pesanan .mobile-menu-grid .menu-action-hint {
        display: none;
    }

    #my-modal-tambah-pesanan .tambah-filter-shell {
        padding: 12px;
    }

    #my-modal-tambah-pesanan .tambah-order-note {
        padding: 10px 14px;
    }
}
</style>
