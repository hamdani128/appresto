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
    $scope.LoadDatMenuAll = [];
    $scope.keywordMenu = "";

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
                    document.getElementById("no_meja").innerHTML = dt.no_meja;
                })
                .catch(function (error) {
                    console.error('Terjadi kesalahan:', error);
                });
        } else if (x.classList.contains("bg-warning")) {
            x.classList.remove("bg-warning");
            x.classList.add("bg-success");
            document.getElementById("no_booking").innerHTML = "";
            document.getElementById("no_meja").innerHTML = "";
        }
    }

    $scope.LoadDataMenu = function () {
        $http.get(base_url('opr/kasir/getdata_menu'))
            .then(function (response) {
                $scope.LoadDatMenuAll = response.data;
                $scope.filteredMenu = angular.copy(response.data);
            })
            .catch(function (error) {
                console.error('Terjadi kesalahan:', error);
            });
    }

    $scope.searchMenu = function () {
        $scope.filteredMenu = $scope.LoadDatMenuAll.filter(function (menu) {
            return menu.nama.toLowerCase().includes($scope.keywordMenu.toLowerCase());
        });
    };

    $scope.Create_Booking = function () {
        var no_booking = document.getElementById("no_booking").innerHTML;
        var no_meja = document.getElementById("no_meja").innerHTML;
        if (no_booking === "-" || no_booking == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Mohon Perhatikan',
                text: 'Anda Wajib Memilih Pesanan Meja Terlebih Dahulu !'
            });
        } else {
            $("#my-modal-booking").modal('show');
            document.getElementById("lb_no_booking").innerHTML = no_booking;
            document.getElementById("lb_no_meja").innerHTML = no_meja;
            $scope.LoadDataMenu();
        }
    }

    $scope.PilihMenu = function (dt) {
        var tbody = document.getElementById("tb_pesanan_body");
        var existingRow = findExistingRow(dt);
        if (existingRow) {
            // Jika data sudah ada, update qty saja
            updateQty(existingRow, 1);
        } else {
            // Jika data belum ada, tambahkan baris baru
            addNewRow(dt);
        }
    }

    $scope.SimpanDataOrder = function () {
        var tbody = document.getElementById("tb_pesanan_body");
        var rows = tbody.getElementsByTagName("tr");
        if (rows.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Mohon Perhatikan',
                text: 'List Pesanan Anda Kosong !'
            });
        } else {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda Yakin Ingin Menyimpan Data Order ini ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var OrderDetail = [];
                    var no_booking = document.getElementById("no_booking").innerHTML;
                    var no_meja = document.getElementById("no_meja").innerHTML;
                    // Ada baris di dalam tabel, lanjutkan dengan logika penyimpanan atau tindakan lainnya
                    for (var i = 0; i < rows.length; i++) {
                        var kategori = rows[i].getElementsByTagName("td")[1].textContent;
                        var nama = rows[i].getElementsByTagName("td")[2].textContent;
                        var harga = rows[i].getElementsByTagName("td")[3].textContent;
                        var qty = rows[i].getElementsByTagName("td")[4].textContent;
                        var jenis = rows[i].getElementsByTagName("td")[5].textContent;
                        var rowData = {
                            kategori: kategori,
                            nama: nama,
                            harga: harga,
                            qty: qty,
                            jenis: jenis
                        };
                        OrderDetail.push(rowData);
                    }
                    var formdata = {
                        no_booking: no_booking,
                        no_meja: no_meja,
                        order_detail: OrderDetail,
                    };

                    $http.post(base_url('opr/kasir/create_order_detail'), formdata)
                        .then(function (response) {
                            var data = response.data;
                            if (data.status == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data Order Berhasil !'
                                });
                                document.location.reload();
                            }
                        }).catch(function (error) {
                            console.error('Terjadi kesalahan saat proses data:', error);
                        });
                }
            });
        }
    }


    $scope.ShowListBelanja = function (dt) {
        var card_list = document.getElementById("card_info_list");
        if (card_list.style.display == "none") {
            card_list.style.display = "block";
        } else {
            card_list.style.display = "none";
        }
    }

});

// Fungsi untuk membuat tombol dengan kelas dan ikon
function createButton(text, className, iconClass) {
    var button = document.createElement("button");
    button.textContent = text;

    // Tambahkan kelas Bootstrap
    button.className = className;

    // Tambahkan ikon Font Awesome
    var icon = document.createElement("i");
    icon.className = iconClass;
    button.appendChild(icon);

    return button;
}

// Fungsi untuk mencari baris yang sudah ada berdasarkan nama pesanan
function findExistingRow(dt) {
    var tbody = document.getElementById("tb_pesanan_body");
    var rows = tbody.getElementsByTagName("tr");

    for (var i = 0; i < rows.length; i++) {
        var namaCell = rows[i].getElementsByTagName("td")[2]; // Kolom kedua berisi nama pesanan
        if (namaCell.textContent === dt.nama) {
            return rows[i];
        }
    }

    return null;
}
// Fungsi untuk memperbarui qty
function updateQty(row, qtyChange) {
    var qtyCell = row.querySelector(".qty-cell");
    var currentQty = (parseInt(qtyCell.textContent) || 0) + qtyChange;

    if (currentQty > 0) {
        qtyCell.textContent = currentQty;
    } else {
        // Hapus baris jika qty mencapai 0
        var tbody = document.getElementById("tb_pesanan_body");
        tbody.removeChild(row);

        // Perbarui nomor urut setelah menghapus baris
        updateRowNumbers();
    }
}


// Fungsi untuk menambahkan baris baru
function addNewRow(dt) {
    var tbody = document.getElementById("tb_pesanan_body");
    var newRow = document.createElement("tr");

    var cellNumber = document.createElement("td");
    cellNumber.appendChild(document.createTextNode(tbody.rows.length + 1));
    newRow.appendChild(cellNumber);

    var cellcat = document.createElement("td");
    cellcat.appendChild(document.createTextNode(dt.kategori));
    newRow.appendChild(cellcat);

    var cellNama = document.createElement("td");
    cellNama.appendChild(document.createTextNode(dt.nama));
    newRow.appendChild(cellNama);

    var cellHarga = document.createElement("td");
    cellHarga.appendChild(document.createTextNode(dt.harga));
    newRow.appendChild(cellHarga);

    var cellQty = document.createElement("td");
    cellQty.className = "qty-cell"; // Tambahkan kelas untuk mengidentifikasi sel qty
    cellQty.appendChild(document.createTextNode(1));
    newRow.appendChild(cellQty);

    var cellJenis = document.createElement("td");
    cellJenis.appendChild(document.createTextNode(dt.jenis));
    newRow.appendChild(cellJenis);

    var cellAction = document.createElement("td");

    var btnPlus = createButton("", "btn btn-dark", "bx bx-plus");
    btnPlus.addEventListener("click", function () {
        updateQty(newRow, 1);
    });
    cellAction.appendChild(btnPlus);

    var btnMinus = createButton("", "btn btn-dark", "bx bx-minus");
    btnMinus.addEventListener("click", function () {
        updateQty(newRow, -1);
    });
    cellAction.appendChild(btnMinus);

    var btnDelete = createButton("", "btn btn-danger", "bx bx-trash");
    btnDelete.addEventListener("click", function () {
        tbody.removeChild(newRow);
        updateRowNumbers(); // Perbarui nomor urut setelah menghapus baris
    });
    cellAction.appendChild(btnDelete);

    newRow.appendChild(cellAction);
    tbody.appendChild(newRow);

    // Perbarui nomor urut setiap kali menambahkan baris baru
    updateRowNumbers();
}

// Fungsi untuk memperbarui nomor urut setiap kali baris dihapus
function updateRowNumbers() {
    var tbody = document.getElementById("tb_pesanan_body");
    var rows = tbody.getElementsByTagName("tr");

    for (var i = 0; i < rows.length; i++) {
        var cellNumber = rows[i].getElementsByTagName("td")[0]; // Kolom pertama berisi nomor urut
        cellNumber.textContent = i + 1;
    }
}
