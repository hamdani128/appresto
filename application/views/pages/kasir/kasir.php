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
                                    <div class="card bg-primary" ng-if="dt.status === '1'">
                                        <div class="card-body">
                                            <h2 class="card-title text-white">{{dt.no_meja}}</h2>
                                            <p class="card-text text-white">{{dt.nama_meja}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6 for="">No.Booking</h6>
                                        <h6 id="no_booking">-</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <!-- Modal Insert Makanan -->
    <div class="modal fade" id="my-modal-booking" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">No.Pesanan <label id="lb_no_booking"></label></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <button class="btn btn-md btn-success btn-block">
                                            <img src="<?= base_url('public/assets/images/paella_80px.png') ?>"
                                                alt=""><br>
                                            <span>Makanan</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <button class="btn btn-md btn-warning btn-block">
                                            <img src="<?= base_url('public/assets/images/coconut_cocktail_80px.png') ?>"
                                                alt=""><br>
                                            <span>Minuman</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" class="form-control" name="" id=""
                                                    placeholder="Masukkan Data . .">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-md-2">
                                            <div class="card">
                                                <div class="card-body">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> -->
                    <button type="button" class="btn btn-primary" onclick="Simpan_List_DataMakanan()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>