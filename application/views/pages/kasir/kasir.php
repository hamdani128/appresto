<div ng-app="KasirApp" ng-controller="KasirAppController">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex">
                    <div class="card radius-10 w-100" style="border: 1px solid #e3e6f0;">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center"
                            style="background: linear-gradient(135deg, #2c3e50 0%, #4a6491 100%);">
                            <h5 class="mb-0 text-white d-flex align-items-center gap-2">
                                <i class="bx bx-table"></i>
                                Table List
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark fw-normal" style="font-size: 0.9rem;">
                                    Total: {{LoadData.length}} Tables
                                </span>
                            </div>
                        </div>
                        <div class="card-body" style="background-color: #f8f9fc; min-height: 200px;">
                            <div class="row">
                                <div class="col-md-4" ng-repeat="dt in LoadData" ng-if="LoadData.length > 0">
                                    <div class="card bg-secondary" id="bg_{{$index}}" ng-if="dt.status === '0'"
                                        ng-click="SelectedMeja('bg_' + $index, dt)">
                                        <div class="card-body">
                                            <h2 class="card-title text-white">{{dt.no_meja}}
                                            </h2>
                                            <p class="card-text text-white">{{dt.nama_meja}}</p>
                                        </div>
                                    </div>
                                    <div class="card bg-primary" ng-if="dt.status === '1'"
                                        ng-click="ShowListBelanja(dt)">
                                        <div class="card-body">
                                            <h2 class="card-title text-white">{{dt.no_meja}}</h2>
                                            <p class="card-text text-white">{{dt.nama_meja}}</p>
                                            <!-- <p class="card-text text-white">{{dt.no_order}}</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Order -->
                <div class="col-12 col-sm-7 col-md-7 col-lg-7 col-xl7 d-flex">

                    <div class="card radius-10 overflow-hidden w-100 shadow-sm" style="border: 1px solid #e3e6f0;">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center"
                            style="background: linear-gradient(135deg, #2c3e50 0%, #4a6491 100%) !important; border-bottom: 0;">
                            <h5 class="mb-0 text-white d-flex align-items-center gap-2" style="font-weight: 600;">
                                <i class="bx bx-slider-alt" style="font-size: 1.3rem;"></i>
                                Operation Dashboard
                            </h5>
                            <button class="btn btn-light btn-md" id="btn_refresh" ng-click="BackToHome()"
                                style="border-radius: 6px; padding: 8px 16px; font-weight: 500; transition: all 0.3s;">
                                <i class="bx bx-home"></i> Dashboard
                            </button>
                        </div>
                        <div class="card-body" style="background-color: #f8f9fc;">
                            <!-- Transactions Table -->
                            <div class="row" id="table_row_order" style="display: block;">
                                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-white border-0 py-3">
                                            <h6 class="mb-0 text-dark" style="font-weight: 600;">
                                                <i class="bx bx-receipt me-2"></i>Recent Transactions
                                            </h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table datatable="ng" dt-options="vm.dtOptions"
                                                    class="table table-hover mb-0" style="width:100%">
                                                    <thead class="text-white text-center"
                                                        style="background: linear-gradient(90deg, #4e54c8, #8f94fb);">
                                                        <tr>
                                                            <th style="width: 5%; padding: 12px 10px;">#</th>
                                                            <th style="width: 30%; padding: 12px 10px;">Transaction
                                                            </th>
                                                            <th style="width: 15%; padding: 12px 10px;">Metode</th>
                                                            <th style="width: 20%; padding: 12px 10px;">Tanggal</th>
                                                            <th style="width: 15%; padding: 12px 10px;">Status</th>
                                                            <th style="width: 15%; padding: 12px 10px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="dt in LoadDataTransaksi"
                                                            ng-if="LoadDataTransaksi.length > 0"
                                                            style="cursor: pointer; transition: background-color 0.2s;"
                                                            onmouseover="this.style.backgroundColor='#f5f7fb'"
                                                            onmouseout="this.style.backgroundColor=''">
                                                            <td class="text-center"
                                                                style="padding: 12px 10px; font-weight: 500;">
                                                                {{$index + 1}}</td>
                                                            <td style="padding: 12px 10px;">
                                                                <div style="font-weight: 600; color: #2c3e50;">
                                                                    {{dt.no_transaksi}}
                                                                    <span ng-if="dt.no_split" class="badge"
                                                                        style="background: #e3f2fd; color: #d25a19ff; font-weight: 500; padding: 4px 10px;">
                                                                        {{dt.no_split}}
                                                                    </span>
                                                                </div>
                                                                <div style="font-size: 0.85rem; color: #6c757d;">
                                                                    Order: {{dt.no_order}} • Table: {{dt.no_meja}}
                                                                </div>
                                                            </td>
                                                            <td style="padding: 12px 10px;">
                                                                <span class="badge"
                                                                    style="background: #e3f2fd; color: #1976d2; font-weight: 500; padding: 4px 10px;">
                                                                    {{dt.metode}}
                                                                </span>
                                                            </td>
                                                            <td style="padding: 12px 10px; color: #5a5c69;">
                                                                <i class="bx bx-calendar me-1"></i>
                                                                {{dt.created_at}}
                                                            </td>
                                                            <td style="padding: 12px 10px;">
                                                                <span class="badge rounded-pill"
                                                                    style="background: #d4edda; color: #155724; padding: 5px 12px; font-weight: 500;">
                                                                    <i class="bx bx-check-circle me-1"></i> Complete
                                                                </span>
                                                            </td>
                                                            <td class="text-center" style="padding: 12px 10px;">
                                                                <button class="btn btn-sm"
                                                                    ng-click="ShowDetailTransaksi(dt)"
                                                                    style="background: #4e54c8; color: white; border-radius: 5px; padding: 6px 12px; transition: all 0.3s;"
                                                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(78, 84, 200, 0.3)'"
                                                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                    <i class="bx bx-printer"></i> Print
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr ng-if="LoadDataTransaksi.length === 0">
                                                            <td colspan="6" class="text-center"
                                                                style="padding: 40px 20px; color: #6c757d;">
                                                                <i class="bx bx-package"
                                                                    style="font-size: 3rem; color: #dee2e6; margin-bottom: 10px; display: block;"></i>
                                                                No transactions available
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="input-group button-group">
                                        <button class="btn btn-md w-100" id="btn_booking" ng-click="Create_Booking()"
                                            style="display: none;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white; border: none; border-radius: 8px; padding: 12px;
                        font-weight: 600; transition: all 0.3s;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(102, 126, 234, 0.4)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="bx bx-plus-circle me-2"></i>
                                            New Booking
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Info -->
                            <div id="row_no_meja" style="display: none;">
                                <div class="row pt-3">
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm h-100" style="background: white;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="bg-primary rounded-circle p-2 me-3">
                                                        <i class="bx bx-calendar-check text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-muted">Booking Number</h6>
                                                        <h5 class="mb-0 text-dark fw-bold mt-1" id="no_booking">-
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm h-100" style="background: white;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="bg-success rounded-circle p-2 me-3">
                                                        <i class="bx bx-table text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-muted">Table Number</h6>
                                                        <h5 class="mb-0 text-dark fw-bold mt-1" id="no_meja">-</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operation Buttons -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex gap-3">
                                        <button class="btn btn-md flex-fill" id="btn_pindah_meja" style="display: none; background: #ff6b6b; color: white; border: none;
                        border-radius: 8px; padding: 15px; font-weight: 600; transition: all 0.3s;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(255, 107, 107, 0.3)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                                            ng-click="PindahMeja()">
                                            <i class="bx bx-move me-2"></i>
                                            Move Table
                                        </button>
                                        <button class="btn btn-md flex-fill" id="btn_gabung_bill" style="display: none; background: #ffa502; color: white; border: none;
                        border-radius: 8px; padding: 15px; font-weight: 600; transition: all 0.3s;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(255, 165, 2, 0.3)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                                            ng-click="GabungBill()">
                                            <i class="bx bx-merge me-2"></i>
                                            Merge Bill
                                        </button>
                                        <button class="btn btn-md flex-fill" id="btn_tambah_pesanan" style="display: none; background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
                        color: white; border: none; border-radius: 8px; padding: 15px; font-weight: 600;
                        transition: all 0.3s; flex: 2;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(91, 134, 229, 0.4)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                                            ng-click="TambahPesanan()">
                                            <i class="bx bx-plus-circle me-2"></i>
                                            Add Order Items
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Count -->
                            <div class="pt-2" id="row_count_pesanan" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-0 shadow-sm"
                                            style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
                                            <div class="card-body text-center p-4">
                                                <div class="d-flex align-items-center justify-content-center mb-3">
                                                    <div class="bg-white rounded-circle p-3 me-3">
                                                        <i class="bx bx-food-menu text-danger"
                                                            style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-dark mb-0">FOOD ITEMS</h5>
                                                        <h2 class="text-dark fw-bold mt-2 mb-0"
                                                            id="lb_makanan_list_pesanan">0</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-0 shadow-sm"
                                            style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);">
                                            <div class="card-body text-center p-4">
                                                <div class="d-flex align-items-center justify-content-center mb-3">
                                                    <div class="bg-white rounded-circle p-3 me-3">
                                                        <i class="bx bx-drink text-primary"
                                                            style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-dark mb-0">DRINK ITEMS</h5>
                                                        <h2 class="text-dark fw-bold mt-2 mb-0"
                                                            id="lb_minuman_list_pesanan">0</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div id="row_list_pesanan" style="display: none;">
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="mb-0 text-dark d-flex align-items-center" style="font-weight: 600;">
                                            <i class="bx bx-detail me-2"></i>Order Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Order Information -->
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center p-3 rounded"
                                                    style="background: #f8f9fa;">
                                                    <i class="bx bx-table text-primary me-3"
                                                        style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Table No</small>
                                                        <strong id="lb_tambahan_no_meja" class="text-dark">-</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center p-3 rounded"
                                                    style="background: #f8f9fa;">
                                                    <i class="bx bx-receipt text-success me-3"
                                                        style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Order No</small>
                                                        <strong id="lb_tambahan_no_order" class="text-dark">-</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center p-3 rounded"
                                                    style="background: #f8f9fa;">
                                                    <i class="bx bx-calendar text-warning me-3"
                                                        style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Created At</small>
                                                        <strong id="lb_tambahan_created_at" class="text-dark">-</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Order Items Table -->
                                        <div class="row pt-2">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" style="width:110%"
                                                    id="tb_pesanan_list">
                                                    <thead class="text-white"
                                                        style="background: linear-gradient(90deg, #2c3e50, #4a6491);">
                                                        <tr>
                                                            <th style="width: 2%; padding: 12px;">#</th>
                                                            <th style="width: 5%; padding: 12px;">Category</th>
                                                            <th style="width: 15%; padding: 12px;">Item</th>
                                                            <th style="width: 10%; padding: 12px;">Price</th>
                                                            <th style="width: 10%; padding: 12px;">Qty</th>
                                                            <th style="width: 10%; padding: 12px;">Subtotal</th>
                                                            <th style="width: 10%; padding: 12px;">Type</th>
                                                            <th style="width: 10%; padding: 12px;">Discount Amt</th>
                                                            <th style="width: 8%; padding: 12px;">Disc. %</th>
                                                            <th style="width: 5%; padding: 12px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_pesanan_list_body_menu">
                                                        <tr ng-repeat="dt in LoadDataPesananList"
                                                            ng-if="LoadDataPesananList.length > 0"
                                                            style="transition: all 0.2s;"
                                                            onmouseover="this.style.backgroundColor='#f8f9fa'">
                                                            <td style="padding: 12px; font-weight: 500;">
                                                                {{$index + 1}}
                                                            </td>
                                                            <td style="padding: 12px;">
                                                                <span class="badge rounded-pill"
                                                                    style="background: #e8f4fd; color: #0369a1; padding: 4px 10px;">
                                                                    {{dt.kategori}}
                                                                </span>
                                                            </td>
                                                            <td style="padding: 12px; font-weight: 500;">
                                                                {{ dt.nama }}
                                                            </td>
                                                            <td style="padding: 12px;">
                                                                {{ dt.harga | currency:"Rp. ":0 }}</td>
                                                            <td style="padding: 12px;">
                                                                <span class="badge"
                                                                    style="background: #f0f9ff; color: #0369a1; padding: 6px 12px; font-weight: 600;">
                                                                    {{ dt.qty }}
                                                                </span>
                                                            </td>
                                                            <td
                                                                style="padding: 12px; font-weight: 600; color: #2c3e50;">
                                                                {{ dt.subtotal | currency:"Rp. ":0 }}
                                                            </td>
                                                            <td style="padding: 12px;">
                                                                <span class="badge"
                                                                    style="background: #f0fdf4; color: #166534; padding: 4px 10px;">
                                                                    {{dt.jenis}}
                                                                </span>
                                                            </td>
                                                            <td style="padding: 12px; color: #dc2626;">
                                                                {{ dt.potongan | currency:"Rp. ":0 }}</td>
                                                            <td style="padding: 12px;">
                                                                <input type="text" class="form-control text-center"
                                                                    ng-model="dt.discount"
                                                                    ng-change="CalculateRowSubtotal(dt)"
                                                                    style="border: 1px solid #d1d5db; border-radius: 6px; padding: 6px;">
                                                            </td>
                                                            <td style="padding: 12px;">
                                                                <button class="btn btn-sm"
                                                                    ng-click="ShowDetailPesanan(dt)"
                                                                    style="background: #4f46e5; color: white; border-radius: 5px; padding: 6px 10px;">
                                                                    <i class="bx bx-show"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr ng-if="LoadDataPesananList.length === 0">
                                                            <td colspan="10" class="text-center"
                                                                style="padding: 40px 20px; color: #6c757d;">
                                                                <i class="bx bx-cart"
                                                                    style="font-size: 3rem; color: #dee2e6; margin-bottom: 10px; display: block;"></i>
                                                                No order items available
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Calculation Card -->
                                        <div class="card mt-4 border-0 shadow-sm" style="background: white;">
                                            <div class="card-header bg-white border-0 pb-0">
                                                <h6 class="mb-0 text-dark" style="font-weight: 600;">
                                                    <i class="bx bx-calculator me-2"></i>Payment Calculation
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-8 text-end fw-bold" style="color: #4b5563;">
                                                        Total Quantity
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control text-end fw-bold"
                                                            id="qty-total" value="0" readonly
                                                            style="background: #f9fafb; border: 1px solid #e5e7eb; color: #111827;">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-8 text-end fw-bold" style="color: #4b5563;">
                                                        Subtotal
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control text-end fw-bold"
                                                            ng-model="amount_total" id="amount-total" readonly
                                                            style="background: #f0f9ff; border: 1px solid #bae6fd; color: #0369a1;">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-8 text-end fw-bold" style="color: #4b5563;">
                                                        Discount (%)
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control text-end mb-2"
                                                            name="discount-nominal" id="discount-nominal"
                                                            onkeyup="angular.element(this).scope().CalculateTotal()"
                                                            placeholder="e.g. 10" style="border: 1px solid #d1d5db;">
                                                        <input type="text" class="form-control text-end"
                                                            name="discount-value" id="discount-value"
                                                            style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;"
                                                            value="0" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mb-3 align-items-center">
                                                    <div class="col-md-8 text-end fw-bold" style="color: #4b5563;">
                                                        Tax (PPN)
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="form-control" id="ppn-select"
                                                            ng-model="ppn_percent"
                                                            onchange="angular.element(this).scope().CalculateTotal()"
                                                            style="border: 1px solid #d1d5db;">
                                                            <option value="">Select Tax</option>
                                                            <option value="10">10%</option>
                                                            <option value="11">11%</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-8 text-end fw-bold" style="color: #4b5563;">
                                                        Tax Amount
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control text-end" id="amount-ppn"
                                                            ng-model="ppn_amount" readonly
                                                            style="background: #fef3c7; border: 1px solid #fde68a; color: #92400e;">
                                                    </div>
                                                </div>

                                                <hr style="border-color: #e5e7eb;">

                                                <div class="row">
                                                    <div class="col-md-8 text-end fs-5 fw-bold" style="color: #2c3e50;">
                                                        GRAND TOTAL
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control text-end fw-bold fs-5"
                                                            id="grand-total" ng-model="grand_total" readonly style="background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
                                                  border: 2px solid #86efac; color: #166534;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Action Buttons -->
                                        <div class="row pt-4">
                                            <div class="col-md-12">
                                                <div class="row g-3" id="payment-action-buttons">
                                                    <!-- Print Bill -->
                                                    <div class="col-12 col-sm-6 col-lg-3">
                                                        <button
                                                            class="btn btn-success btn-md w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3"
                                                            ng-click="CetakBill()" style="border-radius: 10px; border: none;
                           background: linear-gradient(135deg, #67f2f7 0%, #128fc9 100%);
                           transition: all 0.3s; min-height: 100px;"
                                                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(16, 185, 129, 0.3)'"
                                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                            <i class="bx bx-printer mb-2"
                                                                style="font-size: clamp(1.5rem, 4vw, 1.8rem);"></i>
                                                            <span class="text-center"
                                                                style="font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                                                                Print Bill
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <!-- Split Bill -->
                                                    <div class="col-12 col-sm-6 col-lg-3">
                                                        <button
                                                            class="btn btn-primary btn-md w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3"
                                                            ng-click="SplitBill()" style="border-radius: 10px; border: none;
                           background: linear-gradient(135deg, #8aa5d8 0%, #12548a 100%);
                           transition: all 0.3s; min-height: 100px;"
                                                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(59, 130, 246, 0.3)'"
                                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                            <i class="bx bx-credit-card mb-2"
                                                                style="font-size: clamp(1.5rem, 4vw, 1.8rem);"></i>
                                                            <span class="text-center"
                                                                style="font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                                                                Split Bill
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <!-- Pay Later -->
                                                    <div class="col-12 col-sm-6 col-lg-3">
                                                        <button
                                                            class="btn btn-info btn-md w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3"
                                                            ng-click="pay_after_service()" style="border-radius: 10px; border: none;
                           background: linear-gradient(135deg, #57f057 0%, #022c13 100%);
                           transition: all 0.3s; min-height: 100px;"
                                                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(6, 182, 212, 0.3)'"
                                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                            <i class="bx bx-time-five mb-2"
                                                                style="font-size: clamp(1.5rem, 4vw, 1.8rem);"></i>
                                                            <span class="text-center"
                                                                style="font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                                                                Pay Now
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <!-- Pay Now -->
                                                    <!-- <div class="col-12 col-sm-6 col-lg-3">
                                                        <button
                                                            class="btn btn-dark btn-md w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3"
                                                            ng-click="pay_before_service()" style="border-radius: 10px; border: none;
                           background: linear-gradient(135deg, #6b7280 0%, #374151 100%);
                           transition: all 0.3s; min-height: 100px;"
                                                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(107, 114, 128, 0.3)'"
                                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                            <i class="bx bx-money mb-2"
                                                                style="font-size: clamp(1.5rem, 4vw, 1.8rem);"></i>
                                                            <span class="text-center"
                                                                style="font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                                                                Pay Now
                                                            </span>
                                                        </button>
                                                    </div> -->


                                                    <!-- cancel Order -->
                                                    <div class="col-12 col-sm-6 col-lg-3">
                                                        <button
                                                            class="btn btn-dark btn-md w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3"
                                                            ng-click="cancel_order()" style="border-radius: 10px; border: none;
                           background: linear-gradient(135deg, #eb817e 0%, #da1818 100%);
                           transition: all 0.3s; min-height: 100px;"
                                                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(107, 114, 128, 0.3)'"
                                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                            <i class="bx bx-money mb-2"
                                                                style="font-size: clamp(1.5rem, 4vw, 1.8rem);"></i>
                                                            <span class="text-center"
                                                                style="font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                                                                Cancel Order
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Order -->
            </div>
            <!-- End List Pesanan -->
        </div>
    </div>




    <!-- Modal Booking Responsive -->
    <div class="modal fade modal-right" id="my-modal-booking" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        No.Pesanan <label id="lb_no_booking"></label> | No.Meja <label id="lb_no_meja"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <!-- LEFT PANEL: Menu -->
                        <div class="col-12 col-lg-6">
                            <div class="card bg-light h-100">
                                <div class="card-body">
                                    <!-- Search & Category -->
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label>Pencarian Data :</label>
                                            <input type="text" class="form-control" ng-model="keywordMenu"
                                                ng-change="searchMenu()" placeholder="Masukkan Data . .">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label>Category :</label>
                                            <select name="cmb_jenis_pesanan" id="cmb_jenis_pesanan" class="form-control"
                                                ng-model="selectedCategory" ng-change="searchMenu()"
                                                ng-options="c.kategori as c.kategori for c in categories">
                                                <option value="">Pilih Category :</option>
                                                <!-- default placeholder -->
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Menu List -->
                                    <div class="row g-2 mt-3 card-menu-scroll">
                                        <div class="col-6 col-md-4 mb-3" ng-repeat="dt in filteredMenu">
                                            <div class="card h-100">
                                                <a href="javascript:;" ng-click="PilihMenu(dt)"
                                                    class="list-group-item list-group-item-action p-2">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1 text-black">{{dt.jenis}}</h5>
                                                        <span class="badge bg-info text-white"
                                                            ng-if="dt.status_food=='1'">Ready</span>
                                                        <span class="badge bg-danger text-white"
                                                            ng-if="dt.status_food=='0'">Close</span>
                                                    </div>
                                                    <div class="pt-2">
                                                        <img ng-if="dt.jenis=='Makanan' && !dt.img"
                                                            src="<?php echo base_url('public/assets/images/foodbar.png') ?>"
                                                            alt=""
                                                            style="width: 100%; height: 120px; object-fit: cover;">
                                                        <img ng-if="dt.jenis=='Makanan' && dt.img"
                                                            src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                            alt=""
                                                            style="width: 100%; height: 120px; object-fit: cover;">
                                                        <img ng-if="dt.jenis=='Minuman' && !dt.img"
                                                            src="<?php echo base_url('public/assets/images/refreshments.png') ?>"
                                                            alt=""
                                                            style="width: 100%; height: 120px; object-fit: cover;">
                                                        <img ng-if="dt.jenis=='Minuman' && dt.img"
                                                            src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                            alt=""
                                                            style="width: 100%; height: 120px; object-fit: cover;">
                                                    </div>
                                                    <div class="pt-2">
                                                        <h6>{{dt.nama}}</h6>
                                                        <h5>Rp.{{dt.harga}}</h5>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- RIGHT PANEL: Daftar Pesanan -->
                        <div class="col-12 col-lg-6">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="card h-100">
                                        <div class="card-header bg-info">
                                            <h5 class="text-white">List Daftar Pesanan :</h5>
                                        </div>
                                        <div class="card-body table-responsive"
                                            style="max-height: 55vh; overflow-y: auto;">
                                            <table class="table table-striped table-bordered" style="width:100%"
                                                id="tb_pesanan">
                                                <thead class="bg-dark text-white">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Cat.</th>
                                                        <th>List</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Jenis</th>
                                                        <th>Owner</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_pesanan_body"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Simpan -->
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" ng-click="SimpanDataOrder()">
                                        <i class="bx bx-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- modal-body -->
            </div> <!-- modal-content -->
        </div> <!-- modal-dialog -->
    </div> <!-- modal -->


    <!-- Modal Tambah Pesanan -->
    <div class="modal fade modal-right" id="my-modal-tambah-pesanan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_no_booking_tambahan"></label> |
                        No.Meja
                        <label id="lb_no_meja_tambah_pesanan"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Pencarian Data :</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="" id=""
                                                        ng-model="keywordMenu" ng-change="searchMenu()"
                                                        placeholder="Masukkan Data . .">
                                                    <select name="" id="" class="form-control">
                                                        <option value="">Filter By :</option>
                                                        <option value="Makanan">Makanan</option>
                                                        <option value="Minuman">Minuman</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-2">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-md-4" ng-repeat="dt in filteredMenu"
                                                        ng-if="filteredMenu.length > 0">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <a href="javascript:;" ng-click="PilihMenuTambahan(dt)"
                                                                    class="list-group-item list-group-item-action"
                                                                    aria-current="true">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1 text-black">
                                                                            {{dt.jenis}}
                                                                        </h5>
                                                                        <span class="badge bg-info text-white"
                                                                            ng-if="dt.status_food == '1'">
                                                                            Ready
                                                                        </span>
                                                                        <span class="badge bg-danger text-white"
                                                                            ng-if="dt.status_food == '0'">
                                                                            Close
                                                                        </span>

                                                                    </div>
                                                                    <div class="row d-flex pt-2">
                                                                        <div class="col-md-12">
                                                                            <img src="<?php echo base_url('public/assets/images/foodbar.png') ?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Makanan' && !dt.img">

                                                                            <img src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Makanan' && dt.img">

                                                                            <img src="<?php echo base_url('public/assets/images/refreshments.png') ?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Minuman' && !dt.img">

                                                                            <img src="<?php echo base_url('public/upload/{{dt.img}}') ?>"
                                                                                alt=""
                                                                                style="width: 100%;height: 120px;"
                                                                                ng-if="dt.jenis=='Minuman' && dt.img">
                                                                        </div>
                                                                        <div class="col-md-12 pt-2">
                                                                            <h6>{{dt.nama}}</small>
                                                                                <h5>Rp.{{dt.harga}}</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header bg-info">
                                            <h5 class="text-white">List Daftar Pesanan :</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" style="width:100%"
                                                    id="tb_pesanan">
                                                    <thead class="bg-dark text-white">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Cat.</th>
                                                            <th>List</th>
                                                            <th>Harga</th>
                                                            <th>Qty</th>
                                                            <th>Jenis</th>
                                                            <th>Owner</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_pesanan_body_tambahan">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <button class="btn btn-md btn-primary"
                                                        ng-click="SimpanDataOrderTambahan()">
                                                        <i class="bx bx-save"></i>
                                                        Tambah Pesanan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Tambah Pesanan -->

    <!-- List Pesanan Detail -->
    <div id="my-modal-list-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_no_booking_list"></label> | No.Meja
                        <label id="lb_no_meja_list"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row pb-2">
                        <div class="col-md-12">
                            <button class="btn btn-md btn-primary" ng-click="UpdateServed()">
                                <i class="bx bx-edit"></i>
                                Served
                            </button>
                            <button class="btn btn-md btn-info" ng-click="UpdateDelivered()">
                                <i class="bx bx-edit"></i>
                                Delivered
                            </button>
                            <button class="btn btn-md btn-success" ng-click="UpdateCompleted()">
                                <i class="bx bx-edit"></i>
                                Completed
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:130%"
                                    id="tb_pesanan_list_detail">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>
                                                <input type="checkbox" ng-model="checkAll" ng-change="toggleAll()"
                                                    class="form-check-input">
                                            </th>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Status Food</th>
                                            <th>No.Order</th>
                                            <th>No.Meja</th>
                                            <th>Category</th>
                                            <th>List</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Potongan</th>
                                            <th>Disc(%)</th>
                                            <th>Jenis</th>
                                            <th>Owner</th>
                                            <th>Time Request</th>
                                        </tr>
                                    </thead>
                                    <tbody id="td_pesanan_body_list_detail">
                                        <tr ng-repeat="dt in LoadDataPesananDetail"
                                            ng-if="LoadDataPesananDetail.length > 0" style="text-align: center;">
                                            <td>
                                                <input type="checkbox" ng-model="dt.checked"
                                                    ng-change="updateCheckedIds()" class="form-check-input">
                                            </td>
                                            <td>{{$index + 1}}</td>
                                            <td>
                                                <div class="btn-group input-group">
                                                    <button type="button" class="btn btn-sm btn-dark"
                                                        ng-if="dt.status=='1'"
                                                        ng-click="TambahQtyPesananListDetail(dt)">
                                                        <i class=" bx bx-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-dark"
                                                        ng-if="dt.status=='1'"
                                                        ng-click="KurangQtyPesananListDetail(dt)">
                                                        <i class=" bx bx-minus"></i>
                                                    </button>
                                                    <!-- <button type="button" class="btn btn-sm btn-danger"
                                                        ng-click="DeleteListDetail(dt)" ng-if="dt.status=='1'">
                                                        <i class="bx bx-trash"></i>
                                                    </button> -->
                                                </div>
                                            </td>
                                            <td>
                                                <div ng-if="dt.status=='1'">
                                                    <span class="badge bg-warning text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                                <div ng-if="dt.status=='2'">
                                                    <span class="badge bg-info text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                                <div ng-if="dt.status=='3'">
                                                    <span class="badge bg-info text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                                <div ng-if="dt.status=='4'">
                                                    <span class="badge bg-success text-white">
                                                        {{dt.status_food}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>{{dt.no_order}}</td>
                                            <td>{{dt.no_meja}}</td>
                                            <td>{{dt.kategori}}</td>
                                            <td>{{dt.nama}}</td>
                                            <td>{{dt.harga | currency:"":0}}</td>
                                            <td class="qty-cell-list-detail" style="font-size: 14pt;font-weight: 400;">
                                                {{dt.qty | number:0}}
                                            </td>
                                            <td class="subtotal-cell-list-detail">
                                                {{(dt.qty * dt.harga) - dt.potongan | currency:"":0}}</td>
                                            <td class="subtotal-cell-list-detail">{{ dt.potongan | currency:"":0}}
                                            </td>
                                            <td>{{dt.discount | number:0}}</td>
                                            <td>{{dt.jenis}}</td>
                                            <td>{{dt.owner}}</td>
                                            <td>{{dt.created_at}}</td>
                                        </tr>
                                        <tr ng-if="LoadDataPesananDetail.length === 0">
                                            <td colspan="12" class="text-center">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    Footer
                </div> -->
            </div>
        </div>
    </div>
    <!-- End List Pesanan Detail -->

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
                                    <select id="combo-reference-payment-before-service"
                                        class="form-select form-select-lg"
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
                                <div id="display_jumlah_dibayar_payment_before_service" class="mb-3"
                                    style="display:none;">
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


    <!-- Modal Pembayaran Uang  -->
    <!-- PAYMENT AFTER SERVICE MODAL - POS STYLE -->
    <div id="my-modal-payment-After-service" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white">
                        <i class="bx bx-receipt"></i>
                        No.Pesanan <span id="lb_no_booking_payment_After_service"></span>
                        <small class="ms-2">| Meja <span id="lb_no_meja_payment_After_service"></span></small>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- SUMMARY CARD -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-6 fw-bold">Total Qty</div>
                                <div class="col-6 text-end fs-5" id="total-qty-payment-After-service">0</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 fw-bold">Subtotal</div>
                                <div class="col-6 text-end fs-5" id="subtotal-payment-After-service">0</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 fw-bold">Discount (<span id="lb-discount-After-service"></span>%)
                                </div>
                                <div class="col-6 text-end fs-5 text-danger" id="Discount-After-service">0</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 fw-bold">PPN (<span id="ppn-text-payment-After-service"></span>%)
                                </div>
                                <div class="col-6 text-end fs-5" id="ppn-payment-After-service">0</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 fw-bold fs-4">Grand Total</div>
                                <div class="col-6 text-end fs-3 fw-bold text-success"
                                    id="grand-total-payment-After-service">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- PAYMENT METHOD CARD -->
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <!-- Metode Payment -->
                            <div class="row">
                                <div class="mb-3">
                                    <label for="combo-payment-After-service" class="form-label fw-bold">Metode
                                        Payment</label>
                                    <select id="combo-payment-After-service" class="form-select form-select-lg"
                                        onchange="changePaymentAfterService()">
                                        <option value="">Pilih :</option>
                                        <option value="Cash">Cash</option>
                                        <option value="QRIS">QRIS</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>


                            <!-- Reference Payment -->
                            <div class="row">
                                <div class="mb-3" id="display_reference_payment_After_service" style="display:none;">
                                    <label for="combo-reference-payment-After-service"
                                        class="form-label fw-bold">Reference
                                        Payment</label>
                                    <select id="combo-reference-payment-After-service"
                                        class="form-select form-select-lg"
                                        onchange="changeReferencePaymentAfterService()">
                                    </select>
                                </div>
                            </div>

                            <!-- Reference Number -->
                            <div class="row">
                                <div class="mb-3" id="display_reference_number_payment_After_service"
                                    style="display:none;">
                                    <label for="reference-number-payment-After-service"
                                        class="form-label fw-bold">Reference
                                        Number</label>
                                    <input type="text" id="reference-number-payment-After-service"
                                        class="form-control form-control-lg text-end"
                                        placeholder="Masukkan nomor referensi">
                                </div>
                            </div>

                            <!-- Jumlah Dibayar -->
                            <div class="row">
                                <div class="mb-3" id="display_jumlah_dibayar_payment_After_service"
                                    style="display:none;">
                                    <label for="jumlah-dibayar-payment-After-service" class="form-label fw-bold">Jumlah
                                        Dibayar</label>
                                    <input type="text" id="jumlah-dibayar-payment-After-service"
                                        class="form-control form-control-lg text-end" placeholder="0">
                                </div>
                            </div>

                            <!-- Kembalian -->
                            <div class="row">
                                <div class="mb-3" id="display_kembalian_payment_After_service" style="display:none;">
                                    <label class="form-label fw-bold">Kembalian</label>
                                    <div class="fs-4 fw-bold text-danger text-end" id="kembalian-payment-After-service">
                                        0
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer p-0">
                    <button class="btn btn-success w-100 fw-bold" style="height:80px;font-size:22px;"
                        ng-click="PaymentAfterServiceSubmit()">
                        <i class="bx bx-paper-plane"></i>
                        SUBMIT PAYMENT
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- End Modal Pembayaran -->

    <!-- Cetak Bill Modal -->
    <div id="my-modal-cetak-bill" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">No.Pesanan <label id="lb_no_booking_payment_before_service"></label> |
                        No.Meja
                        <label id="lb_no_meja_payment_before_service"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="printArea" class="receipt">

                        <div class="text-center bold" style="font-size: 14px;margin-top: 0px;">
                            <!-- <img src="<?php echo base_url() ?>public/assets/images/millennialpos.png" alt=""> -->
                            <h5>SHAMROCK COFFEE</h5>
                        </div>
                        <div class="text-center" class="sub-title">
                            Jl. STM Komplek SBC Block O No.9-12 i,
                            Suka Maju, Kec. Medan Amplas, Kota Medan,
                            Sumatera Utara
                            20217<br>
                            Telp: 082320103919<br>
                        </div>
                        <hr>
                        <div style="padding-left: 18px;">
                            <table>
                                <tr>
                                    <td>
                                        Tanggal
                                    </td>
                                    <td>:</td>
                                    <td><span id="bill_date"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        No.Order
                                    </td>
                                    <td>:</td>
                                    <td><span id="bill_invoice"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        Kasir
                                    </td>
                                    <td>:</td>
                                    <td><span id="bill_chasier"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        No.Meja
                                    </td>
                                    <td>:</td>
                                    <td><span id="bill_no_meja"></span></td>
                                </tr>
                            </table>

                        </div>
                        <hr>
                        <div style="padding-left: 18px;">
                            <!-- Barang -->
                            <table style="width: 100%;  font-size: 13px;">
                                <tr ng-repeat="dt2 in LoadDataPesananBill" ng-if="LoadDataPesananBill.length > 0">
                                    <td style="width: 8%;">[{{dt2.qty}}]</td>
                                    <td style="width: 50%;">{{dt2.nama}}</td>
                                    <td style="width: 35%; text-align: right;">
                                        {{(dt2.qty * dt2.harga) | currency:"Rp ":0}}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <hr>
                        <!-- Perhitungan -->
                        <div style="padding-left: 18px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 20%;"></td>
                                    <td style="width: 80%;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td>Qty</td>
                                                <td style="width: 10px;">:</td>
                                                <td style="text-align: center;" id="bill_qty">0</td>
                                            </tr>
                                            <tr>
                                                <td>Subtotal</td>
                                                <td style="width: 10px;">:</td>
                                                <td style="text-align: right;" id="bill_subtotal">0</td>
                                            </tr>

                                            <tr>
                                                <td>Discount (<label for="" id="bill_text_discount"></label>%)</td>
                                                <td style="width: 10px;">:</td>
                                                <td style="text-align: right;" id="bill_value_discount">0</td>
                                            </tr>
                                            <tr>
                                                <td>PPN (10%)</td>
                                                <td>:</td>
                                                <td style="text-align: right;" id="bill_ppn">0</td>
                                            </tr>
                                            <tr>
                                                <td>Grand Total</td>
                                                <td>:</td>
                                                <td style="text-align: right;" id="bill_grand_total">0</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <hr>
                        <div class="text-center bold">
                            -- BILL TRANSAKSI --
                        </div>
                        <hr>
                        <div class="text-center bold">
                            -- TERIMA KASIH --
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="printEpppos()">Print</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bill Modal -->

    <!-- Modal Gabung Bill -->
    <div id="my-modal-gabung-bill" class="modal fade modal-right" tabindex="-1" role="dialog"
        aria-labelledby="my-modal-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        Bill Gabung
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9 col-md-9 col-sm-9 col-lg-9">
                            <!-- card-detail -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">No.Meja Digabung :</label>
                                                <select class="form-control" ng-model="cmb_gabung"
                                                    ng-options="meja.no_meja as (meja.no_meja + ' (' + meja.nama_meja + ')') for meja in listMejaGabung"
                                                    ng-change="GabungListMeja()">
                                                    <option value="">Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">List Item : </label>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" style="width:130%"
                                                    id="tb_pesanan_list_detail">
                                                    <thead class="bg-dark text-white">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>No.Order</th>
                                                            <th>No.Meja</th>
                                                            <th>Category</th>
                                                            <th>List</th>
                                                            <th>Harga</th>
                                                            <th>Qty</th>
                                                            <th>Subtotal</th>
                                                            <th>Potongan</th>
                                                            <th>Disc(%)</th>
                                                            <th>Jenis</th>
                                                            <th>Owner</th>
                                                            <th>Time Request</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="td_pesanan_body_gabung_bill">
                                                        <tr ng-repeat="dt in (LoadDataPesananDetail.concat(LoadDataPesananGabungSementara))"
                                                            ng-if="LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length > 0">
                                                            <td>{{$index + 1}}</td>
                                                            <td>{{dt.no_order}}</td>
                                                            <td>{{dt.no_meja}}</td>
                                                            <td>{{dt.kategori}}</td>
                                                            <td>{{dt.nama}}</td>
                                                            <td>{{dt.harga | currency:"Rp ":0}}</td>
                                                            <td>{{dt.qty | number:0}}</td>
                                                            <td>
                                                                {{(dt.qty * dt.harga) - (dt.potongan) | currency:"Rp ":0}}
                                                            </td>
                                                            <td>{{dt.potongan | currency:"Rp ":0}}</td>
                                                            <td>{{dt.discount | number:0}}%</td>
                                                            <td>{{dt.jenis}}</td>
                                                            <td>{{dt.owner}}</td>
                                                            <td>{{dt.created_at}}</td>
                                                        </tr>
                                                        <tr
                                                            ng-if="LoadDataPesananDetail.length + LoadDataPesananGabungSementara.length === 0">
                                                            <td colspan="11" class="text-center">No data available
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot style="border: 1px solid #dee2e6;">
                                                        <tr>
                                                            <td colspan="5"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Total Qty : </label>
                                                            </td>
                                                            <td colspan="5"
                                                                style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="qty-total-gabung" id="qty-total-gabung"
                                                                    style="text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Subtotal : </label>
                                                            </td>
                                                            <td colspan="5"
                                                                style="font-size: 16px; font-weight: bold;
                                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="amount-total-gabung" id="amount-total-gabung"
                                                                    style="text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <div
                                                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                                    Discount (%)
                                                                </div>
                                                            </td>
                                                            <td colspan="5"
                                                                style="font-size: 16px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="discount-nominal-gabung"
                                                                    id="discount-nominal-gabung"
                                                                    style="text-align: right;" placeholder="Sample : 10"
                                                                    ng-keyup="CalculateTotalForGabung()" value="0">
                                                                <input type="text" class="form-control"
                                                                    name="discount-value-gabung"
                                                                    id="discount-value-gabung"
                                                                    style="text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <div
                                                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                                    <select id="ppn-select-gabung" class="form-control"
                                                                        style="width: 100px;"
                                                                        ng-change="CalculateTotalForGabung()"
                                                                        ng-model="ppnValue">
                                                                        <option value="">Pilih PPN :</option>
                                                                        <option value="10">10%</option>
                                                                        <option value="11">11%</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td colspan="5"
                                                                style="font-size: 16px; font-weight: bold;
                                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="amount-ppn-gabung" id="amount-ppn-gabung""
                                                                    style=" text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5"
                                                                style="text-align: right; font-size: 16px; font-weight: bold;
                                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Grand Total : </label>
                                                            </td>
                                                            <td colspan="5"
                                                                style="font-size: 16px; font-weight: bold;
                                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <input type="text" class="form-control"
                                                                    name="grand-total-gabung" id="grand-total-gabung"
                                                                    style="text-align: right;" value="0">
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-end">
                                            <button class="btn btn-md btn-warning btn-md"
                                                ng-click="ResetGabungPesanan()" style="flex: 1;">
                                                <i class="bx bx-refresh"></i>
                                                Clear
                                            </button>
                                            <button class="btn btn-success btn btn-md" style="flex: 1;"
                                                onclick="printEppposBillGabung()">
                                                <i class="bx bx-printer"></i> Cetak Bill
                                            </button>

                                            <button class="btn btn-info btn btn-md" ng-click="pay_payment_bill_gabung()"
                                                style="flex: 1;">
                                                <i class="bx bx-save"></i>
                                                Payment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Card Detail -->

                            <!-- card pembayaran -->
                            <div class="card" id="card-payment-BillGabungan" style="display: none;">
                                <div class="card-header bg-info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h7 class="text-white">Lock to Transaction</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" style="width:100%"
                                                    id="tb_payment_BillGabungan_service">
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Total Qty : </label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for=""
                                                                    id="total-qty-payment-BillGabungan-service">0</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Subtotal : </label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for=""
                                                                    id="subtotal-payment-BillGabungan-service">0</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Discount(<label for=""
                                                                        id="bill_discount_persen_gabungan"></label>%)
                                                                    :
                                                                </label>
                                                            </td>
                                                            <td colspan=" 6"
                                                                style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for=""
                                                                    id="bill_discount_value_gabungan">0</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">
                                                                    PPN
                                                                    <label for=""
                                                                        id="ppn-text-payment-BillGabungan-service">
                                                                    </label>% :
                                                                </label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for=""
                                                                    id="ppn-payment-BillGabungan-service">0</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Grand Total : </label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for=""
                                                                    id="grand-total-payment-BillGabungan-service">0</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Metode Payment :</label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <div
                                                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                                    <select id="combo-payment-BillGabungan-service"
                                                                        class="form-control"
                                                                        style="width: 100%;font-size: 20px;"
                                                                        onchange="changePaymentBillGabunganService()">
                                                                        <option value="">Pilih :</option>
                                                                        <option value="Cash">Cash</option>
                                                                        <option value="QRIS">QRIS</option>
                                                                        <option value="Bank Transfer">Bank Transfer
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr id="display_jumlah_dibayar_payment_BillGabungan_service"
                                                            style="display: none;">
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Jumlah Dibayar :</label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <div
                                                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                                    <input type="text"
                                                                        name="jumlah-dibayar-payment-BillGabungan-service"
                                                                        id="jumlah-dibayar-payment-BillGabungan-service"
                                                                        class=" form-control" style="text-align: right;width:
                                                100%;font-size: 20px;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr id="display_kembalian_payment_BillGabungan_service"
                                                            style="display: none;">
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">kembalian : </label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;text-align: right;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for=""
                                                                    id="kembalian-payment-BillGabungan-service">0</label>
                                                            </td>
                                                        </tr>
                                                        <tr id="display_reference_payment_BillGabungan_service"
                                                            style="display: none;">
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Reference Payment :</label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <div
                                                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                                    <select
                                                                        id="combo-reference-payment-BillGabungan-service"
                                                                        class="form-control"
                                                                        style="width: 100%;font-size: 20px;"
                                                                        onchange="changeReferencePaymentBillGabunganService()">
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr id="display_reference_number_payment_BillGabungan_service"
                                                            style="display: none;">
                                                            <td colspan="2"
                                                                style="text-align: right; font-size: 20px; font-weight: bold;
                                                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <label for="">Reference Number :</label>
                                                            </td>
                                                            <td colspan="6"
                                                                style="font-size: 20px; font-weight: bold;
                                                        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                                <div
                                                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                                                    <input type="text"
                                                                        name="reference-number-payment-BillGabungan-service"
                                                                        id="reference-number-payment-BillGabungan-service"
                                                                        class=" form-control" style="text-align: right;width:
                                                                        100%;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-md btn-success" style="width: 100%;height: 80px;"
                                        ng-click="PaymentBillGabunganSubmit()">
                                        <i class="bx bx-paper-plane"></i>
                                        Submit
                                    </button>
                                </div>
                            </div>
                            <!-- end Card pembayaran -->
                        </div>
                        <!-- Bill -->
                        <div class="col-3 col-md-3 col-sm-3 col-lg-3">
                            <div class="card">
                                <div class="card-body" id="printArea2">
                                    <div>
                                        <div class="text-center bold" style="font-size: 14px;margin-top: 0px;">
                                            <!-- <img src="<?php echo base_url() ?>public/assets/images/millennialpos.png"
                                                alt=""> -->
                                            <h5>SHAMROCK COFFEE</h5>
                                        </div>
                                        <div class="text-center">
                                            Jl. STM Komplek SBC Block O No.9-12 i,
                                            Suka Maju, Kec. Medan Amplas, Kota Medan,
                                            Sumatera Utara
                                            20217<br>
                                            Telp: 0812-3456-7890<br>
                                        </div>
                                        <hr>
                                        <div style="padding-left: 18px;">
                                            <table>
                                                <tr>
                                                    <td>
                                                        Tanggal
                                                    </td>
                                                    <td>:</td>
                                                    <td><span id="bill_date_gabungan"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kasir
                                                    </td>
                                                    <td>:</td>
                                                    <td><span id="bill_chasier_gabungan"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        No.order
                                                    </td>
                                                    <td>:</td>
                                                    <td><span id="bill_no_order_gabungan"></span></td>
                                                </tr>
                                            </table>

                                        </div>
                                        <hr>
                                        <div style="padding-left: 18px;">
                                            <!-- Barang -->
                                            <table style="width: 100%; font-size: 13px;">
                                                <tbody ng-repeat="group in groupedOrders">
                                                    <tr class="fw-bold">
                                                        <td colspan="3" style="padding-top: 6px; padding-bottom: 2px;">
                                                            Table: {{ group.no_meja }}
                                                            <hr class="my-1">
                                                        </td>
                                                    </tr>
                                                    <tr ng-repeat="item in group.items">
                                                        <td style="width: 8%; text-align: center;">[{{ item.qty }}]
                                                        </td>
                                                        <td style="width: 60%;">
                                                            {{ item.nama }}
                                                            <span ng-if="item.potongan !== null">
                                                                ({{item.discount}}%)
                                                            </span>
                                                        </td>
                                                        <td style="width: 30%; text-align: right;">
                                                            {{ (item.qty * item.harga) - item.potongan | currency:'Rp ':0 }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>
                                        <!-- Perhitungan -->
                                        <div style="padding-left: 18px;">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 20%;"></td>
                                                    <td style="width: 80%;">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td>Qty</td>
                                                                <td style="width: 10px;">:</td>
                                                                <td style="text-align: center;" id="bill_qty_gabungan">0
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Subtotal</td>
                                                                <td style="width: 10px;">:</td>
                                                                <td style="text-align: right;"
                                                                    id="bill_subtotal_gabungan">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Disc(<label for=""
                                                                        id="bill_discount_text_gabungan"></label>%)
                                                                </td>
                                                                <td style="width: 10px;">:</td>
                                                                <td style="text-align: right;"
                                                                    id="bill_potongan_value_gabungan">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>PPN (10%)</td>
                                                                <td>:</td>
                                                                <td style="text-align: right;" id="bill_ppn_gabungan">0
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grand Total</td>
                                                                <td>:</td>
                                                                <td style="text-align: right;"
                                                                    id="bill_grand_total_gabungan">0
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                        <hr>
                                        <div class="text-center bold">
                                            -- BILL TRANSAKSI --
                                        </div>
                                        <hr>
                                        <div class="text-center bold">
                                            -- TERIMA KASIH --
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End bill -->
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Gabung -->

    <!-- Modal Bill Biling -->
    <div id="my-modal-bill-billing" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title text-white">No.Pesanan <label id="lb_bill_billing_no_pesanan"></label> |
                        No.Meja
                        <label id="lb_bill_billing_no_meja"></label>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body" id="printArea3">
                            <div>
                                <div class="text-center bold" style="font-size: 14px;margin-top: 0px;">
                                    <!-- <img src="<?php echo base_url() ?>public/assets/images/millennialpos.png" alt=""> -->
                                    <h5>SHAMROCK COFFEE</h5>
                                </div>
                                <div class="text-center">
                                    Jl. STM Komplek SBC Block O No.9-12 i,
                                    Suka Maju, Kec. Medan Amplas, Kota Medan,
                                    Sumatera Utara
                                    20217<br>
                                    Telp: 0812-3456-7890<br>
                                </div>
                                <hr>
                                <div style="padding-left: 18px;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 20%;">
                                                Tanggal
                                            </td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 75%;"><span id="bill_billing_date_show"
                                                    style="font-weight: 500;"></span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Kasir
                                            </td>
                                            <td>:</td>
                                            <td><span id="bill_billing_chasier_show" style="font-weight: 500;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                No.order
                                            </td>
                                            <td>:</td>
                                            <td><span id="bill_billing_no_order_show" style="font-weight: 500;"></span>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <hr>
                                <div style="padding-left: 18px;">
                                    <!-- Barang -->
                                    <table style="width: 100%; font-size: 13px;">
                                        <tbody ng-repeat="group in groupedOrders">
                                            <tr class="fw-bold">
                                                <td colspan="3" style="padding-top: 0px; padding-bottom: 2px;">
                                                    Table : {{ group.no_meja }}
                                                    <hr class="my-1">
                                                </td>
                                            </tr>
                                            <tr ng-repeat="item in group.items">
                                                <td style="width: 8%; text-align: center;">[{{ item.qty }}]</td>
                                                <td style="width: 60%;">
                                                    {{ item.nama }}
                                                    <span ng-if="item.potongan !== null">
                                                        ({{item.discount}}%)
                                                    </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;">
                                                    {{ (item.qty * item.harga) - item.potongan | currency:'Rp ':0 }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <hr>
                                <!-- Perhitungan -->
                                <div style="padding-left: 18px;">
                                    <table style="width: 100%;">
                                        <tr>

                                            <td style="width: 100%;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td>Qty</td>
                                                        <td style="width: 10px;">:</td>
                                                        <td style="text-align: right;padding-right: 10px;font-weight: 500;"
                                                            id="bill_billing_qty_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Subtotal</td>
                                                        <td style="width: 10px;">:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_subtotal_show">0
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Discount (<label for=""
                                                                id="bill_billing_discount_persen"></label>%)</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_discount_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PPN (10%)</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_ppn_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Grand Total</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_grand_total_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Metode Bayar</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_metode_show">-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Dibayar</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_jumlah_dibayar_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kembalian</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_kembalian_show">0
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Service Metode</td>
                                                        <td>:</td>
                                                        <td style="text-align: right;font-weight: 500;"
                                                            id="bill_billing_service_metode_show">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <hr>
                                <div class="text-center bold">
                                    -- TERIMA KASIH --
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Bill Biling -->

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
    <!-- End Pindah Meja -->


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
</div>

<script>
function formatItem(name, qty, price) {
    const left = name.padEnd(16);
    const right = (qty + "x" + price).padStart(14);
    return left + right;
}
</script>

<!-- style -->
<style>
.card-body-scrollable {
    max-height: 700px;
    /* Sesuaikan tinggi maksimum sesuai kebutuhan */
    overflow-y: auto;
}

#card-body-scrollable2 {
    max-height: 400px;
    /* Sesuaikan tinggi maksimum sesuai kebutuhan */
    overflow-y: auto;
}
</style>

<style>
.pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.pagination .page-item {
    display: inline;
}

.pagination .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
}

.pagination .page-link:hover {
    z-index: 2;
    color: #0056b3;
    text-decoration: none;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        display: block;
        width: 100%;
        white-space: nowrap;
    }
}


.modal.modal-right .modal-dialog {
    position: fixed;
    margin: auto;
    width: 100%;
    /* Sesuaikan ukuran modal */
    height: 100%;
    right: 0;
    top: 0;
    bottom: 0;
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
}

.modal.modal-right.show .modal-dialog {
    transform: translateX(0);
}
</style>

<style>
@media print {
    body * {
        visibility: hidden;
    }

    #printArea,
    #printArea * {
        visibility: visible;
    }

    #printArea {
        position: absolute;
        left: 0;
        top: 00px;
        width: 280px;
        /* Sesuaikan ukuran kertas printer */
        font-family: Arial, Helvetica, sans-serif, monospace;
        font-size: 12px;
        margin: 0;
        padding: 0;
        margin-top: -80px;
    }

    @page {
        size: auto;
        /* Biarkan browser menyesuaikan tinggi sesuai isi */
        margin: 0;
        /* Hilangkan margin default browser */
    }

    .text-center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    hr {
        border: none;
        border-top: 5px dashed #000;
        margin: 4px 0;
        color: #000;
    }

    .total-line {
        font-weight: bold;
        font-size: 13px;
        padding-left: 10px;
    }

    .card-menu-scroll {
        max-height: 60vh;
        /* Tinggi menu list tetap scrollable */
        overflow-y: auto;
    }

}
</style>

<!-- Responsive Design CSS -->
<style>
/* Responsive adjustments for payment buttons */
@media (max-width: 576px) {
    #payment-action-buttons .col-12 {
        padding: 0.25rem !important;
    }

    #payment-action-buttons button {
        min-height: 85px !important;
        padding: 0.75rem !important;
        margin-bottom: 0.5rem;
    }

    #payment-action-buttons i {
        font-size: 1.4rem !important;
        margin-bottom: 0.5rem !important;
    }

    #payment-action-buttons span {
        font-size: 0.75rem !important;
    }
}

@media (min-width: 577px) and (max-width: 768px) {
    #payment-action-buttons button {
        min-height: 90px !important;
        padding: 0.85rem !important;
    }

    #payment-action-buttons i {
        font-size: 1.6rem !important;
    }

    #payment-action-buttons span {
        font-size: 0.8rem !important;
    }
}

@media (min-width: 769px) and (max-width: 992px) {
    #payment-action-buttons button {
        min-height: 95px !important;
    }
}

/* Touch-friendly on mobile */
@media (hover: none) and (pointer: coarse) {
    #payment-action-buttons button:active {
        transform: scale(0.98) !important;
        transition: transform 0.1s !important;
    }
}

/* Better spacing for tablet */
@media (min-width: 577px) and (max-width: 992px) {
    #payment-action-buttons {
        gap: 0.75rem !important;
    }

    #payment-action-buttons .col-sm-6 {
        margin-bottom: 0.5rem;
    }
}

/* Ensure consistent button height on all screens */
#payment-action-buttons button {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
}
</style>

<style>
.table-card {
    transition: all 0.2s;
    border-radius: 10px;
    cursor: pointer;
}

.table-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}
</style>