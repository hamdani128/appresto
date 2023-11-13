<div ng-app="MasterSdm" ng-controller="MasterSdmController">
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
                            <li class="breadcrumb-item active" aria-current="page">Data SDM</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mt-3 text-uppercase">Informasi Data SDM</h6>
            <hr />

            <div class="card">
                <div class="card-body">
                    <div class="row pb-5">
                        <div class="col-md-12 text-justify-right" style="text-align: right;">
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-edit"></i>
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                    <a class="dropdown-item" href="javascript:;" ng-click="add_data()">Tambah Data</a>
                                    <a class="dropdown-item" href="javascript:;">Import Data</a>
                                    <a class="dropdown-item" href="javascript:;">Download Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-if="isLoading">
                                    <td colspan="6" class="text-center">
                                        <img ng-if="isLoading" src="<?= base_url() ?>public/assets/images/loader.gif"
                                            alt="" style="width: 50px; height: 50px;">
                                    </td>
                                </tr>
                                <tr ng-if="DataLoad.length === 0">
                                    <td colspan="6" class="text-center">
                                        <h6 ng-if="!isLoading">No data available.</h6>
                                    </td>
                                </tr>
                                <tr ng-repeat="dt in DataLoad" ng-if="DataLoad.length > 0">
                                    <td>{{$index + 1}}</td>
                                    <td>{{dt.kd_sdm}}</td>
                                    <td>{{dt.nama}}</td>
                                    <td>{{dt.jk}}</td>
                                    <td>{{dt.jabatan}}</td>
                                    <td>
                                        <span ng-if="dt.status === 'non active'"
                                            class="badge bg-secondary">{{dt.status}}</span>
                                        <span ng-if="dt.status === 'active'"
                                            class="badge bg-primary">{{dt.status}}</span>
                                    </td>

                                    <td>
                                        <div class="input-group">
                                            <button class="btn btn-md btn-danger" ng-click="Deelete(dt)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            <button class="btn btn-md btn-warning" ng-click="ShowEdit(dt)">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button class="btn btn-md btn-dark" ng-click="Activasi(dt)">
                                                <i class="bx bx-street-view"></i>
                                            </button>
                                            <button class="btn btn-md btn-secondary" ng-click="ShowPassword(dt)">
                                                <i class="bx bx-show"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
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
    <div class="modal fade" id="my-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Tambah Data SDM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="" id="form_insert_sdm" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Kode SDM</label>
                                    <input type="text" class="form-control mt-1" name="kode" id="kode"
                                        placeholder="Kode SDM">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" class="form-control mt-1"
                                        placeholder="Nama Lengkap">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Jenis Kelamin</label>
                                    <select name="cmb_jk" id="cmb_jk" class="form-control mt-1">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Jabatan</label>
                                    <select name="cmb_jabatan" id="cmb_jabatan" class="form-control mt-1">
                                        <option value="">-- Pilih --</option>
                                        <option value="Kasir">Kasir</option>
                                        <option value="Kitchen">Kitchen</option>
                                        <option value="Pelayan">Pelayan</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" ng-click="simpan_data_sdm()">
                        <i class="bx bx-save"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Update Data Meja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="" id="form_update_meja" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_update" id="id_update" ng-model="editMeja.id">
                                </div>
                                <div class="form-group">
                                    <label for="">No.Meja</label>
                                    <input type="text" name="no_meja_update" id="no_meja_update" class="form-control"
                                        ng-model="editMeja.no_meja">
                                </div>
                                <div class="form-group pt-2">
                                    <label for="">Nama Meja</label>
                                    <input type="text" name="nama_meja_update" id="nama_meja_update"
                                        class="form-control" ng-model="editMeja.nama_meja">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-warning" onclick="UpdateDataMeja()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>