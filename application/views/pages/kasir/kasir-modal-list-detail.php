<!-- List Pesanan Detail -->
<div id="my-modal-list-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">No.Pesanan <label id="lb_no_booking_list"></label> | No.Meja
                    <label id="lb_no_meja_list"></label>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row pb-2">
                    <div class="col-md-12">
                        <button class="btn btn-md btn-primary" ng-click="UpdateServed()">
                            <i class="bx bx-edit"></i>
                            Served
                        </button>
                        <button class="btn btn-md btn-info" ng-click="UpdateDelivered()">
                            <i class="bx bx-edit"></i>
                            Delivered
                        </button>
                        <button class="btn btn-md btn-success" ng-click="UpdateCompleted()">
                            <i class="bx bx-edit"></i>
                            Completed
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="width:130%"
                                id="tb_pesanan_list_detail">
                                <thead class="bg-dark text-white">
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
                                        <th>Potongan</th>
                                        <th>Disc(%)</th>
                                        <th>Jenis</th>
                                        <th>Owner</th>
                                        <th>Time Request</th>
                                    </tr>
                                </thead>
                                <tbody id="td_pesanan_body_list_detail">
                                    <tr ng-repeat="dt in LoadDataPesananDetail" ng-if="LoadDataPesananDetail.length > 0"
                                        style="text-align: center;">
                                        <td>
                                            <input type="checkbox" ng-model="dt.checked" ng-change="updateCheckedIds()"
                                                class="form-check-input">
                                        </td>
                                        <td>{{$index + 1}}</td>
                                        <td>
                                            <div class="btn-group input-group">
                                                <button type="button" class="btn btn-sm btn-dark" ng-if="dt.status=='1'"
                                                    ng-click="TambahQtyPesananListDetail(dt)">
                                                    <i class=" bx bx-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-dark" ng-if="dt.status=='1'"
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
                                        <td>{{dt.harga | currency:"":0}}</td>
                                        <td class="qty-cell-list-detail" style="font-size: 14pt;font-weight: 400;">
                                            {{dt.qty | number:0}}
                                        </td>
                                        <td class="subtotal-cell-list-detail">
                                            {{(dt.qty * dt.harga) - dt.potongan | currency:"":0}}</td>
                                        <td class="subtotal-cell-list-detail">{{ dt.potongan | currency:"":0}}
                                        </td>
                                        <td>{{dt.discount | number:0}}</td>
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
            <!-- <div class="modal-footer">
                    Footer
                </div> -->
        </div>
    </div>
</div>
<!-- End List Pesanan Detail -->
