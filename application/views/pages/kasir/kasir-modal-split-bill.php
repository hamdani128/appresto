 <!-- Modal Split Bill -->
 <div id="my-modal-split-bill" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
         <div class="modal-content">
             <div class="modal-header bg-primary text-white">
                 <div>
                     <h5 class="mb-0 text-white">
                         Split Bill
                     </h5>
                     <small>
                         Order <b id="lb_no_booking_split_bill"></b> |
                         Meja <b id="lb_no_meja_split_bill"></b>
                     </small>
                 </div>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
             </div>

             <div class="modal-body">
                 <div class="row g-3">

                     <!-- BILL ASLI -->
                     <div class="col-lg-6">
                         <div class="card h-100 shadow-sm">
                             <div class="card-header bg-dark text-white">
                                 Bill Asli
                             </div>
                             <div class="card-body p-0">
                                 <div class="table-responsive">
                                     <table class="table table-sm table-striped mb-0">
                                         <thead class="table-dark">
                                             <tr>
                                                 <th>#</th>
                                                 <th>Item</th>
                                                 <th>Qty</th>
                                                 <th>Subtotal</th>
                                                 <th></th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <tr ng-repeat="dt in LoadDataPesananList">
                                                 <td>{{$index+1}}</td>
                                                 <td>
                                                     <b>{{dt.nama}}</b><br>
                                                     <small class="text-muted">
                                                         {{dt.jenis}} • {{dt.kategori}}
                                                     </small>
                                                 </td>
                                                 <td>{{dt.qty}}</td>
                                                 <td>{{dt.subtotal | currency:"Rp. ":0}}</td>
                                                 <td>
                                                     <button class="btn btn-sm btn-outline-primary"
                                                         ng-click="SplitPindahPAy(dt)">
                                                         <i class="bx bx-right-arrow-alt"></i>
                                                     </button>
                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <!-- BILL SPLIT -->
                     <div class="col-lg-6">
                         <div class="card h-100 shadow-sm border-primary">
                             <div class="card-header bg-primary text-white">
                                 Bill Split
                             </div>
                             <div class="card-body p-0">
                                 <div class="table-responsive">
                                     <table class="table table-sm table-bordered mb-0">
                                         <thead class="table-primary">
                                             <tr>
                                                 <th>#</th>
                                                 <th>Item</th>
                                                 <th>Qty</th>
                                                 <th>Subtotal</th>
                                                 <th></th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <tr ng-repeat="dt in LoadDataPesananSplit">
                                                 <td>{{$index+1}}</td>
                                                 <td>
                                                     <b>{{dt.nama}}</b><br>
                                                     <small class="text-muted">
                                                         {{dt.jenis}} • {{dt.kategori}}
                                                     </small>
                                                 </td>
                                                 <td>{{dt.qty}}</td>
                                                 <td>{{dt.subtotal | currency:"Rp. ":0}}</td>
                                                 <td>
                                                     <button class="btn btn-sm btn-outline-danger"
                                                         ng-click="SplitKembali(dt)">
                                                         <i class="bx bx-left-arrow-alt"></i>
                                                     </button>
                                                 </td>
                                             </tr>
                                             <tr ng-if="LoadDataPesananSplit.length === 0">
                                                 <td colspan="5" class="text-center text-muted py-4">
                                                     Belum ada item dipindah
                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>

             <div class="modal-footer bg-light border-top">
                 <div class="container-fluid">

                     <!-- TOTAL SPLIT -->
                     <div class="row mb-2 align-items-center">
                         <div class="col-md-6 fw-bold">
                             Total Split
                         </div>
                         <div class="col-md-6 text-end text-primary fw-bold fs-5">
                             {{ TotalSplit | currency:"Rp. ":0 }}
                         </div>
                     </div>

                     <!-- PPN -->
                     <div class="row mb-2 align-items-center">
                         <div class="col-md-6 fw-bold">
                             PPN
                         </div>
                         <div class="col-md-3">
                             <select class="form-control" id="split-ppn-percent"
                                 onchange="angular.element(this).scope().HitungSplitBill()">
                                 <option value="">Pilih PPN</option>
                                 <option value="0">0%</option>
                                 <option value="10">10%</option>
                                 <option value="11">11%</option>
                             </select>
                         </div>
                         <div class="col-md-3 text-end">
                             <input type="text" class="form-control text-end" id="split-ppn-value" readonly>
                         </div>
                     </div>

                     <!-- GRAND TOTAL -->
                     <div class="row mb-3 align-items-center border-top pt-2">
                         <div class="col-md-6 fw-bold fs-5">
                             Grand Total
                         </div>
                         <div class="col-md-6 text-end fw-bold fs-4 text-success">
                             <span id="split-grand-total">Rp. 0</span>
                         </div>
                     </div>

                     <!-- METODE BAYAR -->
                     <div class="row mb-2">
                         <div class="col-md-6 fw-bold">
                             Metode Pembayaran
                         </div>
                         <select class="form-control" id="split-payment-method"
                             onchange="angular.element(this).scope().OnChangePaymentMethod()">
                             <option value="">Pilih Metode</option>
                             <option value="Cash">Cash</option>
                             <option value="QRIS">QRIS</option>
                             <option value="Bank Transfer">Bank Transfer</option>
                         </select>

                     </div>

                     <!-- NOMINAL BAYAR -->
                     <div class="row mb-2">
                         <div class="col-md-6 fw-bold">
                             Nominal Bayar
                         </div>
                         <div class="col-md-6">
                             <input type="text" class="form-control text-end" id="split-paid-amount"
                                 placeholder="Masukkan nominal" onkeyup="formatInputRupiah(this)"
                                 ng-keyup="HitungKembalianSplit()">
                         </div>
                     </div>

                     <!-- KEMBALIAN -->
                     <div class="row mb-3">
                         <div class="col-md-6 fw-bold">
                             Kembalian
                         </div>
                         <div class="col-md-6 text-end fw-bold text-danger">
                             <span id="split-change">Rp. 0</span>
                         </div>
                     </div>

                     <!-- BUTTON -->
                     <div class="row">
                         <div class="col-md-12 text-end">
                             <button class="btn btn-success px-4" ng-click="SubmitSplitBill()">
                                 <i class="bx bx-check"></i> Submit & Cetak
                             </button>
                         </div>
                     </div>

                 </div>
             </div>


         </div>
     </div>
 </div>
 <!-- End Split Bill -->
