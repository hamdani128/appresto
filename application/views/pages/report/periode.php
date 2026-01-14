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
            <div class="card">
                <div class="card-body">
                    <div class="row pb-5">
                        <div class="col-md-2 col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label for="">End Date</label>
                                <div class="input-group">
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="<?php echo date('Y-m-d') ?>">
                                    <button class="btn btn-md btn-dark" ng-click="CetakPeriodeDetail()">
                                        <i class='bx bx-printer'></i>
                                        Cetak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>