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

var app = angular.module("HomeKasirApp", []);
app.controller("HomeKasirController", function ($scope, $http) {
	$scope.GetSummary = function () {
		var date_start = $("#date_start").val();
		var date_end = $("#date_end").val();

		var formdata = {
			date_start: date_start,
			date_end: date_end,
		};

		$http
			.post(base_url("home/home_kasir_summary"), formdata)
			.then(function (response) {
				$scope.menu_deskripsi = response.data.menu_deskripsi;

				document.getElementById("revenue_kasir").innerHTML = formatRupiah(
					response.data.total_revenue
				);
				document.getElementById("visitors_kasir").innerHTML = formatNumber(
					response.data.total_visitor
				);
				document.getElementById("transactions_kasir").innerHTML = formatNumber(
					response.data.total_count_transaksi
				);

				// Ganti data chart
				myChart.data.datasets[0].data = response.data.visitor_chart; // New Visitor
				myChart.update();
			})
			.catch(function (error) {
				console.log(error);
			});
	};

	$scope.GetSummary();

	$scope.getSalesReport = function () {
		$scope.GetSummary();
	};
});

var ctx = document.getElementById("chart1").getContext("2d");

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
