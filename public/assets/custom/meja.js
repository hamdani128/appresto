
var app = angular.module('master', []);

function base_url(string_url) {
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost' || location.host == '10.32.18.206') {
        var url = location.origin + '/' + pathparts[1].trim('/') + '/' + string_url; // http://localhost/myproject/
    } else {
        var url = location.origin + '/' + string_url; // http://stackoverflow.com
    }
    return url;
}

function LoadData() {
    app.controller('meja', function ($scope, $http) {
        $http.get(base_url('master/meja/getdata_meja'))
            .then(function (response) {
                // Tampilkan data di console
                $scope.mejaData = response.data;
                $(document).ready(function () {
                    $('#tb_meja').DataTable({
                        language: {
                            zeroRecords: "",
                        },
                    });
                });
            })
            .catch(function (error) {
                // Tampilkan pesan kesalahan di console
                console.error('Terjadi kesalahan:', error);
            });

        $scope.show_edit = function (meja) {
            $scope.editMeja = angular.copy(meja); // Copy data meja ke variabel editMeja
            $("#id_update").val($scope.editMeja.id); // Menggunakan $scope.editMeja.no_meja
            $("#no_meja_update").val($scope.editMeja.no_meja); // Menggunakan $scope.editMeja.no_meja
            $("#nama_meja_update").val($scope.editMeja.nama_meja); // Menggunakan $scope.editMeja.no_meja
            $('#editModal').modal('show'); // Memunculkan modal dengan ID 'editModal'
        };

        $scope.delete = function (meja) {
            // Konfirmasi penghapusan dengan SweetAlert
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin ingin menghapus data meja?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengkonfirmasi penghapusan
                    // Lakukan permintaan DELETE ke backend
                    $http.delete(base_url('master/meja/delete_meja/' + meja.id))
                        .then(function (response) {
                            // Handler ketika permintaan berhasil
                            // Tampilkan SweetAlert sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data meja telah dihapus!'
                            });
                            document.location.reload();
                        })
                        .catch(function (error) {
                            // Handler ketika terjadi kesalahan pada permintaan
                            console.error('Terjadi kesalahan saat menghapus data meja', error);
                            // Tampilkan SweetAlert error
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat menghapus data meja!'
                            });
                            // Lakukan penanganan kesalahan yang sesuai
                            // ...
                        });
                }
            });
        };

    });
}

LoadData();



function add_meja() {
    $("#my-modal").modal('show');
}

function simpan_data_meja() {
    var formupload = document.getElementById("form_insert_meja");
    var formdata = new FormData(formupload);
    fetch(base_url('master/meja/insert_meja'), {
        method: 'POST',
        body: formdata
    })
        .then(response => response.json())
        .then(data => {
            if (data.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data Berhasil Disimpan !'
                });
                document.location.reload();
            }
        })
        .catch(error => console.error(error));
}

function UpdateDataMeja() {
    var formupload = document.getElementById("form_update_meja");
    var formdata = new FormData(formupload);
    fetch(base_url('master/meja/update_meja'), {
        method: 'POST',
        body: formdata
    })
        .then(response => response.json())
        .then(data => {
            if (data.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data Berhasil Diubah !'
                });
                document.location.reload();
            }
        })
        .catch(error => console.error(error));
}