<div ng-app="MitraApp" ng-controller="MitraAppController">

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
                            <li class="breadcrumb-item active" aria-current="page">Data Mitra</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Informasi Data Mitra</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="row pb-5">
                        <div class="col-md-12 text-justify-right" style="text-align: right;">
                            <div class="button-group">
                                <button type="button"
                                    class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-edit"></i>
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                    <a class="dropdown-item" ng-click="AddModal()">Tambah Data</a>
                                    <a class="dropdown-item" href="javascript:;">Import Data</a>
                                    <a class="dropdown-item" href="javascript:;">Download Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-bordered"
                            style="width:100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Mitra</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>HP</th>
                                    <th>Status Account</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="dt in Makanan" ng-if="Makanan.length > 0">
                                    <td>{{$index + 1}}</td>
                                    <td>{{dt.kode}}</td>
                                    <td>{{dt.nama}}</td>
                                    <td>{{dt.alamat}}</td>
                                    <td>{{dt.email}}</td>
                                    <td>{{dt.hp}}</td>
                                    <td>
                                        <span class="badge bg-success" ng-if="dt.status_account == 1">Aktif</span>
                                        <span class="badge bg-warning" ng-if="dt.status_account == 0">Non Aktif</span>
                                    </td>
                                </tr>
                                <tr ng-if="Makanan.length === 0">
                                    <td colspan="8">No data available</td>
                                </tr>
                            </tbody>
                        </table>
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
                    <h5 class="modal-title text-white">Tambah Data Mitra</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form_insert_makanan">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Nama Mitra</label>
                                    <input type="text" name="nama" id="nama" class="form-control mt-1"
                                        placeholder="Masukkan Nama Mitra">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Alamat Mitra</label>
                                    <textarea name="alamat" id="alamat" class="form-control mt-1"
                                        placeholder="Masukkan Alamat Mitra"></textarea>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">E-mail Mitra</label>
                                    <input type="email" name="email" id="email" class="form-control mt-1"
                                        placeholder="Masukkan Email Mitra">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">No.HP/WA</label>
                                    <input type="text" name="hp" id="hp" class="form-control mt-1"
                                        placeholder="Masukkan No.HP/WA">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-primary" ng-click="insert()">
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
                    <h5 class="modal-title text-white">Edit Data Mitra</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_update" id="id_update" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Kode Mitra</label>
                                    <input type="text" name="kode_edit" id="kode_edit" class="form-control mt-1"
                                        placeholder="Masukkan Nama Mitra" readonly disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Mitra</label>
                                    <input type="text" name="nama_edit" id="nama_edit" class="form-control mt-1"
                                        placeholder="Masukkan Nama Mitra">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Alamat Mitra</label>
                                    <textarea name="alamat_edit" id="alamat_edit" class="form-control mt-1"
                                        placeholder="Masukkan Alamat Mitra"></textarea>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">E-mail Mitra</label>
                                    <input type="email" name="email_edit" id="email_edit" class="form-control mt-1"
                                        placeholder="Masukkan Email Mitra">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">No.HP/WA</label>
                                    <input type="text" name="hp_edit" id="hp_edit" class="form-control mt-1"
                                        placeholder="Masukkan No.HP/WA">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-warning" ng-click="update()">
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
