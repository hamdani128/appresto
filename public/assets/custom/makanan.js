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

// Kategori
var app = angular.module("makanan", ["datatables"]);
app.controller("ControllerCategoryMakanan", function ($scope, $http) {
	function loadDataKategori() {
		$http
			.get(base_url("master/makanan/get_kategori_makanan"))
			.then(function (response) {
				$scope.post = response.data;
				// console.log(response.data);
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
			.post(base_url("master/makanan/insert_kategori_makanan"), newKategoriData)
			.then(function (response) {
				loadDataKategori();
				$("#kategori").val("");
				ComboKategoriMakanan();
				ComboKategoriMakananUpdate();
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat menyimpan data:", error);
			});
	};

	$scope.delete = function (kategori) {
		var kategoriId = kategori.id; // Menggunakan properti id dari objek kategoriMakanan (sesuaikan dengan properti yang sesuai)

		$http
			.delete(base_url("master/makanan/delete_kategori_makanan/" + kategoriId))
			.then(function (response) {
				loadDataKategori();
			})
			.catch(function (error) {
				// Proses hapus gagal
				console.error("Terjadi kesalahan saat menghapus data:", error);
				// Tampilkan pesan kesalahan kepada pengguna atau lakukan penanganan kesalahan yang sesuai.
			});
	};
	ComboKategoriMakanan();
	ComboKategoriMakananUpdate();
});

var appmakanan = angular.module("appmakanan", ["datatables"]);
appmakanan.controller("ControllerMakanan", function ($scope, $http) {
	function LoadDataMakanan() {
		$http
			.get(base_url("master/makanan/data_makanan"))
			.then(function (response) {
				$scope.Makanan = response.data;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	}
	LoadDataMakanan();
	$scope.DataMitra = function (combo) {
		$http
			.get(base_url("master/mitra/getdata"))
			.then(function (response) {
				const optionsData = response.data;
				const select = document.getElementById(combo);
				select.innerHTML = "";

				// Tambah opsi default manual
				const ownerOption = document.createElement("option");
				ownerOption.value = "";
				ownerOption.text = "Pilih Owner :";
				select.appendChild(ownerOption);

				// Tambahkan opsi statis "Owner"
				const staticOwner = document.createElement("option");
				staticOwner.value = "Owner";
				staticOwner.text = "Owner";
				select.appendChild(staticOwner);

				// Tambah opsi berdasarkan response dari server
				optionsData.forEach((option) => {
					const newOption = document.createElement("option");
					newOption.value = option.kode;
					newOption.text = option.kode + " - " + option.nama;
					select.appendChild(newOption);
				});
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

	$scope.DataMitra("cmb_owner");
	$scope.DataMitra("cmb_owner_update");

	$scope.ShowEditMakanan = function (dt) {
		$scope.data = angular.copy(dt);
		$("#id_update").val($scope.data.id);
		$("#cmb_kategori_update").val($scope.data.kategori_id);
		$("#nama_update").val($scope.data.nama);
		$("#harga_update").val($scope.data.harga);
		$("#cmb_owner_update").val($scope.data.owner);
		var displayArea = document.getElementById("display_img_edit");
		if ($scope.data.img != null || $scope.data.img != "") {
			displayArea.innerHTML =
				'<img src="' +
				base_url("public/upload/" + $scope.data.img) +
				'" alt="Selected Image" style="display:block;max-width: 100%; max-height: 200px;">';
			// $("#file_img_update").val($scope.data.img);
		}
		$("#my-modal-show-edit").modal("show");
	};

	$scope.DeleteMakanan = function (dt) {
		$scope.data = angular.copy(dt);
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
					.delete(base_url("master/makanan/delete_makanan/" + dt.id))
					.then(function (response) {
						var data = response.data;
						if (data.status === true) {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Data meja telah dihapus!",
							});
							LoadDataMakanan();
						}
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
});

var app = angular.module("CombineMakanan", ["makanan", "appmakanan"]);

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

function displayImageUpdate() {
	var input = document.getElementById("file_img_update");
	var displayArea = document.getElementById("display_img_edit");
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

function show_kategori() {
	$("#my-modal-kategori").modal("show");
}

function ComboKategoriMakanan() {
	fetch(base_url("master/makanan/get_kategori_makanan"))
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

function ComboKategoriMakananUpdate() {
	fetch(base_url("master/makanan/get_kategori_makanan"))
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

function add_makanan() {
	$("#my-modal-add").modal("show");
}

function insert_makanan() {
	var formupload = document.getElementById("form_insert_makanan");
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
		fetch(base_url("master/makanan/insert_makanan"), {
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

function update_makanan() {
	var formupload = document.getElementById("form_update_makanan");
	var formdata = new FormData(formupload);
	fetch(base_url("master/makanan/update_makanan"), {
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
