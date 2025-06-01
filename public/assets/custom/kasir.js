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

var app = angular.module("KasirApp", ["datatables"]);
app.controller("KasirAppController", function ($scope, $http) {
	$scope.LoadData = [];
	$scope.LoadDataPesananList = [];
	$scope.LoadDatMenuAll = [];
	$scope.keywordMenu = "";

	$scope.DataMeja = function () {
		$http
			.get(base_url("opr/kasir/getdata_meja"))
			.then(function (response) {
				$scope.LoadData = response.data;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};
	$scope.DataMeja();

	$scope.SelectedMeja = function (elementId, dt) {
		$scope.data = angular.copy(dt);
		var btn1 = document.getElementById("btn_booking");
		var btn2 = document.getElementById("btn_pindah_meja");
		var btn3 = document.getElementById("btn_tambah_pesanan");
		var show1 = document.getElementById("row_no_meja");
		var show2 = document.getElementById("row_count_pesanan");
		var show3 = document.getElementById("row_list_pesanan");

		btn1.style.display = "block";
		btn2.style.display = "none";
		btn3.style.display = "none";
		show1.style.display = "block";
		show2.style.display = "none";
		show3.style.display = "none";

		var x = document.getElementById(elementId);
		if (x.classList.contains("bg-success")) {
			x.classList.remove("bg-success");
			x.classList.add("bg-warning");
			$http
				.get(base_url("opr/kasir/get_nomor_meja/" + $scope.data.no_meja))
				.then(function (response) {
					document.getElementById("no_booking").innerHTML = response.data;
					document.getElementById("no_meja").innerHTML = dt.no_meja;
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan:", error);
				});
		} else if (x.classList.contains("bg-warning")) {
			x.classList.remove("bg-warning");
			x.classList.add("bg-success");
			document.getElementById("no_booking").innerHTML = "";
			document.getElementById("no_meja").innerHTML = "";
		}
	};

	$scope.LoadDataMenu = function () {
		$http
			.get(base_url("opr/kasir/getdata_menu"))
			.then(function (response) {
				$scope.LoadDatMenuAll = response.data;
				$scope.filteredMenu = angular.copy(response.data);
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

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
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Anda Wajib Memilih Pesanan Meja Terlebih Dahulu !",
			});
		} else {
			$("#my-modal-booking").modal("show");
			document.getElementById("lb_no_booking").innerHTML = no_booking;
			document.getElementById("lb_no_meja").innerHTML = no_meja;
			$scope.LoadDataMenu();
		}
	};

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
	};

	$scope.SimpanDataOrder = function () {
		var tbody = document.getElementById("tb_pesanan_body");
		var rows = tbody.getElementsByTagName("tr");
		if (rows.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "List Pesanan Anda Kosong !",
			});
		} else {
			Swal.fire({
				title: "Konfirmasi",
				text: "Apakah Anda Yakin Ingin Menyimpan Data Order ini ?",
				icon: "question",
				showCancelButton: true,
				confirmButtonText: "Ya, Simpan",
				cancelButtonText: "Batal",
				reverseButtons: true,
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
							jenis: jenis,
						};
						OrderDetail.push(rowData);
					}
					var formdata = {
						no_booking: no_booking,
						no_meja: no_meja,
						order_detail: OrderDetail,
					};

					$http
						.post(base_url("opr/kasir/create_order_detail"), formdata)
						.then(function (response) {
							var data = response.data;
							if (data.status == true) {
								Swal.fire({
									icon: "success",
									title: "Berhasil",
									text: "Data Order Berhasil !",
								});
								document.location.reload();
							}
						})
						.catch(function (error) {
							console.error("Terjadi kesalahan saat proses data:", error);
						});
				}
			});
		}
	};

	$scope.ShowListBelanja = function (dt) {
		var btn1 = document.getElementById("btn_booking");
		var btn2 = document.getElementById("btn_pindah_meja");
		var btn3 = document.getElementById("btn_tambah_pesanan");
		var show1 = document.getElementById("row_no_meja");
		var show2 = document.getElementById("row_count_pesanan");
		var show3 = document.getElementById("row_list_pesanan");

		if (show3.style.display == "none") {
			btn1.style.display = "none";
			btn2.style.display = "block";
			btn3.style.display = "block";
			show1.style.display = "none";
			show2.style.display = "block";
			show3.style.display = "block";

			// masuk cek
			var formdata = {
				no_meja: dt.no_meja,
			};
			$http
				.post(base_url("opr/kasir/list_pesanan"), formdata)
				.then(function (response) {
					document.getElementById("lb_tambahan_no_meja").innerHTML =
						response.data.no_meja;
					document.getElementById("lb_tambahan_no_order").innerHTML =
						response.data.no_order;
					document.getElementById("lb_tambahan_created_at").innerHTML =
						response.data.created_at;
					$scope.LoadDataPesananList = response.data.detail;
					setTimeout(function () {
						$scope.CalculateTotal();
					}, 100); // beri delay sedikit agar ng-repeat selesai render

					if (
						response.data.count_makanan == 0 ||
						response.data.count_makanan == null
					) {
						document.getElementById("lb_makanan_list_pesanan").innerHTML = 0;
					} else {
						document.getElementById("lb_makanan_list_pesanan").innerHTML =
							response.data.count_makanan;
					}

					if (
						response.data.count_minuman == 0 ||
						response.data.count_minuman == null
					) {
						document.getElementById("lb_minuman_list_pesanan").innerHTML = 0;
					} else {
						document.getElementById("lb_minuman_list_pesanan").innerHTML =
							response.data.count_minuman;
					}
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan saat proses data:", error);
				});
			$scope.LoadDataMenu();
		} else {
			show3.style.display = "none";
		}
	};

	$scope.CalculateTotal = function () {
		var tbody = document.getElementById("tb_pesanan_list_body_menu");
		var rows = tbody.getElementsByTagName("tr");
		var total_harga = 0;
		var qty_total = 0;

		for (var i = 0; i < rows.length; i++) {
			var tds = rows[i].getElementsByTagName("td");
			if (tds.length < 6) continue; // skip jika row bukan data

			var harga = parseInt(tds[3].textContent.trim()) || 0;
			var qty = parseInt(tds[4].textContent.trim()) || 0;
			var subtotal = harga * qty;

			qty_total += qty;
			total_harga += subtotal;
		}

		// Update qty dan subtotal
		document.getElementById("qty-total").value = formatRupiah(qty_total);
		document.getElementById("amount-total").value = formatRupiah(total_harga);

		// Hitung PPN
		var ppn_select = document
			.getElementById("amount-ppn")
			.parentElement.parentElement.querySelector("select");
		var ppn_percent = parseFloat(ppn_select.value) || 0;
		var ppn_amount = Math.floor(total_harga * (ppn_percent / 100));
		document.getElementById("amount-ppn").value = formatRupiah(ppn_amount);

		// Hitung Grand Total
		var grand_total = total_harga + ppn_amount;
		document.getElementById("grand-total").value = formatRupiah(grand_total);
	};

	$scope.TambahPesanan = function () {
		document.getElementById("lb_no_booking_tambahan").innerHTML =
			document.getElementById("lb_tambahan_no_order").innerHTML;
		document.getElementById("lb_no_meja_tambah_pesanan").innerHTML =
			document.getElementById("lb_tambahan_no_meja").innerHTML;
		$("#my-modal-tambah-pesanan").modal("show");
	};
	// Tambahan Menu
	$scope.PilihMenuTambahan = function (dt) {
		var tbody = document.getElementById("tb_pesanan_body_tambahan");
		var existingRow = findExistingRow_tambahan(dt);
		if (existingRow) {
			// Jika data sudah ada, update qty saja
			updateQty(existingRow, 1);
		} else {
			// Jika data belum ada, tambahkan baris baru
			addNewRow_tambahan(dt);
		}
	};

	$scope.SimpanDataOrderTambahan = function () {
		var tbody = document.getElementById("tb_pesanan_body_tambahan");
		var rows = tbody.getElementsByTagName("tr");
		if (rows.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "List Tambahaan Pesanan Anda Kosong !",
			});
		} else {
			Swal.fire({
				title: "Konfirmasi",
				text: "Apakah Anda Yakin Ingin Menyimpan Data Tambahan Pesanan ini ?",
				icon: "question",
				showCancelButton: true,
				confirmButtonText: "Ya, Simpan",
				cancelButtonText: "Batal",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					var OrderDetail = [];
					var no_booking = document.getElementById(
						"lb_tambahan_no_order"
					).innerHTML;
					var no_meja = document.getElementById(
						"lb_tambahan_no_meja"
					).innerHTML;
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
							jenis: jenis,
						};
						OrderDetail.push(rowData);
					}
					var formdata = {
						no_booking: no_booking,
						no_meja: no_meja,
						order_detail: OrderDetail,
					};

					$http
						.post(base_url("opr/kasir/create_order_detail"), formdata)
						.then(function (response) {
							var data = response.data;
							if (data.status == true) {
								Swal.fire({
									icon: "success",
									title: "Berhasil",
									text: "Data Order Berhasil !",
								});
								document.location.reload();
							}
						})
						.catch(function (error) {
							console.error("Terjadi kesalahan saat proses data:", error);
						});
				}
			});
		}
	};

	$scope.CetakBill = function () {
		Swal.fire({
			title: "Konfirmasi",
			text: "Mau Cetak Bill ini ?",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Ya, Cetak",
			cancelButtonText: "Batal",
			reverseButtons: true,
		}).then((result) => {
			if (result.isConfirmed) {
				var OrderDetail = [];
				var no_booking = document.getElementById(
					"lb_tambahan_no_order"
				).innerHTML;
				var no_meja = document.getElementById("lb_tambahan_no_meja").innerHTML;
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
						jenis: jenis,
					};
					OrderDetail.push(rowData);
				}
				var formdata = {
					no_booking: no_booking,
					no_meja: no_meja,
					order_detail: OrderDetail,
				};

				$http
					.post(base_url("opr/kasir/create_order_detail"), formdata)
					.then(function (response) {
						var data = response.data;
						if (data.status == true) {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Data Order Berhasil !",
							});
							document.location.reload();
						}
					})
					.catch(function (error) {
						console.error("Terjadi kesalahan saat proses data:", error);
					});
			}
		});
	};

	$scope.HapusPesananList = function (dt) {
		Swal.fire({
			title: "Konfirmasi",
			text: "Mau List Pesanan " + dt.nama + " ?",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Ya, Hapus",
			cancelButtonText: "Batal",
			reverseButtons: true,
		}).then((result) => {
			if (result.isConfirmed) {
				var formdata = {
					id: dt.id,
				};
				$http
					.post(base_url("opr/kasir/delete_pesanan_list"), formdata)
					.then(function (response) {
						var data = response.data;
						if (data.status == true) {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Data Order Berhasil Dihapus !",
							});
							document.location.reload();
						}
					})
					.catch(function (error) {
						console.error("Terjadi kesalahan saat proses data:", error);
					});
			}
		});
	};

	$scope.payment_cash = function () {
		var no_booking = document.getElementById("lb_tambahan_no_order").innerHTML;
		var no_meja = document.getElementById("lb_tambahan_no_meja").innerHTML;
		var formdata = {
			no_booking: no_booking,
			no_meja: no_meja,
		};
		$http
			.post(base_url("opr/kasir/cek_subtotal_transaksi"), formdata)
			.then(function (response) {
				$("#my-modal-cash").modal("show");
				var lbTotalBelanjaElement = document.getElementById("lb_total_belanja");

				// Misalnya, response.data adalah nilai angka yang akan diformat
				var angka = response.data;

				// Memformat nilai angka dengan separator ribuan dan desimal
				var angkaYangSudahDiFormat = angka.toLocaleString();

				// Menetapkan nilai yang sudah diformat ke elemen HTML
				lbTotalBelanjaElement.innerHTML = angkaYangSudahDiFormat;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};
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

// Tambahah Menu

// Fungsi untuk membuat tombol dengan kelas dan ikon
function createButton_tambahan(text, className, iconClass) {
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
function findExistingRow_tambahan(dt) {
	var tbody = document.getElementById("tb_pesanan_body_tambahan");
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
function updateQty_tambahan(row, qtyChange) {
	var qtyCell = row.querySelector(".qty-cell");
	var currentQty = (parseInt(qtyCell.textContent) || 0) + qtyChange;

	if (currentQty > 0) {
		qtyCell.textContent = currentQty;
	} else {
		// Hapus baris jika qty mencapai 0
		var tbody = document.getElementById("tb_pesanan_body_tambahan");
		tbody.removeChild(row);

		// Perbarui nomor urut setelah menghapus baris
		updateRowNumbers_tambahan();
	}
}

// Fungsi untuk menambahkan baris baru
function addNewRow_tambahan(dt) {
	var tbody = document.getElementById("tb_pesanan_body_tambahan");
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
		updateQty_tambahan(newRow, 1);
	});
	cellAction.appendChild(btnPlus);

	var btnMinus = createButton("", "btn btn-dark", "bx bx-minus");
	btnMinus.addEventListener("click", function () {
		updateQty_tambahan(newRow, -1);
	});
	cellAction.appendChild(btnMinus);

	var btnDelete = createButton("", "btn btn-danger", "bx bx-trash");
	btnDelete.addEventListener("click", function () {
		tbody.removeChild(newRow);
		updateRowNumbers_tambahan(); // Perbarui nomor urut setelah menghapus baris
	});
	cellAction.appendChild(btnDelete);

	newRow.appendChild(cellAction);
	tbody.appendChild(newRow);

	// Perbarui nomor urut setiap kali menambahkan baris baru
	updateRowNumbers_tambahan();
}

// Fungsi untuk memperbarui nomor urut setiap kali baris dihapus
function updateRowNumbers_tambahan() {
	var tbody = document.getElementById("tb_pesanan_body_tambahan");
	var rows = tbody.getElementsByTagName("tr");

	for (var i = 0; i < rows.length; i++) {
		var cellNumber = rows[i].getElementsByTagName("td")[0]; // Kolom pertama berisi nomor urut
		cellNumber.textContent = i + 1;
	}
}

function formatRupiah(angka) {
	return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
