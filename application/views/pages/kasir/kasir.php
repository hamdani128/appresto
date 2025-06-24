<div ng-app="KasirApp" ng-controller="KasirAppController">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-dark">
                            <h5 class="text-white">List Table</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2" ng-repeat="dt in LoadData" ng-if="LoadData.length > 0">
                                    <div class="card bg-secondary" id="bg_{{$index}}" ng-if="dt.status === '0'"
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
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card radius-10 overflow-hidden w-100">
                        <div class="card-header bg-dark">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-white">
                                        <i class="bx bx-slider-alt"></i>
                                        Operation Tools
                                    </h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-md btn-light" id="btn_refresh" ng-click="BackToHome()">
                                        <i class="bx bx-home"></i>
                                        Home
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" id="table_row_order" style="display: block;">
                                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="table-responsive">
                                        <table datatable="ng" dt-options="vm.dtOptions"
                                            class="table table-striped table-bordered" style="width:100%">
                                            <thead class="bg-dark text-white text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Transaction</th>
                                                    <th>Metode</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
                                                    <th>#Act</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="dt in LoadDataTransaksi"
                                                    ng-if="LoadDataTransaksi.length > 0">
                                                    <td style="text-align: center;">{{$index + 1}}</td>
                                                    <td>
                                                        <span>Inv.Code : {{dt.no_transaksi}}</span><br>
                                                        <span>Order No : {{dt.no_order}}</span><br>
                                                        <span>No.Table : {{dt.no_meja}}</span>
                                                    </td>
                                                    <td>{{dt.metode}}</td>
                                                    <td>{{dt.created_at}}</td>
                                                    <td>
                                                        <span class="badge bg-success">
                                                            Complete
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="button-group">
                                                            <button class="btn btn-sm btn-dark">
                                                                <i class="bx bx-printer"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr ng-if="LoadDataTransaksi.length === 0">
                                                    <td colspan="6">No data available</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-md btn-danger flex-fill" id="btn_pindah_meja"
                                            style="display: none;flex: 1;" ng-click="PindahMeja()">
                                            <i class="bx bx-layer"></i>
                                            Pindah
                                        </button>
                                        <button class="btn btn-md btn-dark flex-fill" id="btn_gabung_bill"
                                            style="display: none;flex: 1;" ng-click="GabungBill()">
                                            <i class="bx bx-layer"></i>
                                            Gabung Bill
                                        </button>
                                        <button class="btn btn-md btn-primary flex-fill" id="btn_tambah_pesanan"
                                            style="display: none;flex: 2;" ng-click="TambahPesanan()">
                                            <i class="bx bx-edit"></i>
                                            Tambah Pesanan
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
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-success btn btn-md btn-block w-30 h-30"
                                                    ng-click="CetakBill()" style="height: 100px;flex: 1;">
                                                    <i class="bx bx-printer"></i>
                                                    Cetak Bill
                                                </button>
                                                <button class="btn btn-info btn btn-md btn-block w-30 h-30"
                                                    ng-click="pay_after_service()" style="height: 100px;flex: 1;">
                                                    <i class="bx bx-save"></i>
                                                    Pay after service
                                                </button>
                                                <button class="btn btn-dark btn btn-md btn-block w-30 h-30"
                                                    ng-click="pay_before_service()" style="height: 100px;flex: 1;">
                                                    <i class="bx bx-save"></i>
                                                    Pay Before Service
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

                                                                        <span class="badge bg-info text-white"
                                                                            ng-if="dt.status_food == '1'">
                                                                            Ready
                                                                        </span>
                                                                        <span class="badge bg-danger text-white"
                                                                            ng-if="dt.status_food == '0'">
                                                                            Close
                                                                        </span>

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
                                                <thead class="bg-dark text-white">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Cat.</th>
                                                        <th>List</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Jenis</th>
                                                        <th>Owner</th>
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
                                                                        <span class="badge bg-info text-white"
                                                                            ng-if="dt.status_food == '1'">
                                                                            Ready
                                                                        </span>
                                                                        <span class="badge bg-danger text-white"
                                                                            ng-if="dt.status_food == '0'">
                                                                            Close
                                                                        </span>

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
                                                    <thead class="bg-dark text-white">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Cat.</th>
                                                            <th>List</th>
                                                            <th>Harga</th>
                                                            <th>Qty</th>
                                                            <th>Jenis</th>
                                                            <th>Owner</th>
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
                <!-- <div class="modal-footer">
                    Footer
                </div> -->
            </div>
        </div>
    </div>
    <!-- End List Pesanan Detail -->

    <!-- Pindah Meja -->
    <div id="my-modal-pindah-meja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_no_booking_pindah_meja"></label> |
                        No.Meja
                        <label id="lb_no_meja_pindah_meja"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-grou">
                                <label for="">Tujuan No.Meja Pindah :</label>
                                <select class="form-control" id="combo_pindah_meja"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-md btn-danger btn-block w-100" ng-click="PindahMejaSubmit()">
                                <i class="bx bx-paper-plane"></i>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Pindah Meja -->

    <!-- Modal Pembayaran Uang Cash -->
    <div id="my-modal-payment-before-service" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">No.Pesanan <label
                            id="lb_no_booking_payment_before_service"></label> | No.Meja
                        <label id="lb_no_meja_payment_before_service"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" style="width:100%"
                                id="tb_payment_before_service">
                                <tfoot>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">Total Qty : </label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="" id="total-qty-payment-before-service">0</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">Subtotal : </label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="" id="subtotal-payment-before-service">0</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">
                                                PPN
                                                <label for="" id="ppn-text-payment-before-service">
                                                </label>% :
                                            </label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="" id="ppn-payment-before-service">0</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">Grand Total : </label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="" id="grand-total-payment-before-service">0</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">Metode Payment :</label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <div
                                                style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                <select id="combo-payment-before-service" class="form-control"
                                                    style="width: 100%;font-size: 20px;"
                                                    onchange="changePaymentBeforeService()">
                                                    <option value="">Pilih :</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="QRIS">QRIS</option>
                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="display_jumlah_dibayar_payment_before_service" style="display: none;">
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">Jumlah Dibayar :</label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <div
                                                style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                <input type="text" name="jumlah-dibayar-payment-before-service"
                                                    id="jumlah-dibayar-payment-before-service" class=" form-control"
                                                    style="text-align: right;width:
                                                100%;font-size: 20px;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="display_kembalian_payment_before_service" style="display: none;">
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">kembalian : </label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="" id="kembalian-payment-before-service">0</label>
                                        </td>
                                    </tr>
                                    <tr id="display_reference_payment_before_service" style="display: none;">
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">Reference Payment :</label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <div
                                                style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                <select id="combo-reference-payment-before-service" class="form-control"
                                                    style="width: 100%;font-size: 20px;"
                                                    onchange="changeReferencePaymentBeforeService()">
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="display_reference_number_payment_before_service" style="display: none;">
                                        <td colspan="2"
                                            style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <label for="">Reference Number :</label>
                                        </td>
                                        <td colspan="6"
                                            style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            <div
                                                style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                <input type="text" name="reference-number-payment-before-service"
                                                    id="reference-number-payment-before-service" class=" form-control"
                                                    style="text-align: right;width:
                                                100%;">
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">c
                    <button class="btn btn-md btn-success" style="width: 100%;height: 80px;"
                        ng-click="PaymentBeforeServiceSubmit()">
                        <i class="bx bx-paper-plane"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

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
                    <div id="printArea">

                        <div class="text-center bold" style="font-size: 14px;margin-top: 0px;">
                            <img src="<?=base_url()?>public/assets/images/millennialpos.png" alt="">
                            <h5>ROEMAH PREMIUM KOPI</h5>
                        </div>
                        <div class="text-center" class="sub-title">
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
                    <button class="btn btn-success" onclick="printCard('printArea')">Print</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bill Modal -->

    <!-- Modal Gabung Bill -->
    <div id="my-modal-gabung-bill" class="modal fade modal-right" tabindex="-1" role="dialog"
        aria-labelledby="my-modal-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        Bill Gabung
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9 col-md-9 col-sm-9 col-lg-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">No.Meja Digabung :</label>
                                                <select class="form-control" ng-model="cmb_gabung"
                                                    ng-options="meja.no_meja as (meja.no_meja + ' (' + meja.nama_meja + ')') for meja in listMejaGabung"
                                                    ng-change="GabungListMeja()">
                                                    <option value="">Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">List Item : </label>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" style="width:130%"
                                                    id="tb_pesanan_list_detail">
                                                    <thead class="bg-dark text-white">
                                                        <tr>
                                                            <th>#</th>
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
                                                    <tbody id="td_pesanan_body_gabung_bill">
                                                        <tr ng-repeat="dt in (LoadDataPesananDetail.concat(LoadDataPesananGabungSementara))"
                                                            ng-if="LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length > 0">
                                                            <td>{{$index + 1}}</td>
                                                            <td>{{dt.no_order}}</td>
                                                            <td>{{dt.no_meja}}</td>
                                                            <td>{{dt.kategori}}</td>
                                                            <td>{{dt.nama}}</td>
                                                            <td>{{dt.harga}}</td>
                                                            <td>{{dt.qty}}</td>
                                                            <td>{{dt.qty * dt.harga}}</td>
                                                            <td>{{dt.jenis}}</td>
                                                            <td>{{dt.owner}}</td>
                                                            <td>{{dt.created_at}}</td>
                                                        </tr>
                                                        <tr
                                                            ng-if="LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length === 0">
                                                            <td colspan="11" class="text-center">No data available</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot style="border: 1px solid #dee2e6;">
                                                        <tr>
                                                            <td colspan="7"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Total Qty : </label>
                                                            </td>
                                                            <td colspan="4"
                                                                style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="qty-total-gabung" id="qty-total-gabung"
                                                                    style="text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Subtotal : </label>
                                                            </td>
                                                            <td colspan="4"
                                                                style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="amount-total-gabung" id="amount-total-gabung"
                                                                    style="text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <div
                                                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">

                                                                    <select id="ppn-select-gabung" class="form-control"
                                                                        style="width: 100px;"
                                                                        ng-change="CalculateTotalForGabung()"
                                                                        ng-model="ppnValue">
                                                                        <option value="">Pilih PPN :</option>
                                                                        <option value="10">10%</option>
                                                                        <option value="11">11%</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td colspan="11"
                                                                style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="amount-ppn-gabung" id="amount-ppn-gabung""
                                                                    style=" text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Grand Total : </label>
                                                            </td>
                                                            <td colspan="11"
                                                                style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="grand-total-gabung" id="grand-total-gabung"
                                                                    style="text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-end">
                                            <button class="btn btn-md btn-warning btn-md"
                                                ng-click="ResetGabungPesanan()" style="flex: 1;">
                                                <i class="bx bx-refresh"></i>
                                                Clear
                                            </button>
                                            <button class="btn btn-success btn btn-md" style="flex: 1;"
                                                onclick="printCard('printArea2')">
                                                <i class="bx bx-printer"></i> Cetak Bill
                                            </button>

                                            <button class="btn btn-info btn btn-md" ng-click="pay_after_service()"
                                                style="flex: 1;">
                                                <i class="bx bx-save"></i>
                                                Pay after service
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Bill -->
                        <div class="col-3 col-md-3 col-sm-3 col-lg-3">
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
                                                    <td><span id="bill_date_gabungan"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kasir
                                                    </td>
                                                    <td>:</td>
                                                    <td><span id="bill_chasier_gabungan"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        No.order
                                                    </td>
                                                    <td>:</td>
                                                    <td><span id="bill_no_order_gabungan"></span></td>
                                                </tr>
                                            </table>

                                        </div>
                                        <hr>
                                        <div style="padding-left: 18px;">
                                            <!-- Barang -->
                                            <table style="width: 100%; font-size: 13px;">
                                                <tbody ng-repeat="group in groupedOrders">
                                                    <tr class="fw-bold">
                                                        <td colspan="3" style="padding-top: 6px; padding-bottom: 2px;">
                                                            Table: {{ group.no_meja }}
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
                                                    <td style="width: 20%;"></td>
                                                    <td style="width: 80%;">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td>Qty</td>
                                                                <td style="width: 10px;">:</td>
                                                                <td style="text-align: center;" id="bill_qty_gabungan">0
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Subtotal</td>
                                                                <td style="width: 10px;">:</td>
                                                                <td style="text-align: right;"
                                                                    id="bill_subtotal_gabungan">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>PPN (10%)</td>
                                                                <td>:</td>
                                                                <td style="text-align: right;" id="bill_ppn_gabungan">0
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grand Total</td>
                                                                <td>:</td>
                                                                <td style="text-align: right;"
                                                                    id="bill_grand_total_gabungan">0
                                                                </td>
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
                            </div>
                        </div>
                        <!-- End bill -->
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Gabung -->

</div>

<script>
function formatItem(name, qty, price) {
    const left = name.padEnd(16);
    const right = (qty + "x" + price).padStart(14);
    return left + right;
}
</script>

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

<style>
@media print {
    body * {
        visibility: hidden;
    }

    #printArea,
    #printArea * {
        visibility: visible;
    }

    #printArea {
        position: absolute;
        left: 0;
        top: 00px;
        width: 280px;
        /* Sesuaikan ukuran kertas printer */
        font-family: Arial, Helvetica, sans-serif, monospace;
        font-size: 12px;
        margin: 0;
        padding: 0;
        margin-top: -80px;
    }

    @page {
        size: auto;
        /* Biarkan browser menyesuaikan tinggi sesuai isi */
        margin: 0;
        /* Hilangkan margin default browser */
    }

    .text-center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    hr {
        border: none;
        border-top: 5px dashed #000;
        margin: 4px 0;
        color: #000;
    }

    .total-line {
        font-weight: bold;
        font-size: 13px;
        padding-left: 10px;
    }
}
</style>