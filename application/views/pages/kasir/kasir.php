<div ng-app="KasirApp" ng-controller="KasirAppController">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 col-lg-8 col-xl-8 d-flex">
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
                <div class="col-12 col-lg-4 col-xl-4 d-flex">
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
                                    <div class="button-group">
                                        <button class="btn btn-lg btn-dark" ng-click="Create_Booking()">
                                            <i class="bx bx-plus"></i>
                                            Booking
                                        </button>
                                        <button class="btn btn-lg btn-secondary">
                                            <i class="bx bx-layer"></i>
                                            Pindah Meja
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-2">
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
                    </div>
                </div>
                <!-- End Order -->
            </div>

            <!-- Lust Pesanan -->
            <div id="card_info_list" style="display: none;">
                <div class="row">
                    <div class="col-5 col-lg-5 col-xl-5">
                        <div class="card radius-10 overflow-hidden w-100">
                            <div class="card-header bg-dark">
                                <h5 class="text-white">
                                    <i class="bx bx-slider-alt"></i>
                                    List Pesanan
                                </h5>
                            </div>
                            <div class="card-body">
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
                                            <tbody id="tb_pesanan_list_body_menu">
                                                <tr ng-repeat="dt in LoadDataPesananList"
                                                    ng-if="LoadDataPesananList.length > 0">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{dt.kategori}}</td>
                                                    <td>{{dt.nama}}</td>
                                                    <td>{{dt.harga}}</td>
                                                    <td>{{dt.qty}}</td>
                                                    <td>{{dt.jenis}}</td>
                                                    <td>
                                                        <div class="button-group">
                                                            <button class="btn btn-md btn-danger">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr ng-if="LoadDataPesananList.length === 0">
                                                    <td colspan="7" class="text-center">No data available</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- jumlah makanan -->
                                <div class="row pt-2">
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

                                <!--.row Nominal  -->
                                <div class="row pt-1">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <button class="btn btn-success btn btn-md btn-block" ng-click="CetakBill()">
                                                <i class="bx bx-printer"></i>
                                                Cetak Bill
                                            </button>
                                            <button class="btn btn-info btn btn-md btn-block" ng-click="payment_cash()">
                                                <i class="bx bx-save"></i>
                                                Payment Cash
                                            </button>
                                            <button class="btn btn-dark btn btn-md btn-block">
                                                <i class="bx bx-qr"></i>
                                                Payment From QR Code
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-7 col-lg-7 col-xl-7">
                        <div class="card radius-10 overflow-hidden w-100">
                            <div class="card-header bg-dark">
                                <h5 class="text-white">
                                    <i class="bx bx-slider-alt"></i>
                                    List Menu Tambahan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
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
                                                            <div class="card-body-scrollable"
                                                                id="card-body-scrollable2">
                                                                <div class="list-group" ng-repeat="dt in filteredMenu"
                                                                    ng-if="filteredMenu.length > 0">
                                                                    <a href="javascript:;"
                                                                        ng-click="PilihMenuTambahan(dt)"
                                                                        class="list-group-item list-group-item-action"
                                                                        aria-current="true">
                                                                        <div
                                                                            class="d-flex w-100 justify-content-between">
                                                                            <h5 class="mb-1 text-black">
                                                                                {{dt.jenis}}
                                                                            </h5>
                                                                            <span
                                                                                class="badge bg-info text-white">Ready</span>

                                                                        </div>
                                                                        <div class="row d-flex">
                                                                            <div class="col-md-4">
                                                                                <img src="<?= base_url('public/assets/images/foodbar.png') ?>"
                                                                                    alt=""
                                                                                    style="width: 150px;height: 100px;"
                                                                                    ng-if="dt.jenis=='Makanan' && !dt.img">

                                                                                <img src="<?= base_url('public/upload/{{dt.img}}') ?>"
                                                                                    alt=""
                                                                                    style="width: 150px;height: 100px;"
                                                                                    ng-if="dt.jenis=='Makanan' && dt.img">

                                                                                <img src="<?= base_url('public/assets/images/refreshments.png') ?>"
                                                                                    alt=""
                                                                                    style="width: 150px;height: 100px;"
                                                                                    ng-if="dt.jenis=='Minuman' && !dt.img">

                                                                                <img src="<?= base_url('public/upload/{{dt.img}}') ?>"
                                                                                    alt=""
                                                                                    style="width: 150px;height: 100px;"
                                                                                    ng-if="dt.jenis=='Minuman' && dt.img">
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <h4>{{dt.nama}}</small>
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

                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="card">
                                                        <div class="card-header bg-info">
                                                            <h5 class="text-white">List Daftar Pesanan :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered"
                                                                    style="width:100%" id="tb_pesanan">
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
                </div>
            </div>

            <!-- End List Pesanan -->
        </div>
    </div>




    <!-- Modal Insert Makanan -->
    <div class="modal fade" id="my-modal-booking" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
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
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body-scrollable">
                                                            <div class="list-group" ng-repeat="dt in filteredMenu"
                                                                ng-if="filteredMenu.length > 0">
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
                                                                        <div class="col-md-4">
                                                                            <img src="<?= base_url('public/assets/images/foodbar.png') ?>"
                                                                                alt=""
                                                                                style="width: 150px;height: 100px;"
                                                                                ng-if="dt.jenis=='Makanan' && !dt.img">

                                                                            <img src="<?= base_url('public/upload/{{dt.img}}') ?>"
                                                                                alt=""
                                                                                style="width: 150px;height: 100px;"
                                                                                ng-if="dt.jenis=='Makanan' && dt.img">

                                                                            <img src="<?= base_url('public/assets/images/refreshments.png') ?>"
                                                                                alt=""
                                                                                style="width: 150px;height: 100px;"
                                                                                ng-if="dt.jenis=='Minuman' && !dt.img">

                                                                            <img src="<?= base_url('public/upload/{{dt.img}}') ?>"
                                                                                alt=""
                                                                                style="width: 150px;height: 100px;"
                                                                                ng-if="dt.jenis=='Minuman' && dt.img">
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <h4>{{dt.nama}}</small>
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