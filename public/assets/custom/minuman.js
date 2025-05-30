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

var appminuman = angular.module("appminuman", ["datatables"]);
appminuman.controller("ControllerMinuman", function ($scope, $http) {
	$scope.LoadDataMinuman = function () {
		$http
			.get(base_url("master/minuman/data_minuman"))
			.then(function (response) {
				$scope.MinumanData = response.data;

				// Log the data
				console.log($scope.MinumanData);

				// Initialize DataTable after data is loaded
				$timeout(function () {
					$("#dtMinumanTable").DataTable({
						searching: true,
					});
				});
			})
			.catch(function (error) {
				console.error("Error loading data:", error);
			});
	};
	$scope.LoadDataMinuman();

	$scope.ShowEditMinuman = function (da) {
		$scope.data = angular.copy(da);
		$("#id_update").val($scope.data.id);
		$("#cmb_kategori_update").val($scope.data.kategori_id);
		$("#nama_update").val($scope.data.nama);
		$("#harga_update").val($scope.data.harga);
		var AreaImg = document.getElementById("display_img_edit");
		if ($scope.data.img != "" || $scope.data.img != null) {
			AreaImg.innerHTML =
				'<img src="' +
				base_url("public/upload/" + $scope.data.img) +
				'" alt="Selected Image" style="max-width: 100%; max-height: 200px;">';
		} else if ($scope.data.img == "" || $scope.data.img == null) {
			AreaImg.innerHTML =
				'<img src="' +
				base_url("public/assets/images/refreshments.png") +
				'" alt="Selected Image" style="max-width: 100%; max-height: 200px;">';
		}
		$("#cmb_owner_update").val($scope.data.owner);
		$("#my-modal-show-edit").modal("show");
	};

	$scope.add_minuman = function () {
		$("#my-modal-add").modal("show");
	};

	$scope.DeleteMinuman = function (da) {
		$scope.data = angular.copy(da);
		Swal.fire({
			title: "Konfirmasi",
			text:
				"Anda yakin ingin menghapus data Makanan dengan Nama " +
				$scope.data.nama +
				" ?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Ya, Hapus",
			cancelButtonText: "Batal",
			reverseButtons: true,
		}).then((result) => {
			if (result.isConfirmed) {
				// Jika pengguna mengkonfirmasi penghapusan
				// Lakukan permintaan DELETE ke backend
				$http
					.delete(base_url("master/meja/delete_meja/" + meja.id))
					.then(function (response) {
						// Handler ketika permintaan berhasil
						// Tampilkan SweetAlert sukses
						Swal.fire({
							icon: "success",
							title: "Berhasil",
							text: "Data meja telah dihapus!",
						});
						document.location.reload();
					})
					.catch(function (error) {
						// Handler ketika terjadi kesalahan pada permintaan
						console.error("Terjadi kesalahan saat menghapus data meja", error);
						// Tampilkan SweetAlert error
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Terjadi kesalahan saat menghapus data meja!",
						});
						// Lakukan penanganan kesalahan yang sesuai
						// ...
					});
			}
		});
	};

	$scope.show_kategori_minuman = function () {
		$("#my-modal-kategori").modal("show");
	};
});

// Kategori
var appkategori = angular.module("KategoriMinuman", ["datatables"]);
appkategori.controller("ControllerKategoriMinuman", function ($scope, $http) {
	function loadDataKategori() {
		$http
			.get(base_url("master/minuman/get_kategori_minuman"))
			.then(function (response) {
				$scope.post = response.data;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	}

	loadDataKategori();

	$scope.insertKategori = function () {
		var newKategoriData = {
			kategori: $scope.newKategori,
		};
		$http
			.post(base_url("master/minuman/insert_kategori_minuman"), newKategoriData)
			.then(function (response) {
				loadDataKategori();
				$("#kategori").val("");
				ComboKategoriMinuman();
				ComboKategoriMinumanUpdate();
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat menyimpan data:", error);
			});
	};

	$scope.delete = function (kategori) {
		var kategoriId = kategori.id; // Menggunakan properti id dari objek kategoriMakanan (sesuaikan dengan properti yang sesuai)

		$http
			.delete(base_url("master/minuman/delete_kategori_minuman/" + kategoriId))
			.then(function (response) {
				loadDataKategori();
				ComboKategoriMinuman();
				ComboKategoriMinumanUpdate();
			})
			.catch(function (error) {
				// Proses hapus gagal
				console.error("Terjadi kesalahan saat menghapus data:", error);
				// Tampilkan pesan kesalahan kepada pengguna atau lakukan penanganan kesalahan yang sesuai.
			});
	};
	ComboKategoriMinuman();
	ComboKategoriMinumanUpdate();
});

var combineMinuman = angular.module("CombineMinuman", [
	"appminuman",
	"KategoriMinuman",
	"datatables",
]);

function displayImage() {
	var input = document.getElementById("file_img");
	var displayArea = document.getElementById("display_img");
	// Pastikan ada file yang dipilih
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			// Tampilkan gambar yang dipilih di area display
			displayArea.innerHTML =
				'<img src="' +
				e.target.result +
				'" alt="Selected Image" style="max-width: 100%; max-height: 200px;">';
		};

		// Baca file sebagai URL data
		reader.readAsDataURL(input.files[0]);
	} else {
		// Bersihkan area display jika tidak ada file yang dipilih
		displayArea.innerHTML = "";
	}
}

function ComboKategoriMinuman() {
	fetch(base_url("master/minuman/get_kategori_minuman"))
		.then((response) => response.json())
		.then((data) => {
			const optionsData = data;
			const select = document.getElementById("cmb_kategori");
			select.innerHTML = "";
			// Add the default "Pilih" option
			const defaultOption = document.createElement("option");
			defaultOption.value = "";
			defaultOption.text = "Pilih";
			select.appendChild(defaultOption);

			optionsData.forEach((option) => {
				const newOption = document.createElement("option");
				newOption.value = option.id;
				newOption.text = option.kategori;
				select.appendChild(newOption);
			});
		})
		.catch((error) => console.error(error));
}

function ComboKategoriMinumanUpdate() {
	fetch(base_url("master/minuman/get_kategori_minuman"))
		.then((response) => response.json())
		.then((data) => {
			const optionsData = data;
			const select = document.getElementById("cmb_kategori_update");
			select.innerHTML = "";
			// Add the default "Pilih" option
			const defaultOption = document.createElement("option");
			defaultOption.value = "";
			defaultOption.text = "Pilih";
			select.appendChild(defaultOption);

			optionsData.forEach((option) => {
				const newOption = document.createElement("option");
				newOption.value = option.id;
				newOption.text = option.kategori;
				select.appendChild(newOption);
			});
		})
		.catch((error) => console.error(error));
}

ComboKategoriMakanan();
ComboKategoriMakananUpdate();

function insert_minuman() {
	var formupload = document.getElementById("form_insert_minuman");
	var formdata = new FormData(formupload);
	var kategori = $("#cmb_kategori").val();
	var nama = $("#nama").val();
	var harga = $("#harga").val();
	var owner = $("#owner").val();

	if (kategori == "" || nama == "" || harga == "" || owner == "") {
		Swal.fire({
			icon: "warning",
			title: "Notification",
			text: "Wajib Mengisi Field - Field yang Tersedia !",
		});
	} else {
		fetch(base_url("master/minuman/insert_minuman"), {
			method: "POST",
			body: formdata,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.status == "success") {
					Swal.fire({
						icon: "success",
						title: "Berhasil",
						text: "Data Berhasil Disimpan !",
					});
					document.location.reload();
				}
			})
			.catch((error) => console.error(error));
	}
}

function updateMinuman() {
	var formupload = document.getElementById("form_update_minuman");
	var formdata = new FormData(formupload);
	fetch(base_url("master/minuman/update_minuman"), {
		method: "POST",
		body: formdata,
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.status == "success") {
				Swal.fire({
					icon: "success",
					title: "Berhasil",
					text: "Data Berhasil Diubah !",
				});
				document.location.reload();
			}
		})
		.catch((error) => console.error(error));
}
