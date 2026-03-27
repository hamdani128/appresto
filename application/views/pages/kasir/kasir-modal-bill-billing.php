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
                                <!-- <img src="<?php echo base_url() ?>public/assets/images/millennialpos.png"
                                                alt=""> -->
                                <h5>RUMAH KOPI DINDA</h5>
                            </div>
                            <div class="text-center">
                                Jl. RS Haji NO. 45 A<br>
                                MEDAN - SUMATERA UTARA<br>
                                Telp: 085260207471<br>
                            </div>
                            <hr>
                            <div style="padding-left: 18px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20%;">
                                            Tanggal
                                        </td>
                                        <td style="width: 5%;">:</td>
                                        <td style="width: 75%;"><span id="bill_billing_date_show"
                                                style="font-weight: 500;">
                                                {{$scope.billingData.tanggal | date:'dd-MM-yyyy'}}
                                            </span>
                                        </td>
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
                                    <tr>
                                        <td>
                                            No.Invoice
                                        </td>
                                        <td>:</td>
                                        <td><span id="bill_billing_no_invoice" style="font-weight: 500;"></span>
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
                                                    <td>PPN (<label id="bill_billing_ppn_percen_show"></label>%)</td>
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