function base_url(string_url) {
	var pathparts = location.pathname.split("/");
	if (
		location.host == "localhost:8080" ||
		location.host == "localhost" ||
		location.host == "10.32.18.206"
	) {
		return location.origin + "/" + pathparts[1].trim("/") + "/" + string_url;
	}
	return location.origin + "/" + string_url;
}

function toNumber(value) {
	var numericValue = Number(value);
	return isFinite(numericValue) ? numericValue : 0;
}

function formatRupiah(value) {
	return new Intl.NumberFormat("id-ID").format(toNumber(value));
}

function formatNumber(value) {
	return new Intl.NumberFormat("id-ID").format(toNumber(value));
}

function safeSetText(id, value) {
	var element = document.getElementById(id);
	if (element) {
		element.innerHTML = value;
	}
}

function getLocalDateString() {
	var now = new Date();
	var year = now.getFullYear();
	var month = String(now.getMonth() + 1).padStart(2, "0");
	var day = String(now.getDate()).padStart(2, "0");
	return year + "-" + month + "-" + day;
}

var app = angular.module("HomeKasirApp", []);
app.controller("HomeKasirController", function ($scope, $http, $timeout) {
	var trendChart = null;
	var compositionChart = null;

	$scope.dashboard = {
		summary: {
			total_revenue: 0,
			total_visitor: 0,
			total_count_transaksi: 0,
			takeaway_revenue: 0,
			takeaway_count_transaksi: 0,
			dine_in_revenue: 0,
			dine_in_count_transaksi: 0,
			takeaway_share: 0,
		},
		menu_deskripsi: [],
		payment_summary: [],
		trend: {
			labels: [],
			all: [],
			takeaway: [],
			dine_in: [],
		},
		composition: {
			labels: ["Dine In", "Takeaway"],
			values: [0, 0],
		},
		date_start: "",
		date_end: "",
	};
	$scope.menu_deskripsi = [];
	$scope.paymentMaxAmount = 0;

	function getInputValue(id, fallbackValue) {
		var element = document.getElementById(id);
		if (!element || !element.value) {
			return fallbackValue;
		}
		return element.value;
	}

	function createLineGradient(context, chartArea, colors) {
		var gradient = context.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
		gradient.addColorStop(0, colors[0]);
		gradient.addColorStop(1, colors[1]);
		return gradient;
	}

	function getChartTextColor() {
		return "#475569";
	}

	function getGridColor() {
		return "rgba(148, 163, 184, 0.18)";
	}

	function getRatio(amount, total) {
		var normalizedTotal = toNumber(total);
		if (normalizedTotal <= 0) {
			return 0;
		}
		return (toNumber(amount) / normalizedTotal) * 100;
	}

	function getRevenueSummary() {
		return $scope.dashboard && $scope.dashboard.summary
			? $scope.dashboard.summary
			: {};
	}

	function renderTrendChart(trend) {
		var canvas = document.getElementById("chart1");
		if (!canvas) {
			return;
		}

		var context = canvas.getContext("2d");
		var labels = trend && trend.labels ? trend.labels : [];
		var totalSeries = trend && trend.all ? trend.all : [];
		var takeawaySeries = trend && trend.takeaway ? trend.takeaway : [];

		var totalFill = "rgba(14, 165, 233, 0.16)";
		var takeawayFill = "rgba(16, 185, 129, 0.16)";

		if (trendChart) {
			if (trendChart.chartArea) {
				totalFill = createLineGradient(context, trendChart.chartArea, [
					"rgba(14, 165, 233, 0.30)",
					"rgba(14, 165, 233, 0.02)",
				]);
				takeawayFill = createLineGradient(context, trendChart.chartArea, [
					"rgba(16, 185, 129, 0.26)",
					"rgba(16, 185, 129, 0.03)",
				]);
			}

			trendChart.data.labels = labels;
			trendChart.data.datasets[0].data = totalSeries;
			trendChart.data.datasets[0].backgroundColor = totalFill;
			trendChart.data.datasets[1].data = takeawaySeries;
			trendChart.data.datasets[1].backgroundColor = takeawayFill;
			trendChart.update();
			return;
		}

		trendChart = new Chart(context, {
			type: "line",
			data: {
				labels: labels,
				datasets: [
					{
						label: "Total Transaksi",
						data: totalSeries,
						borderColor: "#0ea5e9",
						backgroundColor: totalFill,
						fill: true,
						tension: 0.42,
						pointRadius: 3.5,
						pointHoverRadius: 5,
						pointBackgroundColor: "#ffffff",
						pointBorderWidth: 2,
						pointBorderColor: "#0ea5e9",
						borderWidth: 3,
					},
					{
						label: "Takeaway",
						data: takeawaySeries,
						borderColor: "#10b981",
						backgroundColor: takeawayFill,
						fill: true,
						tension: 0.42,
						pointRadius: 3.5,
						pointHoverRadius: 5,
						pointBackgroundColor: "#ffffff",
						pointBorderWidth: 2,
						pointBorderColor: "#10b981",
						borderWidth: 3,
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				responsive: true,
				interaction: {
					mode: "index",
					intersect: false,
				},
				plugins: {
					legend: {
						display: true,
						position: "top",
						align: "start",
						labels: {
							usePointStyle: true,
							pointStyle: "circle",
							boxWidth: 8,
							padding: 18,
							color: getChartTextColor(),
							font: {
								family: "system-ui",
								size: 12,
								weight: "600",
							},
						},
					},
					tooltip: {
						backgroundColor: "rgba(15, 23, 42, 0.92)",
						titleColor: "#f8fafc",
						bodyColor: "#e2e8f0",
						padding: 12,
						displayColors: true,
						usePointStyle: true,
					},
				},
				scales: {
					x: {
						grid: {
							display: false,
						},
						ticks: {
							color: getChartTextColor(),
							maxRotation: 0,
							autoSkip: true,
						},
					},
					y: {
						beginAtZero: true,
						grid: {
							color: getGridColor(),
						},
						ticks: {
							color: getChartTextColor(),
							precision: 0,
						},
					},
				},
			},
		});
	}

	function renderCompositionChart(composition) {
		var canvas = document.getElementById("dashboardMixChart");
		if (!canvas) {
			return;
		}

		var context = canvas.getContext("2d");
		var labels = composition && composition.labels ? composition.labels : ["Dine In", "Takeaway"];
		var values = composition && composition.values ? composition.values : [0, 0];

		if (compositionChart) {
			compositionChart.data.labels = labels;
			compositionChart.data.datasets[0].data = values;
			compositionChart.update();
			return;
		}

		compositionChart = new Chart(context, {
			type: "doughnut",
			data: {
				labels: labels,
				datasets: [
					{
						data: values,
						backgroundColor: ["#0ea5e9", "#10b981"],
						borderColor: ["#ffffff", "#ffffff"],
						borderWidth: 4,
						hoverOffset: 8,
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				cutout: "68%",
				plugins: {
					legend: {
						position: "bottom",
						labels: {
							usePointStyle: true,
							pointStyle: "circle",
							padding: 18,
							color: getChartTextColor(),
							font: {
								family: "system-ui",
								size: 12,
								weight: "600",
							},
						},
					},
					tooltip: {
						backgroundColor: "rgba(15, 23, 42, 0.92)",
						titleColor: "#f8fafc",
						bodyColor: "#e2e8f0",
						padding: 12,
					},
				},
			},
		});
	}

	function syncLegacySummary(summary) {
		safeSetText("revenue_kasir", formatRupiah(summary.total_revenue));
		safeSetText("visitors_kasir", formatNumber(summary.total_visitor));
		safeSetText("transactions_kasir", formatNumber(summary.total_count_transaksi));
	}

	function refreshDashboardVisuals() {
		$timeout(function () {
			syncLegacySummary($scope.dashboard.summary || {});
			renderTrendChart($scope.dashboard.trend);
			renderCompositionChart($scope.dashboard.composition);
		}, 0);
	}

	$scope.getPaymentBarStyle = function (amount) {
		if ($scope.paymentMaxAmount <= 0) {
			return {
				width: "0%",
			};
		}

		return {
			width: Math.max((toNumber(amount) / $scope.paymentMaxAmount) * 100, 12) + "%",
		};
	};

	$scope.getPaymentTone = function (label) {
		switch ((label || "").toLowerCase()) {
			case "cash":
				return "cash";
			case "qris":
				return "qris";
			case "transfer":
				return "transfer";
			case "debit":
				return "debit";
			default:
				return "other";
		}
	};

	$scope.getRevenueShare = function (amount) {
		var summary = getRevenueSummary();
		return getRatio(amount, summary.total_revenue);
	};

	$scope.getRevenueBarStyle = function (amount) {
		var width = $scope.getRevenueShare(amount);
		return {
			width: (width > 0 ? Math.max(width, 8) : 0) + "%",
		};
	};

	$scope.getRevenueDiff = function () {
		var summary = getRevenueSummary();
		return Math.abs(
			toNumber(summary.dine_in_revenue) - toNumber(summary.takeaway_revenue)
		);
	};

	$scope.getRevenueLeaderLabel = function () {
		var summary = getRevenueSummary();
		var dineIn = toNumber(summary.dine_in_revenue);
		var takeaway = toNumber(summary.takeaway_revenue);

		if (dineIn === 0 && takeaway === 0) {
			return "Belum ada omzet";
		}

		if (dineIn === takeaway) {
			return "Omzet berimbang";
		}

		return dineIn > takeaway ? "Dine In unggul" : "Takeaway unggul";
	};

	$scope.getRevenueLeaderCopy = function () {
		var summary = getRevenueSummary();
		var dineIn = toNumber(summary.dine_in_revenue);
		var takeaway = toNumber(summary.takeaway_revenue);

		if (dineIn === 0 && takeaway === 0) {
			return "Belum ada pergerakan omzet pada periode aktif.";
		}

		if (dineIn === takeaway) {
			return "Dine In dan takeaway mencatat omzet yang seimbang.";
		}

		return dineIn > takeaway
			? "Dine In memimpin omzet saat ini."
			: "Takeaway memimpin omzet saat ini.";
	};

	$scope.GetSummary = function () {
		var today = getLocalDateString();
		var date_start = getInputValue("date_start", today);
		var date_end = getInputValue("date_end", today);

		$http
			.post(base_url("home/home_kasir_summary"), {
				date_start: date_start,
				date_end: date_end,
			})
			.then(function (response) {
				var payload = response.data || {};
				var summary = payload.summary || {
					total_revenue: payload.total_revenue || 0,
					total_visitor: payload.total_visitor || 0,
					total_count_transaksi: payload.total_count_transaksi || 0,
					takeaway_revenue: payload.takeaway_revenue || 0,
					takeaway_count_transaksi: payload.takeaway_count_transaksi || 0,
					dine_in_revenue: payload.dine_in_revenue || 0,
					dine_in_count_transaksi: payload.dine_in_count_transaksi || 0,
					takeaway_share: payload.takeaway_share || 0,
				};

				$scope.dashboard = {
					summary: summary,
					menu_deskripsi: payload.menu_deskripsi || [],
					payment_summary: payload.payment_summary || [],
					trend: payload.trend || {
						labels: [],
						all: payload.visitor_chart || [],
						takeaway: [],
						dine_in: [],
					},
					composition: payload.composition || {
						labels: ["Dine In", "Takeaway"],
						values: [
							toNumber(summary.dine_in_count_transaksi),
							toNumber(summary.takeaway_count_transaksi),
						],
					},
					date_start: payload.date_start || date_start,
					date_end: payload.date_end || date_end,
				};
				$scope.menu_deskripsi = $scope.dashboard.menu_deskripsi;
				$scope.paymentMaxAmount = 0;

				angular.forEach($scope.dashboard.payment_summary, function (item) {
					$scope.paymentMaxAmount = Math.max(
						$scope.paymentMaxAmount,
						toNumber(item.amount)
					);
				});

				refreshDashboardVisuals();
			})
			.catch(function (error) {
				console.log(error);
			});
	};

	$scope.getSalesReport = function () {
		$scope.GetSummary();
	};

	$scope.GetSummary();
});
