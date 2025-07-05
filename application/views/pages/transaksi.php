<div ng-app="ListTransaksiApp" ng-controller="ListTransaksiAppController">

    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Transaksi</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data List Transaksi</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Informasi Data List Transaksi</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="row pb-5">
                        <div class="col-md-2 col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="<?=date('Y-m-d')?>">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label for="">End Date</label>
                                <div class="input-group">
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="<?=date('Y-m-d')?>">
                                    <button class="btn btn-md btn-dark" ng-click="FilterData()">
                                        <i class='bx bx-search'></i>
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-bordered"
                            style="width:100%">
                            <thead class="bg-dark text-white">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Service Method</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                    <th>Substotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="dt in data_transaksi" ng-if="data_transaksi.length > 0">
                                    <td>{{$index + 1}}</td>
                                    <td>
                                        <span>Inv.Code : <b>{{dt.no_transaksi}}</b></span><br>
                                        <span>Order No : <b>{{dt.no_order}}</b></span><br>
                                        <span>No.Table : <b>{{dt.no_meja}}</b></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{dt.metode_service}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info" ng-if="dt.metode == 'Cash'">
                                            {{dt.metode}}
                                        </span>
                                        <span class="badge bg-primary" ng-if="dt.metode == 'QRIS'">
                                            {{dt.metode}}
                                        </span>
                                        <span class="badge bg-dark" ng-if="dt.metode == 'Bank Transfer'">
                                            {{dt.metode}}
                                        </span>
                                    </td>
                                    <td>
                                        {{dt.created_at}}
                                    </td>
                                    <td>
                                        {{dt.subtotal || 0 | currency:'Rp. '}}
                                    </td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-sm btn-dark" ng-click="printCard(dt)">
                                                <i class="bx bx-printer"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary" ng-click="showDetail(dt)">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" ng-click="deleteData(dt.id)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr ng-if="data_transaksi.length === 0">
                                    <td colspan="11" class="text-center">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Modal Detail -->
    <div id="my-modal-show" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">No.Pesanan <label id="lb_show_no_pesanan"></label> |
                        No.Meja
                        <label id="lb_show_no_meja"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body" id="printArea2">
                            <div>
                                <div class="text-center bold" style="font-size: 14px;margin-top: 0px;">
                                    <img src="<?=base_url()?>public/assets/images/millennialpos.png" alt="">
                                    <h5>ROEMAH PREMIUM KOPI</h5>
                                </div>
                                <div class="text-center">
                                    Jl. STM Jl. Sakti Lubis No.SIMPANG,
                                    Suka Maju, Kec. Medan Amplas, Kota Medan,
                                    Sumatera Utara
                                    20217<br>
                                    Telp: 0812-3456-7890<br>
                                </div>
                                <hr>
                                <div style="padding-left: 18px;">
                                    <table>
                                        <tr>
                                            <td>
                                                Tanggal
                                            </td>
                                            <td>:</td>
                                            <td><span id="bill_date_show" style="font-weight: 500;"></span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Kasir
                                            </td>
                                            <td>:</td>
                                            <td><span id="bill_chasier_show" style="font-weight: 500;"></span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                No.order
                                            </td>
                                            <td>:</td>
                                            <td><span id="bill_no_order_show" style="font-weight: 500;"></span></td>
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
                                                <td style="width: 60%;">{{ item.nama }}</td>
                                                <td style="width: 30%; text-align: right;">
                                                    {{ (item.qty * item.harga) | currency:'Rp ':0 }}
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
                                                            id="bill_qty_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Subtotal</td>
                                                        <td style="width: 10px;">:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_subtotal_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PPN (10%)</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_ppn_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Grand Total</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_grand_total_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Metode Bayar</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_metode_show">-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Dibayar</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_jumlah_dibayar_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kembalian</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_kembalian_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Service Metode</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_service_metode_show">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Detail -->
</div>