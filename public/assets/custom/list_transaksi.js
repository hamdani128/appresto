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
		// $scope.data_transaksi = [];
		$scope.LoadDataTransaksi = function () {
			var date_start = $("#start_date").val();
			var date_end = $("#end_date").val();
			var formdata = {
				date_start: date_start,
				date_end: date_end,
			};
			$http
				.post(base_url("transaksi/invoice/get_transaksi"), formdata)
				.then(function (response) {
					$scope.data_transaksi = response.data;
				})
				.catch(function (error) {
					console.log(error);
				});
		};

		$scope.LoadDataTransaksi();

		$scope.FilterData = function () {
			var date_start = $("#start_date").val();
			var date_end = $("#end_date").val();
			var formdata = {
				date_start: date_start,
				date_end: date_end,
			};
			$http
				.post(base_url("transaksi/invoice/get_transaksi"), formdata)
				.then(function (response) {
					$scope.data_transaksi = response.data;
				})
				.catch(function (error) {
					console.log(error);
				});
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
						data.qty
					);
					document.getElementById("bill_subtotal_show").innerHTML =
						formatRupiah(data.subtotal);
					document.getElementById("bill_ppn_show").innerHTML = formatRupiah(
						data.ppn
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
				$scope.LoadDataPesananGabungSementara
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
				$scope.LoadDataPesananGabungSementara
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
			$scope.DetailPesanan(no_booking, no_meja);

			// Tampilkan modal
			$("#my-modal-show").modal("show");

			// Setelah modal selesai muncul, baru cetak
			$("#my-modal-show").on("shown.bs.modal", function () {
				printCard("printArea2");

				// Optional: Unbind event biar tidak dobel
				$(this).off("shown.bs.modal");
			});
		};
	}
);

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

function printCard(divId) {
	const divContents = document.getElementById(divId).innerHTML;
	const printWindow = window.open("", "_blank", "width=800,height=600");

	printWindow.document.write(`
        <html>
            <head>
                <title>Cetak Bill</title>
                <style>
                    @page {
                        size: 80mm auto;
                        margin: 0;
                    }
                    body {
                        margin: 0;
                        padding: 0;
                        font-family: Arial, sans-serif;
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
                        font-size: 13px; /* Naikkan font default tabel */
                    }
                    .text-center { text-align: center; }
                    .bold { font-weight: bold; }
                    .header-title {
                        font-size: 10px; /* Naikkan ukuran judul */
                        font-weight: bold;
                        margin-bottom: 2px;
                    }
                    .sub-title {
                        font-size: 10px; /* Naikkan subtitle sedikit */
                        margin-bottom: 2px;
                    }
                    .item-row {
                        font-size: 13px; /* Naikkan size item */
                    }
                    .totals {
                        font-size: 14px; /* Naikkan total biar enak dibaca */
                        font-weight: bold;
                    }
                    hr {
                        border: none;
                        border-top: 1px dashed #000;
                        margin: 4px 0;
                    }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                <div class="print-container">
                    ${divContents}
                </div>
            </body>
        </html>
    `);

	printWindow.document.close();
}
