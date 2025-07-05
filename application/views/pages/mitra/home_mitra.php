<div ng-app="HomeMitraApp" ng-controller="HomeMitraAppController">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row align-items-center pb-5">
                <div class="col-md-3">
                </div>
                <div class="col-md-9">
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
                                    <h4 class="my-1 text-white">0</h4>
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
                                    <h4 class="my-1 text-white">0</h4>
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
                                    <h4 class="my-1 text-white">0</h4>
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
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Row Order</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:130%"
                                    id="tb_pesanan_list_detail">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>
                                                <input type="checkbox" ng-model="checkAll" ng-change="toggleAll()"
                                                    class="form-check-input">
                                            </th>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Status Food</th>
                                            <th>No.Order</th>
                                            <th>No.Meja</th>
                                            <th>Category</th>
                                            <th>List</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Jenis</th>
                                            <th>Owner</th>
                                            <th>Time Request</th>
                                        </tr>
                                    </thead>
                                    <tbody id="td_pesanan_body_list_detail">
                                        <tr ng-repeat="dt in LoadDataPesananDetail"
                                            ng-if="LoadDataPesananDetail.length > 0">
                                            <td>
                                                <input type="checkbox" ng-model="dt.checked"
                                                    ng-change="updateCheckedIds()" class="form-check-input">
                                            </td>
                                            <td>{{$index + 1}}</td>
                                            <td>
                                                <div class="btn-group input-group">
                                                    <button type="button" class="btn btn-sm btn-dark"
                                                        ng-if="dt.status=='1'"
                                                        ng-click="TambahQtyPesananListDetail(dt)">
                                                        <i class=" bx bx-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-dark"
                                                        ng-if="dt.status=='1'"
                                                        ng-click="KurangQtyPesananListDetail(dt)">
                                                        <i class=" bx bx-minus"></i>
                                                    </button>
                                                    <!-- <button type="button" class="btn btn-sm btn-danger"
                                                        ng-click="DeleteListDetail(dt)" ng-if="dt.status=='1'">
                                                        <i class="bx bx-trash"></i>
                                                    </button> -->
                                                </div>
                                            </td>
                                            <td>
                                                <div ng-if="dt.status=='1'">
                                                    <span class="badge bg-warning text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                                <div ng-if="dt.status=='2'">
                                                    <span class="badge bg-info text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                                <div ng-if="dt.status=='3'">
                                                    <span class="badge bg-info text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                                <div ng-if="dt.status=='4'">
                                                    <span class="badge bg-success text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>{{dt.no_order}}</td>
                                            <td>{{dt.no_meja}}</td>
                                            <td>{{dt.kategori}}</td>
                                            <td>{{dt.nama}}</td>
                                            <td>{{dt.harga}}</td>
                                            <td class="qty-cell-list-detail">{{dt.qty}}</td>
                                            <td class="subtotal-cell-list-detail">{{dt.qty * dt.harga}}</td>
                                            <td>{{dt.jenis}}</td>
                                            <td>{{dt.owner}}</td>
                                            <td>{{dt.created_at}}</td>
                                        </tr>
                                        <tr ng-if="LoadDataPesananDetail.length === 0">
                                            <td colspan="12" class="text-center">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- row data transaksi -->
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Row Transaction Detail</label>
                                </div>
                            </div>
                        </div>
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
                                <table datatable="ng" dt-options="vm.dtOptions"
                                    class="table table-striped table-bordered" style="width:100%">
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
            <!-- End Row Transaksi -->

            <div class="row">
                <div class="col-12 col-lg-8 col-xl-8 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0">Performance Sales</h5>
                                <div class="dropdown options ms-auto">
                                    <div class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                                        <i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-js-container1">
                                <canvas id="chart3"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-xl-4 d-flex">
                    <div class="card radius-10 overflow-hidden w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0">Top Categories</h5>
                                <div class="dropdown options ms-auto">
                                    <div class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                                        <i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-top">
                                    Clothing
                                    <span class="badge bg-primary rounded-pill">0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Electronics
                                    <span class="badge bg-success rounded-pill">0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Furniture
                                    <span class="badge bg-danger rounded-pill">0</span>
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