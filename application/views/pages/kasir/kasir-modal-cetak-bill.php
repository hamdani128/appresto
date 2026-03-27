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
                <div id="printArea" class="receipt">

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
                        <table>
                            <tr>
                                <td>
                                    Tanggal
                                </td>
                                <td>:</td>
                                <td><span id="bill_date"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    No.Order
                                </td>
                                <td>:</td>
                                <td><span id="bill_invoice"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    No.Invoice
                                </td>
                                <td>:</td>
                                <td><span id="bill_invoice"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    Kasir
                                </td>
                                <td>:</td>
                                <td><span id="bill_chasier"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    No.Meja
                                </td>
                                <td>:</td>
                                <td><span id="bill_no_meja"></span></td>
                            </tr>
                        </table>

                    </div>
                    <hr>
                    <div style="padding-left: 18px;">
                        <!-- Barang -->
                        <table style="width: 100%;  font-size: 13px;">
                            <tr ng-repeat="dt2 in LoadDataPesananBill" ng-if="LoadDataPesananBill.length > 0">
                                <td style="width: 8%;">[{{dt2.qty}}]</td>
                                <td style="width: 50%;">{{dt2.nama}}</td>
                                <td style="width: 35%; text-align: right;">
                                    {{(dt2.qty * dt2.harga) | currency:"Rp ":0}}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr>
                    <!-- Perhitungan -->
                    <div style="padding-left: 18px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;"></td>
                                <td style="width: 80%;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td>Qty</td>
                                            <td style="width: 10px;">:</td>
                                            <td style="text-align: center;" id="bill_qty">0</td>
                                        </tr>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td style="width: 10px;">:</td>
                                            <td style="text-align: right;" id="bill_subtotal">0</td>
                                        </tr>

                                        <tr>
                                            <td>Discount (<label for="" id="bill_text_discount"></label>%)</td>
                                            <td style="width: 10px;">:</td>
                                            <td style="text-align: right;" id="bill_value_discount">0</td>
                                        </tr>
                                        <tr>
                                            <td>PPN (10%)</td>
                                            <td>:</td>
                                            <td style="text-align: right;" id="bill_ppn">0</td>
                                        </tr>
                                        <tr>
                                            <td>Grand Total</td>
                                            <td>:</td>
                                            <td style="text-align: right;" id="bill_grand_total">0</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <hr>
                    <div class="text-center bold">
                        -- BILL TRANSAKSI --
                    </div>
                    <hr>
                    <div class="text-center bold">
                        -- TERIMA KASIH --
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <button class="btn btn-success" onclick="printEpppos()">
                        <i class="bx bx-printer"></i>
                        Print Bluetooth
                    </button>
                    <button class="btn btn-warning mt-2" onclick="PrintCetakUSB()">
                        <i class="bx bx-printer"></i>
                        Print USB
                    </button>
                    <button class="btn btn-secondary mt-2" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Bill Modal -->
