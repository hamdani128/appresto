<!-- Cancel Order Modal -->
<div id="my-modal-cancel-order" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">
                    Cancel Order
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2 small text-muted">
                    No Pesanan :
                    <strong>{{cancel.no_booking}}</strong><br>
                    No Meja :
                    <strong>{{cancel.no_meja}}</strong>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Alasan Pembatalan</label>
                    <textarea class="form-control" rows="2" ng-model="cancel.reason"
                        placeholder="Masukkan alasan pembatalan" required></textarea>
                </div>
                <!-- Password Super Admin -->
                <div class="mb-3">
                    <label class="form-label">Password Super Admin</label>
                    <input type="password" class="form-control" ng-model="cancel.password"
                        placeholder="Masukkan password" required>
                </div>

                <!-- Error Message -->
                <div class="alert alert-danger py-2" ng-if="cancel.error">
                    {{cancel.error}}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger w-100" ng-click="submitCancelOrder()" ng-disabled="cancel.loading">
                    <span ng-if="!cancel.loading">
                        <i class="fa fa-paper-plane"></i> Submit Cancel
                    </span>
                    <span ng-if="cancel.loading">
                        <i class="fa fa-spinner fa-spin"></i> Processing...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Bill Modal -->
