<!-- Cetak Bill Modal -->
<div id="my-modal-cetak-bill" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">No.Pesanan <label id="lb_no_booking_payment_before_service"></label> |
                    No.Meja
                    <label id="lb_no_meja_payment_before_service"></label>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="printArea" class="receipt kasir-receipt-shell">
                    <div class="kasir-receipt-header text-center">
                        <img id="receipt_logo_bill" src="" alt="Logo Struk" class="kasir-receipt-logo"
                            style="display:none;">
                        <h5 id="receipt_company_bill" class="kasir-receipt-company"></h5>
                        <div class="kasir-receipt-address" id="receipt_address_bill"></div>
                    </div>

                    <hr class="kasir-receipt-rule">

                    <div class="kasir-receipt-section">
                        <table class="kasir-receipt-table kasir-receipt-info">
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><span id="bill_date"></span></td>
                            </tr>
                            <tr>
                                <td>No.Order</td>
                                <td>:</td>
                                <td><span id="bill_invoice"></span></td>
                            </tr>
                            <tr>
                                <td>No.Invoice</td>
                                <td>:</td>
                                <td><span id="bill_invoice"></span></td>
                            </tr>
                            <tr>
                                <td>Kasir</td>
                                <td>:</td>
                                <td><span id="bill_chasier"></span></td>
                            </tr>
                            <tr>
                                <td>No.Meja</td>
                                <td>:</td>
                                <td><span id="bill_no_meja"></span></td>
                            </tr>
                        </table>
                    </div>

                    <hr class="kasir-receipt-rule">

                    <div class="kasir-receipt-section">
                        <table class="kasir-receipt-table kasir-receipt-items">
                            <tr ng-repeat="dt2 in LoadDataPesananBill" ng-if="LoadDataPesananBill.length > 0">
                                <td class="qty-col">[{{dt2.qty}}]</td>
                                <td class="name-col">{{dt2.nama}}</td>
                                <td class="amount-col">{{(dt2.qty * dt2.harga) | currency:"Rp ":0}}</td>
                            </tr>
                        </table>
                    </div>

                    <hr class="kasir-receipt-rule">

                    <div class="kasir-receipt-section">
                        <table class="kasir-receipt-table kasir-receipt-summary">
                            <tr>
                                <td>Qty</td>
                                <td>:</td>
                                <td id="bill_qty">0</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td>:</td>
                                <td id="bill_subtotal">0</td>
                            </tr>
                            <tr>
                                <td>Discount (<span id="bill_text_discount"></span>%)</td>
                                <td>:</td>
                                <td id="bill_value_discount">0</td>
                            </tr>
                            <tr>
                                <td>PPN (10%)</td>
                                <td>:</td>
                                <td id="bill_ppn">0</td>
                            </tr>
                            <tr class="kasir-receipt-grand-total">
                                <td>Grand Total</td>
                                <td>:</td>
                                <td id="bill_grand_total">0</td>
                            </tr>
                        </table>
                    </div>

                    <hr class="kasir-receipt-rule">

                    <div class="kasir-receipt-footer text-center">
                        <div class="kasir-receipt-label">-- BILL TRANSAKSI --</div>
                        <div class="kasir-receipt-label mt-1">-- TERIMA KASIH --</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row w-100 g-2">
                    <div class="col-12">
                        <button class="btn btn-success w-100" onclick="printEpppos()">
                            <i class="bx bx-printer"></i>
                            Print Bluetooth
                        </button>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-warning w-100" onclick="PrintCetakUSB()">
                            <i class="bx bx-printer"></i>
                            Print USB
                        </button>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-secondary w-100" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bill Modal -->

<style>
#my-modal-cetak-bill .kasir-receipt-shell {
    font-family: "Courier New", monospace;
    background: #ffffff;
    border: 1px dashed #cbd5e1;
    border-radius: 16px;
    padding: 14px 16px;
    color: #0f172a;
}

#my-modal-cetak-bill .kasir-receipt-header {
    line-height: 1.45;
}

#my-modal-cetak-bill .kasir-receipt-logo {
    max-width: 72px;
    max-height: 72px;
    margin-bottom: 6px;
}

#my-modal-cetak-bill .kasir-receipt-company {
    margin-bottom: 4px;
    font-size: 1rem;
    font-weight: 700;
}

#my-modal-cetak-bill .kasir-receipt-address {
    font-size: 0.78rem;
}

#my-modal-cetak-bill .kasir-receipt-rule {
    margin: 10px 0;
    border-top: 1px dashed #94a3b8;
    opacity: 1;
}

#my-modal-cetak-bill .kasir-receipt-table {
    width: 100%;
    font-size: 0.78rem;
}

#my-modal-cetak-bill .kasir-receipt-info td:first-child,
#my-modal-cetak-bill .kasir-receipt-summary td:first-child {
    width: 38%;
}

#my-modal-cetak-bill .kasir-receipt-info td:nth-child(2),
#my-modal-cetak-bill .kasir-receipt-summary td:nth-child(2) {
    width: 8%;
    text-align: center;
}

#my-modal-cetak-bill .kasir-receipt-items .qty-col {
    width: 16%;
}

#my-modal-cetak-bill .kasir-receipt-items .name-col {
    width: 52%;
}

#my-modal-cetak-bill .kasir-receipt-items .amount-col,
#my-modal-cetak-bill .kasir-receipt-summary td:last-child {
    width: 32%;
    text-align: right;
}

#my-modal-cetak-bill .kasir-receipt-grand-total td {
    font-weight: 700;
}

#my-modal-cetak-bill .kasir-receipt-footer {
    font-size: 0.78rem;
    font-weight: 700;
}
</style>
