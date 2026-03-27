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

var app = angular.module("ReportPeriodeApp", ["datatables"]);
app.controller("ReportPeriodeController", function ($scope, $http, $timeout) {
	let BTPrinter = null;
	$scope.detail_item = [];

	$scope.CheckBluetoothPrinter = async function () {
		BTPrinter = new ThermalPrinter();
	};
	$scope.CheckBluetoothPrinter();

	$scope.CetakPeriodeDetail = async function () {
		var startDate = $("#start_date").val();
		var EndDate = $("#end_date").val();

		if (startDate == "" || EndDate == "") {
			Swal.fire({
				title: "Perhatian!",
				text: "Tanggal awal dan akhir harus diisi!",
				icon: "warning",
				confirmButtonText: "Oke",
			});
			return;
		}

		try {
			const response = await $http.post(
				base_url("transaksi/invoice/get_transaksi_periode"),
				{ date_start: startDate, date_end: EndDate },
			);

			const reportData = response.data;

			if (!BTPrinter) throw "Bluetooth belum siap";

			await BTPrinter.connect();

			const text = $scope.BuilTextReport(startDate, EndDate, reportData);

			// 🔥 FIX UTAMA
			await printChunked(BTPrinter, text);

			showNotification("Berhasil cetak", "success");
		} catch (err) {
			console.error(err);
			showNotification("Gagal cetak Bluetooth", "error");
		}
	};

	$scope.CheckFilter = function () {
		var startDate = $("#start_date").val();
		var EndDate = $("#end_date").val();

		if (startDate == "" || EndDate == "") {
			Swal.fire({
				title: "Perhatian!",
				text: "Tanggal awal dan akhir harus diisi!",
				icon: "warning",
				confirmButtonText: "Oke",
			});

			return;
		}

		var formdata = {
			date_start: startDate,
			date_end: EndDate,
		};

		$http
			.post(
				base_url("transaksi/invoice/get_transaksi_periode_summary"),
				formdata,
			)
			.then(function (response) {
				var data = response.data;

				$scope.start_date = startDate;
				$scope.end_date = EndDate;

				// =====================
				// DEFAULT
				// =====================

				var cash = 0;
				var qris = 0;
				var transfer = 0;

				// =====================
				// METODE PEMBAYARAN
				// =====================

				if (data.metode && data.metode.length > 0) {
					angular.forEach(data.metode, function (item) {
						if (item.metode == "Cash") {
							cash = parseInt(item.total) || 0;
						}

						if (item.metode == "QRIS") {
							qris = parseInt(item.total) || 0;
						}

						if (item.metode == "Bank Transfer") {
							transfer = parseInt(item.total) || 0;
						}
					});
				}

				// =====================
				// DATA LAPORAN
				// =====================

				$scope.report = {
					cash: cash,
					qris: qris,
					transfer: transfer,

					saldo_awal: parseInt(data.saldo_awal.total) || 0,
					pengeluaran: parseInt(data.pengeluaran.total) || 0,

					detail: data.detail,
				};

				// =====================
				// TOTAL BELANJA
				// =====================

				$scope.total_belanja = cash + qris + transfer;

				// =====================
				// TOTAL LACI
				// =====================

				$scope.total_laci =
					$scope.report.saldo_awal + cash - $scope.report.pengeluaran;

				// =====================
				// PENDAPATAN BERSIH
				// =====================

				$scope.pendapatan_bersih =
					$scope.total_belanja - $scope.report.pengeluaran;
			});
	};

	$scope.BuilTextReport = function (date_start, date_end, data) {
		let text = "\x1B\x40";

		const LINE = "--------------------------------\n";
		const TITLE = "================================\n";

		const formatRupiah = (angka) => Number(angka || 0).toLocaleString("id-ID");

		const leftRight = (left, right, width = 32) => {
			let space = width - (left.length + right.length);
			return left + " ".repeat(space > 0 ? space : 1) + right + "\n";
		};

		// =====================
		// HEADER
		// =====================

		text += "\x1B\x61\x01"; // center
		text += "RUMAH KOPI DINDA\n";
		text += "Jl. RS Haji No 45A\n";
		text += "Medan - Sumut\n";
		text += "Telp: 085260207471\n";

		text += "\x1B\x61\x00"; // left

		text += LINE;
		text += "Periode : " + date_start + "\n";
		text += "     s/d " + date_end + "\n";
		text += LINE;

		// =====================
		// GROUP DATA PER MITRA
		// =====================

		let ownerMap = {};
		let total_penjualan = 0;

		data.detail.forEach((item) => {
			let owner = item.owner_name || "UMUM";

			if (!ownerMap[owner]) {
				ownerMap[owner] = [];
			}

			ownerMap[owner].push(item);
		});

		// =====================
		// LOOP MITRA
		// =====================

		Object.keys(ownerMap).forEach((owner) => {
			text += "\n";
			text += TITLE;
			text += "MITRA : " + owner + "\n";
			text += TITLE;

			let ownerTotal = 0;
			let lastGroup = "";

			ownerMap[owner].forEach((item) => {
				let group = item.jenis + " - " + item.kategori;

				if (group !== lastGroup) {
					text += group + "\n";

					lastGroup = group;
				}

				let subtotal = item.qty * item.harga;

				ownerTotal += subtotal;

				text += "  " + item.nama + "\n";

				text += leftRight(
					"    " + item.qty + " x " + formatRupiah(item.harga),
					formatRupiah(subtotal),
				);
			});

			text += "\n";

			// bold ON
			text += "\x1B\x45\x01";

			text += leftRight("SUBTOTAL MITRA", formatRupiah(ownerTotal));

			// bold OFF
			text += "\x1B\x45\x00";

			text += LINE;

			total_penjualan += ownerTotal;
		});

		// =====================
		// TOTAL PENJUALAN
		// =====================

		text += "\n";

		text += "\x1B\x45\x01"; // bold
		text += leftRight("TOTAL PENJUALAN", formatRupiah(total_penjualan));
		text += "\x1B\x45\x00"; // normal

		text += LINE;

		// =====================
		// PEMBAYARAN
		// =====================

		text += "PEMBAYARAN\n";

		text += leftRight("Cash", formatRupiah(data.cash));
		text += leftRight("QRIS", formatRupiah(data.qris));
		text += leftRight("Transfer", formatRupiah(data.transfer));

		text += LINE;

		// =====================
		// KAS LACI
		// =====================

		let total_laci =
			(data.saldo_awal || 0) + (data.cash || 0) - (data.pengeluaran || 0);

		text += "KAS LACI\n";

		text += leftRight("Saldo Awal", formatRupiah(data.saldo_awal));
		text += leftRight("Cash Masuk", formatRupiah(data.cash));
		text += leftRight("Tarik Uang", "-" + formatRupiah(data.pengeluaran));

		text += LINE;

		text += "\x1B\x45\x01";
		text += leftRight("TOTAL LACI", formatRupiah(total_laci));
		text += "\x1B\x45\x00";

		text += LINE;

		// =====================
		// PENDAPATAN BERSIH
		// =====================

		let pendapatan_bersih = total_penjualan - (data.pengeluaran || 0);

		text += "\x1B\x45\x01";
		text += leftRight("PENDAPATAN BERSIH", formatRupiah(pendapatan_bersih));
		text += "\x1B\x45\x00";

		text += LINE;

		text += "\n\n\n";

		return text;
	};

	$scope.printLaporanBluetooth = async function () {
		try {
			if (!BTPrinter) throw "Bluetooth belum siap";

			await BTPrinter.connect();

			const text = $scope.BuilTextReport(
				$scope.start_date,
				$scope.end_date,
				$scope.report,
			);

			await printChunked(BTPrinter, text);

			showNotification("Berhasil cetak", "success");
		} catch (err) {
			console.error(err);

			showNotification("Gagal cetak Bluetooth", "error");
		}
	};

	$scope.printLaporanUSB = async function () {
		try {
			await connectQZ();

			// Ambil printer default Windows
			const printerName = await qz.printers.getDefault();

			const config = qz.configs.create(printerName);

			const text = $scope.BuilTextReport(
				$scope.start_date,
				$scope.end_date,
				$scope.report,
			);
			const openDrawer = "\x1B\x70\x00\x19\xFA";

			const data = [text, openDrawer];

			await qz.print(config, data);

			showNotification("Cetak via: " + printerName, "success");
		} catch (err) {
			console.error(err);
			showNotification("Gagal cetak USB", "error");
		}
	};
});

async function printChunked(printer, text, chunkSize = 180) {
	const encoder = new TextEncoder();
	const bytes = encoder.encode(text);

	for (let i = 0; i < bytes.length; i += chunkSize) {
		const chunk = bytes.slice(i, i + chunkSize);
		await printer.print(chunk);
		await new Promise((r) => setTimeout(r, 120)); // ⏱️ WAJIB
	}
}
