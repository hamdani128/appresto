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
				{ date_start: startDate, date_end: EndDate }
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

	$scope.BuilTextReport = function (date_start, date_end, data) {
		let text = "\x1B\x40";
		let lastGroup = "";
		let grandTotal = 0;

		const formatRupiah = (angka) =>
			angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

		const padLeft = (str, len) => str.toString().padStart(len);

		text += "        SHAMROCK COFFEE        \n";
		text += "Jl. STM Komplek SBC Block O No.9-12 i\n";
		text += "Suka Maju, Kec. Medan Johor\n";
		text += "Kota Medan - Sumatera Utara\n";
		text += "Telp: 082320103919\n";
		text += "--------------------------------\n";
		text += "Periode : " + date_start + "\n";
		text += "     s/d " + date_end + "\n";
		text += "Kasir   : " + (data.kasir || "-") + "\n";
		text += "--------------------------------\n";

		data.detail.forEach(function (item) {
			let group = item.jenis + " - " + item.kategori;

			if (group !== lastGroup) {
				text += group + "\n";
				lastGroup = group;
			}

			let subtotal = item.qty * item.harga;
			grandTotal += subtotal;

			text += "  " + item.nama + "\n";
			text +=
				"           x" +
				padLeft(item.qty, 2) +
				padLeft(formatRupiah(subtotal), 17) +
				"\n\n";
		});

		text += "--------------------------------\n";
		text += "TOTAL".padEnd(20) + formatRupiah(grandTotal).padStart(12) + "\n";
		text += "--------------------------------\n\n\n";

		return text;
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
