<div id="my-modal-print-order-only" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Print Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3 text-muted">Pilih copy order yang ingin dicetak tanpa harga.</p>
                <div class="row g-2">
                    <div class="col-12 col-sm-6">
                        <button class="btn kasir-action-button kasir-action-button-print w-100"
                            ng-click="PrintOrderOnlyByBluetooth('CUSTOMER / MEJA')">
                            <i class="bx bx-bluetooth"></i>
                            <span class="kasir-button-title">Meja Customer</span>
                        </button>
                    </div>
                    <div class="col-12 col-sm-6">
                        <button class="btn kasir-action-button kasir-action-button-print w-100"
                            ng-click="PrintOrderOnlyByBluetooth('DAPUR')">
                            <i class="bx bx-bluetooth"></i>
                            <span class="kasir-button-title">Dapur</span>
                        </button>
                    </div>
                    <div class="col-12 col-sm-6">
                        <button class="btn kasir-action-button kasir-action-button-pay w-100"
                            ng-click="PrintOrderOnlyByUSB('CUSTOMER / MEJA')">
                            <i class="bx bx-printer"></i>
                            <span class="kasir-button-title">USB Meja</span>
                        </button>
                    </div>
                    <div class="col-12 col-sm-6">
                        <button class="btn kasir-action-button kasir-action-button-pay w-100"
                            ng-click="PrintOrderOnlyByUSB('DAPUR')">
                            <i class="bx bx-printer"></i>
                            <span class="kasir-button-title">USB Dapur</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
