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

var app = angular.module("notifyAppMitra", []);
app.controller("notifyAppMitraController", function ($scope, $http) {
	$scope.notifyMitra = function () {
		$http
			.get(base_url("home/mitra_notification"))
			.then(function (response) {
				$scope.notify_mitra = response.data.rows;
				$scope.qty_notification = response.data.jumlah_notifikasi;

				const today = new Date().toISOString().split("T")[0]; // yyyy-mm-dd
				let delay = 0;
				let playedAudio = false;

				$scope.notify_mitra.forEach(function (item, index) {
					const createdDate = item.created_at.split(" ")[0];

					if (createdDate === today) {
						setTimeout(function () {
							// Putar audio hanya sekali di notifikasi pertama
							if ($scope.audioEnabled && !playedAudio) {
								const audio = document.getElementById("notif-sound");
								if (audio) {
									audio.play().catch(function (e) {
										console.log("Audio play failed:", e);
									});
									playedAudio = true;
								}
							}

							// Tampilkan notifikasi
							Lobibox.notify("default", {
								pauseDelayOnHover: true,
								continueDelayOnInactiveTab: false,
								position: "top right",
								img: base_url("public/assets/images/foodbar.png"),
								title: "Pesanan Baru!",
								msg:
									"🛒 No Meja <b>" +
									item.no_meja +
									"</b> memesan pada " +
									$scope.timeAgo(item.created_at),

								// ✅ Tambahkan ini untuk auto-clear saat diklik
								onClick: function () {
									$scope.$apply(function () {
										$scope.markAsReadNotifMitra(item); // panggil fungsi milikmu
									});
								},

								// (Optional) Jika mau juga saat notifikasi ditutup
								onClose: function () {
									$scope.$apply(function () {
										$scope.markAsReadNotifMitra(item);
									});
								},
							});
						}, delay);
						document.getElementById("notif-sound").play();
						delay += 1500; // Jeda 1.5 detik antar notifikasi
					}
				});
			})
			.catch(function (error) {
				console.log(error);
			});
	};

	$scope.notifyMitra();

	$scope.timeAgo = function (datetimeStr) {
		const now = new Date();
		const notifTime = new Date(datetimeStr.replace(" ", "T")); // format jadi ISO

		const diffMs = now - notifTime;
		const diffSec = Math.floor(diffMs / 1000);
		const diffMin = Math.floor(diffSec / 60);
		const diffHour = Math.floor(diffMin / 60);
		const diffDay = Math.floor(diffHour / 24);

		if (diffSec < 60) return diffSec + " sec ago";
		if (diffMin < 60) return diffMin + " min ago";
		if (diffHour < 24) return diffHour + " hour ago";
		if (diffDay < 7) return diffDay + " day ago";

		// jika lebih dari seminggu, tampilkan tanggal saja
		return notifTime.toLocaleDateString();
	};

	$scope.audioEnabled = false;

	$scope.enableNotification = function () {
		const audio = document.getElementById("notif-sound");

		if (audio && !$scope.audioEnabled) {
			audio
				.play()
				.then(() => {
					audio.pause(); // langsung pause setelah trigger agar tidak langsung bunyi
					audio.currentTime = 0;
					$scope.audioEnabled = true;
					console.log("✅ Audio notifikasi aktif.");
				})
				.catch((err) => {
					console.warn("❌ Gagal aktivasi audio:", err);
				});
		}
	};

	$scope.markAsReadNotifMitra = function (dt) {
		var formdata = {
			no_order: dt.no_order,
			no_meja: dt.no_meja,
			owner: dt.owner,
		};
		$http
			.post(base_url("home/mark_as_read_mitra_notification"), formdata)
			.then(function (response) {})
			.catch(function (error) {
				console.log(error);
			});
	};
	setInterval(function () {
		$scope.notifyMitra();
	}, 5000);
});
