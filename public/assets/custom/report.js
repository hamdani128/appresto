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
	$scope.report = {
		detail: [],
		payment_rows: [],
		service_summary: [],
		detail_groups: [],
		takeaway_detail: [],
		dine_in_detail: [],
		overview: {},
	};
	$scope.start_date = $("#start_date").val();
	$scope.end_date = $("#end_date").val();

	const toNumber = (value) => Number(value || 0);
	const formatRupiah = (angka) => Number(angka || 0).toLocaleString("id-ID");

	const buildServiceSummaryMap = (rows) => {
		const base = {
			"Dine In": {
				service_label: "Dine In",
				jumlah_transaksi: 0,
				total_qty: 0,
				total: 0,
			},
			Takeaway: {
				service_label: "Takeaway",
				jumlah_transaksi: 0,
				total_qty: 0,
				total: 0,
			},
		};

		(rows || []).forEach((row) => {
			const key =
				row.service_label && row.service_label.toLowerCase() === "takeaway"
					? "Takeaway"
					: "Dine In";
			base[key] = {
				service_label: key,
				jumlah_transaksi: toNumber(row.jumlah_transaksi),
				total_qty: toNumber(row.total_qty),
				total: toNumber(row.total),
			};
		});

		return base;
	};

	const normalizeDetailRows = (rows) =>
		(rows || []).map((item) => ({
			...item,
			qty: toNumber(item.qty),
			harga: toNumber(item.harga),
			subtotal: toNumber(item.subtotal),
			service_label:
				item.service_label && item.service_label.toLowerCase() === "takeaway"
					? "Takeaway"
					: "Dine In",
			owner_name: item.owner_name || item.owner || "UMUM",
		}));

	const summarizeByService = (rows) => {
		const grouped = {
			"Dine In": [],
			Takeaway: [],
		};

		rows.forEach((item) => {
			grouped[item.service_label].push(item);
		});

		return Object.keys(grouped).map((label) => {
			const items = grouped[label].sort((a, b) => b.subtotal - a.subtotal);
			return {
				service_label: label,
				items: items,
				total_qty: items.reduce((sum, item) => sum + item.qty, 0),
				total_amount: items.reduce((sum, item) => sum + item.subtotal, 0),
			};
		});
	};

	const summarizeTopItems = (rows, limit = 8) =>
		[...rows]
			.sort((a, b) => {
				if (b.qty !== a.qty) {
					return b.qty - a.qty;
				}

				return b.subtotal - a.subtotal;
			})
			.slice(0, limit);

	const hydrateReportState = (data, startDate, EndDate) => {
		$scope.start_date = startDate;
		$scope.end_date = EndDate;

		const paymentRows = (data.metode || []).map((item) => ({
			metode: item.metode || "Lainnya",
			jumlah: toNumber(item.jumlah),
			total: toNumber(item.total),
		}));
		const paymentMap = paymentRows.reduce((acc, item) => {
			acc[item.metode] = item.total;
			return acc;
		}, {});
		const serviceMap = buildServiceSummaryMap(data.service_summary || []);
		const detailRows = normalizeDetailRows(data.detail || []);
		const detailGroups = summarizeByService(detailRows);
		const overview = data.overview || {};
		const totalPendapatan = toNumber(overview.total_pendapatan);
		const totalTransaksi = toNumber(overview.jumlah_transaksi);
		const totalQty = toNumber(overview.total_qty);
		const totalTakeaway = toNumber(overview.total_takeaway);
		const takeawayTransaksi = toNumber(overview.transaksi_takeaway);
		const takeawayQty = toNumber(overview.qty_takeaway);
		const totalDineIn = Math.max(totalPendapatan - totalTakeaway, 0);
		const dineInTransaksi = Math.max(totalTransaksi - takeawayTransaksi, 0);
		const dineInQty = Math.max(totalQty - takeawayQty, 0);
		const saldoAwal = toNumber(data.saldo_awal && data.saldo_awal.total);
		const pengeluaran = toNumber(data.pengeluaran && data.pengeluaran.total);

		$scope.report = {
			cash: paymentMap.Cash || 0,
			qris: paymentMap.QRIS || 0,
			transfer: paymentMap.Transfer || 0,
			debit: paymentMap.Debit || 0,
			lainnya: paymentRows
				.filter(
					(item) =>
						!["Cash", "QRIS", "Transfer", "Debit"].includes(item.metode),
				)
				.reduce((sum, item) => sum + item.total, 0),
			saldo_awal: saldoAwal,
			pengeluaran: pengeluaran,
			payment_rows: paymentRows,
			service_summary: [serviceMap["Dine In"], serviceMap.Takeaway],
			detail: detailRows,
			detail_groups: detailGroups,
			dine_in_detail: detailRows.filter(
				(item) => item.service_label === "Dine In",
			),
			takeaway_detail: detailRows.filter(
				(item) => item.service_label === "Takeaway",
			),
			top_items: summarizeTopItems(detailRows),
			top_takeaway_items: summarizeTopItems(
				detailRows.filter((item) => item.service_label === "Takeaway"),
				6,
			),
			overview: {
				total_pendapatan: totalPendapatan,
				jumlah_transaksi: totalTransaksi,
				total_qty: totalQty,
				total_takeaway: totalTakeaway,
				transaksi_takeaway: takeawayTransaksi,
				qty_takeaway: takeawayQty,
				total_dine_in: totalDineIn,
				transaksi_dine_in: dineInTransaksi,
				qty_dine_in: dineInQty,
				rata_transaksi:
					totalTransaksi > 0 ? Math.round(totalPendapatan / totalTransaksi) : 0,
				porsi_takeaway:
					totalPendapatan > 0
						? ((totalTakeaway / totalPendapatan) * 100).toFixed(1)
						: "0.0",
			},
		};

		$scope.total_belanja = totalPendapatan;
		$scope.total_laci = saldoAwal + $scope.report.cash - pengeluaran;
		$scope.pendapatan_bersih = totalPendapatan - pengeluaran;
		return $scope.report;
	};

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
				base_url("transaksi/invoice/get_transaksi_periode_summary"),
				{ date_start: startDate, date_end: EndDate },
			);

			const reportData = hydrateReportState(response.data, startDate, EndDate);

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
				hydrateReportState(response.data, startDate, EndDate);
			});
	};

	$scope.BuilTextReport = function (date_start, date_end, data) {
		let text = "\x1B\x40";

		const LINE = "--------------------------------\n";
		const TITLE = "================================\n";

		const leftRight = (left, right, width = 32) => {
			let space = width - (left.length + right.length);
			return left + " ".repeat(space > 0 ? space : 1) + right + "\n";
		};

		// =====================
		// HEADER
		// =====================

		text += "\x1B\x61\x01"; // center
		if (typeof getReceiptHeaderText === "function") {
			text += getReceiptHeaderText();
		} else {
			text += "--------------------------------\n";
		}

		text += "\x1B\x61\x00"; // left

		text += "Periode : " + date_start + "\n";
		text += "     s/d " + date_end + "\n";
		text += LINE;

		text += "\x1B\x45\x01";
		text += leftRight(
			"TOTAL PENDAPATAN",
			formatRupiah(data.overview.total_pendapatan),
		);
		text += "\x1B\x45\x00";
		text += leftRight(
			"Total Transaksi",
			formatRupiah(data.overview.jumlah_transaksi),
		);
		text += leftRight("Total Item", formatRupiah(data.overview.total_qty));
		text += leftRight(
			"Rata-rata / Trx",
			formatRupiah(data.overview.rata_transaksi),
		);
		text += LINE;

		text += "RINGKASAN LAYANAN\n";
		(data.service_summary || []).forEach((row) => {
			text += leftRight(
				row.service_label + " (" + row.jumlah_transaksi + " trx)",
				formatRupiah(row.total),
			);
			text += leftRight("  Total Item", formatRupiah(row.total_qty));
		});
		text += LINE;

		text += "PEMBAYARAN\n";
		(data.payment_rows || []).forEach((row) => {
			text += leftRight(
				row.metode + " (" + row.jumlah + ")",
				formatRupiah(row.total),
			);
		});
		text += LINE;

		(data.detail_groups || []).forEach((serviceGroup) => {
			text += "\n";
			text += TITLE;
			text += "LAYANAN : " + serviceGroup.service_label.toUpperCase() + "\n";
			text += TITLE;

			let ownerMap = {};

			(serviceGroup.items || []).forEach((item) => {
				let owner = item.owner_name || "UMUM";
				if (!ownerMap[owner]) {
					ownerMap[owner] = [];
				}

				ownerMap[owner].push(item);
			});

			Object.keys(ownerMap).forEach((owner) => {
				let ownerTotal = 0;
				let lastGroup = "";
				text += "MITRA : " + owner + "\n";

				ownerMap[owner].forEach((item) => {
					let group = item.jenis + " - " + item.kategori;

					if (group !== lastGroup) {
						text += group + "\n";
						lastGroup = group;
					}

					ownerTotal += item.subtotal;
					text += "  " + item.nama + "\n";
					text += leftRight(
						"    " + item.qty + " x " + formatRupiah(item.harga),
						formatRupiah(item.subtotal),
					);
				});

				text += "\x1B\x45\x01";
				text += leftRight("SUBTOTAL MITRA", formatRupiah(ownerTotal));
				text += "\x1B\x45\x00";
				text += LINE;
			});
		});

		text += "\n";
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

		let pendapatan_bersih =
			(data.overview.total_pendapatan || 0) - (data.pengeluaran || 0);

		text += "\x1B\x45\x01";
		text += leftRight("PENDAPATAN BERSIH", formatRupiah(pendapatan_bersih));
		text += "\x1B\x45\x00";

		text += LINE;

		text += "\n\n\n";

		return text;
	};

	$scope.printLaporanBluetooth = async function () {
		try {
			if (typeof ensureReceiptSettingLoaded === "function") {
				await ensureReceiptSettingLoaded();
			}
			if (!BTPrinter) throw "Bluetooth belum siap";

			await BTPrinter.connect();

			const text = $scope.BuilTextReport(
				$scope.start_date,
				$scope.end_date,
				$scope.report,
			);

			if (
				typeof buildEscposFromText === "function" &&
				typeof printBytesChunked === "function"
			) {
				const escposBytes = await buildEscposFromText(text);
				await printBytesChunked(BTPrinter, escposBytes);
			} else {
				await printChunked(BTPrinter, text);
			}

			showNotification("Berhasil cetak", "success");
		} catch (err) {
			console.error(err);

			showNotification("Gagal cetak Bluetooth", "error");
		}
	};

	$scope.printLaporanUSB = async function () {
		try {
			if (typeof ensureReceiptSettingLoaded === "function") {
				await ensureReceiptSettingLoaded();
			}
			await connectQZ();

			// Ambil printer default Windows
			const printerName = await qz.printers.getDefault();

			const config = qz.configs.create(printerName);

			const text = $scope.BuilTextReport(
				$scope.start_date,
				$scope.end_date,
				$scope.report,
			);

			if (
				typeof buildEscposFromText === "function" &&
				typeof escposBytesToString === "function"
			) {
				const escposBytes = await buildEscposFromText(text);
				const rawData = escposBytesToString(escposBytes);
				await qz.print(config, [
					{
						type: "raw",
						format: "command",
						data: rawData,
					},
				]);
			} else {
				await qz.print(config, [text]);
			}

			showNotification("Cetak via: " + printerName, "success");
		} catch (err) {
			console.error(err);
			showNotification("Gagal cetak USB", "error");
		}
	};

	$timeout(function () {
		$scope.CheckFilter();
	}, 150);
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
