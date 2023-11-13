<div ng-app="CombineMakanan">

    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Master</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Makanan</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Informasi Data Minuman</h6>
            <hr />
            <div class="card" ng-module="appminuman" ng-controller="ControllerMinuman">
                <div class="card-body">
                    <div class="row pb-5">
                        <div class="col-md-12 text-justify-right" style="text-align: right;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark" onclick="show_kategori()">
                                    <i class="bx bx-folder"></i>
                                    Kategori Minuman
                                </button>
                                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                    <i class="bx bx-edit"></i>
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                    <a class="dropdown-item" onclick="add_mainuman()">Tambah Data</a>
                                    <a class="dropdown-item" href="javascript:;">Import Data</a>
                                    <a class="dropdown-item" href="javascript:;">Download Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Nama Minuman</th>
                                    <th>Harga Jual</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr ng-repeat="dt in Makanan" ng-if="Makanan.length > 0">
                                    <td>{{$index + 1}}</td>
                                    <td>{{dt.kategori}}</td>
                                    <td>{{dt.nama}}</td>s
                                    <td>{{dt.harga}}</td>
                                    <td>{{dt.owner}}</td>
                                    <td>
                                        <div class="input-group">
                                            <button class="btn btn-md btn-danger" ng-click="DeleteMakanan(dt)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            <button class="btn btn-md btn-warning" ng-click="ShowEditMakanan(dt)">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr ng-if="Makanan.length === 0">
                                    <td colspan="6">No data available</td>
                                </tr> -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Nama Minuman</th>
                                    <th>Harga Jual</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal app -->
    <div class="modal fade" id="my-modal-kategori" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Informasi Kategori Makanan</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="pill" href="#dark-pills-home" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon">
                                        <i class='bx bx-table font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Info</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="pill" href="#dark-pills-profile" role="tab" aria-selected="false">
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
                    <div class="tab-content" id="pills-tabContent" ng-module="makanan" ng-controller="ControllerCategoryMakanan">
                        <div class="tab-pane fade show active" id="dark-pills-home" role="tabpanel">
                            <div class="table-responsive">
                                <table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-bordered" style="width:100%">
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
                                            <textarea name="kategori" id="kategori" cols="5" rows="5" class="form-control pt-2" placeholder="Masukkan Kategori" ng-model="newKategori"></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-md btn-primary" ng-click="insertKategori()">
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

    <!-- modal add Makanan -->
    <div class="modal fade" id="my-modal-add" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Tambah Data Makanan</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form_insert_makanan">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Kategori Makanan</label>
                                    <select name="cmb_kategori" id="cmb_kategori" class="form-control mt-1">
                                        <option value="">Pilih Kategori</option>
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Nama Makanan</label>
                                    <input type="text" name="nama" id="nama" class="form-control mt-1" placeholder="Masukkan Nama Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Harga Makanan</label>
                                    <input type="number" name="harga" id="harga" class="form-control mt-1" placeholder="Masukkan Harga Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Owner</label>
                                    <select class="form-control mt-1" name="cmb_owner" id="cmb_owner">
                                        <option value="">Pilih Owner</option>
                                        <option value="Owner">Owner</option>
                                        <option value="Mitra">Mitra</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-primary" onclick="insert_makanan()">
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
                    <h5 class="modal-title text-white">Edit Data Makanan</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form_update_makanan">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_update" id="id_update" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori Makanan</label>
                                    <select name="cmb_kategori_update" id="cmb_kategori_update" class="form-control mt-1">
                                        <option value="">Pilih Kategori</option>
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Nama Makanan</label>
                                    <input type="text" name="nama_update" id="nama_update" class="form-control mt-1" placeholder="Masukkan Nama Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Harga Makanan</label>
                                    <input type="number" name="harga_update" id="harga_update" class="form-control mt-1" placeholder="Masukkan Harga Makanan">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Owner</label>
                                    <select class="form-control mt-1" name="cmb_owner_update" id="cmb_owner_update">
                                        <option value="">Pilih Owner</option>
                                        <option value="Owner">Owner</option>
                                        <option value="Mitra">Mitra</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-warning" onclick="update_makanan()">
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