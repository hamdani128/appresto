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

var app = angular.module("HomeMitraApp", ["notifyAppMitra"]);
app.controller("HomeMitraAppController", function ($scope, $http) {
	$scope.LoadRowOrders = function () {
		var start_date = $("#date_start").val();
		var end_date = $("#date_end").val();

		var formdata = {
			start_date: start_date,
			end_date: end_date,
		};

		$http
			.post(base_url("home/get_row_orders"), formdata)
			.then(function (response) {
				$scope.row_orders = response.data;
			})
			.catch(function (error) {
				console.log(error);
			});
	};
	$scope.LoadRowOrders();

	$scope.LoadDataTransaksiMitra = function () {
		var start_date = $("#date_start").val();
		var end_date = $("#date_end").val();

		var formdata = {
			start_date: start_date,
			end_date: end_date,
		};
		$http
			.post(base_url("home/get_data_transaksi_mitra"), formdata)
			.then(function (response) {
				$scope.row_transaksi_mitra = response.data;
			})
			.catch(function (error) {
				console.log(error);
			});
	};

	$scope.LoadDataTransaksiMitra();

	$scope.FilterDataTransaksi = function () {
		$scope.LoadDataTransaksiMitra();
	};

	$scope.checkAll = false; // state header “Select All”
	$scope.selectedIds = [];

	$scope.toggleAll = function () {
		$scope.selectedIds = []; // Reset dulu
		angular.forEach($scope.row_orders, function (item) {
			item.checked = $scope.checkAll;
			if ($scope.checkAll) {
				$scope.selectedIds.push(item.id);
			}
		});
	};
	$scope.updateCheckedIds = function () {
		$scope.selectedIds = []; // Reset dahulu
		// Kosongkan dahulu
		// Loop semua LoadDataPesananDetail, jika item.checked==true, push id-nya
		$scope.row_orders.forEach(function (item) {
			if (item.checked) {
				$scope.selectedIds.push(item.id);
			}
		});
		// Jika jumlah yang ter-check sama dengan total row, biarkan checkAll = true,
		// kalau tidak, set checkAll = false (tujuannya, apabila tiba-tiba user
		// uncheck satu per satu sehingga header harus otomatis unset).
		$scope.checkAll = $scope.selectedIds.length === $scope.row_orders.length;
	};

	$scope.UpdateCompleted = function () {
		if ($scope.selectedIds.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Tidak ada menu yang dipilih !",
			});
			return;
		}
		// Contoh payload-nya berisi array selectedIds
		var payload = {
			ids: $scope.selectedIds,
		};
		// Kirim ke server, misalnya via POST:
		$http
			.post(base_url("opr/kasir/update_completed_food"), payload)
			.then(function (response) {
				$scope.LoadRowOrders();
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};

	$scope.GetSummaryMitra = function () {
		var date_start = $("#date_start").val();
		var date_end = $("#date_end").val();

		var formdata = {
			date_start: date_start,
			date_end: date_end,
		};

		$http
			.post(base_url("home/home_kasir_summary_mitra"), formdata)
			.then(function (response) {
				$scope.menu_deskripsi = response.data.menu_deskripsi;

				document.getElementById("revenue_kasir_mitra").innerHTML = formatRupiah(
					response.data.total_revenue
				);
				document.getElementById("visitors_kasir_mitra").innerHTML =
					formatNumber(response.data.total_visitor);
				document.getElementById("transactions_kasir_mitra").innerHTML =
					formatNumber(response.data.total_count_transaksi);

				// Ganti data chart
				myChart.data.datasets[0].data = response.data.visitor_chart; // New Visitor
				myChart.update();
			})
			.catch(function (error) {
				console.log(error);
			});
	};

	$scope.GetSummaryMitra();

	$scope.getSalesReport = function () {
		$scope.GetSummaryMitra();
	};
});

// Manual bootstrap
angular.element(document).ready(function () {
	angular.bootstrap(document.getElementById("notifyAppMitraDivMitra"), [
		"notifyAppMitra",
	]);
	angular.bootstrap(document.getElementById("contentAppDivMitra"), [
		"HomeMitraApp",
	]);
});

var chart3El = document.getElementById("chart3");

if (chart3El) {
var ctx = chart3El.getContext("2d");

var myChart = new Chart(ctx, {
	type: "line",
	data: {
		labels: [
			"Jan",
			"Feb",
			"Mar",
			"Apr",
			"May",
			"Jun",
			"Jul",
			"Aug",
			"Sep",
			"Oct",
			"Nov",
			"Dec",
		],
		datasets: [
			{
				label: "New Visitor",
				data: [], // akan diisi dari backend
				backgroundColor: [
					"#FF6384",
					"#36A2EB",
					"#FFCE56",
					"#4BC0C0",
					"#9966FF",
					"#FF9F40",
					"#E74C3C",
					"#2ECC71",
					"#F1C40F",
					"#1ABC9C",
					"#9B59B6",
					"#34495E",
				],
				borderColor: [
					"#FF6384",
					"#36A2EB",
					"#FFCE56",
					"#4BC0C0",
					"#9966FF",
					"#FF9F40",
					"#E74C3C",
					"#2ECC71",
					"#F1C40F",
					"#1ABC9C",
					"#9B59B6",
					"#34495E",
				],
				fill: {
					target: "origin",
					above: "#dfe6e9", // warna area di atas garis
				},
				tension: 0.4,
				pointRadius: 5,
				pointHoverRadius: 6,
				borderWidth: 2,
			},
		],
	},
	options: {
		maintainAspectRatio: false,
		responsive: true,
		plugins: {
			legend: {
				display: true,
			},
		},
		scales: {
			y: {
				beginAtZero: true,
			},
		},
	},
});
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
