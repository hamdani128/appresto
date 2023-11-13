function base_url(string_url) {
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost' || location.host == '10.32.18.206') {
        var url = location.origin + '/' + pathparts[1].trim('/') + '/' + string_url; // http://localhost/myproject/
    } else {
        var url = location.origin + '/' + string_url; // http://stackoverflow.com
    }
    return url;
}

var app = angular.module('MasterSdm', ['datatables']);
app.controller('MasterSdmController', function ($scope, $http) {
    $scope.isLoading = false; // Default: loading is not active
    $scope.add_data = function () {
        $("#my-modal").modal('show');
    }
    $scope.LoadDataSDM = function () {
        $scope.isLoading = true;
        $http.get(base_url('master/sdm/getdata_sdm'))
            .then(function (response) {
                $scope.DataLoad = response.data;
                $scope.isLoading = false;
            })
            .catch(function (error) {
                console.error('Terjadi kesalahan:', error);
            });
    }
    $scope.LoadDataSDM();

    $scope.LoadKodeSDM = function () {
        $http.get(base_url('master/sdm/getkode_sdm'))
            .then(function (response) {
                $("#kode").val(response.data);
                document.getElementById("kode").readOnly = true;
            })
            .catch(function (error) {
                console.error('Terjadi kesalahan:', error);
            });
    }
    $scope.LoadKodeSDM();

    $scope.simpan_data_sdm = function () {
        var formupload = document.getElementById("form_insert_sdm");
        var formdata = new FormData(formupload);
        var kode = $("#kode").val();
        var nama = $("#nama").val();
        var jk = $("#cmb_jk").val();
        var jabatan = $("#cmb_jabatan").val();

        if (kode == "" || nama == "" || jk == "" || jabatan == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Notification',
                text: 'Wajib Mengisi Field - Field yang Tersedia !'
            });
        } else {
            fetch(base_url('master/sdm/insert_sdm'), {
                method: 'POST',
                body: formdata
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 'success') {
                        $("#my-modal").modal('toggle');
                        $scope.LoadDataSDM();
                        $scope.LoadKodeSDM();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data Berhasil Disimpan !'
                        });

                    }
                })
                .catch(error => console.error(error));
        }
    }

    $scope.Activasi = function (dt) {
        $scope.data = angular.copy(dt);
        if ($scope.data.status === "active") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Akun Anda Sudah Terdaftar !'
            });
        } else {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin ingin mengactivasi akun dengan user ' + $scope.data.kd_sdm + ' ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Activasi',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var formdata = {
                        kd_sdm: $scope.data.kd_sdm,
                        nama: $scope.data.nama,
                        jabatan: $scope.data.jabatan,
                    }
                    $http.post(base_url('master/sdm/aktivasi'), formdata)
                        .then(function (response) {
                            if (response.status == "success") {
                                $scope.LoadDataSDM();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Good Luck',
                                    text: 'Data Berhasil Di Activasi !'
                                });
                            }
                        })
                        .catch(function (error) {
                            console.error('Terjadi kesalahan saat di activasi', error);
                        });
                }
            });
        }
    }

});