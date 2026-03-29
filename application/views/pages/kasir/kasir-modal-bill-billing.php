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
                    <div class="card-body kasir-billing-receipt-shell" id="printArea3">
                        <div class="kasir-billing-receipt-header text-center">
                            <img id="receipt_logo_billing" src="" alt="Logo Struk" class="kasir-billing-receipt-logo"
                                style="display:none;">
                            <h5 id="receipt_company_billing" class="kasir-billing-receipt-company"></h5>
                            <div class="kasir-billing-receipt-address" id="receipt_address_billing"></div>
                        </div>

                        <hr class="kasir-billing-receipt-rule">

                        <div class="kasir-billing-receipt-section">
                            <table class="kasir-billing-receipt-table kasir-billing-receipt-info">
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><span id="bill_billing_date_show" style="font-weight: 500;"></span></td>
                                </tr>
                                <tr>
                                    <td>Kasir</td>
                                    <td>:</td>
                                    <td><span id="bill_billing_chasier_show" style="font-weight: 500;"></span></td>
                                </tr>
                                <tr>
                                    <td>No.Order</td>
                                    <td>:</td>
                                    <td><span id="bill_billing_no_order_show" style="font-weight: 500;"></span></td>
                                </tr>
                                <tr>
                                    <td>No.Invoice</td>
                                    <td>:</td>
                                    <td><span id="bill_billing_no_invoice" style="font-weight: 500;"></span></td>
                                </tr>
                            </table>
                        </div>

                        <hr class="kasir-billing-receipt-rule">

                        <div class="kasir-billing-receipt-section">
                            <table class="kasir-billing-receipt-table kasir-billing-receipt-items">
                                <tbody ng-repeat="group in groupedOrders">
                                    <tr class="group-row">
                                        <td colspan="3">Table : {{ group.no_meja }}</td>
                                    </tr>
                                    <tr ng-repeat="item in group.items">
                                        <td class="qty-col">[{{ item.qty }}]</td>
                                        <td class="name-col">
                                            {{ item.nama }}
                                            <span ng-if="item.potongan !== null">({{item.discount}}%)</span>
                                        </td>
                                        <td class="amount-col">
                                            {{ (item.qty * item.harga) - item.potongan | currency:'Rp ':0 }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr class="kasir-billing-receipt-rule">

                        <div class="kasir-billing-receipt-section">
                            <table class="kasir-billing-receipt-table kasir-billing-receipt-summary">
                                <tr>
                                    <td>Qty</td>
                                    <td>:</td>
                                    <td id="bill_billing_qty_show">0</td>
                                </tr>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>:</td>
                                    <td id="bill_billing_subtotal_show">0</td>
                                </tr>
                                <tr>
                                    <td>Discount (<span id="bill_billing_discount_persen"></span>%)</td>
                                    <td>:</td>
                                    <td id="bill_billing_discount_show">0</td>
                                </tr>
                                <tr>
                                    <td>PPN (<span id="bill_billing_ppn_percen_show"></span>%)</td>
                                    <td>:</td>
                                    <td id="bill_billing_ppn_show">0</td>
                                </tr>
                                <tr class="kasir-billing-receipt-grand-total">
                                    <td>Grand Total</td>
                                    <td>:</td>
                                    <td id="bill_billing_grand_total_show">0</td>
                                </tr>
                                <tr>
                                    <td>Metode Bayar</td>
                                    <td>:</td>
                                    <td id="bill_billing_metode_show">-</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Dibayar</td>
                                    <td>:</td>
                                    <td id="bill_billing_jumlah_dibayar_show">0</td>
                                </tr>
                                <tr>
                                    <td>Kembalian</td>
                                    <td>:</td>
                                    <td id="bill_billing_kembalian_show">0</td>
                                </tr>
                                <tr>
                                    <td>Service Metode</td>
                                    <td>:</td>
                                    <td id="bill_billing_service_metode_show"></td>
                                </tr>
                            </table>
                        </div>

                        <hr class="kasir-billing-receipt-rule">

                        <div class="kasir-billing-receipt-footer text-center">
                            <div class="kasir-billing-receipt-label">-- TERIMA KASIH --</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <button type="button" class="btn btn-primary" ng-click="printBillinvoiceBluetooth();">
                                <i class="bx bx-printer"></i>
                                Cetak Bluethooth
                            </button>
                            <button type="button" class="btn btn-dark mt-2" ng-click="printBillinvoiceUSB();">
                                <i class="bx bx-printer"></i>
                                Cetak USB
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Bill Biling -->

<style>
#my-modal-bill-billing .kasir-billing-receipt-shell {
    font-family: "Courier New", monospace;
    background: #ffffff;
    border: 1px dashed #cbd5e1;
    border-radius: 16px;
    padding: 14px 16px;
    color: #0f172a;
}

#my-modal-bill-billing .kasir-billing-receipt-header {
    line-height: 1.45;
}

#my-modal-bill-billing .kasir-billing-receipt-logo {
    max-width: 72px;
    max-height: 72px;
    margin-bottom: 6px;
}

#my-modal-bill-billing .kasir-billing-receipt-company {
    margin-bottom: 4px;
    font-size: 1rem;
    font-weight: 700;
}

#my-modal-bill-billing .kasir-billing-receipt-address {
    font-size: 0.78rem;
}

#my-modal-bill-billing .kasir-billing-receipt-rule {
    margin: 10px 0;
    border-top: 1px dashed #94a3b8;
    opacity: 1;
}

#my-modal-bill-billing .kasir-billing-receipt-table {
    width: 100%;
    font-size: 0.78rem;
}

#my-modal-bill-billing .kasir-billing-receipt-info td:first-child,
#my-modal-bill-billing .kasir-billing-receipt-summary td:first-child {
    width: 42%;
}

#my-modal-bill-billing .kasir-billing-receipt-info td:nth-child(2),
#my-modal-bill-billing .kasir-billing-receipt-summary td:nth-child(2) {
    width: 8%;
    text-align: center;
}

#my-modal-bill-billing .kasir-billing-receipt-items .group-row td {
    padding-top: 6px;
    font-weight: 700;
}

#my-modal-bill-billing .kasir-billing-receipt-items .qty-col {
    width: 16%;
}

#my-modal-bill-billing .kasir-billing-receipt-items .name-col {
    width: 52%;
}

#my-modal-bill-billing .kasir-billing-receipt-items .amount-col,
#my-modal-bill-billing .kasir-billing-receipt-summary td:last-child {
    width: 32%;
    text-align: right;
}

#my-modal-bill-billing .kasir-billing-receipt-grand-total td {
    font-weight: 700;
}

#my-modal-bill-billing .kasir-billing-receipt-footer {
    font-size: 0.78rem;
    font-weight: 700;
}
</style>
