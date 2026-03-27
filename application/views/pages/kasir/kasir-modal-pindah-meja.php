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
