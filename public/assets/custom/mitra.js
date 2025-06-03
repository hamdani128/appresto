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

var app = angular.module("MitraApp", ["datatables"]);
app.controller("MitraAppController", function ($scope, $http) {
	$scope.LoadData = function () {
		$http
			.get(base_url("master/mitra/getdata"))
			.then(function (response) {
				$scope.LoadDataRow = response.data;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};
	$scope.LoadData();

	$scope.AddModal = function () {
		$("#my-modal-add").modal("show");
	};

	$scope.EditShow = function (dt) {
		if (dt.status_account == "1") {
			Swal.fire({
				title: "Error",
				text: "Account Mitra sudah aktif Data Tidak Bisa Dirubah",
				icon: "error",
			});
		} else {
			$("#id_update").val(dt.id);
			$("#kode_edit").val(dt.kode);
			$("#nama_edit").val(dt.nama);
			$("#alamat_edit").val(dt.alamat);
			$("#email_edit").val(dt.email);
			$("#hp_edit").val(dt.hp);
			$("#my-modal-show-edit").modal("show");
		}
	};

	$scope.insert = function () {
		var nama_mitra = $("#nama").val();
		var alamat = $("#alamat").val();
		var email = $("#email").val();
		var hp = $("#hp").val();

		if (nama_mitra == "" || alamat == "" || email == "" || hp == "") {
			Swal.fire({
				title: "Error",
				text: "Data tidak boleh kosong",
				icon: "error",
			});
		} else {
			var formdata = {
				nama: nama_mitra,
				alamat: alamat,
				email: email,
				hp: hp,
			};

			$http
				.post(base_url("master/mitra/insert"), formdata)
				.then(function (response) {
					if (response.data.status == "success") {
						Swal.fire({
							title: "Success",
							text: response.data.message,
							icon: "success",
						});
						$scope.LoadData();
						document.location.reload();
					} else {
						Swal.fire({
							title: "Error",
							text: response.data.message,
							icon: "error",
						});
					}
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan:", error);
				});
		}
	};

	$scope.update = function () {
		var formdata = {
			id: $("#id_update").val(),
			kode: $("#kode_edit").val(),
			nama: $("#nama_edit").val(),
			alamat: $("#alamat_edit").val(),
			email: $("#email_edit").val(),
			hp: $("#hp_edit").val(),
		};

		$http
			.post(base_url("master/mitra/update"), formdata)
			.then(function (response) {
				if (response.data.status == "success") {
					Swal.fire({
						title: "Success",
						text: response.data.message,
						icon: "success",
					});
					$scope.LoadData();
					document.location.reload();
				} else {
					Swal.fire({
						title: "Error",
						text: response.data.message,
						icon: "error",
					});
				}
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

	$scope.Delete = function (dt) {
		if (dt.status_account == "1") {
			Swal.fire({
				title: "Error",
				text: "Account Mitra sudah aktif Data Tidak Bisa Dihapus !",
				icon: "error",
			});
		} else {
			var formdata = {
				id: dt.id,
			};
			Swal.fire({
				title: "Are you sure?",
				text: "You won't delete " + dt.kode + " !",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!",
			}).then((result) => {
				if (result.isConfirmed) {
					$http
						.post(base_url("master/mitra/delete"), formdata)
						.then(function (response) {
							if (response.data.status == "success") {
								Swal.fire({
									title: "Success",
									text: response.data.message,
									icon: "success",
								});
								$scope.LoadData();
								document.location.reload();
							} else {
								Swal.fire({
									title: "Error",
									text: response.data.message,
									icon: "error",
								});
							}
						})
						.catch(function (error) {
							console.error("Terjadi kesalahan:", error);
						});
				}
			});
		}
	};

	$scope.ActivateAccount = function (dt) {
		if (dt.status_account == "1") {
			Swal.fire({
				title: "Error",
				text: "Account Mitra sudah aktif",
				icon: "error",
			});
		} else {
			var formdata = {
				kode: dt.kode,
			};
			$http
				.post(base_url("master/mitra/activate"), formdata)
				.then(function (response) {
					if (response.data.status == "success") {
						Swal.fire({
							title: "Success",
							text: response.data.message,
							icon: "success",
						});
						$scope.LoadData();
						document.location.reload();
					} else {
						Swal.fire({
							title: "Error",
							text: response.data.message,
							icon: "error",
						});
					}
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan:", error);
				});
		}
	};

	$scope.DeActivateAccount = function (dt) {
		var formdata = {
			kode: dt.kode,
		};

		Swal.fire({
			title: "Are you sure?",
			text: "You won't Deactive Account Users " + dt.kode + " !",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Deactivate it!",
		}).then((result) => {
			if (result.isConfirmed) {
				$http
					.post(base_url("master/mitra/deactivate"), formdata)
					.then(function (response) {
						if (response.data.status == "success") {
							Swal.fire({
								title: "Success",
								text: response.data.message,
								icon: "success",
							});
							document.location.reload();
						} else {
							Swal.fire({
								title: "Error",
								text: response.data.message,
								icon: "error",
							});
						}
					})
					.catch(function (error) {
						console.error("Terjadi kesalahan:", error);
					});
			}
		});
	};
});
