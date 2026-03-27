<div ng-app="ReportPeriodeApp" ng-controller="ReportPeriodeController">

    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Report</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Periode Detail</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Informasi Data Report Periode Detail</h6>
            <hr />
            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <!-- FILTER -->
                    <div class="row pb-4">

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="<?php echo date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">End Date</label>
                            <div class="input-group">

                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="<?php echo date('Y-m-d') ?>">

                                <button class="btn btn-dark" ng-click="CheckFilter()">
                                    <i class="bx bx-search"></i>
                                    Check Report
                                </button>

                            </div>
                        </div>

                    </div>

                    <!-- HEADER LAPORAN -->
                    <div class="text-center mb-3">

                        <h4 class="fw-bold mb-0">
                            LAPORAN KASIR
                        </h4>

                        <small class="text-muted">
                            Periode
                            {{start_date}} s/d {{end_date}}
                        </small>

                    </div>


                    <!-- TABLE LAPORAN -->
                    <div class="table-responsive">

                        <table class="table table-bordered align-middle">

                            <tbody>

                                <tr class="table-primary fw-bold">
                                    <td colspan="2">Total Belanja</td>
                                    <td class="text-end fs-5">
                                        {{ total_belanja | currency:'Rp '}}
                                    </td>
                                </tr>

                                <tr class="table-secondary fw-bold">
                                    <td colspan="3">Rincian Pembayaran</td>
                                </tr>

                                <tr>
                                    <td width="40"></td>
                                    <td>Tunai / Cash</td>
                                    <td class="text-end">
                                        {{ report.cash | currency:'Rp '}}
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>QRIS</td>
                                    <td class="text-end">
                                        {{ report.qris | currency:'Rp '}}
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Transfer</td>
                                    <td class="text-end">
                                        {{ report.transfer | currency:'Rp '}}
                                    </td>
                                </tr>

                                <tr class="table-warning fw-bold">
                                    <td colspan="3">Uang Tunai Dalam Laci</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Uang Awal</td>
                                    <td class="text-end">
                                        {{ report.saldo_awal | currency:'Rp '}}
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Tarik Uang</td>
                                    <td class="text-end text-danger">
                                        - {{ report.pengeluaran | currency:'Rp '}}
                                    </td>
                                </tr>

                                <tr class="table-success fw-bold">
                                    <td></td>
                                    <td>Total Kas Dalam Laci</td>
                                    <td class="text-end fs-5">
                                        {{ total_laci | currency:'Rp '}}
                                    </td>
                                </tr>

                                <tr class="table-dark fw-bold">
                                    <td></td>
                                    <td>Pendapatan Bersih</td>
                                    <td class="text-end fs-5">
                                        {{ pendapatan_bersih | currency:'Rp '}}
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>


                    <!-- ACTION BUTTON -->
                    <div class="text-center mt-4">

                        <button class="btn btn-success me-2" type="button" ng-click="printLaporanUSB()">
                            <i class="bx bx-printer"></i>
                            Cetak Laporan USB
                        </button>

                        <button class="btn btn-info text-white me-2" type="button" ng-click="printLaporanBluetooth()">
                            <i class="bx bx-printer"></i>
                            Cetak Bluetooth
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
