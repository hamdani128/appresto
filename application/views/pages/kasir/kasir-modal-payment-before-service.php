 <!-- Modal Pembayaran Uang Cash -->
 <div id="my-modal-payment-before-service" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header bg-dark">
                 <h5 class="modal-title text-white">
                     <i class="bx bx-receipt"></i>
                     No.Pesanan <span id="lb_no_booking_payment_before_service"></span>
                     <small class="ms-2">| Meja <span id="lb_no_meja_payment_before_service"></span></small>
                 </h5>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
             </div>

             <div class="modal-body">

                 <!-- SUMMARY -->
                 <div class="card shadow-sm mb-3">
                     <div class="card-body">

                         <div class="row mb-2">
                             <div class="col-6 fw-bold">Total Qty</div>
                             <div class="col-6 text-end fs-5">
                                 <span id="total-qty-payment-before-service">0</span>
                             </div>
                         </div>

                         <div class="row mb-2">
                             <div class="col-6 fw-bold">Subtotal</div>
                             <div class="col-6 text-end fs-5">
                                 <span id="subtotal-payment-before-service">0</span>
                             </div>
                         </div>

                         <div class="row mb-2">
                             <div class="col-6 fw-bold">
                                 Discount (<span id="lb-discount-before-service"></span>%)
                             </div>
                             <div class="col-6 text-end fs-5 text-danger">
                                 <span id="Discount-before-service">0</span>
                             </div>
                         </div>

                         <div class="row mb-2">
                             <div class="col-6 fw-bold">
                                 PPN <span id="ppn-text-payment-before-service"></span>%
                             </div>
                             <div class="col-6 text-end fs-5">
                                 <span id="ppn-payment-before-service">0</span>
                             </div>
                         </div>

                         <hr>

                         <div class="row">
                             <div class="col-6 fw-bold fs-4">Grand Total</div>
                             <div class="col-6 text-end fs-3 fw-bold text-success">
                                 <span id="grand-total-payment-before-service">0</span>
                             </div>
                         </div>

                     </div>
                 </div>

                 <!-- PAYMENT METHOD -->
                 <!-- PAYMENT METHOD -->
                 <div class="card shadow-sm">
                     <div class="card-body">

                         <!-- Metode Pembayaran -->
                         <div class="row">
                             <div class="mb-3">
                                 <label for="combo-payment-before-service" class="form-label fw-bold">Metode
                                     Pembayaran</label>
                                 <select id="combo-payment-before-service" class="form-select form-select-lg"
                                     onchange="changePaymentBeforeService()">
                                     <option value="">Pilih</option>
                                     <option value="Cash">Cash</option>
                                     <option value="QRIS">QRIS</option>
                                     <option value="Bank Transfer">Bank Transfer</option>
                                 </select>
                             </div>
                         </div>

                         <!-- Reference Payment -->
                         <div class="row">
                             <div id="display_reference_payment_before_service" class="mb-3" style="display:none;">
                                 <label for="combo-reference-payment-before-service"
                                     class="form-label fw-bold">Reference
                                     Payment</label>
                                 <select id="combo-reference-payment-before-service" class="form-select form-select-lg"
                                     onchange="changeReferencePaymentBeforeService()">
                                 </select>
                             </div>
                         </div>

                         <!-- Reference Number -->
                         <div class="row">
                             <div id="display_reference_number_payment_before_service" class="mb-3"
                                 style="display:none;">
                                 <label for="reference-number-payment-before-service"
                                     class="form-label fw-bold">Reference Number</label>
                                 <input type="text" id="reference-number-payment-before-service"
                                     class="form-control form-control-lg" placeholder="Masukkan nomor referensi">
                             </div>
                         </div>

                         <!-- Jumlah Dibayar -->
                         <div class="row">
                             <div id="display_jumlah_dibayar_payment_before_service" class="mb-3" style="display:none;">
                                 <label for="jumlah-dibayar-payment-before-service" class="form-label fw-bold">Jumlah
                                     Dibayar</label>
                                 <input type="text" id="jumlah-dibayar-payment-before-service"
                                     class="form-control form-control-lg text-end" placeholder="0">
                             </div>
                         </div>


                         <!-- Kembalian -->
                         <div class="row">
                             <div id="display_kembalian_payment_before_service" class="mb-3" style="display:none;">
                                 <label class="form-label fw-bold">Kembalian</label>
                                 <div class="fs-4 fw-bold text-danger text-end">
                                     <span id="kembalian-payment-before-service">0</span>
                                 </div>
                             </div>
                         </div>



                     </div>
                 </div>


             </div>

             <div class="modal-footer p-0">
                 <button class="btn btn-success w-100 fw-bold" style="height:80px;font-size:22px;"
                     ng-click="PaymentBeforeServiceSubmit()">
                     <i class="bx bx-paper-plane"></i>
                     SUBMIT PAYMENT
                 </button>
             </div>

         </div>
     </div>
 </div>
 <!-- End Modal -->
