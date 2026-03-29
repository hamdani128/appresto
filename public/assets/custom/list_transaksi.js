function base_url(string_url) {
	var pathparts = location.pathname.split("/");
	if (
		location.host == "localhost:8080" ||
		location.host == "localhost" ||
		location.host == "10.32.18.206"
	) {
		var url = location.origin + "/" + pathparts[1].trim("/") + "/" + string_url; // http://localhost/myproject/
	} else {
		var url = location.origin + "/" + string_url; // http://stackoverflow.com
	}
	return url;
}

var app = angular.module("ListTransaksiApp", ["datatables"]);
app.controller(
	"ListTransaksiAppController",
	function ($scope, $http, $timeout) {
		$scope.data_transaksi = [];
		$scope.saldo_awal_data = [];
		$scope.pengeluaran_data = [];

		function applyTransaksiPayload(payload) {
			$scope.data_transaksi = Array.isArray(payload)
				? payload
				: (payload && payload.transaksi) || [];
			$scope.saldo_awal_data =
				(payload && payload.saldo_awal) || $scope.saldo_awal_data || [];
			$scope.pengeluaran_data =
				(payload && payload.pengeluaran) || $scope.pengeluaran_data || [];
		}

		$scope.sumField = function (items, field) {
			if (!Array.isArray(items) || !items.length) return 0;
			return items.reduce(function (total, item) {
				return total + (parseFloat((item && item[field]) || 0) || 0);
			}, 0);
		};

		$scope.getNetCashMovement = function () {
			return (
				$scope.sumField($scope.data_transaksi, "subtotal") +
				$scope.sumField($scope.saldo_awal_data, "saldo") -
				$scope.sumField($scope.pengeluaran_data, "amount")
			);
		};

		$scope.countByField = function (items, field, value) {
			if (!Array.isArray(items) || !items.length) return 0;
			return items.filter(function (item) {
				return ((item && item[field]) || "") === value;
			}).length;
		};

		$scope.countDistinct = function (items, field) {
			if (!Array.isArray(items) || !items.length) return 0;
			var values = items
				.map(function (item) {
					return ((item && item[field]) || "").toString().trim();
				})
				.filter(function (value) {
					return value !== "";
				});
			return new Set(values).size;
		};

		$scope.getDateRangeLabel = function () {
			var start = $("#start_date").val() || "-";
			var end = $("#end_date").val() || "-";
			return start === end ? start : start + " s/d " + end;
		};

		$scope.getSelectedTypeLabel = function () {
			var type = $("#type_transaction").val() || "All";
			if (type === "All") return "Semua owner kasir";
			if (type === "Owner") return "Owner internal";
			return "Mitra " + type;
		};

		$scope.LoadDataTransaksi = function () {
			var date_start = $("#start_date").val();
			var date_end = $("#end_date").val();
			var type = $("#type_transaction").val() || "All";
			var formdata = {
				date_start: date_start,
				date_end: date_end,
				type: type,
			};
			$http
				.post(base_url("transaksi/invoice/get_transaksi"), formdata)
				.then(function (response) {
					applyTransaksiPayload(response.data);
				})
				.catch(function (error) {
					console.log(error);
				});
		};

		$scope.LoadDataTransaksi();

		$scope.ComboMitra = function () {
			$http
				.get(base_url("master/mitra/getdata"))
				.then(function (response) {
					$scope.ComboMitraData = response.data;
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan:", error);
				});
		};

		$scope.ComboMitra();

		$scope.FilterData = function () {
			var date_start = $("#start_date").val();
			var date_end = $("#end_date").val();
			var type = $("#type_transaction").val();
			var formdata = {
				date_start: date_start,
				date_end: date_end,
				type: type,
			};
			$http
				.post(base_url("transaksi/invoice/get_transaksi"), formdata)
				.then(function (response) {
					applyTransaksiPayload(response.data);
				})
				.catch(function (error) {
					console.log(error);
				});
		};

		/*************  ✨ Windsurf Command ⭐  *************/
		/**
		 * Toggle row expansion and load detail items if expanded and not loaded yet
		 * @param {Object} dt - data object of the row to toggle
		 */
		/*******  efa75dbb-b2f6-4788-af5e-ec3bedff344e  *******/ $scope.toggleRow =
			function (dt) {
				dt.expanded = !dt.expanded;
				var type = $("#type_transaction").val();
				if (dt.expanded && !dt.detail_loaded) {
					dt.loading = true;
					$http
						.post(base_url("transaksi/invoice/get_detail_transaksi_by_owner"), {
							no_transaksi: dt.no_transaksi,
							type: type,
						})
						.then(function (res) {
							dt.detail_items = res.data;
							dt.detail_loaded = true;
							dt.loading = false;
						})
						.catch(function () {
							dt.loading = false;
							alert("Gagal load detail");
						});
				}
			};
		$scope.getTotalQtyToggleRow = function (items) {
			if (!items) return 0;
			return items.reduce(function (total, item) {
				return total + (parseInt(item.qty) || 0);
			}, 0);
		};

		$scope.showDetail = function (dt) {
			var no_booking = dt.no_order;
			var no_meja = dt.no_meja;
			$scope.DetailPesanan(no_booking, no_meja);
			$("#my-modal-show").modal("show");
		};
		$scope.LoadDataPesananDetail = [];
		$scope.LoadDataPesananGabungSementara = [];
		$scope.LoadDataPesananDetailAll = [];

		$scope.DetailPesanan = function (no_booking, no_meja) {
			var formdata = { no_booking: no_booking, no_meja: no_meja };
			$scope.LoadDataPesananDetail = [];
			$scope.LoadDataPesananGabungSementara = [];
			$scope.LoadDataPesananDetailAll = [];

			$http
				.post(base_url("transaksi/invoice/get_detail_transaksi"), formdata)
				.then(function (response) {
					var data = response.data.transaksi;
					document.getElementById("bill_date_show").innerHTML = data.created_at;
					document.getElementById("bill_chasier_show").innerHTML =
						data.created_by;
					document.getElementById("bill_no_order_show").innerHTML =
						data.no_order;
					document.getElementById("bill_qty_show").innerHTML = formatNumber(
						data.qty,
					);
					document.getElementById("bill_subtotal_show").innerHTML =
						formatRupiah(data.subtotal);
					document.getElementById("bill_ppn_show").innerHTML = formatRupiah(
						data.ppn,
					);
					document.getElementById("bill_grand_total_show").innerHTML =
						formatRupiah(data.amount_total);
					document.getElementById("bill_metode_show").innerHTML = data.metode;
					document.getElementById("bill_jumlah_dibayar_show").innerHTML =
						formatRupiah(data.dibayar);
					document.getElementById("bill_kembalian_show").innerHTML =
						formatRupiah(data.kembalian);
					document.getElementById("bill_service_metode_show").innerHTML =
						data.metode_service;
					$scope.LoadDataPesananDetail = response.data.detail_transaksi;
					$scope.UpdateGabungAll();
				});
		};

		$scope.UpdateGabungAll = function () {
			$scope.LoadDataPesananDetailAll = $scope.LoadDataPesananDetail.concat(
				$scope.LoadDataPesananGabungSementara,
			);

			// FIX PENTING → Pindahin ke $timeout supaya Angular selesai render DOM dulu
			$timeout(function () {
				$scope.groupPesananByOrder();
			}, 0);
		};

		$scope.groupedOrders = [];
		$scope.groupPesananByOrder = function () {
			$scope.groupedOrders = [];
			const dataGabungan = $scope.LoadDataPesananDetail.concat(
				$scope.LoadDataPesananGabungSementara,
			);

			dataGabungan.sort((a, b) => a.no_meja.localeCompare(b.no_meja)); // Sort by no_meja

			const grouped = {};

			dataGabungan.forEach(function (item) {
				if (!grouped[item.no_meja]) {
					grouped[item.no_meja] = {
						no_meja: item.no_meja,
						items: [],
					};
				}
				grouped[item.no_meja].items.push(item); // ← ini yang tadi salah, harusnya no_meja
			});

			$scope.groupedOrders = Object.values(grouped);
		};

		$scope.printCard = function (dt) {
			var no_booking = dt.no_order;
			var no_meja = dt.no_meja;
			var no_transaksi = dt.no_transaksi;
			var no_split = dt.no_split || null;

			document.getElementById("lb_bill_billing_no_pesanan").innerHTML =
				no_booking;
			document.getElementById("lb_bill_billing_no_meja").innerHTML = no_meja;

			$scope.DetailPesananBilling(no_booking, no_meja, no_transaksi, no_split);

			// // Unbind event dulu biar tidak dobel
			// $("#my-modal-bill-billing")
			// 	.off("shown.bs.modal")
			// 	.on("shown.bs.modal", function () {
			// 		// printCard("printArea3");
			// 	});

			// Tampilkan modal
			$("#my-modal-bill-billing").modal("show");
			printEppposAfterPayment();
		};

		$scope.DetailPesananBilling = function (
			no_booking,
			no_meja,
			no_transaksi,
			no_split,
		) {
			var formdata = {
				no_booking: no_booking,
				no_meja: no_meja,
				no_transaksi: no_transaksi,
				no_split: no_split,
			};
			$scope.LoadDataPesananDetail = [];
			$scope.LoadDataPesananGabungSementara = [];
			$scope.LoadDataPesananDetailAll = [];

			$http
				.post(base_url("transaksi/invoice/get_detail_transaksi"), formdata)
				.then(function (response) {
					var data = response.data.transaksi;
					document.getElementById("bill_billing_date_show").innerHTML =
						data.created_at;
					document.getElementById("bill_billing_chasier_show").innerHTML =
						data.created_by;
					document.getElementById("bill_billing_no_order_show").innerHTML =
						data.no_order;
					document.getElementById("bill_billing_qty_show").innerHTML =
						formatNumber(data.qty);
					document.getElementById("bill_billing_subtotal_show").innerHTML =
						formatRupiah(data.subtotal);

					document.getElementById("bill_billing_discount_persen").innerHTML =
						formatNumber(data.discount);
					document.getElementById("bill_billing_discount_show").innerHTML =
						formatRupiah(data.potongan);
					document.getElementById("bill_billing_ppn_show").innerHTML =
						formatRupiah(data.ppn);

					document.getElementById("bill_billing_grand_total_show").innerHTML =
						formatRupiah(data.amount_total);
					document.getElementById("bill_billing_metode_show").innerHTML =
						data.metode;
					document.getElementById(
						"bill_billing_jumlah_dibayar_show",
					).innerHTML = formatRupiah(data.dibayar);
					document.getElementById("bill_billing_kembalian_show").innerHTML =
						formatRupiah(data.kembalian);
					document.getElementById(
						"bill_billing_service_metode_show",
					).innerHTML = data.metode_service;
					$scope.LoadDataPesananDetail = response.data.detail_transaksi;
					$scope.UpdateGabungAll();
				});
		};

		$scope.UpdateGabungAll = function () {
			$scope.LoadDataPesananDetailAll = $scope.LoadDataPesananDetail.concat(
				$scope.LoadDataPesananGabungSementara,
			);

			// FIX PENTING → Pindahin ke $timeout supaya Angular selesai render DOM dulu
			$timeout(function () {
				$scope.CalculateTotalForGabung();
				$scope.groupPesananByOrder();
				$scope.CalculatePaymentGabung();
			}, 0);
		};

		$scope.CalculateTotalForGabung = function () {
			var total_harga = 0;
			var qty_total = 0;

			// Loop data pesanan
			var dataGabungan = $scope.LoadDataPesananDetail.concat(
				$scope.LoadDataPesananGabungSementara,
			);
			for (var i = 0; i < dataGabungan.length; i++) {
				var item = dataGabungan[i];
				var harga = parseInt(item.harga) || 0;
				var qty = parseInt(item.qty) || 0;
				var potongan = parseInt(item.potongan) || 0;
				var discount_percent = parseFloat(item.discount) || 0;

				var total = harga * qty;
				// var diskon = Math.floor(total * (discount_percent / 100));
				var subtotal = total - potongan;

				if (subtotal < 0) subtotal = 0;

				qty_total += qty;
				total_harga += subtotal;
			}

			// Update Qty dan Subtotal
			document.getElementById("qty-total-gabung").value =
				formatRupiah(qty_total);
			document.getElementById("bill_qty_gabungan").innerHTML =
				formatRupiah(qty_total);
			document.getElementById("amount-total-gabung").value =
				formatRupiah(total_harga);
			document.getElementById("bill_subtotal_gabungan").innerHTML =
				formatRupiah(total_harga);

			// Diskon tambahan dari input
			var discountInput =
				parseFloat(document.getElementById("discount-nominal-gabung").value) ||
				0;
			var discountValue = Math.floor(total_harga * (discountInput / 100));
			document.getElementById("discount-value-gabung").value =
				formatRupiah(discountValue);

			var subtotalSetelahDiskon = total_harga - discountValue;

			// Hitung PPN
			var ppn_percent = parseFloat($scope.ppnValue) || 0;
			var ppn_amount = Math.floor(subtotalSetelahDiskon * (ppn_percent / 100));
			document.getElementById("amount-ppn-gabung").value =
				formatRupiah(ppn_amount);
			document.getElementById("bill_ppn_gabungan").innerHTML =
				formatRupiah(ppn_amount);

			// Grand Total
			var grand_total = subtotalSetelahDiskon + ppn_amount;
			document.getElementById("grand-total-gabung").value =
				formatRupiah(grand_total);
			document.getElementById("bill_grand_total_gabungan").innerHTML =
				formatRupiah(grand_total);

			$scope.CalculatePaymentGabung();
		};
		$scope.CalculatePaymentGabung = function () {
			var total_qty = unformatNumber(
				document.getElementById("qty-total-gabung").value,
			);
			var subtoal = unformatNumber($("#amount-total-gabung").val());
			var ppn_text = unformatNumber($("#ppn-select-gabung").val());
			var ppn_value = unformatNumber(
				document.getElementById("amount-ppn-gabung").value,
			);
			var discount_text = unformatNumber(
				document.getElementById("discount-nominal-gabung").value,
			);
			var discount_value = unformatNumber(
				document.getElementById("discount-value-gabung").value,
			);
			var grand_total = unformatNumber(
				document.getElementById("grand-total-gabung").value,
			);
			document.getElementById(
				"total-qty-payment-BillGabungan-service",
			).innerHTML = formatNumber(total_qty);

			document.getElementById(
				"subtotal-payment-BillGabungan-service",
			).innerHTML = formatNumber(subtoal);

			// billl
			document.getElementById("bill_discount_text_gabungan").innerHTML =
				formatNumber(discount_text);
			document.getElementById("bill_potongan_value_gabungan").innerHTML =
				formatNumber(discount_value);

			// submit
			document.getElementById("bill_discount_persen_gabungan").innerHTML =
				formatNumber(discount_text);
			document.getElementById("bill_discount_value_gabungan").innerHTML =
				formatNumber(discount_value);

			document.getElementById(
				"ppn-text-payment-BillGabungan-service",
			).innerHTML = formatNumber(ppn_text);

			document.getElementById("ppn-payment-BillGabungan-service").innerHTML =
				formatNumber(ppn_value);

			document.getElementById(
				"grand-total-payment-BillGabungan-service",
			).innerHTML = formatNumber(grand_total);
		};

		$scope.groupedOrders = [];
		$scope.groupPesananByOrder = function () {
			$scope.groupedOrders = [];
			const dataGabungan = $scope.LoadDataPesananDetail.concat(
				$scope.LoadDataPesananGabungSementara,
			);

			dataGabungan.sort((a, b) => a.no_meja.localeCompare(b.no_meja)); // Sort by no_meja

			const grouped = {};

			dataGabungan.forEach(function (item) {
				if (!grouped[item.no_meja]) {
					grouped[item.no_meja] = {
						no_meja: item.no_meja,
						items: [],
					};
				}
				grouped[item.no_meja].items.push(item); // ← ini yang tadi salah, harusnya no_meja
			});

			$scope.groupedOrders = Object.values(grouped);
		};

		$scope.groupPesananByOrder();
	},
);

async function printEppposAfterPayment() {
	try {
		if (typeof ensureReceiptSettingLoaded === "function") {
			await ensureReceiptSettingLoaded();
		}
		if (!BTPrinter) throw "Bluetooth belum siap";

		await BTPrinter.connect();

		const text = buildBillTextAfterPayment();

		// 🔥 FIX UTAMA: encode string → bytes
		if (
			typeof buildEscposFromText === "function" &&
			typeof printBytesChunked === "function"
		) {
			const escposBytes = await buildEscposFromText(text);
			await printBytesChunked(BTPrinter, escposBytes);
		} else {
			await printChunked(BTPrinter, text);
		}
		// await BTPrinter.print(data); // ✅ sekarang BENAR

		showNotification("Berhasil cetak", "success");
	} catch (err) {
		console.error(err);
		showNotification("Gagal cetak Bluetooth", "error");
	}
}

function buildBillTextAfterPayment() {
	if (
		typeof getReceiptHeaderText === "function" &&
		typeof formatRupiah === "function"
	) {
		const scope = angular.element(document.getElementById("printArea3")).scope();
		const data = scope && scope.billingData ? scope.billingData : null;
		const groupedOrders = (scope && scope.groupedOrders) || [];

		if (data) {
			let receiptText = "";

			receiptText += getReceiptHeaderText();
			receiptText += "Tanggal   : " + data.created_at + "\n";
			receiptText += "No.Order  : " + data.no_order + "\n";
			receiptText += "No.Invoice: " + data.no_transaksi + "\n";
			receiptText += "Kasir     : " + data.created_by + "\n";
			receiptText += "No.Meja   : " + (data.no_meja || "-") + "\n";
			receiptText += "--------------------------------\n";

			groupedOrders.forEach((group) => {
				receiptText += "Table : " + group.no_meja + "\n";

				group.items.forEach((item) => {
					const qty = `[${item.qty}]`.padEnd(5, " ");
					const name = item.nama.substring(0, 16).padEnd(16, " ");
					const total = (item.qty * item.harga - (item.potongan || 0))
						.toLocaleString("id-ID")
						.padStart(8, " ");

					receiptText += `${qty}${name}${total}\n`;
				});

				receiptText += "--------------------------------\n";
			});

			receiptText += `Qty         : ${data.qty}\n`;
			receiptText += `Subtotal    : ${formatRupiah(data.subtotal)}\n`;
			receiptText += `Discount    : ${formatRupiah(data.potongan)}\n`;
			receiptText += `PPN ${data.ppn_persen || 10}%     : ${formatRupiah(data.ppn)}\n`;
			receiptText += "--------------------------------\n";
			receiptText += `GRAND TOTAL : ${formatRupiah(data.amount_total)}\n`;
			receiptText += `Metode Bayar: ${data.metode || "-"}\n`;
			receiptText += `Dibayar     : ${formatRupiah(data.dibayar || 0)}\n`;
			receiptText += `Kembalian   : ${formatRupiah(data.kembalian || 0)}\n`;

			if (data.metode_service) {
				receiptText += `Service     : ${data.metode_service}\n`;
			}

			receiptText += "--------------------------------\n";
			receiptText += "     -- BILL TRANSAKSI --     \n";
			receiptText += "      -- TERIMA KASIH --      \n";
			receiptText += " Barang yang sudah dibeli\n";
			receiptText += " tidak dapat dikembalikan\n\n\n";

			return receiptText;
		}
	}

	let text = "";
	const companyFallback = (document.getElementById("receipt_company_billing") || {})
		.textContent || "";
	const addressFallbackHtml = (
		(document.getElementById("receipt_address_billing") || {}).innerHTML || ""
	).replace(/<br\s*\/?>/gi, "\n");
	const addressFallback = addressFallbackHtml
		.split(/\r?\n/)
		.map((line) => line.trim())
		.filter(Boolean)
		.join("\n");

	// ===== HEADER =====
	if (companyFallback) {
		text += "   " + companyFallback.toUpperCase() + "  \n";
	}
	if (addressFallback) {
		text += addressFallback + "\n";
	}
	text += "--------------------------------\n";

	// ===== INFO TRANSAKSI =====
	text += "Tanggal : " + bill_billing_date_show.innerText + "\n";
	text += "Kasir   : " + bill_billing_chasier_show.innerText + "\n";
	text += "No.Order: " + bill_billing_no_order_show.innerText + "\n";
	text += "--------------------------------\n";

	// ===== ITEM PER MEJA =====
	const scope = angular.element(document.getElementById("printArea3")).scope();

	const groupedOrders = scope.groupedOrders || [];

	groupedOrders.forEach((group) => {
		text += `MEJA : ${group.no_meja}\n`;
		text += "--------------------------------\n";

		group.items.forEach((item) => {
			const qty = `[${item.qty}]`.padEnd(5, " ");
			const name = item.nama.substring(0, 16).padEnd(16, " ");
			const total = (item.qty * item.harga - (item.potongan || 0))
				.toLocaleString("id-ID")
				.padStart(8, " ");

			text += `${qty}${name}${total}\n`;
		});

		text += "--------------------------------\n";
	});

	// ===== TOTAL & PAYMENT =====
	text += `Qty        : ${bill_billing_qty_show.innerText}\n`;
	text += `Subtotal   : ${bill_billing_subtotal_show.innerText}\n`;
	text += `Discount   : ${bill_billing_discount_show.innerText}\n`;
	text += `PPN 10%    : ${bill_billing_ppn_show.innerText}\n`;
	text += "--------------------------------\n";

	text += `GRAND TOTAL  : ${bill_billing_grand_total_show.innerText}\n`;
	text += `Metode Bayar : ${bill_billing_metode_show.innerText}\n`;
	text += `Dibayar      : ${bill_billing_jumlah_dibayar_show.innerText}\n`;
	text += `Kembalian    : ${bill_billing_kembalian_show.innerText}\n`;

	// OPTIONAL (kadang kosong)
	const serviceMetode = bill_billing_service_metode_show.innerText.trim();
	if (serviceMetode !== "") {
		text += `Service    : ${serviceMetode}\n`;
	}

	text += "--------------------------------\n";

	// ===== FOOTER =====
	text += "      -- TERIMA KASIH --      \n";
	text += " Barang yang sudah dibeli\n";
	text += " tidak dapat dikembalikan\n\n\n";

	return text;
}

function formatRupiah(angka) {
	// Hapus semua karakter selain angka
	angka = angka.toString().replace(/\D/g, "");
	// Tambah titik ribuan
	return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi format angka: 1000000 => "1.000.000"
function formatNumber(num) {
	return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

async function printViaBluetooth(divId) {
	try {
		// Ambil konten print
		const printContent = document.getElementById(divId).innerHTML;
		const textContent = extractTextFromHTML(printContent);

		console.log("Mencari printer Bluetooth...");

		// Minta user memilih printer
		const device = await navigator.bluetooth.requestDevice({
			filters: [
				{ services: ["00001101-0000-1000-8000-00805f9b34fb"] }, // SPP service
				{ services: ["000018f0-0000-1000-8000-00805f9b34fb"] }, // Printer service
				{ namePrefix: "Blue" },
				{ namePrefix: "BT" },
				{ namePrefix: "Printer" },
				{ namePrefix: "POS" },
			],
			optionalServices: [
				"00001101-0000-1000-8000-00805f9b34fb",
				"000018f0-0000-1000-8000-00805f9b34fb",
				"0000ff00-0000-1000-8000-00805f9b34fb",
			],
		});

		console.log("Printer dipilih:", device.name);

		// Connect ke printer
		const server = await device.gatt.connect();
		console.log("Terhubung ke printer");

		// Cari service dan characteristic untuk menulis
		let characteristic = null;

		// Coba SPP service (umum untuk printer Bluetooth)
		try {
			const service = await server.getPrimaryService(
				"00001101-0000-1000-8000-00805f9b34fb",
			);
			const characteristics = await service.getCharacteristics();

			characteristic = characteristics.find(
				(c) => c.properties.write || c.properties.writeWithoutResponse,
			);
		} catch (e) {
			console.log("SPP service tidak ditemukan, cari service lain...");
		}

		// Jika tidak ada, cari semua service yang tersedia
		if (!characteristic) {
			const services = await server.getPrimaryServices();
			for (const service of services) {
				const characteristics = await service.getCharacteristics();
				const writableChar = characteristics.find(
					(c) => c.properties.write || c.properties.writeWithoutResponse,
				);
				if (writableChar) {
					characteristic = writableChar;
					break;
				}
			}
		}

		if (!characteristic) {
			throw new Error("Tidak bisa menemukan karakteristik untuk print");
		}

		// Siapkan data ESC/POS
		const escPosData = prepareEscPosData(textContent);

		// Kirim data ke printer
		await characteristic.writeValue(escPosData);
		console.log("Data berhasil dikirim ke printer");

		// Kirim perintah cut paper (jika printer support)
		setTimeout(async () => {
			try {
				const cutCommand = new Uint8Array([0x1d, 0x56, 0x41, 0x00]); // Partial cut
				await characteristic.writeValue(cutCommand);
				console.log("Perintah cut dikirim");
			} catch (e) {
				console.log("Printer tidak support cut atau sudah auto cut");
			}

			// Disconnect dari printer
			device.gatt.disconnect();
			console.log("Disconnected dari printer");
		}, 100);

		// Tampilkan notifikasi sukses
		showNotification(
			"✅ Bill berhasil dikirim ke printer Bluetooth!",
			"success",
		);
	} catch (error) {
		console.error("Error Bluetooth:", error);

		// Tampilkan error dan fallback ke print browser
		if (error.name === "NotFoundError") {
			showNotification(
				"❌ Tidak ada printer Bluetooth ditemukan. Pastikan printer sudah ON dan dalam mode pairing.",
				"error",
			);
		} else if (error.name === "SecurityError") {
			showNotification(
				"❌ Izin Bluetooth ditolak. Izinkan browser untuk mengakses Bluetooth.",
				"error",
			);
		} else if (error.name === "NotAllowedError") {
			showNotification("❌ Pencarian printer dibatalkan.", "info");
		} else {
			showNotification(
				`❌ ${error.message}. Menggunakan print browser...`,
				"warning",
			);
		}

		// Fallback ke print browser biasa
		setTimeout(() => printViaBrowser(divId), 1500);
	}
}

// Fungsi print via browser biasa
function printViaBrowser(divId) {
	const originalContent = document.body.innerHTML;
	const printContent = document.getElementById(divId).innerHTML;

	// Simpan halaman asli
	const originalPage = document.body.innerHTML;

	// Buat halaman khusus untuk print
	document.body.innerHTML = `
        <div class="print-container" style="
            width: 80mm;
            margin: 0 auto;
            padding: 5px 10px;
            font-family: Arial, sans-serif;
            font-size: 13px;
        ">
            ${printContent}
        </div>
    `;

	// Tambahkan style khusus untuk print
	const style = document.createElement("style");
	style.innerHTML = `
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
                width: 80mm;
            }
            .print-container {
                width: 100%;
                padding: 5px 10px;
                box-sizing: border-box;
            }
            img {
                max-width: 100%;
                height: auto;
                margin-bottom: 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 5px;
                font-size: 13px;
            }
            .text-center { text-align: center; }
            .bold { font-weight: bold; }
            .header-title {
                font-size: 10px;
                font-weight: bold;
                margin-bottom: 2px;
            }
            .sub-title {
                font-size: 10px;
                margin-bottom: 2px;
            }
            .item-row {
                font-size: 13px;
            }
            .totals {
                font-size: 14px;
                font-weight: bold;
            }
            hr {
                border: none;
                border-top: 1px dashed #000;
                margin: 4px 0;
            }
        }
        
        @media screen {
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: #f0f0f0;
            }
            .print-container {
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        }
    `;
	document.head.appendChild(style);

	// Tunggu sebentar agar style diterapkan
	setTimeout(() => {
		window.print();

		// Kembalikan halaman asli setelah 500ms
		setTimeout(() => {
			document.body.innerHTML = originalPage;
		}, 500);
	}, 100);
}

// Helper Functions
function extractTextFromHTML(html) {
	const div = document.createElement("div");
	div.innerHTML = html;
	let text = div.textContent || div.innerText || "";

	// Format untuk struk
	text = text.replace(/\s+/g, " ").trim();
	text = text.replace(/<[^>]*>/g, ""); // Hapus tag HTML jika ada
	text = text.replace(/&nbsp;/g, " "); // Ganti &nbsp; dengan spasi

	// Tambahkan format struk
	const lines = text.split("\n");
	const formattedLines = lines.map((line) => {
		line = line.trim();
		if (line.length > 32) {
			// Potong jika terlalu panjang untuk printer 80mm
			return line.substring(0, 32);
		}
		return line;
	});

	return formattedLines.join("\n");
}

function prepareEscPosData(text) {
	// ESC/POS Commands
	const commands = [];

	// Initialize printer
	commands.push(0x1b, 0x40); // ESC @ - Initialize

	// Set alignment center untuk header
	commands.push(0x1b, 0x61, 0x01); // ESC a 1 - Center align

	// Set font size (double height dan width)
	commands.push(0x1d, 0x21, 0x11); // GS ! 0x11 - Double height and width

	// Tambahkan text (konversi ke bytes)
	const encoder = new TextEncoder("iso-8859-1"); // Encoding untuk printer
	const textBytes = encoder.encode(text);

	// Gabungkan semua commands
	const result = new Uint8Array(commands.length + textBytes.length);
	result.set(new Uint8Array(commands), 0);
	result.set(textBytes, commands.length);

	return result;
}

function showNotification(message, type = "info") {
	// Buat elemen notifikasi
	const notification = document.createElement("div");
	notification.textContent = message;
	notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${
					type === "success"
						? "#4CAF50"
						: type === "error"
							? "#F44336"
							: type === "warning"
								? "#FF9800"
								: "#2196F3"
				};
        color: white;
        border-radius: 5px;
        z-index: 9999;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        font-family: Arial, sans-serif;
        max-width: 300px;
    `;

	document.body.appendChild(notification);

	// Auto hilang setelah 3 detik
	setTimeout(() => {
		notification.style.opacity = "0";
		notification.style.transition = "opacity 0.5s";
		setTimeout(() => {
			if (notification.parentNode) {
				notification.parentNode.removeChild(notification);
			}
		}, 500);
	}, 3000);
}
