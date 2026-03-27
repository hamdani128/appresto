function base_url(string_url) {
	var pathparts = location.pathname.split("/");
	if (
		location.host == "localhost:8080" ||
		location.host == "localhost" ||
		location.host == "10.32.18.206"
	) {
		var url =
			location.origin + "/" + pathparts[1].trim("/") + "/" + string_url;
	} else {
		var url = location.origin + "/" + string_url;
	}
	return url;
}

var app = angular.module("KasirTakeAwayApp", ["notifyAppMitra", "datatables"]);
app.controller("KasirTakeAwayAppController", function ($scope, $http) {
	$scope.LoadData = [];
	$scope.LoadDatMenuAll = [];
	$scope.filteredMenu = [];
	$scope.categories = [];
	$scope.LoadDataPesananList = [];
	$scope.keywordMenu = "";
	$scope.selectedCategory = "";
	$scope.queueLookup = "";
	$scope.total_qty = 0;
	$scope.amount_total = 0;
	$scope.discount_nominal = 0;
	$scope.discount_value = 0;
	$scope.ppn_percent = "";
	$scope.ppn_amount = 0;
	$scope.grand_total = 0;
	$scope.payment_method = "Cash";
	$scope.amount_paid = 0;
	$scope.change_amount = 0;
	$scope.payment_reference = "";
	$scope.serviceLabel = "Takeaway";
	$scope.queueNumber = "-";
	$scope.draftOrderNo = "-";
	$scope.invoiceNumber = "-";
	$scope.orderStatusLabel = "Draft";
	$scope.orderLocked = false;
	$scope.paymentCompleted = false;
	$scope.todayLabel = nowLabel();
	$scope.takeawayTransactions = [];
	$scope.takeawayTransactionsAll = [];
	$scope.transactionFilter = {
		start_date: todayInputValue(),
		end_date: todayInputValue(),
		keyword: "",
	};
	$scope.lastPaidTransaction = null;

	function nowLabel() {
		return new Date().toLocaleString("id-ID", {
			day: "2-digit",
			month: "short",
			year: "numeric",
			hour: "2-digit",
			minute: "2-digit",
		});
	}

	function todayInputValue() {
		var today = new Date();
		var month = String(today.getMonth() + 1).padStart(2, "0");
		var day = String(today.getDate()).padStart(2, "0");
		return today.getFullYear() + "-" + month + "-" + day;
	}

	function normalizeDateLabel(value) {
		if (!value) {
			return nowLabel();
		}

		var date = new Date(value);
		if (isNaN(date.getTime())) {
			return value;
		}

		return date.toLocaleString("id-ID", {
			day: "2-digit",
			month: "short",
			year: "numeric",
			hour: "2-digit",
			minute: "2-digit",
		});
	}

	function toNumber(value) {
		var number = parseFloat(value);
		return isNaN(number) ? 0 : number;
	}

	function isTakeawayTransaction(item) {
		var noMeja = ((item && item.no_meja) || "").toLowerCase();
		var service = ((item && item.metode_service) || "").toLowerCase();
		var invoiceNo = ((item && item.no_transaksi) || "").toUpperCase();

		return (
			noMeja === "takeaway" ||
			service === "takeaway" ||
			invoiceNo.indexOf("TKI") === 0
		);
	}

	function transactionMatchesKeyword(item, keyword) {
		if (!keyword) {
			return true;
		}

		var searchable = [
			item.no_transaksi,
			item.no_order,
			item.no_meja,
			item.metode,
			item.metode_service,
			item.created_at,
		]
			.join(" ")
			.toLowerCase();

		return searchable.indexOf(keyword) !== -1;
	}

	function createTransactionViewModel(item) {
		return angular.extend({}, item, {
			expanded: false,
			loading: false,
			detail_loaded: false,
			detail_items: [],
			print_loading: false,
			detail_summary: null,
		});
	}

	function sortTransactionsByNewest(items) {
		return items.sort(function (left, right) {
			var leftTime = new Date(left.created_at || left.tanggal || 0).getTime();
			var rightTime = new Date(right.created_at || right.tanggal || 0).getTime();
			return rightTime - leftTime;
		});
	}

	function applyTransactionFilters() {
		var keyword = ($scope.transactionFilter.keyword || "").toLowerCase().trim();

		$scope.takeawayTransactions = $scope.takeawayTransactionsAll.filter(
			function (item) {
				return transactionMatchesKeyword(item, keyword);
			},
		);
	}

	function getMenuKey(menu) {
		if (!menu) return "";
		return menu.id || menu.id_menu || menu.kode || menu.nama;
	}

	function recalculateItem(item) {
		var harga = toNumber(item.harga);
		var qty = toNumber(item.qty);
		item.subtotal = harga * qty;
		return item;
	}

	function hasOrderItems() {
		return $scope.LoadDataPesananList.length > 0;
	}

	function hasQueuedOrder() {
		return $scope.draftOrderNo && $scope.draftOrderNo !== "-";
	}

	function canEditDraft() {
		return !hasQueuedOrder() && !$scope.paymentCompleted;
	}

	function showEmptyOrderWarning() {
		Swal.fire({
			icon: "warning",
			title: "Mohon Perhatikan",
			text: "List pesanan masih kosong.",
		});
	}

	function showLockedOrderWarning() {
		Swal.fire({
			icon: "warning",
			title: "Order Sudah Masuk Antrian",
			text: "Batalkan antrian atau selesaikan pembayaran sebelum mengubah item.",
		});
	}

	function buildOrderDetailPayload() {
		return $scope.LoadDataPesananList.map(function (item) {
			return {
				kategori: item.kategori || "",
				nama: item.nama || "",
				harga: toNumber(item.harga),
				qty: toNumber(item.qty),
				jenis: item.jenis || "Menu",
				owner: item.owner || "Owner",
			};
		});
	}

	function applyLoadedOrder(data) {
		$scope.LoadDataPesananList = (data.detail || []).map(function (item) {
			var row = angular.copy(item);
			row.qty = toNumber(row.qty);
			row.discount = toNumber(row.discount);
			recalculateItem(row);
			return row;
		});

		$scope.discount_nominal = 0;
		$scope.discount_value = 0;
		$scope.ppn_percent = "";
		$scope.ppn_amount = 0;
		$scope.payment_method = "Cash";
		$scope.amount_paid = 0;
		$scope.change_amount = 0;
		$scope.payment_reference = "";
		$scope.draftOrderNo = data.no_order || "-";
		$scope.queueNumber = data.queue_no || "-";
		$scope.invoiceNumber = data.invoice_no || "-";
		$scope.orderStatusLabel = data.status_label || "Menunggu";
		$scope.orderLocked = true;
		$scope.paymentCompleted = false;
		$scope.todayLabel = normalizeDateLabel(data.created_at);
		$scope.CalculateTotal();
	}

	function resetDraft() {
		$scope.LoadDataPesananList = [];
		$scope.total_qty = 0;
		$scope.amount_total = 0;
		$scope.discount_nominal = 0;
		$scope.discount_value = 0;
		$scope.ppn_percent = "";
		$scope.ppn_amount = 0;
		$scope.grand_total = 0;
		$scope.payment_method = "Cash";
		$scope.amount_paid = 0;
		$scope.change_amount = 0;
		$scope.payment_reference = "";
		$scope.queueLookup = "";
		$scope.queueNumber = "-";
		$scope.draftOrderNo = "-";
		$scope.invoiceNumber = "-";
		$scope.orderStatusLabel = "Draft";
		$scope.orderLocked = false;
		$scope.paymentCompleted = false;
		$scope.todayLabel = nowLabel();
	}

	function closeMenuOffcanvas() {
		if (window.innerWidth >= 768 || typeof bootstrap === "undefined") {
			return;
		}

		var offcanvasEl = document.getElementById("menuOffcanvas");
		if (!offcanvasEl) {
			return;
		}

		var instance =
			bootstrap.Offcanvas.getInstance(offcanvasEl) ||
			bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);

		instance.hide();
	}

	function fetchTransactionDetail(transaction, onSuccess, onError) {
		$http
			.post(base_url("transaksi/invoice/get_detail_transaksi"), {
				no_booking: transaction.no_order || "",
				no_meja: transaction.no_meja || "Takeaway",
				no_transaksi: transaction.no_transaksi || "",
				no_split: null,
			})
			.then(function (response) {
				if (!response.data || !response.data.transaksi) {
					if (onError) {
						onError();
					}
					Swal.fire({
						icon: "error",
						title: "Gagal",
						text: "Detail transaksi takeaway tidak ditemukan.",
					});
					return;
				}

				if (onSuccess) {
					onSuccess(response.data);
				}
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat mengambil detail transaksi:", error);
				if (onError) {
					onError(error);
				}
				Swal.fire({
					icon: "error",
					title: "Gagal",
					text: "Tidak bisa mengambil detail transaksi takeaway.",
				});
			});
	}

	$scope.syncPaymentState = function () {
		if (!hasOrderItems()) {
			$scope.amount_paid = 0;
			$scope.change_amount = 0;
			return;
		}

		if ($scope.payment_method !== "Cash") {
			$scope.amount_paid = $scope.grand_total;
			$scope.change_amount = 0;
			return;
		}

		if (!toNumber($scope.amount_paid)) {
			$scope.amount_paid = $scope.grand_total;
		}

		$scope.change_amount = Math.max(
			0,
			toNumber($scope.amount_paid) - toNumber($scope.grand_total),
		);
	};

	$scope.isQueueReady = function () {
		return hasOrderItems() && !hasQueuedOrder() && !$scope.paymentCompleted;
	};

	$scope.isPaymentReady = function () {
		return hasOrderItems() && !$scope.paymentCompleted;
	};

	$scope.getCancelButtonLabel = function () {
		if ($scope.paymentCompleted) {
			return "Order Baru";
		}

		if (hasQueuedOrder()) {
			return "Batalkan";
		}

		return "Reset";
	};

	$scope.canPrintLastBill = function () {
		return !!(
			$scope.lastPaidTransaction &&
			$scope.lastPaidTransaction.no_transaksi
		);
	};

	$scope.LoadTakeawayTransactions = function () {
		var formdata = {
			date_start: $scope.transactionFilter.start_date,
			date_end: $scope.transactionFilter.end_date,
			type: "All",
		};

		$http
			.post(base_url("transaksi/invoice/get_transaksi"), formdata)
			.then(function (response) {
				var rows = Array.isArray(response.data.transaksi)
					? response.data.transaksi
					: [];

				$scope.takeawayTransactionsAll = sortTransactionsByNewest(
					rows.filter(isTakeawayTransaction).map(createTransactionViewModel),
				);
				applyTransactionFilters();
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat memuat transaksi:", error);
				Swal.fire({
					icon: "error",
					title: "Gagal",
					text: "Tidak bisa memuat list transaksi takeaway.",
				});
			});
	};

	$scope.applyTransactionFilters = function () {
		applyTransactionFilters();
	};

	$scope.toggleTransactionRow = function (transaction) {
		transaction.expanded = !transaction.expanded;

		if (!transaction.expanded || transaction.detail_loaded || transaction.loading) {
			return;
		}

		transaction.loading = true;
		fetchTransactionDetail(
			transaction,
			function (data) {
				transaction.detail_summary = data.transaksi || null;
				transaction.detail_items = Array.isArray(data.detail_transaksi)
					? data.detail_transaksi
					: [];
				transaction.detail_loaded = true;
				transaction.loading = false;
			},
			function () {
				transaction.loading = false;
			},
		);
	};

	$scope.getTransactionTotalQty = function (items) {
		if (!Array.isArray(items)) {
			return 0;
		}

		return items.reduce(function (total, item) {
			return total + toNumber(item.qty);
		}, 0);
	};

	$scope.printTransaction = function (transaction) {
		if (!transaction || !transaction.no_transaksi) {
			Swal.fire({
				icon: "info",
				title: "Print Bill",
				text: "Transaksi takeaway belum tersedia untuk dicetak.",
			});
			return;
		}

		if (transaction.print_loading) {
			return;
		}

		transaction.print_loading = true;
		fetchTransactionDetail(
			transaction,
			function (data) {
				transaction.print_loading = false;
				$scope.lastPaidTransaction = {
					no_order: data.transaksi.no_order || transaction.no_order || "",
					no_meja: data.transaksi.no_meja || transaction.no_meja || "Takeaway",
					no_transaksi:
						data.transaksi.no_transaksi || transaction.no_transaksi || "",
				};
				printTakeawayBluetoothReceipt(
					data.transaksi,
					Array.isArray(data.detail_transaksi) ? data.detail_transaksi : [],
				);
			},
			function () {
				transaction.print_loading = false;
			},
		);
	};

	$scope.showTransactionDetail = function (transaction) {
		if (!transaction || !transaction.no_transaksi) {
			return;
		}

		if (transaction.detail_loaded && Array.isArray(transaction.detail_items)) {
			Swal.fire({
				title: "Detail Transaksi",
				width: 780,
				html: buildTakeawayDetailHtml(
					transaction.detail_summary || transaction,
					transaction.detail_items,
				),
				confirmButtonText: "Tutup",
			});
			return;
		}

		fetchTransactionDetail(transaction, function (data) {
			transaction.detail_summary = data.transaksi || null;
			transaction.detail_items = Array.isArray(data.detail_transaksi)
				? data.detail_transaksi
				: [];
			transaction.detail_loaded = true;

			Swal.fire({
				title: "Detail Transaksi",
				width: 780,
				html: buildTakeawayDetailHtml(
					transaction.detail_summary || transaction,
					transaction.detail_items,
				),
				confirmButtonText: "Tutup",
			});
		});
	};

	$scope.ComboJenisMakanan = function () {
		$http
			.get(base_url("opr/kasir/getdata_kategori"))
			.then(function (response) {
				$scope.categories = Array.isArray(response.data) ? response.data : [];
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

	$scope.LoadDataMenu = function () {
		$http
			.get(base_url("opr/kasir/getdata_menu"))
			.then(function (response) {
				$scope.LoadDatMenuAll = Array.isArray(response.data) ? response.data : [];
				$scope.searchMenu();
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

	$scope.searchMenu = function () {
		var keyword = ($scope.keywordMenu || "").toLowerCase().trim();
		var selectedCategory = ($scope.selectedCategory || "").toLowerCase().trim();

		$scope.filteredMenu = $scope.LoadDatMenuAll.filter(function (menu) {
			var nama = ((menu && menu.nama) || "").toLowerCase();
			var kategori = ((menu && menu.kategori) || "").toLowerCase();
			var jenis = ((menu && menu.jenis) || "").toLowerCase();

			var keywordMatch =
				keyword === "" ||
				nama.includes(keyword) ||
				kategori.includes(keyword) ||
				jenis.includes(keyword);

			var categoryMatch =
				selectedCategory === "" || kategori === selectedCategory;

			return keywordMatch && categoryMatch;
		});
	};

	$scope.PilihMenu = function (dt) {
		if (!canEditDraft()) {
			showLockedOrderWarning();
			return;
		}

		if (dt && dt.status_food == "0") {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Menu " + dt.nama + " sedang tidak tersedia.",
			});
			return;
		}

		var existingItem = $scope.LoadDataPesananList.find(function (item) {
			return getMenuKey(item) === getMenuKey(dt);
		});

		if (existingItem) {
			existingItem.qty = toNumber(existingItem.qty) + 1;
			recalculateItem(existingItem);
		} else {
			var newItem = angular.copy(dt);
			newItem.qty = 1;
			newItem.discount = 0;
			recalculateItem(newItem);
			$scope.LoadDataPesananList.push(newItem);
		}

		$scope.CalculateTotal();
		closeMenuOffcanvas();
	};

	$scope.changeQty = function (item, delta) {
		if (!canEditDraft()) {
			showLockedOrderWarning();
			return;
		}

		if (!item) {
			return;
		}

		item.qty = toNumber(item.qty) + delta;

		if (item.qty <= 0) {
			$scope.removeItem(item);
			return;
		}

		recalculateItem(item);
		$scope.CalculateTotal();
	};

	$scope.removeItem = function (item) {
		if (!canEditDraft()) {
			showLockedOrderWarning();
			return;
		}

		var index = $scope.LoadDataPesananList.indexOf(item);
		if (index > -1) {
			$scope.LoadDataPesananList.splice(index, 1);
			$scope.CalculateTotal();
		}
	};

	$scope.CalculateTotal = function () {
		var subtotal = 0;
		var totalQty = 0;

		$scope.LoadDataPesananList.forEach(function (item) {
			recalculateItem(item);
			subtotal += toNumber(item.subtotal);
			totalQty += toNumber(item.qty);
		});

		if (toNumber($scope.discount_nominal) < 0) {
			$scope.discount_nominal = 0;
		}

		if (toNumber($scope.discount_nominal) > 100) {
			$scope.discount_nominal = 100;
		}

		var discountPercent = toNumber($scope.discount_nominal);
		var discountValue = Math.floor(subtotal * (discountPercent / 100));
		var netSubtotal = subtotal - discountValue;
		var ppnAmount = Math.floor(
			netSubtotal * (toNumber($scope.ppn_percent) / 100),
		);

		$scope.total_qty = totalQty;
		$scope.amount_total = subtotal;
		$scope.discount_value = discountValue;
		$scope.ppn_amount = ppnAmount;
		$scope.grand_total = netSubtotal + ppnAmount;
		$scope.syncPaymentState();
	};

	$scope.updatePaidAmount = function () {
		$scope.syncPaymentState();
	};

	$scope.createQueue = function () {
		if (!hasOrderItems()) {
			showEmptyOrderWarning();
			return;
		}

		if (hasQueuedOrder()) {
			Swal.fire({
				icon: "info",
				title: "Antrian Sudah Dibuat",
				text: "Order ini sudah punya no antrian. Lanjutkan ke pembayaran atau batalkan antrian.",
			});
			return;
		}

		var formdata = {
			order_detail: buildOrderDetailPayload(),
		};

		Swal.fire({
			title: "Buat antrian?",
			text: "Order takeaway akan disimpan dengan status Menunggu.",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Ya, buat",
			cancelButtonText: "Batal",
			reverseButtons: true,
		}).then(function (result) {
			if (!result.isConfirmed) {
				return;
			}

			$http
				.post(base_url("transaksi/takeaway/create_queue"), formdata)
				.then(function (response) {
					if (response.data.status !== "success") {
						Swal.fire({
							icon: "error",
							title: "Gagal",
							text:
								response.data.message ||
								"Gagal membuat antrian takeaway.",
						});
						return;
					}

					var createdQueue = response.data.queue_no || "-";
					var createdOrder = response.data.no_order || "-";
					resetDraft();
					$scope.queueLookup = createdQueue;

					Swal.fire({
						icon: "success",
						title: "Antrian Dibuat",
						text:
							"No antrian " +
							createdQueue +
							" berhasil dibuat untuk order " +
							createdOrder +
							". Form siap dipakai untuk order baru.",
					});
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan saat proses data:", error);
					Swal.fire({
						icon: "error",
						title: "Gagal",
						text: "Tidak bisa membuat antrian takeaway.",
					});
				});
		});
	};

	$scope.loadQueueByNumber = function () {
		if (!$scope.queueLookup) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Masukkan no antrian terlebih dahulu.",
			});
			return;
		}

		if (hasOrderItems() && !hasQueuedOrder() && !$scope.paymentCompleted) {
			Swal.fire({
				icon: "warning",
				title: "Draft Masih Terisi",
				text: "Reset atau jadikan antrian dulu draft yang sedang dibuka sebelum ambil no antrian lain.",
			});
			return;
		}

		if (hasQueuedOrder() && !$scope.paymentCompleted) {
			Swal.fire({
				icon: "warning",
				title: "Masih Ada Antrian Aktif",
				text: "Selesaikan atau batalkan antrian yang sedang terbuka dulu.",
			});
			return;
		}

		$http
			.post(base_url("transaksi/takeaway/find_queue"), {
				queue_no: $scope.queueLookup,
			})
			.then(function (response) {
				if (response.data.status !== "success") {
					Swal.fire({
						icon: "error",
						title: "Tidak Ditemukan",
						text:
							response.data.message ||
							"No antrian takeaway tidak ditemukan.",
					});
					return;
				}

				applyLoadedOrder(response.data);
				Swal.fire({
					icon: "success",
					title: "Antrian Ditemukan",
					text:
						"No antrian " +
						$scope.queueNumber +
						" siap dilanjutkan ke pembayaran.",
				});
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
				Swal.fire({
					icon: "error",
					title: "Gagal",
					text: "Tidak bisa mengambil data antrian takeaway.",
				});
			});
	};

	$scope.CetakBill = function () {
		if (!$scope.canPrintLastBill()) {
			Swal.fire({
				icon: "info",
				title: "Print Bill",
				text: "Bill takeaway bisa dicetak ulang setelah ada transaksi yang berhasil dibayar.",
			});
			return;
		}

		$scope.printTransaction($scope.lastPaidTransaction);
	};

	$scope.pay_after_service = function () {
		if (!hasOrderItems()) {
			showEmptyOrderWarning();
			return;
		}

		if ($scope.paymentCompleted) {
			Swal.fire({
				icon: "info",
				title: "Sudah Dibayar",
				text: "Order takeaway ini sudah dibayar.",
			});
			return;
		}

		var paidAmount = toNumber($scope.amount_paid);
		var grandTotal = toNumber($scope.grand_total);

		if (paidAmount < grandTotal) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Jumlah dibayar belum cukup untuk menyimpan transaksi.",
			});
			return;
		}

		var formdata = {
			no_order: hasQueuedOrder() ? $scope.draftOrderNo : "",
			order_detail: hasQueuedOrder() ? [] : buildOrderDetailPayload(),
			qty: toNumber($scope.total_qty),
			subtotal: toNumber($scope.amount_total),
			discount_text: toNumber($scope.discount_nominal),
			discount: toNumber($scope.discount_value),
			ppn_text: toNumber($scope.ppn_percent),
			ppn: toNumber($scope.ppn_amount),
			amount_total: grandTotal,
			metode: $scope.payment_method || "Cash",
			dibayar: paidAmount,
			kembalian:
				$scope.payment_method === "Cash"
					? toNumber($scope.change_amount)
					: 0,
			refrence_payment:
				$scope.payment_method === "Cash" ? "" : $scope.payment_method,
			refrence_number: $scope.payment_reference || "",
			metode_service: "Takeaway",
		};

		Swal.fire({
			title: "Lanjut pembayaran?",
			text:
				hasQueuedOrder()
					? "Pembayaran untuk no antrian " +
					  $scope.queueNumber +
					  " akan diproses dan invoice takeaway akan dibuat."
					: "Draft order ini akan langsung dibayar tanpa masuk antrian, dan invoice takeaway akan dibuat.",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Ya, bayar",
			cancelButtonText: "Batal",
			reverseButtons: true,
		}).then(function (result) {
			if (!result.isConfirmed) {
				return;
			}

			$http
				.post(base_url("transaksi/takeaway/submit_payment"), formdata)
				.then(function (response) {
					if (response.data.status !== "success") {
						Swal.fire({
							icon: "error",
							title: "Gagal",
							text:
								response.data.message ||
								"Transaksi takeaway gagal disimpan.",
						});
						return;
					}

					var createdInvoice = response.data.no_transaksi || "-";
					var paidQueue =
						response.data.queue_no && response.data.queue_no !== "-"
							? response.data.queue_no
							: "-";
					var successText =
						paidQueue !== "-"
							? "No antrian " +
							  paidQueue +
							  " selesai dibayar dengan invoice " +
							  createdInvoice +
							  ". Form siap dipakai untuk order baru."
							: "Invoice takeaway " +
							  createdInvoice +
							  " berhasil dibuat. Form siap dipakai untuk order baru.";

					$scope.lastPaidTransaction = {
						no_order: response.data.no_order || "-",
						no_meja: "Takeaway",
						no_transaksi: createdInvoice,
					};
					$scope.LoadTakeawayTransactions();
					resetDraft();

					Swal.fire({
						icon: "success",
						title: "Pembayaran Berhasil",
						text: successText,
					});
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan saat proses data:", error);
					Swal.fire({
						icon: "error",
						title: "Gagal",
						text: "Tidak bisa menyimpan pembayaran takeaway ke database.",
					});
				});
		});
	};

	$scope.SplitBill = function () {
		Swal.fire({
			icon: "info",
			title: "Tidak Dipakai",
			text: "Untuk flow takeaway ini tombol split bill diganti menjadi Buat Antrian.",
		});
	};

	$scope.cancel_order = function () {
		if ($scope.paymentCompleted) {
			resetDraft();
			return;
		}

		if (hasQueuedOrder()) {
			Swal.fire({
				title: "Batalkan antrian?",
				text:
					"No antrian " +
					$scope.queueNumber +
					" akan dihapus dari daftar order takeaway.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Ya, batalkan",
				cancelButtonText: "Kembali",
				reverseButtons: true,
			}).then(function (result) {
				if (!result.isConfirmed) {
					return;
				}

				$http
					.post(base_url("transaksi/takeaway/cancel_queue"), {
						no_order: $scope.draftOrderNo,
					})
					.then(function (response) {
						if (response.data.status !== "success") {
							Swal.fire({
								icon: "error",
								title: "Gagal",
								text:
									response.data.message ||
									"Gagal membatalkan antrian takeaway.",
							});
							return;
						}

						resetDraft();
						Swal.fire({
							icon: "success",
							title: "Dibatalkan",
							text: "Antrian takeaway berhasil dibatalkan.",
						});
					})
					.catch(function (error) {
						console.error("Terjadi kesalahan saat proses data:", error);
						Swal.fire({
							icon: "error",
							title: "Gagal",
							text: "Tidak bisa membatalkan antrian takeaway.",
						});
					});
			});
			return;
		}

		if (!hasOrderItems()) {
			showEmptyOrderWarning();
			return;
		}

		Swal.fire({
			title: "Reset draft?",
			text: "Semua item yang belum dibuatkan antrian akan dihapus dari form.",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Ya, reset",
			cancelButtonText: "Kembali",
			reverseButtons: true,
		}).then(function (result) {
			if (!result.isConfirmed) {
				return;
			}

			resetDraft();
		});
	};

	resetDraft();
	$scope.ComboJenisMakanan();
	$scope.LoadDataMenu();
	$scope.LoadTakeawayTransactions();
});

function formatTakeawayReceiptNumber(value) {
	var amount = parseFloat(value);
	return isNaN(amount) ? "0" : amount.toLocaleString("id-ID");
}

function escapeTakeawayHtml(value) {
	return String(value == null ? "" : value)
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#39;");
}

function buildTakeawayDetailHtml(data, items) {
	var rows = (items || [])
		.map(function (item) {
			var total =
				parseFloat(item.qty || 0) * parseFloat(item.harga || 0) -
				parseFloat(item.potongan || 0);

			return (
				"<tr>" +
				"<td>" +
				escapeTakeawayHtml(item.kategori || "-") +
				"</td>" +
				"<td>" +
				escapeTakeawayHtml(item.nama || "-") +
				"</td>" +
				"<td style='text-align:right;'>Rp " +
				formatTakeawayReceiptNumber(item.harga || 0) +
				"</td>" +
				"<td style='text-align:center;'>" +
				escapeTakeawayHtml(item.qty || 0) +
				"</td>" +
				"<td style='text-align:right;'>Rp " +
				formatTakeawayReceiptNumber(total) +
				"</td>" +
				"</tr>"
			);
		})
		.join("");

	if (!rows) {
		rows =
			"<tr><td colspan='5' style='text-align:center;color:#64748b;'>Detail item tidak tersedia.</td></tr>";
	}

	return (
		"<div style='text-align:left;'>" +
		"<div style='display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-bottom:16px;'>" +
		"<div><small style='color:#64748b;'>Invoice</small><div style='font-weight:700;'>" +
		escapeTakeawayHtml(data.no_transaksi || "-") +
		"</div></div>" +
		"<div><small style='color:#64748b;'>Order</small><div style='font-weight:700;'>" +
		escapeTakeawayHtml(data.no_order || "-") +
		"</div></div>" +
		"<div><small style='color:#64748b;'>Metode</small><div style='font-weight:700;'>" +
		escapeTakeawayHtml(data.metode || "-") +
		"</div></div>" +
		"<div><small style='color:#64748b;'>Grand Total</small><div style='font-weight:700;'>Rp " +
		formatTakeawayReceiptNumber(data.amount_total || data.subtotal || 0) +
		"</div></div>" +
		"</div>" +
		"<div style='overflow:auto;'>" +
		"<table style='width:100%;border-collapse:collapse;font-size:13px;'>" +
		"<thead>" +
		"<tr>" +
		"<th style='text-align:left;padding:8px;border-bottom:1px solid #e2e8f0;'>Kategori</th>" +
		"<th style='text-align:left;padding:8px;border-bottom:1px solid #e2e8f0;'>Nama</th>" +
		"<th style='text-align:right;padding:8px;border-bottom:1px solid #e2e8f0;'>Harga</th>" +
		"<th style='text-align:center;padding:8px;border-bottom:1px solid #e2e8f0;'>Qty</th>" +
		"<th style='text-align:right;padding:8px;border-bottom:1px solid #e2e8f0;'>Total</th>" +
		"</tr>" +
		"</thead>" +
		"<tbody>" +
		rows +
		"</tbody>" +
		"</table>" +
		"</div>" +
		"</div>"
	);
}

function getTakeawayBluetoothPrinter() {
	if (!navigator.bluetooth) {
		throw new Error("Browser ini belum mendukung cetak Bluetooth.");
	}

	if (!window.__takeawayBluetoothPrinter) {
		if (typeof ThermalPrinter === "undefined") {
			throw new Error("Modul printer Bluetooth belum siap.");
		}

		window.__takeawayBluetoothPrinter = new ThermalPrinter();
	}

	return window.__takeawayBluetoothPrinter;
}

async function printTakeawayChunked(printer, text, chunkSize = 180) {
	const encoder = new TextEncoder();
	const bytes = encoder.encode(text);

	for (let index = 0; index < bytes.length; index += chunkSize) {
		const chunk = bytes.slice(index, index + chunkSize);
		await printer.print(chunk);
		await new Promise((resolve) => setTimeout(resolve, 120));
	}
}

function buildTakeawayBillText(data, items) {
	let text = "";
	const kasir = data.fullname || data.created_by || "-";
	const tanggal = data.created_at || data.tanggal || "-";

	text += "   RUMAH KOPI DINDA  \n";
	text += "Jl. RS Haji NO. 45 A\n";
	text += "MEDAN - SUMATERA UTARA\n";
	text += "Telp: 085260207471\n";
	text += "--------------------------------\n";
	text += "Tanggal   : " + tanggal + "\n";
	text += "Kasir     : " + kasir + "\n";
	text += "No.Order  : " + (data.no_order || "-") + "\n";
	text += "No.Invoice: " + (data.no_transaksi || "-") + "\n";
	text += "Service   : " + (data.metode_service || "Takeaway") + "\n";
	text += "--------------------------------\n";

	(items || []).forEach(function (item) {
		const qty = "[" + (item.qty || 0) + "]";
		const name = ((item.nama || "-") + "").substring(0, 16).padEnd(16, " ");
		const total = formatTakeawayReceiptNumber(
			(parseFloat(item.qty || 0) * parseFloat(item.harga || 0)) -
				parseFloat(item.potongan || 0),
		).padStart(8, " ");

		text += qty.padEnd(5, " ") + name + total + "\n";
	});

	text += "--------------------------------\n";
	text += "Qty         : " + formatTakeawayReceiptNumber(data.qty || 0) + "\n";
	text +=
		"Subtotal    : " + formatTakeawayReceiptNumber(data.subtotal || 0) + "\n";
	text +=
		"Discount    : " + formatTakeawayReceiptNumber(data.potongan || 0) + "\n";
	text += "PPN         : " + formatTakeawayReceiptNumber(data.ppn || 0) + "\n";
	text +=
		"Grand Total : " +
		formatTakeawayReceiptNumber(data.amount_total || 0) +
		"\n";
	text += "Metode      : " + (data.metode || "-") + "\n";
	text +=
		"Dibayar     : " + formatTakeawayReceiptNumber(data.dibayar || 0) + "\n";
	text +=
		"Kembalian   : " +
		formatTakeawayReceiptNumber(data.kembalian || 0) +
		"\n";
	text += "--------------------------------\n";
	text += "      -- TERIMA KASIH --      \n";
	text += " Barang yang sudah dibeli\n";
	text += " tidak dapat dikembalikan\n\n\n";

	return text;
}

async function printTakeawayBluetoothReceipt(data, items) {
	try {
		const printer = getTakeawayBluetoothPrinter();
		await printer.connect();
		await printTakeawayChunked(printer, buildTakeawayBillText(data, items));

		Swal.fire({
			icon: "success",
			title: "Berhasil",
			text: "Struk takeaway berhasil dikirim ke printer Bluetooth.",
		});
	} catch (error) {
		console.error("Gagal cetak bluetooth takeaway:", error);
		Swal.fire({
			icon: "error",
			title: "Print Gagal",
			text:
				error && error.message
					? error.message
					: "Tidak bisa mencetak struk takeaway lewat Bluetooth.",
		});
	}
}
