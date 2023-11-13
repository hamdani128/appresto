function base_url(string_url) {
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost' || location.host == '10.32.18.206') {
        var url = location.origin + '/' + pathparts[1].trim('/') + '/' + string_url; // http://localhost/myproject/
    } else {
        var url = location.origin + '/' + string_url; // http://stackoverflow.com
    }
    return url;
}

var app = angular.module('KasirApp', ['datatables']);
app.controller('KasirAppController', function ($scope, $http) {
    $scope.LoadData = [];
    $scope.DataMeja = function () {
        $http.get(base_url('opr/kasir/getdata_meja'))
            .then(function (response) {
                $scope.LoadData = response.data;
            })
            .catch(function (error) {
                console.error('Terjadi kesalahan:', error);
            });
    }
    $scope.DataMeja();

    $scope.SelectedMeja = function (elementId, dt) {
        $scope.data = angular.copy(dt);
        var x = document.getElementById(elementId);
        if (x.classList.contains("bg-success")) {
            x.classList.remove("bg-success");
            x.classList.add("bg-warning");
            $http.get(base_url('opr/kasir/get_nomor_meja/' + $scope.data.no_meja))
                .then(function (response) {
                    document.getElementById("no_booking").innerHTML = response.data;
                })
                .catch(function (error) {
                    console.error('Terjadi kesalahan:', error);
                });
        } else if (x.classList.contains("bg-warning")) {
            x.classList.remove("bg-warning");
            x.classList.add("bg-success");
            document.getElementById("no_booking").innerHTML = "";
        }
    }

    $scope.Create_Booking = function () {
        var no_booking = document.getElementById("no_booking").innerHTML;
        if (no_booking === "-" || no_booking == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Mohon Perhatikan',
                text: 'Anda Wajib Memilih Pesanan Meja Terlebih Dahulu !'
            });
        } else {
            $("#my-modal-booking").modal('show');
            document.getElementById("lb_no_booking").innerHTML = no_booking;
        }
    }



});


