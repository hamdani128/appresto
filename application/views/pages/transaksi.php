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
                    <div class="row pb-4 g-3">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="type_transaction">Type Transaction</label>
                                <div class="input-group">
                                    <select class="form-select" id="type_transaction" name="type_transaction">
                                        <option value="All">All</option>
                                        <option value="Owner">Owner</option>
                                        <div ng-repeat="dt in ComboMitraData">
                                            <option value="{{dt.kode}}">{{dt.kode}} - {{dt.nama}}</option>
                                        </div>
                                    </select>
                                    <button class="btn btn-dark" ng-click="FilterData()">
                                        <i class='bx bx-search'></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_transaksi">
                                <i class="bx bx-receipt"></i> Transaksi
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_saldo_awal">
                                <i class="bx bx-wallet"></i> Saldo Awal
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_pengeluaran">
                                <i class="bx bx-minus-circle"></i> Pengeluaran
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <!-- ================= TRANSAKSI ================= -->
                        <div class="tab-pane fade show active" id="tab_transaksi">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle" style="width:100%">
                                    <thead class="table-dark">
                                        <tr class="text-center">
                                            <th style="width:50px;"></th>
                                            <th>#</th>
                                            <th>Invoice</th>
                                            <th>Service</th>
                                            <th>Payment</th>
                                            <th>Date</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat-start="dt in data_transaksi">

                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light" ng-click="toggleRow(dt)">
                                                    <i class="bx"
                                                        ng-class="dt.expanded ? 'bx-minus-circle text-danger' : 'bx-plus-circle text-success'">
                                                    </i>
                                                </button>
                                            </td>

                                            <td class="text-center">{{$index + 1}}</td>
                                            <td>
                                                <strong>{{dt.no_transaksi}}</strong><br>
                                                <small>Order: {{dt.no_order}}</small><br>
                                                <small>Table: {{dt.no_meja}}</small>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    {{dt.metode_service}}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge" ng-class="{
													'bg-success': dt.metode == 'Cash',
													'bg-primary': dt.metode == 'QRIS',
													'bg-dark': dt.metode == 'Bank Transfer'
												}">
                                                    {{dt.metode}}
                                                </span>
                                            </td>
                                            <td>{{dt.created_at}}</td>
                                            <td class="text-end fw-bold">
                                                {{dt.subtotal || 0 | currency:'Rp. '}}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-dark" ng-click="printCard(dt)">
                                                        <i class="bx bx-printer"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr ng-repeat-end ng-if="dt.expanded">
                                            <td colspan="8" class="bg-light p-3">

                                                <div ng-if="dt.loading" class="text-center p-2">
                                                    Loading detail...
                                                </div>

                                                <div ng-if="!dt.loading">

                                                    <!-- 🔥 SUMMARY SECTION -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <span class="badge bg-primary">
                                                                Total Item : {{ getTotalQtyToggleRow(dt.detail_items) }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <table class="table table-sm table-bordered">
                                                        <thead class="table-secondary">
                                                            <tr class="text-center">
                                                                <th>Kategori</th>
                                                                <th>Nama</th>
                                                                <th>Harga</th>
                                                                <th>Qty</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="item in dt.detail_items">
                                                                <td>{{item.kategori}}</td>
                                                                <td>{{item.nama}}</td>
                                                                <td class="text-center">
                                                                    {{item.harga | currency:'Rp. '}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{item.qty}}
                                                                </td>
                                                                <td class="text-end">
                                                                    {{item.qty * item.harga | currency:'Rp. '}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!-- ================= SALDO AWAL ================= -->
                        <div class="tab-pane fade" id="tab_saldo_awal">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered align-middle">
                                            <thead class="table-warning">
                                                <tr class="text-center">
                                                    <th style="width:50px">#</th>
                                                    <th>Amount</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal</th>
                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ; ?>
                                                    <th>Action</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="dt in saldo_awal_data">
                                                    <td class="text-center">{{$index+1}}</td>
                                                    <td class="text-end fw-bold text-success">
                                                        {{dt.saldo | currency:'Rp '}}
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{dt.keterangan || '-'}}
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        {{dt.created_at | date:'dd-MM-yyyy HH:mm'}}
                                                    </td>

                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ; ?>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-warning"
                                                            ng-click="editSaldoAwal(dt.id)">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger"
                                                            ng-click="deleteSaldoAwal(dt.id)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>

                                                <tr ng-if="saldo_awal_data.length == 0">
                                                    <td colspan="4" class="text-center text-muted">
                                                        Belum ada saldo awal
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ================= PENGELUARAN ================= -->
                        <div class="tab-pane fade" id="tab_pengeluaran">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table class="table table-hover table-bordered align-middle">

                                            <thead class="table-danger">
                                                <tr class="text-center">
                                                    <th style="width:50px">#</th>
                                                    <th>Amount</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal</th>

                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ?>
                                                    <th>Action</th>
                                                    <?php endif; ?>

                                                </tr>
                                            </thead>

                                            <tbody>

                                                <tr ng-repeat="dt in pengeluaran_data">

                                                    <td class="text-center">{{$index+1}}</td>

                                                    <td class="text-end fw-bold text-danger">
                                                        {{dt.amount | currency:'Rp '}}
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{dt.keterangan || '-'}}
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        {{dt.created_at | date:'dd-MM-yyyy HH:mm'}}
                                                    </td>

                                                    <?php if ($this->session->userdata("level") == "Super Admin"): ?>
                                                    <td class="text-center">

                                                        <button class="btn btn-sm btn-warning"
                                                            ng-click="editPengeluaran(dt.id)">
                                                            <i class="bx bx-edit"></i>
                                                        </button>

                                                        <button class="btn btn-sm btn-danger"
                                                            ng-click="deletePengeluaran(dt.id)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>

                                                    </td>
                                                    <?php endif; ?>

                                                </tr>

                                                <tr ng-if="pengeluaran_data.length == 0">
                                                    <td colspan="5" class="text-center text-muted">
                                                        Belum ada pengeluaran
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- Show Modal Detail -->
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
                                    <!-- <img src="<?php echo base_url() ?>public/assets/images/millennialpos.png" alt=""> -->
                                    <h5>RUMAH KOPI DINDA</h5>
                                </div>
                                <div class="text-center">
                                    Jl. RS Haji NO. 45 A,
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
                                                    style="font-weight: 500;"></span></td>
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
                                                        <td>PPN (10%)</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Bill Biling -->
    <!-- End Modal Detail -->
</div>