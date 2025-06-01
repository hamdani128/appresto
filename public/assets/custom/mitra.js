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
});
