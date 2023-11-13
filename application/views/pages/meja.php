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
                        <li class="breadcrumb-item active" aria-current="page">Data Meja</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <!-- <div class="btn-group">
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                        <i class="bx bx-edit"></i>
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <a class="dropdown-item" href="javascript:;" onclick="add_makanan()">Tambah Data</a>
                        <a class="dropdown-item" href="javascript:;">Import Data</a>
                        <a class="dropdown-item" href="javascript:;">Download Data</a>
                    </div>
                </div> -->
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mt-3 text-uppercase">Informasi Data Meja</h6>
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
                                <a class="dropdown-item" href="javascript:;" onclick="add_meja()">Tambah Data</a>
                                <a class="dropdown-item" href="javascript:;">Import Data</a>
                                <a class="dropdown-item" href="javascript:;">Download Data</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tb_meja" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Meja</th>
                                <th>Nama Meja</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody ng-app="master" ng-controller="meja">
                            <tr ng-repeat="meja in mejaData" ng-if="mejaData.length > 0">
                                <td>{{$index + 1}}</td>
                                <td>{{meja.no_meja}}</td>
                                <td>{{meja.nama_meja}}</td>
                                <td>
                                    <div class="input-group">
                                        <button class="btn btn-md btn-warning" ng-click="show_edit(meja)">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn btn-md btn-danger" ng-click="delete(meja)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr ng-if="mejaData.length === 0">
                                <td colspan="4">No data available</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>No Meja</th>
                                <th>Nama Meja</th>
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
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Meja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="" id="form_insert_meja" enctype="multipart/form-data">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="">No.Meja</label>
                                <input type="text" name="no_meja" id="no_meja" class="form-control"
                                    placeholder="No Meja">
                            </div>
                            <div class="form-group pt-2">
                                <label for="">Nama Meja</label>
                                <input type="text" name="nama_meja" id="nama_meja" class="form-control"
                                    placeholder="Nama Meja">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> -->
                <button type="button" class="btn btn-primary" onclick="simpan_data_meja()">Simpan</button>
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
                                <input type="text" name="nama_meja_update" id="nama_meja_update" class="form-control"
                                    ng-model="editMeja.nama_meja">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> -->
                <button type="button" class="btn btn-warning" onclick="UpdateDataMeja()">Update</button>
            </div>
        </div>
    </div>
</div>