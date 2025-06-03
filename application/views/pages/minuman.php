<div ng-app="CombineMinuman">

    <div class="page-wrapper" ng-module="appminuman" ng-controller="ControllerMinuman">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Master</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Minuman</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Informasi Data Minuman</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="row pb-5">
                        <div class="col-md-12 text-justify-right" style="text-align: right;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark" ng-click="show_kategori_minuman()">
                                    <i class="bx bx-folder"></i>
                                    Kategori Minuman
                                </button>
                                <button type="button"
                                    class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-edit"></i>
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                    <a class="dropdown-item" ng-click="add_minuman()">Tambah Data</a>
                                    <a class="dropdown-item" href="javascript:;">Ready All Status Food</a>
                                    <a class="dropdown-item" href="javascript:;">Not Ready All Status Food</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-bordered"
                            style="width:100%" id="dtMinumanTable">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Nama Minuman</th>
                                    <th>Harga Jual</th>
                                    <th>Image</th>
                                    <th>Owner/Mitra</th>
                                    <th>Status Food</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="da in MinumanData" ng-if="MinumanData.length > 0">
                                    <td>{{$index + 1}}</td>
                                    <td>{{da.kategori}}</td>
                                    <td>{{da.nama}}</td>
                                    <td>{{da.harga}}</td>
                                    <td style="text-align: center;">
                                        <img style="height: 80px;width: 100px;"
                                            ng-src="{{da.img ? '<?=base_url("public/upload/")?>' + da.img : '<?=base_url("public/assets/images/refreshments.png")?>'}}"
                                            alt="">
                                    </td>
                                    <td>
                                        <div ng-if="da.name_owner == 'Owner'">
                                            <p>Owner</p>
                                        </div>
                                        <div ng-if="da.name_owner !== 'Owner'">
                                            <p>{{da.owner}}</p>
                                            <p>{{da.name_owner}}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div ng-if="da.status == '1'">
                                            <span class="badge bg-success">
                                                Ready
                                            </span>
                                        </div>
                                        <div ng-if="da.status == '0'">
                                            <span class="badge bg-danger">
                                                Not Ready
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <button class="btn btn-md btn-danger" ng-click="DeleteMinuman(da)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            <button class="btn btn-md btn-warning" ng-click="ShowEditMinuman(da)">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button class="btn btn-md btn-info" ng-if="da.status=='0'"
                                                ng-click="ReadyOpen(da)">
                                                <i class="bx bx-book-open"></i>
                                            </button>
                                            <button class="btn btn-md btn-dark" ng-if="da.status=='1'"
                                                ng-click="ReadyClose(da)">
                                                <i class="bx bx-book"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr ng-if="MinumanData.length === 0">
                                    <td colspan="6">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal app Kategori-->
    <div class="modal fade" id="my-modal-kategori" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Informasi Kategori Minuman</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div ng-module="KategoriMinuman" ng-controller="ControllerKategoriMinuman">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="pill" href="#dark-pills-home" role="tab"
                                    aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                            <i class='bx bx-table font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Info</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="pill" href="#dark-pills-profile" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                            <i class='bx bx-edit font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Form</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="dark-pills-home" role="tabpanel">
                                <div class="table-responsive">
                                    <table datatable="ng" dt-options="vm.dtOptions"
                                        class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kategori</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="pos in post" ng-if="post.length > 0">
                                                <td>{{$index + 1}}</td>
                                                <td>{{pos.kategori}}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <button class="btn btn-md btn-danger" ng-click="delete(pos)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr ng-if="post.length === 0">
                                                <td colspan="3" class="text-center">No data available</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Kategori</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="dark-pills-profile" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="">
                                            <div class="form-group">
                                                <label for="">Kategori</label>
                                                <textarea name="kategori" id="kategori" cols="5" rows="5"
                                                    class="form-control pt-2" placeholder="Masukkan Kategori"
                                                    ng-model="newKategori"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-md btn-primary"
                                            ng-click="insertKategori()">
                                            <i class="bx bx-plus"></i>
                                            Submit
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

    <!-- modal add Makanan -->
    <div class="modal fade" id="my-modal-add" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Tambah Data Minuman</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form_insert_minuman">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="cmb_kategori" id="cmb_kategori" class="form-control mt-1">
                                        <option value="">Pilih Kategori</option>
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Nama Minuman</label>
                                    <input type="text" name="nama" id="nama" class="form-control mt-1"
                                        placeholder="Masukkan Nama Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Harga Jual</label>
                                    <input type="number" name="harga" id="harga" class="form-control mt-1"
                                        placeholder="Masukkan Harga Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Ambil Gambar :</label>
                                    <input type="file" class="form-control" id="file_img" name="file_img"
                                        onchange="displayImage()">
                                    <div class="pt-2" id="display_img"></div>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Owner</label>
                                    <select class="form-control mt-1" name="cmb_owner" id="cmb_owner">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-primary" onclick="insert_minuman()">
                                <i class="bx bx-plus"></i>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal Edit Makanan -->
    <div class="modal fade" id="my-modal-show-edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Edit Data Minuman</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form_update_minuman">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_update" id="id_update" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori Makanan</label>
                                    <select name="cmb_kategori_update" id="cmb_kategori_update"
                                        class="form-control mt-1">
                                        <option value="">Pilih Kategori</option>
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Nama Makanan</label>
                                    <input type="text" name="nama_update" id="nama_update" class="form-control mt-1"
                                        placeholder="Masukkan Nama Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Harga Makanan</label>
                                    <input type="number" name="harga_update" id="harga_update" class="form-control mt-1"
                                        placeholder="Masukkan Harga Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Edit Gambar (Jika Diperlukan) :</label>
                                    <input type="file" class="form-control" id="file_img_update" name="file_img_update"
                                        onchange="displayImageUpdate()">
                                    <div class="pt-2" id="display_img_edit"></div>
                                </div>
                                <div class="form-group pt-2">W
                                    <label for="">Owner</label>
                                    <select class="form-control mt-1" name="cmb_owner_update" id="cmb_owner_update">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-warning" onclick="updateMinuman()">
                                <i class="bx bx-edit"></i>
                                Update
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>