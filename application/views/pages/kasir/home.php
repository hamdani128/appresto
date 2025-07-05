<div ng-app="HomeKasirApp" ng-controller="HomeKasirController">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row align-items-center pb-5">
                <div class="col-md-2">
                </div>
                <div class="col-md-10">
                    <form class="float-md-end">
                        <div class="row row-cols-md-auto g-lg-3 align-items-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputFromDate" class="">From Date</label>
                                    <input type="date" class="form-control" id="date_start" value="<?=date('Y-m-d')?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputToDate" class="">To Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="date_end" value="<?=date('Y-m-d')?>">
                                    <button type="button" class="btn btn-dark" ng-click="getSalesReport()">
                                        <i class="bx bx-search-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3">
                <div class="col">
                    <div class="card radius-10 bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Revenue</p>
                                    <h4 class="my-1 text-white" id="revenue_kasir">0</h4>
                                </div>
                                <div class="widgets-icons bg-light-transparent text-white ms-auto"><i
                                        class="bx bxs-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Visitors</p>
                                    <h4 class="my-1 text-white" id="visitors_kasir">0</h4>
                                </div>
                                <div class="widgets-icons bg-light-transparent text-white ms-auto"><i
                                        class="bx bxs-binoculars"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-0 text-white">Total Transactions</p>
                                    <h4 class="my-1 text-white" id="transactions_kasir">0</h4>
                                </div>
                                <div class="widgets-icons bg-light-transparent text-white"><i
                                        class="bx bx-line-chart-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->


            <div class="row">
                <div class="col-12 col-lg-8 col-xl-8 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0">Performance Sales</h5>
                                <!-- <div class="dropdown options ms-auto">
                                    <div class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                                        <i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="chart-js-container1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-xl-4 d-flex">
                    <div class="card radius-10 overflow-hidden w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0">Top Menu Sales</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li ng-repeat="dt in menu_deskripsi"
                                    ng-if="menu_deskripsi.length > 0 && dt.jenis == 'Makanan'"
                                    class="list-group-item d-flex justify-content-between align-items-center border-top">
                                    {{dt.nama}}
                                    <span class="badge bg-primary rounded-pill">
                                        {{dt.jumlah | number:0}}
                                    </span>
                                </li>
                                <li ng-repeat="dt in menu_deskripsi"
                                    ng-if="menu_deskripsi.length > 0 && dt.jenis == 'Minuman'"
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    {{dt.nama}}
                                    <span class="badge bg-success rounded-pill">
                                        {{dt.jumlah | number:0}}
                                    </span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>