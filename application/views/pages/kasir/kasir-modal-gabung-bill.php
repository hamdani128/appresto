<!-- Modal Gabung Bill -->
<div id="my-modal-gabung-bill" class="modal fade modal-right" tabindex="-1" role="dialog"
    aria-labelledby="my-modal-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="gabung-modal-heading">
                    <span class="gabung-modal-eyebrow">Kasir Merge Bill</span>
                    <h5 class="modal-title text-white">
                        <i class="bx bx-git-merge me-1"></i> Bill Gabung
                    </h5>
                    <p class="gabung-modal-subtitle mb-0">
                        Gabungkan pesanan dari beberapa meja, review total tagihan, lalu lanjutkan ke pembayaran
                        dalam satu transaksi.
                    </p>
                </div>
                <div class="gabung-modal-meta d-none d-md-flex">
                    <span class="gabung-modal-chip">
                        <i class="bx bx-layer"></i>
                        {{LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length}} Item
                    </span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="d-block d-md-none mb-3">
                    <button class="btn gabung-mobile-toggle w-100" type="button" data-bs-toggle="collapse"
                        data-bs-target="#billCollapse">
                        <i class="bx bx-receipt"></i>
                        <span>Lihat Preview Bill</span>
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-7 col-lg-8">
                        <div class="card gabung-panel-card">
                            <div class="card-body p-0">
                                <div class="gabung-panel-header">
                                    <div class="gabung-panel-title-group">
                                        <span class="gabung-panel-icon gabung-panel-icon-blue">
                                            <i class="bx bx-list-ul"></i>
                                        </span>
                                        <div>
                                            <h6 class="mb-1">Penggabungan Pesanan</h6>
                                            <p class="mb-0">
                                                Pilih meja yang akan digabung, cek seluruh item, dan pastikan
                                                ringkasan bill sudah sesuai.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="gabung-kpi-strip">
                                        <span class="gabung-kpi-chip">
                                            <i class="bx bx-table"></i>
                                            Mode Gabung
                                        </span>
                                        <span class="gabung-kpi-chip">
                                            <i class="bx bx-check-shield"></i>
                                            Siap Bayar
                                        </span>
                                    </div>
                                </div>

                                <div class="p-3 p-lg-4">
                                    <div class="row g-3 align-items-stretch mb-3">
                                        <div class="col-12 col-lg-8">
                                            <div class="gabung-field-card h-100">
                                                <label class="form-label">No. Meja Digabung</label>
                                                <select class="form-select" ng-model="cmb_gabung"
                                                    ng-options="meja.no_meja as (meja.no_meja + ' (' + meja.nama_meja + ')') for meja in listMejaGabung"
                                                    ng-change="GabungListMeja()">
                                                    <option value="">Pilih Meja</option>
                                                </select>
                                                <small class="gabung-field-helper">
                                                    Meja yang dipilih akan ditambahkan ke daftar item bill gabungan.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="gabung-stat-card h-100">
                                                <span class="gabung-stat-label">Baris Pesanan Aktif</span>
                                                <strong class="gabung-stat-value">
                                                    {{LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length}}
                                                </strong>
                                                <small>Jumlah item yang sedang dirangkum di bill gabungan.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gabung-table-card">
                                        <div class="gabung-subsection-heading">
                                            <div>
                                                <h6 class="mb-1">Daftar Item Gabungan</h6>
                                                <p class="mb-0">
                                                    Tabel ini menampilkan seluruh item dari bill utama dan meja yang
                                                    baru digabung.
                                                </p>
                                            </div>
                                            <span class="gabung-soft-badge">
                                                <i class="bx bx-spreadsheet"></i>
                                                Detail Order
                                            </span>
                                        </div>

                                        <div class="table-responsive gabung-table-wrap">
                                            <table class="table table-sm mb-0 gabung-item-table" style="width:100%"
                                                id="tb_pesanan_list_detail">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="d-none d-sm-table-cell">No.Order</th>
                                                        <th>Meja</th>
                                                        <th class="d-none d-sm-table-cell">Kategori</th>
                                                        <th>Item</th>
                                                        <th class="d-none d-sm-table-cell">Harga</th>
                                                        <th>Qty</th>
                                                        <th class="d-none d-sm-table-cell">Subtotal</th>
                                                        <th class="d-none d-sm-table-cell">Potongan</th>
                                                        <th class="d-none d-sm-table-cell">Disc%</th>
                                                        <th class="d-none d-sm-table-cell">Jenis</th>
                                                        <th class="d-none d-sm-table-cell">Owner</th>
                                                        <th class="d-none d-sm-table-cell">Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="td_pesanan_body_gabung_bill">
                                                    <tr ng-repeat="dt in (LoadDataPesananDetail.concat(LoadDataPesananGabungSementara))"
                                                        ng-if="(LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length) > 0">
                                                        <td>{{$index + 1}}</td>
                                                        <td class="d-none d-sm-table-cell">{{dt.no_order}}</td>
                                                        <td>{{dt.no_meja}}</td>
                                                        <td class="d-none d-sm-table-cell">{{dt.kategori}}</td>
                                                        <td>{{dt.nama}}</td>
                                                        <td class="d-none d-sm-table-cell">
                                                            {{dt.harga | currency:"Rp ":0}}
                                                        </td>
                                                        <td>{{dt.qty | number:0}}</td>
                                                        <td class="d-none d-sm-table-cell">
                                                            {{(dt.qty * dt.harga) - (dt.potongan) | currency:"Rp ":0}}
                                                        </td>
                                                        <td class="d-none d-sm-table-cell">
                                                            {{dt.potongan | currency:"Rp ":0}}
                                                        </td>
                                                        <td class="d-none d-sm-table-cell">
                                                            {{dt.discount | number:0}}%
                                                        </td>
                                                        <td class="d-none d-sm-table-cell">{{dt.jenis}}</td>
                                                        <td class="d-none d-sm-table-cell">{{dt.owner}}</td>
                                                        <td class="d-none d-sm-table-cell">
                                                            {{dt.created_at | date:'short'}}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        ng-if="LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length === 0">
                                                        <td colspan="13" class="text-center">
                                                            <div class="gabung-empty-state">
                                                                <i class="bx bx-receipt"></i>
                                                                <span>Belum ada item yang digabung.</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card gabung-summary-card mt-3">
                                        <div class="card-body p-3 p-lg-4">
                                            <div class="gabung-subsection-heading">
                                                <div>
                                                    <h6 class="mb-1">Ringkasan Tagihan</h6>
                                                    <p class="mb-0">
                                                        Atur diskon dan PPN, lalu cek nilai akhir bill sebelum dicetak
                                                        atau dibayar.
                                                    </p>
                                                </div>
                                                <span class="gabung-soft-badge gabung-soft-badge-success">
                                                    <i class="bx bx-calculator"></i>
                                                    Kalkulasi
                                                </span>
                                            </div>

                                            <div class="gabung-summary-grid">
                                                <div class="gabung-summary-block">
                                                    <label class="form-label">Total Qty</label>
                                                    <input type="text" class="form-control text-end"
                                                        id="qty-total-gabung" value="0" readonly>
                                                </div>
                                                <div class="gabung-summary-block">
                                                    <label class="form-label">Subtotal</label>
                                                    <input type="text" class="form-control text-end"
                                                        id="amount-total-gabung" value="0" readonly>
                                                </div>
                                                <div class="gabung-summary-block">
                                                    <label class="form-label">Disc. (%)</label>
                                                    <input type="text" class="form-control text-end"
                                                        id="discount-nominal-gabung" placeholder="%"
                                                        ng-keyup="CalculateTotalForGabung()" value="0">
                                                </div>
                                                <div class="gabung-summary-block">
                                                    <label class="form-label">Disc. Rp</label>
                                                    <input type="text" class="form-control text-end"
                                                        id="discount-value-gabung" value="0" readonly>
                                                </div>
                                                <div class="gabung-summary-block">
                                                    <label class="form-label">PPN</label>
                                                    <select id="ppn-select-gabung" class="form-select"
                                                        ng-change="CalculateTotalForGabung()" ng-model="ppnValue">
                                                        <option value="">Pilih</option>
                                                        <option value="10">10%</option>
                                                        <option value="11">11%</option>
                                                    </select>
                                                </div>
                                                <div class="gabung-summary-block">
                                                    <label class="form-label">PPN Rp</label>
                                                    <input type="text" class="form-control text-end"
                                                        id="amount-ppn-gabung" value="0" readonly>
                                                </div>
                                            </div>

                                            <div class="gabung-grand-total-card">
                                                <span>Grand Total</span>
                                                <input type="text" class="form-control text-end fw-bold"
                                                    id="grand-total-gabung" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gabung-action-grid mt-3">
                                        <button type="button" class="btn gabung-action-btn gabung-action-btn-warning"
                                            ng-click="ResetGabungPesanan()">
                                            <i class="bx bx-refresh"></i>
                                            <span>Clear</span>
                                        </button>
                                        <button type="button" class="btn gabung-action-btn gabung-action-btn-print"
                                            onclick="printEppposBillGabung()">
                                            <i class="bx bx-printer"></i>
                                            <span>Cetak Bill</span>
                                        </button>
                                        <button type="button" class="btn gabung-action-btn gabung-action-btn-dark"
                                            onclick="printEppposBillGabungUSB()">
                                            <i class="bx bx-printer"></i>
                                            <span>Cetak USB</span>
                                        </button>
                                        <button type="button" class="btn gabung-action-btn gabung-action-btn-pay"
                                            ng-click="pay_payment_bill_gabung()">
                                            <i class="bx bx-wallet"></i>
                                            <span>Payment</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card gabung-payment-card mt-3" id="card-payment-BillGabungan"
                            style="display: none;">
                            <div class="card-header">
                                <div class="gabung-panel-title-group">
                                    <span class="gabung-panel-icon gabung-panel-icon-green">
                                        <i class="bx bx-lock-alt"></i>
                                    </span>
                                    <div>
                                        <h6 class="mb-1">Lock to Transaction</h6>
                                        <p class="mb-0">
                                            Finalisasi nominal transaksi dan lengkapi metode pembayaran sebelum submit.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 p-lg-4">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0 gabung-payment-table"
                                        id="tb_payment_BillGabungan_service">
                                        <tbody class="border-0">
                                            <tr>
                                                <td>Total Qty</td>
                                                <td class="text-end fw-bold"
                                                    id="total-qty-payment-BillGabungan-service">0</td>
                                            </tr>
                                            <tr>
                                                <td>Subtotal</td>
                                                <td class="text-end fw-bold" id="subtotal-payment-BillGabungan-service">
                                                    0</td>
                                            </tr>
                                            <tr>
                                                <td>Discount (<span id="bill_discount_persen_gabungan"></span>%)</td>
                                                <td class="text-end fw-bold" id="bill_discount_value_gabungan">0</td>
                                            </tr>
                                            <tr>
                                                <td>PPN (<span id="ppn-text-payment-BillGabungan-service"></span>%)</td>
                                                <td class="text-end fw-bold" id="ppn-payment-BillGabungan-service">0
                                                </td>
                                            </tr>
                                            <tr class="gabung-payment-grand">
                                                <td>GRAND TOTAL</td>
                                                <td class="text-end fw-bold text-primary"
                                                    id="grand-total-payment-BillGabungan-service">0</td>
                                            </tr>
                                            <tr>
                                                <td>Metode Payment</td>
                                                <td>
                                                    <select id="combo-payment-BillGabungan-service" class="form-select"
                                                        onchange="changePaymentBillGabunganService()">
                                                        <option value="">Pilih</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="QRIS">QRIS</option>
                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="display_jumlah_dibayar_payment_BillGabungan_service"
                                                style="display: none;">
                                                <td>Jumlah Dibayar</td>
                                                <td>
                                                    <input type="text" class="form-control text-end"
                                                        id="jumlah-dibayar-payment-BillGabungan-service">
                                                </td>
                                            </tr>
                                            <tr id="display_kembalian_payment_BillGabungan_service"
                                                style="display: none;">
                                                <td>Kembalian</td>
                                                <td class="text-end fw-bold"
                                                    id="kembalian-payment-BillGabungan-service">0</td>
                                            </tr>
                                            <tr id="display_reference_payment_BillGabungan_service"
                                                style="display: none;">
                                                <td>Reference Payment</td>
                                                <td>
                                                    <select id="combo-reference-payment-BillGabungan-service"
                                                        class="form-select"
                                                        onchange="changeReferencePaymentBillGabunganService()"></select>
                                                </td>
                                            </tr>
                                            <tr id="display_reference_number_payment_BillGabungan_service"
                                                style="display: none;">
                                                <td>Reference Number</td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        id="reference-number-payment-BillGabungan-service">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-grid mt-3">
                                    <button type="button" class="btn gabung-submit-btn"
                                        ng-click="PaymentBillGabunganSubmit()">
                                        <i class="bx bx-paper-plane"></i>
                                        <span>Submit Payment</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-lg-4 d-none d-md-block">
                        <div class="card gabung-preview-card sticky-top">
                            <div class="card-header">
                                <div class="gabung-panel-title-group">
                                    <span class="gabung-panel-icon gabung-panel-icon-amber">
                                        <i class="bx bx-receipt"></i>
                                    </span>
                                    <div>
                                        <h6 class="mb-1">Preview Bill</h6>
                                        <p class="mb-0">
                                            Tampilan bill gabungan yang siap dicetak untuk pelanggan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 pt-0">
                                <div class="gabung-receipt-shell" id="printArea2">
                                    <div class="text-center small">
                                        <h5 class="mb-1">RUMAH KOPI DINDA</h5>
                                        <div>Jl. RS Haji NO. 45 A<br>MEDAN - SUMATERA UTARA<br>Telp: 085260207471</div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="small">
                                        <table style="width:100%">
                                            <tr>
                                                <td>Tanggal</td>
                                                <td>:</td>
                                                <td><span id="bill_date_gabungan"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Kasir</td>
                                                <td>:</td>
                                                <td><span id="bill_chasier_gabungan"></span></td>
                                            </tr>
                                            <tr>
                                                <td>No. Order</td>
                                                <td>:</td>
                                                <td><span id="bill_no_order_gabungan"></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr class="my-2">
                                    <div class="small">
                                        <table style="width:100%; font-size: 12px;">
                                            <tbody ng-repeat="group in groupedOrders">
                                                <tr>
                                                    <td colspan="3" class="fw-bold pt-2">Table: {{ group.no_meja }}</td>
                                                </tr>
                                                <tr ng-repeat="item in group.items">
                                                    <td style="width:10%; text-align:center;">[{{ item.qty }}]</td>
                                                    <td style="width:60%;">{{ item.nama }} <span
                                                            ng-if="item.potongan !== null">({{item.discount}}%)</span>
                                                    </td>
                                                    <td style="width:30%; text-align:right;">
                                                        {{ (item.qty * item.harga) - item.potongan | currency:'Rp ':0 }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr class="my-2">
                                    <div class="small">
                                        <table style="width:100%;">
                                            <tr>
                                                <td>Qty</td>
                                                <td style="width:10px;">:</td>
                                                <td style="text-align:center;" id="bill_qty_gabungan">0</td>
                                            </tr>
                                            <tr>
                                                <td>Subtotal</td>
                                                <td>:</td>
                                                <td style="text-align:right;" id="bill_subtotal_gabungan">0</td>
                                            </tr>
                                            <tr>
                                                <td>Disc(<span id="bill_discount_text_gabungan"></span>%)</td>
                                                <td>:</td>
                                                <td style="text-align:right;" id="bill_potongan_value_gabungan">0</td>
                                            </tr>
                                            <tr>
                                                <td>PPN (10%)</td>
                                                <td>:</td>
                                                <td style="text-align:right;" id="bill_ppn_gabungan">0</td>
                                            </tr>
                                            <tr>
                                                <td>Grand Total</td>
                                                <td>:</td>
                                                <td style="text-align:right;" id="bill_grand_total_gabungan">0</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr class="my-2">
                                    <div class="text-center small">-- BILL TRANSAKSI --<br>-- TERIMA KASIH --</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-md-none">
                        <div class="collapse" id="billCollapse">
                            <div class="card gabung-preview-card gabung-preview-card-mobile">
                                <div class="card-header">
                                    <div class="gabung-panel-title-group">
                                        <span class="gabung-panel-icon gabung-panel-icon-amber">
                                            <i class="bx bx-receipt"></i>
                                        </span>
                                        <div>
                                            <h6 class="mb-1">Preview Bill</h6>
                                            <p class="mb-0">
                                                Ringkasan bill gabungan untuk mode mobile.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3 pt-0">
                                    <div class="gabung-receipt-shell" id="printArea2Mobile">
                                        <div class="text-center small">
                                            <h5 class="mb-1">RUMAH KOPI DINDA</h5>
                                            <div>Jl. RS Haji NO. 45 A<br>MEDAN - SUMATERA UTARA<br>Telp: 085260207471
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="small">
                                            <table style="width:100%">
                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td>:</td>
                                                    <td><span id="bill_date_gabungan_mobile"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Kasir</td>
                                                    <td>:</td>
                                                    <td><span id="bill_chasier_gabungan_mobile"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>No. Order</td>
                                                    <td>:</td>
                                                    <td><span id="bill_no_order_gabungan_mobile"></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <hr class="my-2">
                                        <div class="small">
                                            <table style="width:100%; font-size: 11px;">
                                                <tbody ng-repeat="group in groupedOrders">
                                                    <tr>
                                                        <td colspan="3" class="fw-bold pt-2">Table: {{ group.no_meja }}
                                                        </td>
                                                    </tr>
                                                    <tr ng-repeat="item in group.items">
                                                        <td style="width:10%; text-align:center;">[{{ item.qty }}]</td>
                                                        <td style="width:60%;">{{ item.nama }} <span
                                                                ng-if="item.potongan !== null">({{item.discount}}%)</span>
                                                        </td>
                                                        <td style="width:30%; text-align:right;">
                                                            {{ (item.qty * item.harga) - item.potongan | currency:'Rp ':0 }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr class="my-2">
                                        <div class="small">
                                            <table style="width:100%;">
                                                <tr>
                                                    <td>Qty</td>
                                                    <td style="width:10px;">:</td>
                                                    <td style="text-align:center;" id="bill_qty_gabungan_mobile">0</td>
                                                </tr>
                                                <tr>
                                                    <td>Subtotal</td>
                                                    <td>:</td>
                                                    <td style="text-align:right;" id="bill_subtotal_gabungan_mobile">0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Disc(<span id="bill_discount_text_gabungan_mobile"></span>%)</td>
                                                    <td>:</td>
                                                    <td style="text-align:right;"
                                                        id="bill_potongan_value_gabungan_mobile">0</td>
                                                </tr>
                                                <tr>
                                                    <td>PPN (10%)</td>
                                                    <td>:</td>
                                                    <td style="text-align:right;" id="bill_ppn_gabungan_mobile">0</td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total</td>
                                                    <td>:</td>
                                                    <td style="text-align:right;" id="bill_grand_total_gabungan_mobile">
                                                        0
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <hr class="my-2">
                                        <div class="text-center small">-- BILL TRANSAKSI --<br>-- TERIMA KASIH --</div>
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
<!-- End Modal Gabung Bill -->


<style>
#my-modal-gabung-bill {
    --gabung-bg: #f4f7fb;
    --gabung-surface: #ffffff;
    --gabung-surface-soft: #f8fbff;
    --gabung-border: #dbe3ee;
    --gabung-border-soft: #e8eef5;
    --gabung-text: #0f172a;
    --gabung-muted: #64748b;
    --gabung-blue: #2563eb;
    --gabung-blue-soft: #dbeafe;
    --gabung-green: #15803d;
    --gabung-green-soft: #dcfce7;
    --gabung-amber: #d97706;
    --gabung-amber-soft: #fef3c7;
    --gabung-red: #b91c1c;
    --gabung-red-soft: #fee2e2;
    --gabung-slate: #0f172a;
}

#my-modal-gabung-bill .modal-content {
    border: none;
    border-radius: 24px 24px 0 0;
    overflow: hidden;
    background:
        radial-gradient(circle at top right, rgba(14, 165, 233, 0.08), transparent 28%),
        radial-gradient(circle at top left, rgba(13, 148, 136, 0.1), transparent 24%),
        var(--gabung-bg);
}

#my-modal-gabung-bill .modal-header {
    position: relative;
    align-items: flex-start;
    gap: 1rem;
    border: 0;
    padding: 1.15rem 1.35rem;
    background: linear-gradient(135deg, #0f172a 0%, #1f3b57 55%, #0f766e 100%);
}

#my-modal-gabung-bill .modal-title {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    margin-bottom: 0.35rem;
    font-size: 1.25rem;
    font-weight: 800;
    letter-spacing: 0.01em;
}

#my-modal-gabung-bill .modal-body {
    padding: 1rem;
}

#my-modal-gabung-bill .gabung-modal-heading {
    max-width: 820px;
}

#my-modal-gabung-bill .gabung-modal-eyebrow {
    display: inline-block;
    margin-bottom: 0.45rem;
    color: rgba(255, 255, 255, 0.74);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

#my-modal-gabung-bill .gabung-modal-subtitle {
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.88rem;
    line-height: 1.55;
}

#my-modal-gabung-bill .gabung-modal-meta {
    margin-left: auto;
    padding-top: 0.15rem;
}

#my-modal-gabung-bill .gabung-modal-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.14);
    color: #fff;
    font-size: 0.82rem;
    font-weight: 700;
    white-space: nowrap;
}

#my-modal-gabung-bill .btn-close-white {
    margin-left: 0;
    filter: brightness(0) invert(1);
    opacity: 0.86;
    transition: opacity 0.2s ease;
}

#my-modal-gabung-bill .btn-close-white:hover {
    opacity: 1;
}

#my-modal-gabung-bill .gabung-mobile-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    border: 0;
    border-radius: 18px;
    padding: 0.95rem 1.1rem;
    background: linear-gradient(135deg, #0f172a 0%, #1f3b57 100%);
    color: #fff;
    font-weight: 700;
    box-shadow: 0 18px 30px -20px rgba(15, 23, 42, 0.9);
}

#my-modal-gabung-bill .card {
    border: 1px solid var(--gabung-border);
    border-radius: 22px;
    overflow: hidden;
    background: var(--gabung-surface);
    box-shadow: 0 16px 38px -30px rgba(15, 23, 42, 0.6);
}

#my-modal-gabung-bill .gabung-panel-card,
#my-modal-gabung-bill .gabung-payment-card,
#my-modal-gabung-bill .gabung-preview-card,
#my-modal-gabung-bill .gabung-summary-card {
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
}

#my-modal-gabung-bill .gabung-panel-header,
#my-modal-gabung-bill .gabung-preview-card .card-header,
#my-modal-gabung-bill .gabung-payment-card .card-header {
    padding: 1rem 1.2rem;
    border-bottom: 1px solid var(--gabung-border);
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
}

#my-modal-gabung-bill .gabung-panel-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

#my-modal-gabung-bill .gabung-panel-title-group {
    display: flex;
    align-items: flex-start;
    gap: 0.9rem;
}

#my-modal-gabung-bill .gabung-panel-title-group h6 {
    color: var(--gabung-text);
    font-weight: 800;
}

#my-modal-gabung-bill .gabung-panel-title-group p,
#my-modal-gabung-bill .gabung-subsection-heading p,
#my-modal-gabung-bill .gabung-payment-card .card-header p {
    color: var(--gabung-muted);
    font-size: 0.84rem;
    line-height: 1.55;
}

#my-modal-gabung-bill .gabung-panel-icon {
    width: 46px;
    height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    font-size: 1.2rem;
}

#my-modal-gabung-bill .gabung-panel-icon-blue {
    background: var(--gabung-blue-soft);
    color: var(--gabung-blue);
}

#my-modal-gabung-bill .gabung-panel-icon-green {
    background: var(--gabung-green-soft);
    color: var(--gabung-green);
}

#my-modal-gabung-bill .gabung-panel-icon-amber {
    background: var(--gabung-amber-soft);
    color: var(--gabung-amber);
}

#my-modal-gabung-bill .gabung-kpi-strip {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 0.65rem;
}

#my-modal-gabung-bill .gabung-kpi-chip,
#my-modal-gabung-bill .gabung-soft-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.42rem 0.82rem;
    border-radius: 999px;
    font-size: 0.76rem;
    font-weight: 700;
}

#my-modal-gabung-bill .gabung-kpi-chip {
    background: var(--gabung-blue-soft);
    color: var(--gabung-blue);
}

#my-modal-gabung-bill .gabung-field-card,
#my-modal-gabung-bill .gabung-stat-card,
#my-modal-gabung-bill .gabung-table-card {
    border: 1px solid var(--gabung-border);
    border-radius: 18px;
    background: var(--gabung-surface);
}

#my-modal-gabung-bill .gabung-field-card,
#my-modal-gabung-bill .gabung-stat-card {
    padding: 1rem;
}

#my-modal-gabung-bill .gabung-stat-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: linear-gradient(135deg, #0f172a 0%, #1f3b57 70%, #0f766e 100%);
    color: #fff;
}

#my-modal-gabung-bill .gabung-stat-label {
    margin-bottom: 0.35rem;
    font-size: 0.78rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.72);
    font-weight: 700;
}

#my-modal-gabung-bill .gabung-stat-value {
    font-size: 2rem;
    line-height: 1;
    font-weight: 800;
}

#my-modal-gabung-bill .gabung-stat-card small {
    margin-top: 0.6rem;
    color: rgba(255, 255, 255, 0.76);
    line-height: 1.5;
}

#my-modal-gabung-bill .gabung-subsection-heading {
    padding: 1rem 1rem 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

#my-modal-gabung-bill .gabung-subsection-heading h6 {
    color: var(--gabung-text);
    font-weight: 800;
}

#my-modal-gabung-bill .gabung-soft-badge {
    background: #eef2ff;
    color: #4338ca;
    white-space: nowrap;
}

#my-modal-gabung-bill .gabung-soft-badge-success {
    background: var(--gabung-green-soft);
    color: var(--gabung-green);
}

#my-modal-gabung-bill .form-label {
    margin-bottom: 0.45rem;
    color: var(--gabung-muted);
    font-size: 0.82rem;
    font-weight: 700;
}

#my-modal-gabung-bill .form-control,
#my-modal-gabung-bill .form-select {
    min-height: 46px;
    border-color: var(--gabung-border);
    border-radius: 12px;
    box-shadow: none;
    color: var(--gabung-text);
}

#my-modal-gabung-bill .form-control:focus,
#my-modal-gabung-bill .form-select:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
}

#my-modal-gabung-bill .gabung-field-helper {
    display: block;
    margin-top: 0.5rem;
    color: var(--gabung-muted);
    font-size: 0.78rem;
    line-height: 1.45;
}

#my-modal-gabung-bill .gabung-table-wrap {
    max-height: 520px;
    padding: 0 1rem 1rem;
    scrollbar-width: thin;
    scrollbar-color: #c1c1c1 #f1f1f1;
}

#my-modal-gabung-bill .gabung-table-wrap::-webkit-scrollbar {
    height: 6px;
    width: 6px;
}

#my-modal-gabung-bill .gabung-table-wrap::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 999px;
}

#my-modal-gabung-bill .gabung-table-wrap::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 999px;
}

#my-modal-gabung-bill .gabung-item-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    font-size: 0.85rem;
}

#my-modal-gabung-bill .gabung-item-table thead th {
    position: sticky;
    top: 0;
    z-index: 2;
    padding: 0.85rem 0.65rem;
    border: 0;
    background: #f8fbff;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

#my-modal-gabung-bill .gabung-item-table tbody td {
    padding: 0.95rem 0.65rem;
    vertical-align: middle;
    border-top: 1px solid var(--gabung-border-soft);
    color: var(--gabung-text);
    background: transparent;
}

#my-modal-gabung-bill .gabung-item-table tbody tr:hover td {
    background: #f8fbff;
}

#my-modal-gabung-bill .gabung-empty-state {
    padding: 2rem 1rem;
    color: var(--gabung-muted);
    text-align: center;
}

#my-modal-gabung-bill .gabung-empty-state i {
    display: inline-flex;
    margin-bottom: 0.55rem;
    font-size: 2rem;
    color: #cbd5e1;
}

#my-modal-gabung-bill .gabung-empty-state span {
    display: block;
    font-weight: 600;
}

#my-modal-gabung-bill .gabung-summary-card {
    border-color: var(--gabung-border);
}

#my-modal-gabung-bill .gabung-summary-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
}

#my-modal-gabung-bill .gabung-summary-block {
    padding: 1rem;
    border: 1px solid var(--gabung-border);
    border-radius: 16px;
    background: var(--gabung-surface);
}

#my-modal-gabung-bill .gabung-grand-total-card {
    margin-top: 1rem;
    padding: 1rem;
    border-radius: 18px;
    background: linear-gradient(135deg, #dcfce7 0%, #dbeafe 100%);
}

#my-modal-gabung-bill .gabung-grand-total-card span {
    display: block;
    margin-bottom: 0.55rem;
    color: var(--gabung-text);
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

#my-modal-gabung-bill #grand-total-gabung {
    background: rgba(255, 255, 255, 0.78);
    border-width: 2px;
    color: var(--gabung-green);
}

#my-modal-gabung-bill .gabung-action-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.75rem;
}

#my-modal-gabung-bill .gabung-action-btn,
#my-modal-gabung-bill .gabung-submit-btn {
    min-height: 90px;
    border: 0;
    border-radius: 20px;
    padding: 1rem;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    color: #fff;
    font-weight: 800;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

#my-modal-gabung-bill .gabung-action-btn i,
#my-modal-gabung-bill .gabung-submit-btn i {
    font-size: 1.35rem;
}

#my-modal-gabung-bill .gabung-action-btn:hover,
#my-modal-gabung-bill .gabung-submit-btn:hover {
    transform: translateY(-2px);
}

#my-modal-gabung-bill .gabung-action-btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

#my-modal-gabung-bill .gabung-action-btn-print {
    background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
}

#my-modal-gabung-bill .gabung-action-btn-dark {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

#my-modal-gabung-bill .gabung-action-btn-pay,
#my-modal-gabung-bill .gabung-submit-btn {
    background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
}

#my-modal-gabung-bill .gabung-payment-card .card-header {
    background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
}

#my-modal-gabung-bill .gabung-payment-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

#my-modal-gabung-bill .gabung-payment-table tbody td {
    padding: 0.95rem 0;
    border-top: 1px solid var(--gabung-border-soft);
    vertical-align: middle;
    color: var(--gabung-text);
    background: transparent;
}

#my-modal-gabung-bill .gabung-payment-table tbody tr:first-child td {
    border-top: 0;
}

#my-modal-gabung-bill .gabung-payment-table tbody td:first-child {
    color: var(--gabung-muted);
    font-weight: 700;
    padding-right: 1rem;
}

#my-modal-gabung-bill .gabung-payment-grand td {
    color: var(--gabung-text) !important;
    font-size: 1rem;
    font-weight: 800;
}

#my-modal-gabung-bill .gabung-submit-btn {
    min-height: 54px;
    flex-direction: row;
}

#my-modal-gabung-bill .sticky-top {
    top: 1rem;
    z-index: 1010;
}

#my-modal-gabung-bill .gabung-preview-card .card-header {
    background: linear-gradient(180deg, #ffffff 0%, #fffaf0 100%);
}

#my-modal-gabung-bill .gabung-receipt-shell {
    margin-top: 1rem;
    border: 1px dashed #cbd5e1;
    border-radius: 18px;
    background: #fff;
    padding: 1rem;
    font-family: "Courier New", monospace;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.02);
}

#my-modal-gabung-bill .gabung-receipt-shell hr {
    margin: 0.5rem 0;
    border-top: 1px dashed #adb5bd;
}

#my-modal-gabung-bill .gabung-receipt-shell table {
    width: 100%;
    font-size: 0.8rem;
}

#my-modal-gabung-bill .gabung-receipt-shell .fw-bold {
    font-weight: 700;
}

@media (max-width: 991.98px) {
    #my-modal-gabung-bill .gabung-panel-header {
        flex-direction: column;
    }

    #my-modal-gabung-bill .gabung-kpi-strip {
        justify-content: flex-start;
    }

    #my-modal-gabung-bill .gabung-action-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 767.98px) {
    #my-modal-gabung-bill .modal-header {
        padding: 1rem;
        flex-wrap: wrap;
    }

    #my-modal-gabung-bill .modal-body {
        padding: 0.85rem;
    }

    #my-modal-gabung-bill .modal-title {
        font-size: 1.1rem;
    }

    #my-modal-gabung-bill .gabung-summary-grid,
    #my-modal-gabung-bill .gabung-action-grid {
        grid-template-columns: 1fr;
    }

    #my-modal-gabung-bill .gabung-subsection-heading {
        flex-direction: column;
    }

    #my-modal-gabung-bill .gabung-item-table thead th {
        font-size: 0.68rem;
        padding: 0.7rem 0.5rem;
    }

    #my-modal-gabung-bill .gabung-item-table tbody td {
        padding: 0.8rem 0.5rem;
        font-size: 0.78rem;
    }
}
</style>
