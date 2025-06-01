<div ng-app="KasirApp" ng-controller="KasirAppController">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 col-lg-7 col-xl-7 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-dark">
                            <h5 class="text-white">List Table</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2" ng-repeat="dt in LoadData" ng-if="LoadData.length > 0">
                                    <div class="card bg-success" id="bg_{{$index}}" ng-if="dt.status === '0'"
                                        ng-click="SelectedMeja('bg_' + $index, dt)">
                                        <div class="card-body">
                                            <h2 class="card-title text-white">{{dt.no_meja}}
                                            </h2>
                                            <p class="card-text text-white">{{dt.nama_meja}}</p>
                                        </div>
                                    </div>
                                    <div class="card bg-primary" ng-if="dt.status === '1'"
                                        ng-click="ShowListBelanja(dt)">
                                        <div class="card-body">
                                            <h2 class="card-title text-white">{{dt.no_meja}}</h2>
                                            <p class="card-text text-white">{{dt.nama_meja}}</p>
                                            <!-- <p class="card-text text-white">{{dt.no_order}}</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order -->
                <div class="col-12 col-lg-5 col-xl-5 d-flex">
                    <div class="card radius-10 overflow-hidden w-100">
                        <div class="card-header bg-dark">
                            <h5 class="text-white">
                                <i class="bx bx-slider-alt"></i>
                                Operation Tools
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group button-group">
                                        <button class="btn btn-md btn-dark w-100" id="btn_booking"
                                            ng-click="Create_Booking()" style="display: none;">
                                            <i class="bx bx-plus"></i>
                                            Booking
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="row_no_meja" style="display: none;">
                                <div class="row pt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h6 for="">No.Booking</h6>
                                            <h6 id="no_booking">-</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h6 for="">No.Meja</h6>
                                            <h6 id="no_meja">-</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group button-group">
                                        <button class="btn btn-md btn-danger w-50" id="btn_pindah_meja"
                                            style="display: none;">
                                            <i class="bx bx-layer"></i>
                                            Pindah
                                        </button>
                                        <button class="btn btn-md btn-primary w-50" id="btn_tambah_pesanan"
                                            style="display: none;" ng-click="TambahPesanan()">
                                            <i class="bx bx-edit"></i>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- jumlah makanan -->
                            <div class="pt-2" id="row_count_pesanan" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card bg-warning">
                                            <div class="card-body text-center">
                                                <h5 class="text-white">MAKANAN</h5>
                                                <h3 class="text-white" id="lb_makanan_list_pesanan">0</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-success">
                                            <div class="card-body text-center">
                                                <h5 class="text-white">MINUMAN</h5>
                                                <h3 class="text-white" id="lb_minuman_list_pesanan">0</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="row_list_pesanan" style="display: none;">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="">No.Meja</label>
                                    </div>
                                    <div class="col-1">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col-8">
                                        <label for="" id="lb_tambahan_no_meja"></label>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-3">
                                        <label for="">No.Order</label>
                                    </div>
                                    <div class="col-1">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col-8">
                                        <label for="" id="lb_tambahan_no_order"></label>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-3">
                                        <label for="">Created at</label>
                                    </div>
                                    <div class="col-1">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col-8">
                                        <label for="" id="lb_tambahan_created_at"></label>
                                    </div>
                                </div>

                                <div class="row pt-2">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" style="width:100%"
                                            id="tb_pesanan_list">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Cat.</th>
                                                    <th>List</th>
                                                    <th>Harga</th>
                                                    <th>Qty</th>
                                                    <th>Subtotal</th>
                                                    <th>Jenis</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tb_pesanan_list_body_menu">
                                                <tr ng-repeat="dt in LoadDataPesananList"
                                                    ng-if="LoadDataPesananList.length > 0">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{dt.kategori}}</td>
                                                    <td>{{dt.nama}}</td>
                                                    <td>{{dt.harga}}</td>
                                                    <td>{{dt.qty}}</td>
                                                    <td>{{dt.qty * dt.harga}}</td>
                                                    <td>{{dt.jenis}}</td>
                                                    <td>
                                                        <div class="button-group">
                                                            <button class="btn btn-sm btn-dark"
                                                                ng-click="ShowDetailPesanan(dt)">
                                                                <i class="bx bx-show"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr ng-if="LoadDataPesananList.length === 0">
                                                    <td colspan="7" class="text-center">No data available</td>
                                                </tr>
                                            </tbody>
                                            <tfoot style="border: 1px solid #dee2e6;">
                                                <tr>
                                                    <td colspan="6"
                                                        style="text-align: right; font-size: 16px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <label for="">Total Qty : </label>
                                                    </td>
                                                    <td colspan="2"
                                                        style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <input type="text" class="form-control" name="qty-total"
                                                            id="qty-total" style="text-align: right;" value="0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"
                                                        style="text-align: right; font-size: 16px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <label for="">Subtotal : </label>
                                                    </td>
                                                    <td colspan="2"
                                                        style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <input type="text" class="form-control" name="amount-total"
                                                            id="amount-total" style="text-align: right;" value="0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"
                                                        style="text-align: right; font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <div
                                                            style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">

                                                            <select id="ppn-select" class="form-control"
                                                                style="width: 100px;" ng-change="CalculateTotal()"
                                                                ng-model="ppnValue">
                                                                <option value="">Pilih PPN :</option>
                                                                <option value="10">10%</option>
                                                                <option value="11">11%</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td colspan="2"
                                                        style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <input type="text" class="form-control" name="amount-ppn"
                                                            id="amount-ppn" style="text-align: right;" value="0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"
                                                        style="text-align: right; font-size: 16px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <label for="">Grand Total : </label>
                                                    </td>
                                                    <td colspan="2"
                                                        style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                        <input type="text" class="form-control" name="grand-total"
                                                            id="grand-total" style="text-align: right;" value="0">
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!--.row Nominal  -->
                                <div class="row pt-1">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="input-group button-group">
                                                <button class="btn btn-success btn btn-md btn-block w-50 h-30"
                                                    ng-click="CetakBill()" style="height: 100px;">
                                                    <i class="bx bx-printer"></i>
                                                    Cetak Bill
                                                </button>
                                                <button class="btn btn-info btn btn-md btn-block w-50 h-30"
                                                    ng-click="payment_cash()" style="height: 100px;">
                                                    <i class="bx bx-save"></i>
                                                    Payment Cash
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Order -->
            </div>
            <!-- End List Pesanan -->
        </div>
    </div>




    <!-- Modal Insert Makanan -->
    <div class="modal fade modal-right" id="my-modal-booking" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_no_booking"></label> | No.Meja <label
                            id="lb_no_meja"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-xl-6 col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Pencarian Data :</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="" id=""
                                                                ng-model="keywordMenu" ng-change="searchMenu()"
                                                                placeholder="Masukkan Data . .">
                                                            <select name="" id="" class="form-control">
                                                                <option value="">Filter By :</option>
                                                                <option value="Makanan">Makanan</option>
                                                                <option value="Minuman">Minuman</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pt-4">
                                                <div class="col-md-4" ng-repeat="dt in filteredMenu">
                                                    <div class="card">
                                                        <div class="card-body-scrollable">
                                                            <div class="list-group" ng-if="filteredMenu.length > 0">
                                                                <a href="javascript:;" ng-click="PilihMenu(dt)"
                                                                    class="list-group-item list-group-item-action"
                                                                    aria-current="true">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1 text-black">
                                                                            {{dt.jenis}}
                                                                        </h5>
                                                                        <span
                                                                            class="badge bg-info text-white">Ready</span>

                                                                    </div>
                                                                    <div class="row d-flex">
                                                                        <div class="col-md-12 pt-2">
                                                                            <img src="<?=base_url('public/assets/images/foodbar.png')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Makanan' && !dt.img">

                                                                            <img src="<?=base_url('public/upload/{{dt.img}}')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Makanan' && dt.img">

                                                                            <img src="<?=base_url('public/assets/images/refreshments.png')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Minuman' && !dt.img">

                                                                            <img src="<?=base_url('public/upload/{{dt.img}}')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Minuman' && dt.img">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row pt-2">
                                                                        <div class="col-md-12">
                                                                            <h6>{{dt.nama}}</small>
                                                                                <h5>Rp.{{dt.harga}}</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6 col-sm-12">
                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h5 class="text-white">List Daftar Pesanan :</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" style="width:100%"
                                                id="tb_pesanan">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Cat.</th>
                                                        <th>List</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Jenis</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_pesanan_body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <button class="btn btn-md btn-primary" ng-click="SimpanDataOrder()">
                                                    <i class="bx bx-save"></i>
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Tambah Pesanan -->
    <div class="modal fade modal-right" id="my-modal-tambah-pesanan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_no_booking_tambahan"></label> | No.Meja
                        <label id="lb_no_meja_tambah_pesanan"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Pencarian Data :</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="" id=""
                                                        ng-model="keywordMenu" ng-change="searchMenu()"
                                                        placeholder="Masukkan Data . .">
                                                    <select name="" id="" class="form-control">
                                                        <option value="">Filter By :</option>
                                                        <option value="Makanan">Makanan</option>
                                                        <option value="Minuman">Minuman</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-2">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-md-4" ng-repeat="dt in filteredMenu"
                                                        ng-if="filteredMenu.length > 0">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <a href="javascript:;" ng-click="PilihMenuTambahan(dt)"
                                                                    class="list-group-item list-group-item-action"
                                                                    aria-current="true">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1 text-black">
                                                                            {{dt.jenis}}
                                                                        </h5>
                                                                        <span
                                                                            class="badge bg-info text-white">Ready</span>

                                                                    </div>
                                                                    <div class="row d-flex pt-2">
                                                                        <div class="col-md-12">
                                                                            <img src="<?=base_url('public/assets/images/foodbar.png')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Makanan' && !dt.img">

                                                                            <img src="<?=base_url('public/upload/{{dt.img}}')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Makanan' && dt.img">

                                                                            <img src="<?=base_url('public/assets/images/refreshments.png')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Minuman' && !dt.img">

                                                                            <img src="<?=base_url('public/upload/{{dt.img}}')?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Minuman' && dt.img">
                                                                        </div>
                                                                        <div class="col-md-12 pt-2">
                                                                            <h6>{{dt.nama}}</small>
                                                                                <h5>Rp.{{dt.harga}}</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header bg-info">
                                            <h5 class="text-white">List Daftar Pesanan :</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" style="width:100%"
                                                    id="tb_pesanan">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Cat.</th>
                                                            <th>List</th>
                                                            <th>Harga</th>
                                                            <th>Qty</th>
                                                            <th>Jenis</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_pesanan_body_tambahan">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <button class="btn btn-md btn-primary"
                                                        ng-click="SimpanDataOrderTambahan()">
                                                        <i class="bx bx-save"></i>
                                                        Tambah Pesanan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Tambah Pesanan -->


    <!-- Modal Pembayaran Uang Cash -->
    <div id="my-modal-cash" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_no_booking_cash"></label> | No.Meja
                        <label id="lb_no_meja_cash"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-end">
                            <h4>Subtotal Belanja</h4>
                            <h2 id="lb_total_belanja">Rp.0 </h2>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    Footer
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

</div>

<!-- style -->
<style>
.card-body-scrollable {
    max-height: 700px;
    /* Sesuaikan tinggi maksimum sesuai kebutuhan */
    overflow-y: auto;
}

#card-body-scrollable2 {
    max-height: 400px;
    /* Sesuaikan tinggi maksimum sesuai kebutuhan */
    overflow-y: auto;
}
</style>

<style>
.pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.pagination .page-item {
    display: inline;
}

.pagination .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
}

.pagination .page-link:hover {
    z-index: 2;
    color: #0056b3;
    text-decoration: none;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        display: block;
        width: 100%;
        white-space: nowrap;
    }
}


.modal.modal-right .modal-dialog {
    position: fixed;
    margin: auto;
    width: 100%;
    /* Sesuaikan ukuran modal */
    height: 100%;
    right: 0;
    top: 0;
    bottom: 0;
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
}

.modal.modal-right.show .modal-dialog {
    transform: translateX(0);
}
</style>