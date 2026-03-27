<!-- Tarik Uang -->
<div id="my-modal-tarik-uang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    Tarik Uang <?php echo date('Y-m-d'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nominal Penarikan :</label>
                            <input type="text" name="saldo_tarik_uang" class="form-control mt-2" id="saldo_tarik_uang"
                                ng-model="saldo_tarik_uang" placeholder="Masukkan nominal"
                                onkeyup="formatInputRupiah(this)">
                        </div>
                        <div class="form-group pt-1">
                            <label for="">Keterangan :</label>
                            <textarea name="keterangan_tarik_uang" id="keterangan_tarik_uang" class="form-control mt-2"
                                ng-model="keterangan_tarik_uang" placeholder="Masukkan keterangan" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="button-group">
                            <button class="btn btn-md btn-danger " ng-click="SubmitPenarikan()">
                                <i class="bx bx-paper-plane"></i>
                                Submit
                            </button>
                            <!-- <button class="btn btn-md btn-dark  " ng-click="OpenCashDrawerPenarikan()">
                                <i class="bx bx-open"></i>
                                open cash drawer
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Tarik Uang -->
