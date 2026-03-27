<!-- Saldo Awal -->
<div id="my-modal-saldo-awal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white">
                    Saldo Awal <?php echo date('Y-m-d'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nominal Saldo :</label>
                            <input type="text" name="saldo_awal_entry" class="form-control mt-2" id="saldo_awal_entry"
                                ng-model="saldo_awal_entry" placeholder="Masukkan nominal"
                                onkeyup="formatInputRupiah(this)">
                        </div>
                        <div class="form-group pt-1">
                            <label for="">Keterangan :</label>
                            <textarea name="keterangan_saldo_awal" id="keterangan_saldo_awal" class="form-control mt-2"
                                ng-model="keterangan_saldo_awal" placeholder="Masukkan keterangan" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-md btn-warning btn-block w-100" ng-click="SubmitSaldoAwal()">
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
